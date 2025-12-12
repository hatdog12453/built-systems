<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Coach;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AdminWebController extends Controller
{
    public function dashboard()
    {
        $admin = Session::get('user');
        $payments = Payment::with(['client', 'admin'])->latest()->paginate(10);
        $clients = Client::with('coach')->latest()->paginate(10);
        $coaches = Coach::withCount('clients')->latest()->paginate(10);

        // Get clients with expiring subscriptions (within 7 days)
        $expiringClients = Client::where('status', 'active')
            ->whereNotNull('subscription_expires_at')
            ->where('subscription_expires_at', '>=', now())
            ->where('subscription_expires_at', '<=', now()->addDays(7))
            ->with('coach')
            ->get();

        // Get new pending payments (for notifications)
        $newPendingPayments = Payment::where('status', 'pending')
            ->where('created_at', '>=', now()->subHours(24))
            ->with('client')
            ->latest()
            ->get();

        $stats = [
            'total_clients' => Client::count(),
            'total_coaches' => Coach::count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'active_clients' => Client::where('status', 'active')->count(),
            'expiring_subscriptions' => $expiringClients->count(),
        ];

        return view('admin.dashboard', compact('admin', 'payments', 'clients', 'coaches', 'stats', 'expiringClients', 'newPendingPayments'));
    }

    public function createCoach()
    {
        return view('admin.create-coach');
    }

    public function storeCoach(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:coaches,email',
            'password' => 'required|string|min:8|confirmed',
            'quotes' => 'nullable|string',
        ]);

        $coach = Coach::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'quotes' => $request->quotes,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Coach created successfully.');
    }

    public function updatePaymentStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:paid,pending,failed,refunded',
        ]);

        $payment->status = $request->status;
        $payment->save();

        // If payment is marked as paid, activate the client and extend subscription
        if ($request->status === 'paid') {
            $client = $payment->client;
            $client->status = 'active';
            $client->payment_status = 'paid';
            
            // Extend subscription based on subscription_type
            if ($client->subscription_type) {
                $currentExpiry = $client->subscription_expires_at ? \Carbon\Carbon::parse($client->subscription_expires_at) : now();
                
                // If subscription already expired or doesn't exist, start from today
                if ($currentExpiry->isPast()) {
                    $currentExpiry = now();
                }
                
                $newExpiry = null;
                switch ($client->subscription_type) {
                    case 'weekly':
                        $newExpiry = $currentExpiry->copy()->addWeek();
                        break;
                    case 'monthly':
                        $newExpiry = $currentExpiry->copy()->addMonth();
                        break;
                    case 'quarterly':
                        $newExpiry = $currentExpiry->copy()->addMonths(3);
                        break;
                    case 'yearly':
                        $newExpiry = $currentExpiry->copy()->addYear();
                        break;
                }
                
                if ($newExpiry) {
                    $client->subscription_expires_at = $newExpiry;
                }
            }
            
            $client->save();

            // Send email notification
            try {
                Mail::send('emails.client-approved', ['client' => $client], function ($message) use ($client) {
                    $message->to($client->email, $client->full_name)
                        ->subject('Payment Approved - Fitness Coaching');
                });
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Log::error('Failed to send approval email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function updateClientStatus(Request $request, Client $client)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,suspended,pending',
        ]);

        $client->status = $request->status;
        $client->save();

        return back()->with('success', 'Client status updated successfully.');
    }

    public function editCoach(Coach $coach)
    {
        return view('admin.edit-coach', compact('coach'));
    }

    public function updateCoach(Request $request, Coach $coach)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:coaches,email,' . $coach->id,
            'quotes' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->only(['full_name', 'email', 'quotes']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $coach->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Coach updated successfully.');
    }

    public function deleteCoach(Coach $coach)
    {
        $coach->delete();
        return back()->with('success', 'Coach deleted successfully.');
    }

    public function editClient(Client $client)
    {
        $coaches = Coach::all();
        return view('admin.edit-client', compact('client', 'coaches'));
    }

    public function updateClient(Request $request, Client $client)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'coach_id' => 'required|exists:coaches,id',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'goal' => 'nullable|string',
            'subscription_type' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended,pending',
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->only(['full_name', 'email', 'coach_id', 'height', 'weight', 'age', 'goal', 'subscription_type', 'status']);
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $client->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Client updated successfully.');
    }

    public function deleteClient(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client deleted successfully.');
    }

    public function sendRenewalReminder(Client $client)
    {
        try {
            Mail::send('emails.subscription-renewal-reminder', ['client' => $client], function ($message) use ($client) {
                $message->to($client->email, $client->full_name)
                    ->subject('Subscription Renewal Reminder - Fitness Coaching');
            });

            return back()->with('success', 'Renewal reminder sent successfully to ' . $client->full_name . '.');
        } catch (\Exception $e) {
            \Log::error('Failed to send renewal reminder: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to send renewal reminder. Please try again.']);
        }
    }

    public function sendBulkRenewalReminders()
    {
        $expiringClients = Client::where('status', 'active')
            ->whereNotNull('subscription_expires_at')
            ->where('subscription_expires_at', '>=', now())
            ->where('subscription_expires_at', '<=', now()->addDays(7))
            ->get();

        $sentCount = 0;
        $failedCount = 0;

        foreach ($expiringClients as $client) {
            try {
                Mail::send('emails.subscription-renewal-reminder', ['client' => $client], function ($message) use ($client) {
                    $message->to($client->email, $client->full_name)
                        ->subject('Subscription Renewal Reminder - Fitness Coaching');
                });
                $sentCount++;
            } catch (\Exception $e) {
                \Log::error('Failed to send renewal reminder to ' . $client->email . ': ' . $e->getMessage());
                $failedCount++;
            }
        }

        if ($sentCount > 0) {
            return back()->with('success', "Renewal reminders sent to {$sentCount} client(s)." . ($failedCount > 0 ? " {$failedCount} failed." : ''));
        } else {
            return back()->withErrors(['error' => 'Failed to send renewal reminders. Please try again.']);
        }
    }
}

