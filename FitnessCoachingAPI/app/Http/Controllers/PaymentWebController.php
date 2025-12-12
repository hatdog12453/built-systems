<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentWebController extends Controller
{
    public function create()
    {
        $clientId = Session::get('client_id');
        
        if (!$clientId) {
            return redirect()->route('register')->with('error', 'Please register first.');
        }

        $client = Client::findOrFail($clientId);

        return view('payment.create', compact('client'));
    }

    public function store(Request $request)
    {
        $clientId = Session::get('client_id');
        
        if (!$clientId) {
            return redirect()->route('register')->with('error', 'Please register first.');
        }

        $request->validate([
            'transaction_reference_no' => 'required|string|max:255|unique:payments,transaction_reference_no',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'method' => 'required|string|max:255',
        ]);

        // Get the main admin account (creates if doesn't exist)
        $admin = Admin::getMainAdmin();

        // Check if payment already exists for this client
        $existingPayment = Payment::where('client_id', $clientId)->first();
        
        if ($existingPayment) {
            return back()->withErrors(['transaction_reference_no' => 'Payment already exists for this client.'])->withInput();
        }

        Payment::create([
            'client_id' => $clientId,
            'admin_id' => $admin->id,
            'transaction_reference_no' => $request->transaction_reference_no,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'method' => $request->input('method'),
            'status' => 'pending',
        ]);

        Session::forget('client_id');

        return redirect()->route('login')->with('success', 'Payment submitted successfully. Please wait for admin approval.');
    }
}

