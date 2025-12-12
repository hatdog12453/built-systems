@extends('layouts.app')

@section('title', 'Coach Dashboard - Fitness Coaching')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10 animate-fade-in">
        <div class="bg-gradient-to-br from-green-600 via-teal-600 to-cyan-600 rounded-2xl p-8 text-white shadow-xl">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl md:text-5xl font-extrabold mb-1">Coach Dashboard</h1>
                            <p class="text-white/90 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Welcome back, <span class="font-bold ml-1">{{ $coach->full_name }}</span>
                            </p>
                        </div>
                    </div>
                    @if($coach->quotes)
                        <div class="mt-4 px-5 py-3 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                            <p class="text-white italic font-medium text-lg">"{{ $coach->quotes }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Side Navigation (Vue-powered) -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-10">
        <!-- Side Navigation Buttons -->
        <div
            id="coach-dashboard-stats-root"
            class="lg:col-span-1"
            data-total-clients="{{ $stats['total_clients'] }}"
            data-active-clients="{{ $stats['active_clients'] }}"
            data-total-meal-plans="{{ $stats['total_meal_plans'] }}"
            data-total-session-plans="{{ $stats['total_session_plans'] }}"
        ></div>

        <!-- Main Content Area -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Clients List (Vue-powered) -->
            <div
                id="coach-client-cards-root"
                data-clients="{{ json_encode($clients->map(function($c) { return ['id' => $c->id, 'full_name' => $c->full_name, 'email' => $c->email, 'status' => $c->status, 'goal' => $c->goal, 'unread_count' => $c->unread_count ?? 0]; })) }}"
            ></div>

            <!-- Creation Forms -->
            <div id="meal-plans" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Meal Plan Form -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 card-hover animate-slide-up">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Create Meal Plan</h2>
                    </div>
                    <form method="POST" action="{{ route('coach.meal-plan.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="meal_plan_client_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Client <span class="text-red-500">*</span></label>
                                <select name="client_id" id="meal_plan_client_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="meal_type" class="block text-sm font-semibold text-gray-700 mb-2">Meal Type</label>
                                <select name="meal_type" id="meal_type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                                    <option value="">Select Meal Type</option>
                                    <option value="breakfast" {{ old('meal_type') === 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                    <option value="lunch" {{ old('meal_type') === 'lunch' ? 'selected' : '' }}>Lunch</option>
                                    <option value="dinner" {{ old('meal_type') === 'dinner' ? 'selected' : '' }}>Dinner</option>
                                    <option value="snack" {{ old('meal_type') === 'snack' ? 'selected' : '' }}>Snack</option>
                                    <option value="full_day" {{ old('meal_type') === 'full_day' ? 'selected' : '' }}>Full Day</option>
                                </select>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none" placeholder="Enter meal description...">{{ old('description') }}</textarea>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="flex flex-col">
                                    <label for="protein" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Protein (g) <span class="text-red-500">*</span></label>
                                    <input type="number" name="protein" id="protein" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-center font-semibold text-lg" value="{{ old('protein', '0') }}" placeholder="0">
                                </div>
                                <div class="flex flex-col">
                                    <label for="carbs" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Carbs (g) <span class="text-red-500">*</span></label>
                                    <input type="number" name="carbs" id="carbs" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-center font-semibold text-lg" value="{{ old('carbs', '0') }}" placeholder="0">
                                </div>
                                <div class="flex flex-col">
                                    <label for="fats" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Fats (g) <span class="text-red-500">*</span></label>
                                    <input type="number" name="fats" id="fats" required min="0" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-center font-semibold text-lg" value="{{ old('fats', '0') }}" placeholder="0">
                                </div>
                            </div>
                            <div>
                                <label for="calories" class="block text-sm font-semibold text-gray-700 mb-2">Calories</label>
                                <input type="number" name="calories" id="calories" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" value="{{ old('calories') }}" placeholder="Optional">
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                                <textarea name="notes" id="notes" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                            </div>
                            @if ($errors->has('client_id') || $errors->has('protein') || $errors->has('carbs') || $errors->has('fats'))
                                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-slide-in">
                                    <p class="text-sm font-medium text-red-800">{{ $errors->first('client_id') ?: $errors->first('protein') ?: $errors->first('carbs') ?: $errors->first('fats') }}</p>
                                </div>
                            @endif
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                Create Meal Plan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Session Plan Form -->
                <div id="session-plans" class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 card-hover animate-slide-up">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Create Session Plan</h2>
                    </div>
                    <form method="POST" action="{{ route('coach.session-plan.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="session_plan_client_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Client <span class="text-red-500">*</span></label>
                                <select name="client_id" id="session_plan_client_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="type_of_workout" class="block text-sm font-semibold text-gray-700 mb-2">Workout Type <span class="text-red-500">*</span></label>
                                <input type="text" name="type_of_workout" id="type_of_workout" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                       placeholder="e.g., Strength Training, Cardio" 
                                       value="{{ old('type_of_workout') }}">
                            </div>
                            <div>
                                <label for="session_plan_description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="session_plan_description" rows="2" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none" 
                                          placeholder="Enter workout description...">{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <label for="target_muscle" class="block text-sm font-semibold text-gray-700 mb-2">Target Muscle</label>
                                <input type="text" name="target_muscle" id="target_muscle" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                       placeholder="e.g., Full Body, Chest, Legs" 
                                       value="{{ old('target_muscle') }}">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label for="status" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Status <span class="text-red-500">*</span></label>
                                    <select name="status" id="status" required 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white font-medium">
                                        <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label for="duration" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Duration (min) <span class="text-red-500">*</span></label>
                                    <input type="number" name="duration" id="duration" required min="1" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-center font-semibold text-lg" 
                                           value="{{ old('duration', '60') }}" placeholder="60">
                                </div>
                            </div>
                            <div>
                                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                                <input type="date" name="date" id="date" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                       value="{{ old('date') }}">
                            </div>
                            @if ($errors->has('client_id') || $errors->has('type_of_workout') || $errors->has('duration'))
                                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-slide-in">
                                    <p class="text-sm font-medium text-red-800">{{ $errors->first('client_id') ?: $errors->first('type_of_workout') ?: $errors->first('duration') }}</p>
                                </div>
                            @endif
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                Create Session Plan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Progress Tracker Form -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 card-hover animate-slide-up">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Create Progress Tracker</h2>
                    </div>
                    <form method="POST" action="{{ route('coach.progress-tracker.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="progress_client_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Client <span class="text-red-500">*</span></label>
                                <select name="client_id" id="progress_client_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-white">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="flex flex-col">
                                    <label for="weight_progress" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Weight (kg)</label>
                                    <input type="number" step="0.01" name="weight_progress" id="weight_progress" min="0" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-center font-semibold text-lg" 
                                           placeholder="0.00" 
                                           value="{{ old('weight_progress') }}">
                                </div>
                                <div class="flex flex-col">
                                    <label for="body_fat_percentage" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Body Fat %</label>
                                    <input type="number" step="0.01" name="body_fat_percentage" id="body_fat_percentage" min="0" max="100" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-center font-semibold text-lg" 
                                           placeholder="0.00" 
                                           value="{{ old('body_fat_percentage') }}">
                                </div>
                                <div class="flex flex-col">
                                    <label for="muscle_mass" class="text-sm font-semibold text-gray-700 mb-2 leading-tight whitespace-nowrap">Muscle (kg)</label>
                                    <input type="number" step="0.01" name="muscle_mass" id="muscle_mass" min="0" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-center font-semibold text-lg" 
                                           placeholder="0.00" 
                                           value="{{ old('muscle_mass') }}">
                                </div>
                            </div>
                            <div>
                                <label for="record_at" class="block text-sm font-semibold text-gray-700 mb-2">Record Date</label>
                                <input type="date" name="record_at" id="record_at" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" 
                                       value="{{ old('record_at', date('Y-m-d')) }}">
                            </div>
                            <div>
                                <label for="remarks" class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="2" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-none" 
                                          placeholder="Additional remarks...">{{ old('remarks') }}</textarea>
                            </div>
                            @if ($errors->has('client_id'))
                                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-slide-in">
                                    <p class="text-sm font-medium text-red-800">{{ $errors->first('client_id') }}</p>
                                </div>
                            @endif
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200">
                                Create Progress Tracker
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Client Details Modal -->
<div id="clientModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl animate-fade-in max-h-[90vh] overflow-y-auto">
        <div class="p-8">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900" id="modalClientName">Client Details</h3>
                </div>
                <button onclick="closeClientModal()" class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="clientModalContent" class="space-y-6">
                <!-- Loading state -->
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                    <p class="mt-2 text-gray-600">Loading client details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showClientDetails(clientId) {
        const modal = document.getElementById('clientModal');
        const content = document.getElementById('clientModalContent');
        const clientName = document.getElementById('modalClientName');
        
        // Show modal
        modal.classList.remove('hidden');
        
        // Show loading state
        content.innerHTML = `
            <div class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                <p class="mt-2 text-gray-600">Loading client details...</p>
            </div>
        `;
        
        // Fetch client details
        fetch(`/coach/clients/${clientId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            const client = data.client;
            const mealPlan = data.meal_plan;
            const sessionPlan = data.session_plan;
            const progressTracker = data.progress_tracker;
            
            clientName.textContent = client.full_name;
            
            content.innerHTML = `
                <!-- Client Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Client Information</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-gray-900 font-medium">${client.email || 'N/A'}</p>
                        </div>
                        ${client.height ? `
                        <div>
                            <p class="text-sm text-gray-500">Height</p>
                            <p class="text-gray-900 font-medium">${client.height} cm</p>
                        </div>
                        ` : ''}
                        ${client.weight ? `
                        <div>
                            <p class="text-sm text-gray-500">Weight</p>
                            <p class="text-gray-900 font-medium">${client.weight} kg</p>
                        </div>
                        ` : ''}
                        ${client.age ? `
                        <div>
                            <p class="text-sm text-gray-500">Age</p>
                            <p class="text-gray-900 font-medium">${client.age} years</p>
                        </div>
                        ` : ''}
                        ${client.goal ? `
                        <div class="col-span-2 md:col-span-4">
                            <p class="text-sm text-gray-500">Goal</p>
                            <p class="text-gray-900 font-medium">${client.goal}</p>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <!-- Meal Plan -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Meal Plan</h4>
                    ${mealPlan ? `
                        <div class="space-y-3">
                            ${mealPlan.meal_type ? `
                            <div>
                                <p class="text-sm text-gray-500">Meal Type</p>
                                <p class="text-gray-900">${mealPlan.meal_type}</p>
                            </div>
                            ` : ''}
                            ${mealPlan.description ? `
                            <div>
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="text-gray-900">${mealPlan.description}</p>
                            </div>
                            ` : ''}
                            <div class="grid grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Calories</p>
                                    <p class="text-gray-900 font-semibold">${mealPlan.calories || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Protein (g)</p>
                                    <p class="text-gray-900 font-semibold">${mealPlan.protein || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Carbs (g)</p>
                                    <p class="text-gray-900 font-semibold">${mealPlan.carbs || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Fats (g)</p>
                                    <p class="text-gray-900 font-semibold">${mealPlan.fats || 'N/A'}</p>
                                </div>
                            </div>
                            ${mealPlan.notes ? `
                            <div>
                                <p class="text-sm text-gray-500">Notes</p>
                                <p class="text-gray-900">${mealPlan.notes}</p>
                            </div>
                            ` : ''}
                        </div>
                    ` : '<p class="text-gray-500">No meal plan assigned yet.</p>'}
                </div>

                <!-- Session Plan -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Session Plan</h4>
                    ${sessionPlan ? `
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Workout Type</p>
                                <p class="text-gray-900">${sessionPlan.type_of_workout || 'N/A'}</p>
                            </div>
                            ${sessionPlan.description ? `
                            <div>
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="text-gray-900">${sessionPlan.description}</p>
                            </div>
                            ` : ''}
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Target Muscle</p>
                                    <p class="text-gray-900">${sessionPlan.target_muscle || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Duration</p>
                                    <p class="text-gray-900">${sessionPlan.duration || 'N/A'} minutes</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full ${
                                        sessionPlan.status === 'completed' ? 'bg-green-100 text-green-800' : 
                                        (sessionPlan.status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')
                                    }">
                                        ${sessionPlan.status ? sessionPlan.status.charAt(0).toUpperCase() + sessionPlan.status.slice(1).replace('_', ' ') : 'N/A'}
                                    </span>
                                </div>
                            </div>
                            ${sessionPlan.date ? `
                            <div>
                                <p class="text-sm text-gray-500">Date</p>
                                <p class="text-gray-900">${sessionPlan.date}</p>
                            </div>
                            ` : ''}
                        </div>
                    ` : '<p class="text-gray-500">No session plan assigned yet.</p>'}
                </div>

                <!-- Progress Tracker -->
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Progress Tracker</h4>
                    ${progressTracker ? `
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Weight (kg)</p>
                                    <p class="text-gray-900 font-semibold">${progressTracker.weight_progress || 'N/A'}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Body Fat %</p>
                                    <p class="text-gray-900 font-semibold">${progressTracker.body_fat_percentage || 'N/A'}%</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Muscle Mass (kg)</p>
                                    <p class="text-gray-900 font-semibold">${progressTracker.muscle_mass || 'N/A'}</p>
                                </div>
                            </div>
                            ${progressTracker.record_at ? `
                            <div>
                                <p class="text-sm text-gray-500">Record Date</p>
                                <p class="text-gray-900">${progressTracker.record_at}</p>
                            </div>
                            ` : ''}
                            ${progressTracker.remarks ? `
                            <div>
                                <p class="text-sm text-gray-500">Remarks</p>
                                <p class="text-gray-900">${progressTracker.remarks}</p>
                            </div>
                            ` : ''}
                        </div>
                    ` : '<p class="text-gray-500">No progress tracker created yet.</p>'}
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <p class="text-red-600">Error loading client details. Please try again.</p>
                </div>
            `;
        });
    }
    
    function closeClientModal() {
        document.getElementById('clientModal').classList.add('hidden');
    }
    
    // Close modal when clicking outside
    document.getElementById('clientModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeClientModal();
        }
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeClientModal();
        }
    });

    // Scroll to section function
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            // Remove active class from all buttons
            document.querySelectorAll('.stats-nav-btn').forEach(btn => {
                btn.classList.remove('ring-4', 'ring-offset-2', 'ring-white/50');
            });
            
            // Add active class to clicked button
            event.target.closest('.stats-nav-btn')?.classList.add('ring-4', 'ring-offset-2', 'ring-white/50');
            
            // Scroll to section with offset for header
            const offset = 100;
            const elementPosition = section.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }

    // Chat Side Panel Functions
    let currentChatClientId = null;
    let coachChatPollingInterval = null;

    function openCoachChatPanel(clientId, clientName, clientEmail) {
        currentChatClientId = clientId;
        document.getElementById('coachChatClientName').textContent = clientName;
        document.getElementById('coachChatClientEmail').textContent = clientEmail;
        document.getElementById('coachChatClientInitial').textContent = clientName.charAt(0).toUpperCase();
        document.getElementById('coachChatPanel').classList.remove('translate-x-full');
        document.getElementById('coachChatOverlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.getElementById('coachChatClientId').value = clientId;
        
        // Setup form event listeners when panel opens
        setupCoachChatForm();
        
        loadCoachChatMessages();
        startCoachChatPolling();
    }

    function closeCoachChatPanel() {
        document.getElementById('coachChatPanel').classList.add('translate-x-full');
        document.getElementById('coachChatOverlay').classList.add('hidden');
        document.body.style.overflow = '';
        stopCoachChatPolling();
        currentChatClientId = null;
    }

    function loadCoachChatMessages() {
        if (!currentChatClientId) return;
        
        fetch(`{{ route('coach.chat.messages') }}?client_id=${currentChatClientId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.messages) {
                renderCoachChatMessages(data.messages);
            }
        })
        .catch(error => console.error('Error loading messages:', error));
    }

    function renderCoachChatMessages(messages) {
        const container = document.getElementById('coachChatMessagesContainer');
        container.innerHTML = '';
        
        if (messages.length === 0) {
            container.innerHTML = '<div class="text-center text-gray-500 py-8"><p>No messages yet. Start the conversation!</p></div>';
            return;
        }

        messages.forEach(message => {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${message.sender_type === 'coach' ? 'justify-end' : 'justify-start'}`;
            
            const isRead = message.read_at !== null;
            const readStatus = isRead && message.sender_type === 'coach' ? '<span class="ml-2 text-indigo-300">✓</span>' : '';
            
            const date = new Date(message.created_at);
            const formattedDate = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
            
            const imageHtml = message.image ? `<img src="/storage/${message.image}" alt="Message image" class="max-w-xs rounded-lg mb-2 cursor-pointer" onclick="openCoachImageModal('/storage/${message.image}')">` : '';
            const messageHtml = message.message ? `<p class="text-sm">${escapeCoachHtml(message.message)}</p>` : '';
            
            messageDiv.innerHTML = `
                <div class="max-w-xs lg:max-w-sm px-4 py-2 rounded-2xl ${message.sender_type === 'coach' ? 'bg-gradient-to-br from-green-600 to-teal-600 text-white' : 'bg-white border border-gray-200 text-gray-900 shadow-sm'}" style="border-radius: ${message.sender_type === 'coach' ? '1rem 1rem 0.25rem 1rem' : '1rem 1rem 1rem 0.25rem'};">
                    ${imageHtml}
                    ${messageHtml}
                    <p class="text-xs mt-1 ${message.sender_type === 'coach' ? 'text-green-200' : 'text-gray-500'}">
                        ${formattedDate}${readStatus}
                    </p>
                </div>
            `;
            container.appendChild(messageDiv);
        });
        scrollCoachChatToBottom();
    }

    function escapeCoachHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function scrollCoachChatToBottom() {
        const container = document.getElementById('coachChatMessagesContainer');
        container.scrollTop = container.scrollHeight;
    }

    function openCoachImageModal(imageSrc) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 cursor-pointer';
        modal.onclick = function() { document.body.removeChild(modal); };
        modal.innerHTML = `<img src="${imageSrc}" alt="Full size" class="max-w-full max-h-full rounded-lg">`;
        document.body.appendChild(modal);
    }

    let coachChatFormHandler = null;
    let coachImageInputHandler = null;

    function setupCoachChatForm() {
        // Remove existing listeners if any
        const coachChatForm = document.getElementById('coachChatMessageForm');
        const coachImageInput = document.getElementById('coachChatImageInput');
        
        if (coachChatForm && coachChatFormHandler) {
            coachChatForm.removeEventListener('submit', coachChatFormHandler);
        }
        
        if (coachImageInput && coachImageInputHandler) {
            coachImageInput.removeEventListener('change', coachImageInputHandler);
        }

        // Image preview for coach chat
        if (coachImageInput) {
            coachImageInputHandler = function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('coachChatPreviewImg').src = e.target.result;
                        document.getElementById('coachChatImagePreview').classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            };
            coachImageInput.addEventListener('change', coachImageInputHandler);
        }

        // Send message for coach
        if (coachChatForm) {
            coachChatFormHandler = function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const messageInput = document.getElementById('coachChatMessageInput');
                const imageInput = document.getElementById('coachChatImageInput');
                const message = messageInput ? messageInput.value.trim() : '';
                const hasImage = imageInput && imageInput.files.length > 0;
                
                if (!message && !hasImage) {
                    return false;
                }

                const formData = new FormData(coachChatForm);
                
                fetch('{{ route("coach.chat.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error('Server error: ' + text);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (messageInput) messageInput.value = '';
                        removeCoachChatImage();
                        loadCoachChatMessages();
                    } else {
                        console.error('Error:', data.error || 'Failed to send message');
                        alert('Failed to send message: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    alert('Failed to send message. Please try again.');
                });
                
                return false;
            };
            coachChatForm.addEventListener('submit', coachChatFormHandler);
        }
    }

    function removeCoachChatImage() {
        const imageInput = document.getElementById('coachChatImageInput');
        const imagePreview = document.getElementById('coachChatImagePreview');
        const previewImg = document.getElementById('coachChatPreviewImg');
        
        if (imageInput) imageInput.value = '';
        if (imagePreview) imagePreview.classList.add('hidden');
        if (previewImg) previewImg.src = '';
    }

    function startCoachChatPolling() {
        coachChatPollingInterval = setInterval(loadCoachChatMessages, 2000);
    }

    function stopCoachChatPolling() {
        if (coachChatPollingInterval) {
            clearInterval(coachChatPollingInterval);
            coachChatPollingInterval = null;
        }
    }
</script>

<!-- Coach Chat Side Panel -->
<div id="coachChatPanel" class="fixed right-0 top-0 h-full w-full md:w-96 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
    <!-- Chat Header -->
    <div class="bg-gradient-to-br from-green-600 to-teal-600 text-white px-6 py-4 flex items-center justify-between border-b border-green-500">
        <div class="flex items-center space-x-3 flex-1">
            <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <span id="coachChatClientInitial" class="text-white text-lg font-bold">C</span>
            </div>
            <div class="flex-1 min-w-0">
                <h3 id="coachChatClientName" class="font-bold text-lg truncate">Client Name</h3>
                <p id="coachChatClientEmail" class="text-xs text-white/80 truncate">client@email.com</p>
            </div>
        </div>
        <button onclick="closeCoachChatPanel()" class="ml-3 p-2 hover:bg-white/20 rounded-lg transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Messages Container -->
    <div id="coachChatMessagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 custom-scrollbar">
        <!-- Messages will be loaded here -->
    </div>

    <!-- Message Input -->
    <div class="border-t border-gray-200 bg-white p-4">
        <form id="coachChatMessageForm" enctype="multipart/form-data" class="space-y-2" onsubmit="return false;">
            @csrf
            <input type="hidden" id="coachChatClientId" name="client_id" value="">
            <div id="coachChatImagePreview" class="hidden mb-2">
                <div class="relative inline-block">
                    <img id="coachChatPreviewImg" src="" alt="Preview" class="max-w-xs rounded-lg border-2 border-green-500">
                    <button type="button" onclick="removeCoachChatImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center bg-white border border-green-100 rounded-full px-4 py-2 shadow-sm focus-within:ring-2 focus-within:ring-green-500">
                    <input 
                        type="text" 
                        id="coachChatMessageInput" 
                        name="message" 
                        placeholder="Type a message..." 
                        class="flex-1 border-0 bg-transparent text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        maxlength="5000"
                    >
                    <label for="coachChatImageInput" class="ml-3 inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 text-gray-500 hover:text-green-600 hover:border-green-400 transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <input type="file" id="coachChatImageInput" name="image" accept="image/*" class="hidden">
                    </label>
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-500 to-teal-500 text-white font-semibold px-8 h-12 rounded-full shadow-lg hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all flex items-center justify-center"
                >
                    Send
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Coach Chat Overlay -->
<div id="coachChatOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="closeCoachChatPanel()"></div>
@endsection
