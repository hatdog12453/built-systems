<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClientWebController extends Controller
{
    public function dashboard()
    {
        $client = Session::get('user');
        $client->load(['coach', 'mealPlan', 'sessionPlan', 'progressTracker', 'mealPlans', 'sessionPlans', 'progressTrackers', 'payments']);
        
        // Get unread message count
        $unreadCount = 0;
        if ($client->coach) {
            $unreadCount = \App\Models\Message::where('coach_id', $client->coach->id)
                ->where('client_id', $client->id)
                ->where('sender_type', 'coach')
                ->whereNull('read_at')
                ->count();
        }

        return view('client.dashboard', compact('client', 'unreadCount'));
    }

    public function updateSubscription(Request $request)
    {
        $client = Session::get('user');

        $request->validate([
            'subscription_type' => 'required|in:weekly,monthly,quarterly,yearly',
        ]);

        $client->subscription_type = $request->subscription_type;
        $client->save();

        // Update session
        Session::put('user', $client->fresh());

        return back()->with('success', 'Subscription updated successfully.');
    }

    public function submitPayment(Request $request)
    {
        $client = Session::get('user');

        $request->validate([
            'transaction_reference_no' => 'required|string|max:255|unique:payments,transaction_reference_no',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|in:PayMaya,GCash,Bank',
        ]);

        // Get the main admin account
        $admin = Admin::getMainAdmin();

        Payment::create([
            'client_id' => $client->id,
            'admin_id' => $admin->id,
            'transaction_reference_no' => $request->transaction_reference_no,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'method' => $request->input('method'),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Payment submitted successfully. Please wait for admin approval.');
    }
}

