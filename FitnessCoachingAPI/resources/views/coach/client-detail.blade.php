@extends('layouts.app')

@section('title', 'Client Details - Fitness Coaching')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('coach.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Dashboard</a>
    </div>

    <!-- Client Info -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $client->full_name }}</h1>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-gray-900">{{ $client->email }}</p>
            </div>
            @if($client->height)
                <div>
                    <p class="text-sm text-gray-500">Height</p>
                    <p class="text-gray-900">{{ $client->height }} cm</p>
                </div>
            @endif
            @if($client->weight)
                <div>
                    <p class="text-sm text-gray-500">Weight</p>
                    <p class="text-gray-900">{{ $client->weight }} kg</p>
                </div>
            @endif
            @if($client->age)
                <div>
                    <p class="text-sm text-gray-500">Age</p>
                    <p class="text-gray-900">{{ $client->age }} years</p>
                </div>
            @endif
            @if($client->goal)
                <div>
                    <p class="text-sm text-gray-500">Goal</p>
                    <p class="text-gray-900">{{ $client->goal }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Meal Plan -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Meal Plan</h2>
            <a href="{{ route('coach.meal-plan.create', $client->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                {{ $client->mealPlan ? 'Update' : 'Create' }} Meal Plan
            </a>
        </div>
        <div class="p-6">
            @if($client->mealPlan)
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Meal Type</p>
                        <p class="text-gray-900">{{ $client->mealPlan->meal_type ?? 'N/A' }}</p>
                    </div>
                    @if($client->mealPlan->description)
                        <div>
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="text-gray-900">{{ $client->mealPlan->description }}</p>
                        </div>
                    @endif
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Calories</p>
                            <p class="text-gray-900">{{ $client->mealPlan->calories ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Protein (g)</p>
                            <p class="text-gray-900">{{ $client->mealPlan->protein }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Carbs (g)</p>
                            <p class="text-gray-900">{{ $client->mealPlan->carbs }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fats (g)</p>
                            <p class="text-gray-900">{{ $client->mealPlan->fats }}</p>
                        </div>
                    </div>
                    @if($client->mealPlan->notes)
                        <div>
                            <p class="text-sm text-gray-500">Notes</p>
                            <p class="text-gray-900">{{ $client->mealPlan->notes }}</p>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('coach.meal-plan.delete', $client->mealPlan->id) }}" onsubmit="return confirm('Are you sure?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete Meal Plan</button>
                    </form>
                </div>
            @else
                <p class="text-gray-500">No meal plan created yet.</p>
            @endif
        </div>
    </div>

    <!-- Session Plan -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Session Plan</h2>
            <a href="{{ route('coach.session-plan.create', $client->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                {{ $client->sessionPlan ? 'Update' : 'Create' }} Session Plan
            </a>
        </div>
        <div class="p-6">
            @if($client->sessionPlan)
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Workout Type</p>
                        <p class="text-gray-900">{{ $client->sessionPlan->type_of_workout }}</p>
                    </div>
                    @if($client->sessionPlan->description)
                        <div>
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="text-gray-900">{{ $client->sessionPlan->description }}</p>
                        </div>
                    @endif
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Target Muscle</p>
                            <p class="text-gray-900">{{ $client->sessionPlan->target_muscle ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="text-gray-900">{{ $client->sessionPlan->duration }} minutes</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $client->sessionPlan->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($client->sessionPlan->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($client->sessionPlan->status) }}
                            </span>
                        </div>
                    </div>
                    @if($client->sessionPlan->date)
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="text-gray-900">{{ $client->sessionPlan->date }}</p>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('coach.session-plan.delete', $client->sessionPlan->id) }}" onsubmit="return confirm('Are you sure?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete Session Plan</button>
                    </form>
                </div>
            @else
                <p class="text-gray-500">No session plan created yet.</p>
            @endif
        </div>
    </div>

    <!-- Progress Tracker -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Progress Tracker</h2>
            <a href="{{ route('coach.progress-tracker.create', $client->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                {{ $client->progressTracker ? 'Update' : 'Create' }} Progress
            </a>
        </div>
        <div class="p-6">
            @if($client->progressTracker)
                <div class="space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Weight Progress (kg)</p>
                            <p class="text-gray-900">{{ $client->progressTracker->weight_progress ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Body Fat %</p>
                            <p class="text-gray-900">{{ $client->progressTracker->body_fat_percentage ?? 'N/A' }}%</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Muscle Mass (kg)</p>
                            <p class="text-gray-900">{{ $client->progressTracker->muscle_mass ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($client->progressTracker->record_at)
                        <div>
                            <p class="text-sm text-gray-500">Record Date</p>
                            <p class="text-gray-900">{{ $client->progressTracker->record_at }}</p>
                        </div>
                    @endif
                    @if($client->progressTracker->remarks)
                        <div>
                            <p class="text-sm text-gray-500">Remarks</p>
                            <p class="text-gray-900">{{ $client->progressTracker->remarks }}</p>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('coach.progress-tracker.delete', $client->progressTracker->id) }}" onsubmit="return confirm('Are you sure?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete Progress Tracker</button>
                    </form>
                </div>
            @else
                <p class="text-gray-500">No progress tracker created yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection

