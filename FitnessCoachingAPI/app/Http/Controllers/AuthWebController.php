<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Coach;
use App\Models\Client;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Carbon\Carbon;

class AuthWebController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:admin,coach,client',
        ]);

        $role = $request->role;
        $email = $request->email;
        $password = $request->password;

        $modelMap = [
            'admin' => Admin::class,
            'coach' => Coach::class,
            'client' => Client::class,
        ];

        $model = $modelMap[$role];
        $user = $model::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        // Check if client is active
        if ($role === 'client' && $user->status !== 'active') {
            return back()->withErrors(['email' => 'Your account is pending approval.'])->withInput();
        }

        // Refresh user from database to ensure we have latest data
        $user->refresh();

        // Store user in session
        Session::put('user', $user);
        Session::put('role', $role);
        Session::put('user_id', $user->id);

        // Redirect based on role
        return redirect()->route($role . '.dashboard')->with('success', 'Welcome back, ' . $user->full_name . '!');
    }

    public function showRegister($coach = null)
    {
        $coaches = Coach::all();
        $selectedCoachId = null;
        
        // If coach ID is provided via route parameter, use it
        if ($coach) {
            $selectedCoach = Coach::find($coach);
            if ($selectedCoach) {
                $selectedCoachId = $selectedCoach->id;
            }
        }
        
        // Also check for coach_id in query string (for backward compatibility)
        if (!$selectedCoachId && request()->has('coach_id')) {
            $selectedCoachId = request()->query('coach_id');
        }
        
        return view('auth.register', compact('coaches', 'selectedCoachId'));
    }

    public function register(Request $request)
    {
        // Only allow client registration
        $request->validate([
            'role' => 'required|in:client',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'password' => 'required|string|min:8|confirmed',
            'coach_id' => 'required|exists:coaches,id',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'goal' => 'nullable|string',
            'subscription_type' => 'nullable|string',
        ]);

        $data = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'coach_id' => $request->coach_id,
            'height' => $request->height ?? null,
            'weight' => $request->weight ?? null,
            'age' => $request->age ?? null,
            'goal' => $request->goal ?? null,
            'subscription_type' => $request->subscription_type ?? null,
            'status' => 'pending', // Client starts as pending
            'payment_status' => 'pending',
        ];

        $user = Client::create($data);

        // Redirect to payment page
        Session::put('client_id', $user->id);
        return redirect()->route('payment.create');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:admin,coach,client',
        ]);

        $role = $request->role;
        $email = $request->email;

        // Rate limiting: max 3 requests per 15 minutes per email
        $key = 'password_reset:' . $email . ':' . $role;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => 'Too many password reset attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.'
            ])->withInput();
        }

        $modelMap = [
            'admin' => Admin::class,
            'coach' => Coach::class,
            'client' => Client::class,
        ];

        $model = $modelMap[$role];
        $user = $model::where('email', $email)->first();

        // Always return success message to prevent email enumeration
        if (!$user) {
            RateLimiter::hit($key);
            return back()->with('success', 'If an account exists with that email, a verification code has been sent.');
        }

        // Clean up expired codes
        PasswordReset::cleanupExpired();

        // Delete any existing codes for this email/role
        PasswordReset::where('email', $email)
            ->where('role', $role)
            ->delete();

        // Generate 6-digit code
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store code (valid for 5 minutes)
        PasswordReset::create([
            'email' => $email,
            'code' => $code,
            'role' => $role,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // Send email with code
        try {
            Mail::send('emails.password-reset-code', ['code' => $code], function ($message) use ($email, $user) {
                $message->to($email, $user->full_name ?? $email)
                    ->subject('Password Reset Verification Code - Fitness Coaching');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send verification code. Please try again later.'])->withInput();
        }

        RateLimiter::hit($key);

        // Store email and role in session for verification step
        Session::put('password_reset_email', $email);
        Session::put('password_reset_role', $role);

        return redirect()->route('password.verify-code')->with('success', 'A verification code has been sent to your email.');
    }

    public function showVerifyCode()
    {
        $email = Session::get('password_reset_email');
        $role = Session::get('password_reset_role');

        if (!$email || !$role) {
            return redirect()->route('password.forgot');
        }

        return view('auth.verify-code', [
            'email' => $email,
            'role' => $role,
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $email = Session::get('password_reset_email');
        $role = Session::get('password_reset_role');

        if (!$email || !$role) {
            return redirect()->route('password.forgot');
        }

        // Find the password reset record
        $passwordReset = PasswordReset::where('email', $email)
            ->where('role', $role)
            ->where('code', $request->code)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['code' => 'Invalid verification code.'])->withInput();
        }

        if ($passwordReset->isExpired()) {
            $passwordReset->delete();
            return back()->withErrors(['code' => 'Verification code has expired. Please request a new one.'])->withInput();
        }

        // Mark as verified
        Session::put('code_verified', true);
        $passwordReset->delete();

        return redirect()->route('password.reset');
    }

    public function showResetPassword()
    {
        if (!Session::get('code_verified')) {
            return redirect()->route('password.forgot');
        }

        $email = Session::get('password_reset_email');
        $role = Session::get('password_reset_role');

        if (!$email || !$role) {
            return redirect()->route('password.forgot');
        }

        return view('auth.reset-password', [
            'email' => $email,
            'role' => $role,
        ]);
    }

    public function resetPassword(Request $request)
    {
        if (!Session::get('code_verified')) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = Session::get('password_reset_email');
        $role = Session::get('password_reset_role');

        if (!$email || !$role) {
            return redirect()->route('password.forgot');
        }

        $modelMap = [
            'admin' => Admin::class,
            'coach' => Coach::class,
            'client' => Client::class,
        ];

        $model = $modelMap[$role];
        $user = $model::where('email', $email)->first();

        if (!$user) {
            Session::forget(['password_reset_email', 'password_reset_role', 'code_verified']);
            return redirect()->route('password.forgot')->withErrors(['email' => 'User not found.']);
        }

        // Update password (bcrypt is used by default in Hash::make)
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear all password reset session data
        Session::forget(['password_reset_email', 'password_reset_role', 'code_verified']);

        return redirect()->route('login')->with('success', 'Password reset successfully. Please login with your new password.');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('home');
    }
}

