@extends('layouts.app')

@section('title', 'Client Dashboard - Fitness Coaching')

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl md:text-5xl font-extrabold mb-1">Client Dashboard</h1>
                            <p class="text-white/90 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Welcome back, <span class="font-bold ml-1">{{ $client->full_name }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coach Info -->
    @if($client->coach)
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-6 p-6 card-hover animate-slide-up">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Your Coach</h2>
                </div>
                <button onclick="openChatPanel()" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2 relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>Chat with Coach</span>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-md">{{ $unreadCount }}</span>
                    @endif
                </button>
            </div>
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                    <span class="text-white text-3xl font-bold">{{ substr($client->coach->full_name, 0, 1) }}</span>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $client->coach->full_name }}</h3>
                    <p class="text-gray-600 mb-2">{{ $client->coach->email }}</p>
                    @if($client->coach->quotes)
                        <div class="mt-3 px-4 py-2 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border-l-4 border-indigo-500">
                            <p class="text-indigo-700 italic font-medium">"{{ $client->coach->quotes }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Subscription Management -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-6 p-6 card-hover animate-slide-up">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Subscription</h2>
        </div>
        <form method="POST" action="{{ route('client.subscription.update') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label for="subscription_type" class="block text-sm font-semibold text-gray-700 mb-2">Subscription Type</label>
                    <select name="subscription_type" id="subscription_type" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                        <option value="weekly" {{ $client->subscription_type === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $client->subscription_type === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="quarterly" {{ $client->subscription_type === 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="yearly" {{ $client->subscription_type === 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        Update
                    </button>
                </div>
            </div>
        </form>
        
        @if($client->subscription_expires_at)
            <div class="mt-6 p-4 rounded-xl border-l-4 {{ $client->isSubscriptionExpiringSoon() ? 'bg-orange-50 border-orange-500' : 'bg-green-50 border-green-500' }} animate-slide-in">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        @if($client->isSubscriptionExpiringSoon())
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold {{ $client->isSubscriptionExpiringSoon() ? 'text-orange-800' : 'text-green-800' }} mb-1">
                            @if($client->isSubscriptionExpiringSoon())
                                Subscription Expiring Soon
                            @else
                                Subscription Active
                            @endif
                        </p>
                        <p class="text-sm {{ $client->isSubscriptionExpiringSoon() ? 'text-orange-700' : 'text-green-700' }}">
                            @if($client->isSubscriptionExpiringSoon())
                                Expires on {{ $client->subscription_expires_at->format('M d, Y') }} ({{ now()->diffInDays($client->subscription_expires_at, false) }} days left)
                            @else
                                Active until {{ $client->subscription_expires_at->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Payment Submission -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-6 p-6 card-hover animate-slide-up">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Submit Payment</h2>
                <p class="text-sm text-gray-600 mt-1">Submit a new payment to renew your subscription. Admin will review and approve your payment.</p>
            </div>
        </div>
        <form method="POST" action="{{ route('client.payment.submit') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="transaction_reference_no" class="block text-sm font-semibold text-gray-700 mb-2">Transaction Reference No. <span class="text-red-500">*</span></label>
                    <input type="text" name="transaction_reference_no" id="transaction_reference_no" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                           placeholder="e.g., PAY123456789">
                </div>
                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Amount <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                           placeholder="0.00">
                </div>
                <div>
                    <label for="payment_date" class="block text-sm font-semibold text-gray-700 mb-2">Payment Date <span class="text-red-500">*</span></label>
                    <input type="date" name="payment_date" id="payment_date" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                           value="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label for="method" class="block text-sm font-semibold text-gray-700 mb-2">Payment Method <span class="text-red-500">*</span></label>
                    <select name="method" id="method" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                        <option value="">Select Payment Method</option>
                        <option value="PayMaya">PayMaya</option>
                        <option value="GCash">GCash</option>
                        <option value="Bank">Bank</option>
                    </select>
                </div>
            </div>
            @if ($errors->any())
                <div class="mt-4 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-slide-in">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-red-800 mb-2">Please correct the following errors:</h3>
                            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <div class="mt-6">
                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                    Submit Payment
                </button>
            </div>
        </form>
    </div>

    <!-- My Plans Section -->
    <div class="mb-10">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">My Plans</h2>
                <p class="text-gray-600">View your meal plans, workout sessions, and progress tracking</p>
            </div>
        </div>

        <!-- Plans Grid with Side Navigation -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Side Navigation Buttons (Vue-powered) -->
            <div
                id="client-dashboard-stats-root"
                class="lg:col-span-1"
                data-meal-plans-count="{{ $client->mealPlans->count() }}"
                data-session-plans-count="{{ $client->sessionPlans->count() }}"
                data-progress-count="{{ $client->progressTrackers->count() }}"
            ></div>

            <!-- Plans Content Area (Vue-powered) -->
            <div
                id="client-plans-content-root"
                class="lg:col-span-3"
                data-meal-plans="{{ json_encode($client->mealPlans->map(function($m) { return ['id' => $m->id, 'protein' => $m->protein, 'carbs' => $m->carbs, 'fats' => $m->fats, 'calories' => $m->calories, 'description' => $m->description, 'notes' => $m->notes, 'meal_type' => $m->meal_type, 'created_at' => $m->created_at->toDateTimeString()]; })) }}"
                data-session-plans="{{ json_encode($client->sessionPlans->map(function($s) { return ['id' => $s->id, 'type_of_workout' => $s->type_of_workout, 'duration' => $s->duration, 'status' => $s->status, 'target_muscle' => $s->target_muscle, 'description' => $s->description, 'date' => $s->date, 'created_at' => $s->created_at->toDateTimeString()]; })) }}"
                data-progress-trackers="{{ json_encode($client->progressTrackers->map(function($p) { return ['id' => $p->id, 'weight_progress' => $p->weight_progress, 'body_fat_percentage' => $p->body_fat_percentage, 'muscle_mass' => $p->muscle_mass, 'remarks' => $p->remarks, 'record_at' => $p->record_at ? $p->record_at->toDateTimeString() : null, 'created_at' => $p->created_at->toDateTimeString()]; })) }}"
            ></div>
            
            <!-- Legacy content (hidden, kept for compatibility) -->
            <div class="lg:col-span-3 hidden">
                <!-- Meal Plans Content -->
                <div id="content-meal" class="plan-content max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @if($client->mealPlans->count() > 0)
                        <div class="space-y-4">
                            @foreach($client->mealPlans as $index => $mealPlan)
                                <div class="bg-gradient-to-br from-orange-50 via-orange-100 to-orange-50 rounded-2xl shadow-xl border-2 border-orange-200 overflow-hidden card-hover group animate-slide-up">
                                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-white">Meal Plan #{{ $client->mealPlans->count() - $index }}</h3>
                                                    <p class="text-xs text-white/90">{{ $mealPlan->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            @if($mealPlan->meal_type)
                                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-semibold text-white capitalize">
                                                    {{ str_replace('_', ' ', $mealPlan->meal_type) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <!-- Macros Grid -->
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                                <div class="bg-white rounded-xl p-4 border border-green-200 text-center group-hover:shadow-md transition-shadow">
                                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Protein</p>
                                                    <p class="text-2xl font-extrabold text-green-600">{{ $mealPlan->protein }}g</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-yellow-200 text-center group-hover:shadow-md transition-shadow">
                                                    <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Carbs</p>
                                                    <p class="text-2xl font-extrabold text-yellow-600">{{ $mealPlan->carbs }}g</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-purple-200 text-center group-hover:shadow-md transition-shadow">
                                                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Fats</p>
                                                    <p class="text-2xl font-extrabold text-purple-600">{{ $mealPlan->fats }}g</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-blue-200 text-center group-hover:shadow-md transition-shadow">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Calories</p>
                                                    <p class="text-2xl font-extrabold text-blue-600">{{ $mealPlan->calories ?? 'N/A' }}</p>
                                                </div>
                                            </div>

                                            @if($mealPlan->description)
                                                <div class="bg-white rounded-xl p-4 border border-orange-200">
                                                    <p class="text-xs font-semibold text-gray-500 mb-2">Description</p>
                                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $mealPlan->description }}</p>
                                                </div>
                                            @endif

                                            @if($mealPlan->notes)
                                                <div class="bg-white rounded-xl p-4 border-l-4 border-indigo-500">
                                                    <p class="text-xs font-semibold text-indigo-600 mb-1">Coach Notes</p>
                                                    <p class="text-sm text-gray-700">{{ $mealPlan->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gradient-to-br from-orange-50 via-orange-100 to-orange-50 rounded-2xl shadow-xl border-2 border-orange-200 p-12 text-center">
                            <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-semibold text-lg mb-2">No meal plans yet</p>
                            <p class="text-sm text-gray-600">Your coach will assign meal plans soon</p>
                        </div>
                    @endif
                </div>

                <!-- Session Plans Content -->
                <div id="content-session" class="plan-content hidden max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @if($client->sessionPlans->count() > 0)
                        <div class="space-y-4">
                            @foreach($client->sessionPlans as $index => $sessionPlan)
                                <div class="bg-gradient-to-br from-purple-50 via-purple-100 to-purple-50 rounded-2xl shadow-xl border-2 border-purple-200 overflow-hidden card-hover group animate-slide-up">
                                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-white">Workout Plan #{{ $client->sessionPlans->count() - $index }}</h3>
                                                    <p class="text-xs text-white/90">{{ $sessionPlan->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-semibold text-white">
                                                {{ $sessionPlan->type_of_workout }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <div class="bg-white rounded-xl p-4 border border-purple-200">
                                                <p class="text-xs font-semibold text-gray-500 mb-1">Workout Type</p>
                                                <p class="text-lg font-bold text-gray-900">{{ $sessionPlan->type_of_workout }}</p>
                                            </div>

                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                                <div class="bg-white rounded-xl p-4 border border-blue-200 text-center">
                                                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Duration</p>
                                                    <p class="text-xl font-extrabold text-blue-600">{{ $sessionPlan->duration }}m</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-indigo-200 text-center">
                                                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Status</p>
                                                    <span class="px-2 py-1 inline-flex text-xs font-bold rounded-full 
                                                        {{ $sessionPlan->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                           ($sessionPlan->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                        {{ ucfirst(str_replace('_', ' ', $sessionPlan->status)) }}
                                                    </span>
                                                </div>
                                                @if($sessionPlan->target_muscle)
                                                    <div class="bg-white rounded-xl p-4 border border-green-200 text-center">
                                                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-2">
                                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <p class="text-xs font-semibold text-gray-500 mb-1">Target</p>
                                                        <p class="text-sm font-bold text-green-600">{{ $sessionPlan->target_muscle }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            @if($sessionPlan->description)
                                                <div class="bg-white rounded-xl p-4 border border-purple-200">
                                                    <p class="text-xs font-semibold text-gray-500 mb-2">Description</p>
                                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $sessionPlan->description }}</p>
                                                </div>
                                            @endif

                                            @if($sessionPlan->date)
                                                <div class="bg-white rounded-xl p-4 border-l-4 border-indigo-500">
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Scheduled Date</p>
                                                    <p class="text-sm font-bold text-gray-900">{{ $sessionPlan->date }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gradient-to-br from-purple-50 via-purple-100 to-purple-50 rounded-2xl shadow-xl border-2 border-purple-200 p-12 text-center">
                            <div class="w-20 h-20 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-semibold text-lg mb-2">No workout plans yet</p>
                            <p class="text-sm text-gray-600">Your coach will assign workout plans soon</p>
                        </div>
                    @endif
                </div>

                <!-- Progress Trackers Content -->
                <div id="content-progress" class="plan-content hidden max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    @if($client->progressTrackers->count() > 0)
                        <div class="space-y-4">
                            @foreach($client->progressTrackers as $index => $progressTracker)
                                <div class="bg-gradient-to-br from-green-50 via-green-100 to-green-50 rounded-2xl shadow-xl border-2 border-green-200 overflow-hidden card-hover group animate-slide-up">
                                    <div class="bg-gradient-to-br from-green-500 to-green-600 px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-white">Progress Record #{{ $client->progressTrackers->count() - $index }}</h3>
                                                    <p class="text-xs text-white/90">{{ $progressTracker->record_at ? $progressTracker->record_at->format('M d, Y') : $progressTracker->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <div class="space-y-4">
                                            <div class="bg-white rounded-xl p-5 border border-blue-200 text-center">
                                                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mx-auto mb-3">
                                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-xs font-semibold text-gray-500 mb-1">Weight Progress</p>
                                                <p class="text-3xl font-extrabold text-blue-600">{{ $progressTracker->weight_progress ?? 'N/A' }}</p>
                                                <p class="text-xs text-gray-500 mt-1">kilograms</p>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="bg-white rounded-xl p-4 border border-orange-200 text-center">
                                                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Body Fat</p>
                                                    <p class="text-xl font-extrabold text-orange-600">{{ $progressTracker->body_fat_percentage ?? 'N/A' }}%</p>
                                                </div>
                                                <div class="bg-white rounded-xl p-4 border border-green-200 text-center">
                                                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mx-auto mb-2">
                                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-gray-500 mb-1">Muscle Mass</p>
                                                    <p class="text-xl font-extrabold text-green-600">{{ $progressTracker->muscle_mass ?? 'N/A' }}</p>
                                                    <p class="text-xs text-gray-500">kg</p>
                                                </div>
                                            </div>

                                            @if($progressTracker->remarks)
                                                <div class="bg-white rounded-xl p-4 border border-indigo-200">
                                                    <p class="text-xs font-semibold text-indigo-600 mb-1">Coach Remarks</p>
                                                    <p class="text-sm text-gray-700">{{ $progressTracker->remarks }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gradient-to-br from-green-50 via-green-100 to-green-50 rounded-2xl shadow-xl border-2 border-green-200 p-12 text-center">
                            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-semibold text-lg mb-2">No progress data yet</p>
                            <p class="text-sm text-gray-600">Your coach will update your progress soon</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Keep showPlans function for compatibility with Vue components
        function showPlans(type) {
            // Hide all content
            document.querySelectorAll('.plan-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.plan-nav-btn').forEach(btn => {
                btn.classList.remove('active', 'ring-4', 'ring-offset-2');
            });
            
            // Show selected content (for legacy fallback)
            const contentEl = document.getElementById('content-' + type);
            if (contentEl) {
                contentEl.classList.remove('hidden');
            }
            
            // Add active class to selected button
            const activeBtn = document.getElementById('btn-' + type + '-vue') || document.getElementById('btn-' + type);
            if (activeBtn) {
                activeBtn.classList.add('active', 'ring-4', 'ring-offset-2', 'ring-white/50');
            }
        }
        
        // Initialize - show meal plans by default
        document.addEventListener('DOMContentLoaded', function() {
            showPlans('meal');
        });
    </script>

    <!-- Chat Side Panel -->
    @if($client->coach)
        <div id="chatPanel" class="fixed right-0 top-0 h-full w-full md:w-96 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
            <!-- Chat Header -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white px-6 py-4 flex items-center justify-between border-b border-indigo-500">
                <div class="flex items-center space-x-3 flex-1">
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-lg font-bold">{{ substr($client->coach->full_name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg truncate">{{ $client->coach->full_name }}</h3>
                        <p class="text-xs text-white/80 truncate">{{ $client->coach->email }}</p>
                    </div>
                </div>
                <button onclick="closeChatPanel()" class="ml-3 p-2 hover:bg-white/20 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Messages Container -->
            <div id="chatMessagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 custom-scrollbar">
                <!-- Messages will be loaded here -->
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-200 bg-white p-4">
                <form id="chatMessageForm" enctype="multipart/form-data" class="space-y-2">
                    @csrf
                    <div id="chatImagePreview" class="hidden mb-2">
                        <div class="relative inline-block">
                            <img id="chatPreviewImg" src="" alt="Preview" class="max-w-xs rounded-lg border-2 border-indigo-500">
                            <button type="button" onclick="removeChatImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center bg-white border border-indigo-100 rounded-full px-4 py-2 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500">
                            <input 
                                type="text" 
                                id="chatMessageInput" 
                                name="message" 
                                placeholder="Type a message..." 
                                class="flex-1 border-0 bg-transparent text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                                maxlength="5000"
                            >
                            <label for="chatImageInput" class="ml-3 inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 text-gray-500 hover:text-indigo-600 hover:border-indigo-400 transition-colors cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2z"></path>
                                </svg>
                                <input type="file" id="chatImageInput" name="image" accept="image/*" class="hidden">
                            </label>
                        </div>
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold px-8 h-12 rounded-full shadow-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all flex items-center justify-center"
                        >
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Chat Overlay -->
        <div id="chatOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeChatPanel()"></div>

        <script>
            let chatSelectedImage = null;
            let chatPollingInterval = null;

            function openChatPanel() {
                document.getElementById('chatPanel').classList.remove('translate-x-full');
                document.getElementById('chatOverlay').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                loadChatMessages();
                startChatPolling();
            }

            function closeChatPanel() {
                document.getElementById('chatPanel').classList.add('translate-x-full');
                document.getElementById('chatOverlay').classList.add('hidden');
                document.body.style.overflow = '';
                stopChatPolling();
            }

            function loadChatMessages() {
                fetch('{{ route("client.chat.messages") }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.messages) {
                        renderChatMessages(data.messages);
                    }
                })
                .catch(error => console.error('Error loading messages:', error));
            }

            function renderChatMessages(messages) {
                const container = document.getElementById('chatMessagesContainer');
                container.innerHTML = '';
                
                if (messages.length === 0) {
                    container.innerHTML = '<div class="text-center text-gray-500 py-8"><p>No messages yet. Start the conversation!</p></div>';
                    return;
                }

                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `flex ${message.sender_type === 'client' ? 'justify-end' : 'justify-start'}`;
                    
                    const isRead = message.read_at !== null;
                    const readStatus = isRead && message.sender_type === 'client' ? '<span class="ml-2 text-indigo-300">✓</span>' : '';
                    
                    const date = new Date(message.created_at);
                    const formattedDate = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                    
                    const imageHtml = message.image ? `<img src="/storage/${message.image}" alt="Message image" class="max-w-xs rounded-lg mb-2 cursor-pointer" onclick="openImageModal('/storage/${message.image}')">` : '';
                    const messageHtml = message.message ? `<p class="text-sm">${escapeHtml(message.message)}</p>` : '';
                    
                    messageDiv.innerHTML = `
                        <div class="max-w-xs lg:max-w-sm px-4 py-2 rounded-2xl ${message.sender_type === 'client' ? 'bg-gradient-to-br from-indigo-600 to-purple-600 text-white' : 'bg-white border border-gray-200 text-gray-900 shadow-sm'}" style="border-radius: ${message.sender_type === 'client' ? '1rem 1rem 0.25rem 1rem' : '1rem 1rem 1rem 0.25rem'};">
                            ${imageHtml}
                            ${messageHtml}
                            <p class="text-xs mt-1 ${message.sender_type === 'client' ? 'text-indigo-200' : 'text-gray-500'}">
                                ${formattedDate}${readStatus}
                            </p>
                        </div>
                    `;
                    container.appendChild(messageDiv);
                });
                scrollChatToBottom();
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function scrollChatToBottom() {
                const container = document.getElementById('chatMessagesContainer');
                container.scrollTop = container.scrollHeight;
            }

            function openImageModal(imageSrc) {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 cursor-pointer';
                modal.onclick = function() { document.body.removeChild(modal); };
                modal.innerHTML = `<img src="${imageSrc}" alt="Full size" class="max-w-full max-h-full rounded-lg">`;
                document.body.appendChild(modal);
            }

            // Image preview
            document.getElementById('chatImageInput').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    chatSelectedImage = file;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('chatPreviewImg').src = e.target.result;
                        document.getElementById('chatImagePreview').classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            function removeChatImage() {
                document.getElementById('chatImageInput').value = '';
                chatSelectedImage = null;
                document.getElementById('chatImagePreview').classList.add('hidden');
                document.getElementById('chatPreviewImg').src = '';
            }

            // Send message
            document.getElementById('chatMessageForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const message = document.getElementById('chatMessageInput').value.trim();
                const hasImage = document.getElementById('chatImageInput').files.length > 0;
                
                if (!message && !hasImage) {
                    return;
                }

                const formData = new FormData(this);
                
                fetch('{{ route("client.chat.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('chatMessageInput').value = '';
                        removeChatImage();
                        loadChatMessages();
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            });

            function startChatPolling() {
                chatPollingInterval = setInterval(loadChatMessages, 3000);
            }

            function stopChatPolling() {
                if (chatPollingInterval) {
                    clearInterval(chatPollingInterval);
                    chatPollingInterval = null;
                }
            }
        </script>
    @endif
</div>
@endsection

