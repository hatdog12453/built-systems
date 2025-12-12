<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Client;
use App\Models\MealPlan;
use App\Models\SessionPlan;
use App\Models\ProgressTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CoachWebController extends Controller
{
    public function dashboard()
    {
        $coach = Session::get('user');
        $clients = Client::where('coach_id', $coach->id)->where('status', 'active')->get();
        
        // Get unread message counts for each client
        $clients->each(function ($client) use ($coach) {
            $client->unread_count = \App\Models\Message::where('coach_id', $coach->id)
                ->where('client_id', $client->id)
                ->where('sender_type', 'client')
                ->whereNull('read_at')
                ->count();
        });
        
        $stats = [
            'total_clients' => Client::where('coach_id', $coach->id)->count(),
            'active_clients' => $clients->count(),
            'total_meal_plans' => MealPlan::where('coach_id', $coach->id)->count(),
            'total_session_plans' => SessionPlan::where('coach_id', $coach->id)->count(),
        ];

        return view('coach.dashboard', compact('coach', 'clients', 'stats'));
    }

    public function showClient(Client $client)
    {
        $coach = Session::get('user');
        
        // Ensure client belongs to this coach
        if ($client->coach_id !== $coach->id) {
            abort(403);
        }

        $client->load(['coach', 'mealPlan', 'sessionPlan', 'progressTracker']);
        
        // Return JSON if AJAX request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'client' => $client,
                'meal_plan' => $client->mealPlan,
                'session_plan' => $client->sessionPlan,
                'progress_tracker' => $client->progressTracker,
            ]);
        }
        
        return view('coach.client-detail', compact('client'));
    }

    public function storeMealPlan(Request $request)
    {
        $coach = Session::get('user');
        
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'meal_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'calories' => 'nullable|integer|min:0',
            'protein' => 'required|integer|min:0',
            'carbs' => 'required|integer|min:0',
            'fats' => 'required|integer|min:0',
        ]);

        $client = Client::findOrFail($request->client_id);
        
        if ($client->coach_id !== $coach->id) {
            abort(403);
        }

        MealPlan::create([
            'client_id' => $client->id,
            'coach_id' => $coach->id,
            'meal_type' => $request->meal_type,
            'description' => $request->description,
            'notes' => $request->notes,
            'calories' => $request->calories,
            'protein' => $request->protein,
            'carbs' => $request->carbs,
            'fats' => $request->fats,
        ]);

        return redirect()->route('coach.dashboard')->with('success', 'Meal plan created successfully.');
    }

    public function storeSessionPlan(Request $request)
    {
        $coach = Session::get('user');
        
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'type_of_workout' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_muscle' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled,in_progress',
            'date' => 'nullable|date',
            'duration' => 'required|integer|min:1',
        ]);

        $client = Client::findOrFail($request->client_id);
        
        if ($client->coach_id !== $coach->id) {
            abort(403);
        }

        SessionPlan::create([
            'client_id' => $client->id,
            'coach_id' => $coach->id,
            'type_of_workout' => $request->type_of_workout,
            'description' => $request->description,
            'target_muscle' => $request->target_muscle,
            'status' => $request->status,
            'date' => $request->date,
            'duration' => $request->duration,
        ]);

        return redirect()->route('coach.dashboard')->with('success', 'Session plan created successfully.');
    }

    public function storeProgressTracker(Request $request)
    {
        $coach = Session::get('user');
        
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'weight_progress' => 'nullable|numeric|min:0',
            'body_fat_percentage' => 'nullable|numeric|min:0|max:100',
            'muscle_mass' => 'nullable|numeric|min:0',
            'record_at' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $client = Client::findOrFail($request->client_id);
        
        if ($client->coach_id !== $coach->id) {
            abort(403);
        }

        ProgressTracker::create([
            'client_id' => $client->id,
            'coach_id' => $coach->id,
            'weight_progress' => $request->weight_progress,
            'body_fat_percentage' => $request->body_fat_percentage,
            'muscle_mass' => $request->muscle_mass,
            'record_at' => $request->record_at ?? now()->toDateString(),
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('coach.dashboard')->with('success', 'Progress tracker created successfully.');
    }

    public function deleteMealPlan(MealPlan $mealPlan)
    {
        $coach = Session::get('user');
        
        if ($mealPlan->coach_id !== $coach->id) {
            abort(403);
        }

        $mealPlan->delete();

        return redirect()->route('coach.dashboard')->with('success', 'Meal plan deleted successfully.');
    }

    public function deleteSessionPlan(SessionPlan $sessionPlan)
    {
        $coach = Session::get('user');
        
        if ($sessionPlan->coach_id !== $coach->id) {
            abort(403);
        }

        $sessionPlan->delete();

        return redirect()->route('coach.dashboard')->with('success', 'Session plan deleted successfully.');
    }

    public function deleteProgressTracker(ProgressTracker $progressTracker)
    {
        $coach = Session::get('user');
        
        if ($progressTracker->coach_id !== $coach->id) {
            abort(403);
        }

        $progressTracker->delete();

        return redirect()->route('coach.dashboard')->with('success', 'Progress tracker deleted successfully.');
    }
}

