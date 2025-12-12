<?php

namespace App\Http\Controllers;

use App\Models\SessionPlan;
use Illuminate\Http\Request;

class SessionPlanController extends Controller
{
    public function index()
    {
        return SessionPlan::with(['client', 'coach'])->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required','exists:clients,id'],
            'coach_id' => ['required','exists:coaches,id'],
            'type_of_workout' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'target_muscle' => ['nullable','string','max:255'],
            'status' => ['nullable','string','max:255'],
            'date' => ['nullable','date'],
            'duration' => ['required','integer','min:1'],
        ]);
        $sessionPlan = SessionPlan::create($data);
        return response()->json($sessionPlan->load(['client', 'coach']), 201);
    }

    public function show(SessionPlan $sessionPlan)
    {
        return $sessionPlan->load(['client', 'coach']);
    }

    public function update(Request $request, SessionPlan $sessionPlan)
    {
        $data = $request->validate([
            'client_id' => ['sometimes','exists:clients,id'],
            'coach_id' => ['sometimes','exists:coaches,id'],
            'type_of_workout' => ['sometimes','string','max:255'],
            'description' => ['nullable','string'],
            'target_muscle' => ['nullable','string','max:255'],
            'status' => ['nullable','string','max:255'],
            'date' => ['nullable','date'],
            'duration' => ['sometimes','integer','min:1'],
        ]);
        $sessionPlan->update($data);
        return response()->json($sessionPlan->load(['client', 'coach']));
    }

    public function destroy(SessionPlan $sessionPlan)
    {
        $sessionPlan->delete();
        return response()->json(null, 204);
    }
}
