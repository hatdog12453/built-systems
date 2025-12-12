<?php

namespace App\Http\Controllers;

use App\Models\ProgressTracker;
use Illuminate\Http\Request;

class ProgressTrackerController extends Controller
{
    public function index()
    {
        return ProgressTracker::with(['client', 'coach'])->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required','exists:clients,id'],
            'coach_id' => ['required','exists:coaches,id'],
            'weight_progress' => ['nullable','numeric'],
            'body_fat_percentage' => ['nullable','numeric'],
            'muscle_mass' => ['nullable','numeric'],
            'record_at' => ['nullable','date'],
            'remarks' => ['nullable','string'],
        ]);
        $progress = ProgressTracker::create($data);
        return response()->json($progress->load(['client', 'coach']), 201);
    }

    public function show(ProgressTracker $progressTracker)
    {
        return $progressTracker->load(['client', 'coach']);
    }

    public function update(Request $request, ProgressTracker $progressTracker)
    {
        $data = $request->validate([
            'client_id' => ['sometimes','exists:clients,id'],
            'coach_id' => ['sometimes','exists:coaches,id'],
            'weight_progress' => ['nullable','numeric'],
            'body_fat_percentage' => ['nullable','numeric'],
            'muscle_mass' => ['nullable','numeric'],
            'record_at' => ['nullable','date'],
            'remarks' => ['nullable','string'],
        ]);
        $progressTracker->update($data);
        return response()->json($progressTracker->load(['client', 'coach']));
    }

    public function destroy(ProgressTracker $progressTracker)
    {
        $progressTracker->delete();
        return response()->json(null, 204);
    }
}
