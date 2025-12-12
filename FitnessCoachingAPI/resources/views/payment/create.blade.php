@extends('layouts.app')

@section('title', 'Payment - Fitness Coaching')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Complete Your Registration</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Please provide your payment information</p>
        </div>
        <form class="mt-8 space-y-6" method="POST" action="{{ route('payment.store') }}">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div
                    id="payment-client-info-root"
                    data-client-name="{{ $client->full_name }}"
                    data-client-email="{{ $client->email }}"
                    data-subscription="{{ $client->subscription_type ?? 'Not selected' }}"
                ></div>

                <div>
                    <label for="transaction_reference_no" class="block text-sm font-medium text-gray-700">Transaction Reference Number</label>
                    <input id="transaction_reference_no" name="transaction_reference_no" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g., TXN-1234-5678-9012" value="{{ old('transaction_reference_no') }}">
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input id="amount" name="amount" type="number" step="0.01" min="0" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="0.00" value="{{ old('amount') }}">
                </div>

                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                    <input id="payment_date" name="payment_date" type="date" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('payment_date', date('Y-m-d')) }}">
                </div>

                <div>
                    <label for="method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select name="method" id="method" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select Method</option>
                        <option value="paymaya" {{ old('method') === 'paymaya' ? 'selected' : '' }}>PayMaya</option>
                        <option value="gcash" {{ old('method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="bank" {{ old('method') === 'bank' ? 'selected' : '' }}>Bank</option>
                    </select>
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                <p class="text-sm text-yellow-800">
                    <strong>Note:</strong> Your payment will be reviewed by an admin. You will receive an email notification once your account is approved.
                </p>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

