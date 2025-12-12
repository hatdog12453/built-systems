@extends('layouts.app')

@section('title', 'Register - Fitness Coaching')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 animate-fade-in">
        <div id="register-header-root"></div>
        
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-6">
                @csrf
                <input type="hidden" name="role" value="client">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input id="full_name" name="full_name" type="text" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                               placeholder="John Doe" 
                               value="{{ old('full_name') }}">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input id="email" name="email" type="email" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                               placeholder="you@example.com" 
                               value="{{ old('email') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                               placeholder="••••••••">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                               placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label for="coach_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Your Coach <span class="text-red-500">*</span></label>
                    <select name="coach_id" id="coach_id" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                        <option value="">Choose a coach...</option>
                        @foreach($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ old('coach_id', $selectedCoachId ?? null) == $coach->id ? 'selected' : '' }}>
                                {{ $coach->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="height" class="block text-sm font-semibold text-gray-700 mb-2">Height (cm)</label>
                        <input id="height" name="height" type="number" step="0.01" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                               placeholder="170" 
                               value="{{ old('height') }}">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">Weight (kg)</label>
                        <input id="weight" name="weight" type="number" step="0.01" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                               placeholder="70" 
                               value="{{ old('weight') }}">
                    </div>
                    <div>
                        <label for="age" class="block text-sm font-semibold text-gray-700 mb-2">Age</label>
                        <input id="age" name="age" type="number" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                               placeholder="25" 
                               value="{{ old('age') }}">
                    </div>
                </div>

                <div>
                    <label for="goal" class="block text-sm font-semibold text-gray-700 mb-2">Fitness Goal</label>
                    <input id="goal" name="goal" type="text" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                           placeholder="e.g., Weight loss, Muscle gain" 
                           value="{{ old('goal') }}">
                </div>

                <div>
                    <label for="subscription_type" class="block text-sm font-semibold text-gray-700 mb-2">Subscription Type</label>
                    <select name="subscription_type" id="subscription_type" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                        <option value="">Select subscription...</option>
                        <option value="weekly" {{ old('subscription_type') == 'weekly' ? 'selected' : '' }}>Weekly - ₱500.00</option>
                        <option value="monthly" {{ old('subscription_type') == 'monthly' ? 'selected' : '' }}>Monthly - ₱1,800.00</option>
                        <option value="quarterly" {{ old('subscription_type') == 'quarterly' ? 'selected' : '' }}>Quarterly - ₱5,000.00</option>
                        <option value="yearly" {{ old('subscription_type') == 'yearly' ? 'selected' : '' }}>Yearly - ₱18,000.00</option>
                    </select>
                    <p class="mt-2 text-xs text-gray-500">Prices are in Philippine Peso (₱)</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-slide-in">
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

                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                    Create Account
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
