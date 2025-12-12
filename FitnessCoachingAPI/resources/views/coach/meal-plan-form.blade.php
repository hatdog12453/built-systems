@extends('layouts.app')

@section('title', 'Meal Plan - Fitness Coaching')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('coach.client', $client->id) }}" class="text-indigo-600 hover:text-indigo-800">← Back to Client</a>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $client->mealPlan ? 'Update' : 'Create' }} Meal Plan for {{ $client->full_name }}</h1>
        <form method="POST" action="{{ route('coach.meal-plan.store', $client->id) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="meal_type" class="block text-sm font-medium text-gray-700">Meal Type</label>
                    <select name="meal_type" id="meal_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select Meal Type</option>
                        <option value="breakfast" {{ old('meal_type', $client->mealPlan->meal_type ?? '') === 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                        <option value="lunch" {{ old('meal_type', $client->mealPlan->meal_type ?? '') === 'lunch' ? 'selected' : '' }}>Lunch</option>
                        <option value="dinner" {{ old('meal_type', $client->mealPlan->meal_type ?? '') === 'dinner' ? 'selected' : '' }}>Dinner</option>
                        <option value="snack" {{ old('meal_type', $client->mealPlan->meal_type ?? '') === 'snack' ? 'selected' : '' }}>Snack</option>
                        <option value="full_day" {{ old('meal_type', $client->mealPlan->meal_type ?? '') === 'full_day' ? 'selected' : '' }}>Full Day</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $client->mealPlan->description ?? '') }}</textarea>
                </div>
                <div>
                    <label for="calories" class="block text-sm font-medium text-gray-700">Calories</label>
                    <input type="number" name="calories" id="calories" min="0" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('calories', $client->mealPlan->calories ?? '') }}">
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="protein" class="block text-sm font-medium text-gray-700">Protein (g) *</label>
                        <input type="number" name="protein" id="protein" required min="0" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('protein', $client->mealPlan->protein ?? '0') }}">
                    </div>
                    <div>
                        <label for="carbs" class="block text-sm font-medium text-gray-700">Carbs (g) *</label>
                        <input type="number" name="carbs" id="carbs" required min="0" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('carbs', $client->mealPlan->carbs ?? '0') }}">
                    </div>
                    <div>
                        <label for="fats" class="block text-sm font-medium text-gray-700">Fats (g) *</label>
                        <input type="number" name="fats" id="fats" required min="0" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('fats', $client->mealPlan->fats ?? '0') }}">
                    </div>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('notes', $client->mealPlan->notes ?? '') }}</textarea>
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
                <div class="flex space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Save Meal Plan</button>
                    <a href="{{ route('coach.client', $client->id) }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

