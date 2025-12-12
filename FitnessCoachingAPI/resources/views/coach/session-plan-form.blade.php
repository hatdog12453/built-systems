@extends('layouts.app')

@section('title', 'Session Plan - Fitness Coaching')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('coach.client', $client->id) }}" class="text-indigo-600 hover:text-indigo-800">← Back to Client</a>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $client->sessionPlan ? 'Update' : 'Create' }} Session Plan for {{ $client->full_name }}</h1>
        <form method="POST" action="{{ route('coach.session-plan.store', $client->id) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="type_of_workout" class="block text-sm font-medium text-gray-700">Workout Type *</label>
                    <input type="text" name="type_of_workout" id="type_of_workout" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g., Strength Training, Cardio, HIIT" value="{{ old('type_of_workout', $client->sessionPlan->type_of_workout ?? '') }}">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $client->sessionPlan->description ?? '') }}</textarea>
                </div>
                <div>
                    <label for="target_muscle" class="block text-sm font-medium text-gray-700">Target Muscle</label>
                    <input type="text" name="target_muscle" id="target_muscle" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g., Full Body, Chest, Legs" value="{{ old('target_muscle', $client->sessionPlan->target_muscle ?? '') }}">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select name="status" id="status" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="scheduled" {{ old('status', $client->sessionPlan->status ?? 'scheduled') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="in_progress" {{ old('status', $client->sessionPlan->status ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $client->sessionPlan->status ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $client->sessionPlan->status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes) *</label>
                        <input type="number" name="duration" id="duration" required min="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('duration', $client->sessionPlan->duration ?? '60') }}">
                    </div>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" id="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('date', $client->sessionPlan->date ?? '') }}">
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
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Save Session Plan</button>
                    <a href="{{ route('coach.client', $client->id) }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

