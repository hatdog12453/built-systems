@extends('layouts.app')

@section('title', 'Admin Dashboard - Fitness Coaching')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10 animate-fade-in">
        <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-8 text-white shadow-xl">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl md:text-5xl font-extrabold mb-1">Admin Dashboard</h1>
                            <p class="text-white/90 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Welcome back, <span class="font-bold ml-1">{{ $admin->full_name }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards (Vue-powered, same design) -->
    <div
        id="admin-dashboard-root"
        data-total-clients="{{ $stats['total_clients'] }}"
        data-total-coaches="{{ $stats['total_coaches'] }}"
        data-pending-payments="{{ $stats['pending_payments'] }}"
        data-active-clients="{{ $stats['active_clients'] }}"
        data-expiring-subscriptions="{{ $stats['expiring_subscriptions'] }}"
    ></div>

    <!-- New Payment Notifications (Vue-powered) -->
    <div
        id="admin-payment-notifications-root"
        data-payments="{{ isset($newPendingPayments) && $newPendingPayments->count() > 0 ? json_encode($newPendingPayments->map(function($p) { return ['id' => $p->id, 'amount' => $p->amount, 'method' => $p->method, 'transaction_reference_no' => $p->transaction_reference_no, 'client' => ['full_name' => $p->client->full_name]]; })) : '[]' }}"
    ></div>

    <!-- Actions -->
    <div class="mb-8 flex flex-wrap gap-4">
        <a href="{{ route('admin.coaches.create') }}" class="group px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Create New Coach</span>
        </a>
        @if($expiringClients->count() > 0)
            <form method="POST" action="{{ route('admin.clients.send-bulk-reminders') }}" class="inline">
                @csrf
                <button type="submit" class="group px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-semibold hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center space-x-2" onclick="return confirm('Send renewal reminders to all {{ $expiringClients->count() }} client(s) with expiring subscriptions?')">
                    <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Send Reminders to All ({{ $expiringClients->count() }})</span>
                </button>
            </form>
        @endif
    </div>

    <!-- Expiring Subscriptions Section (Vue-powered) -->
    <div
        id="admin-expiring-subscriptions-root"
        data-clients="{{ $expiringClients->count() > 0 ? json_encode($expiringClients->map(function($c) { $daysLeft = now()->diffInDays($c->subscription_expires_at, false); return ['id' => $c->id, 'full_name' => $c->full_name, 'email' => $c->email, 'subscription_type' => $c->subscription_type, 'subscription_expires_at' => $c->subscription_expires_at->format('M d, Y'), 'days_left' => $daysLeft, 'coach' => ['full_name' => $c->coach->full_name]]; })) : '[]' }}"
        data-csrf-token="{{ csrf_token() }}"
        data-send-reminder-route="/admin/clients"
    ></div>

    <!-- Payments Section (Vue-powered) -->
    <div
        id="admin-payments-table-root"
        data-payments="{{ json_encode($payments->map(function($p) { return ['id' => $p->id, 'amount' => $p->amount, 'payment_date' => $p->payment_date, 'method' => $p->method, 'status' => $p->status, 'client' => ['full_name' => $p->client->full_name]]; })) }}"
        data-csrf-token="{{ csrf_token() }}"
        data-update-status-route="/admin/payments"
        data-pagination-html="{{ $payments->links()->toHtml() }}"
    ></div>

    <!-- Clients Section (Vue-powered) -->
    <div
        id="admin-clients-table-root"
        data-clients="{{ json_encode($clients->map(function($c) { return ['id' => $c->id, 'full_name' => $c->full_name, 'email' => $c->email, 'status' => $c->status, 'coach' => ['full_name' => $c->coach->full_name]]; })) }}"
        data-csrf-token="{{ csrf_token() }}"
        data-update-status-route="/admin/clients"
        data-edit-route="/admin/clients"
        data-delete-route="/admin/clients"
        data-pagination-html="{{ $clients->links()->toHtml() }}"
    ></div>

    <!-- Coaches Section (Vue-powered) -->
    <div
        id="admin-coaches-table-root"
        data-coaches="{{ json_encode($coaches->map(function($c) { return ['id' => $c->id, 'full_name' => $c->full_name, 'email' => $c->email, 'clients_count' => $c->clients_count]; })) }}"
        data-csrf-token="{{ csrf_token() }}"
        data-edit-route="/admin/coaches"
        data-delete-route="/admin/coaches"
        data-pagination-html="{{ $coaches->links()->toHtml() }}"
    ></div>
</div>
@endsection

