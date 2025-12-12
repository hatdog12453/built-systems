@extends('layouts.app')

@section('title', 'Progress Tracker - Fitness Coaching')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('coach.client', $client->id) }}" class="text-indigo-600 hover:text-indigo-800">← Back to Client</a>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $client->progressTracker ? 'Update' : 'Create' }} Progress Tracker for {{ $client->full_name }}</h1>
        <form method="POST" action="{{ route('coach.progress-tracker.store', $client->id) }}">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="weight_progress" class="block text-sm font-medium text-gray-700">Weight Progress (kg)</label>
                        <input type="number" step="0.01" name="weight_progress" id="weight_progress" min="0" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('weight_progress', $client->progressTracker->weight_progress ?? '') }}">
                    </div>
                    <div>
                        <label for="body_fat_percentage" class="block text-sm font-medium text-gray-700">Body Fat %</label>
                        <input type="number" step="0.01" name="body_fat_percentage" id="body_fat_percentage" min="0" max="100" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('body_fat_percentage', $client->progressTracker->body_fat_percentage ?? '') }}">
                    </div>
                    <div>
                        <label for="muscle_mass" class="block text-sm font-medium text-gray-700">Muscle Mass (kg)</label>
                        <input type="number" step="0.01" name="muscle_mass" id="muscle_mass" min="0" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('muscle_mass', $client->progressTracker->muscle_mass ?? '') }}">
                    </div>
                </div>
                <div>
                    <label for="record_at" class="block text-sm font-medium text-gray-700">Record Date</label>
                    <input type="date" name="record_at" id="record_at" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('record_at', $client->progressTracker->record_at ?? date('Y-m-d')) }}">
                </div>
                <div>
                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('remarks', $client->progressTracker->remarks ?? '') }}</textarea>
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
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Save Progress Tracker</button>
                    <a href="{{ route('coach.client', $client->id) }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

