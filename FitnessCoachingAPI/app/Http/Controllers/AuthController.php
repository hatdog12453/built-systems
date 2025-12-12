<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Coach;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request, string $role)
    {
        $validated = $request->validate([
            'full_name' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'password' => ['required','string','min:8'],
        ]);

        $modelMap = [
            'admin' => Admin::class,
            'coach' => Coach::class,
            'client' => Client::class,
        ];
        abort_unless(isset($modelMap[$role]), 404);

        $data = $validated;
        $data['password'] = Hash::make($validated['password']);

        if ($role === 'coach') {
            $data['quotes'] = $request->string('quotes')->toString() ?: null;
        }
        if ($role === 'client') {
            $request->validate(['coach_id' => ['required','exists:coaches,id']]);
            $data['coach_id'] = $request->integer('coach_id');
            $data['height'] = $request->float('height') ?: null;
            $data['weight'] = $request->float('weight') ?: null;
            $data['age'] = $request->integer('age') ?: null;
            $data['goal'] = $request->string('goal')->toString() ?: null;
            $data['payment_status'] = $request->string('payment_status')->toString() ?: null;
            $data['subscription_type'] = $request->string('subscription_type')->toString() ?: null;
            $data['status'] = $request->string('status')->toString() ?: 'active';
        }

        $model = $modelMap[$role];
        $user = $model::create($data);
        $token = $user->createToken($role.'-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request, string $role)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        $modelMap = [
            'admin' => Admin::class,
            'coach' => Coach::class,
            'client' => Client::class,
        ];
        abort_unless(isset($modelMap[$role]), 404);

        $model = $modelMap[$role];
        $user = $model::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }
        $token = $user->createToken($role.'-token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logged out']);
    }
}


