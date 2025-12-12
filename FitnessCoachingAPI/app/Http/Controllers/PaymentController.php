<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return Payment::with(['client', 'admin'])->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required','exists:clients,id'],
            'admin_id' => ['required','exists:admins,id'],
            'transaction_reference_no' => ['required','string','max:255','unique:payments,transaction_reference_no'],
            'amount' => ['required','numeric','min:0'],
            'payment_date' => ['required','date'],
            'method' => ['required','string'],
            'status' => ['required','string'],
        ]);
        
        // Check if payment already exists for this client
        $existingPayment = Payment::where('client_id', $data['client_id'])->first();
            
        if ($existingPayment) {
            return response()->json([
                'message' => 'Payment already exists for this client.'
            ], 422);
        }
        $payment = Payment::create($data);
        return response()->json($payment, 201);
    }

    public function show(Payment $payment)
    {
        return $payment->load(['client', 'admin']);
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'client_id' => ['sometimes','exists:clients,id'],
            'admin_id' => ['sometimes','exists:admins,id'],
            'transaction_reference_no' => ['sometimes','string','max:255','unique:payments,transaction_reference_no,'.$payment->id],
            'amount' => ['sometimes','numeric','min:0'],
            'payment_date' => ['sometimes','date'],
            'method' => ['sometimes','string'],
            'status' => ['sometimes','string'],
        ]);
        
        // If client_id is being updated, check for duplicates
        if (isset($data['client_id'])) {
            $existingPayment = Payment::where('client_id', $data['client_id'])
                ->where('id', '!=', $payment->id)
                ->first();
                
            if ($existingPayment) {
                return response()->json([
                    'message' => 'Payment already exists for this client.'
                ], 422);
            }
        }
        $payment->update($data);
        return response()->json($payment);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(null, 204);
    }
}
