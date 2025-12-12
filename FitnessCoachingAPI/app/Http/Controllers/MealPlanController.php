<?php

namespace App\Http\Controllers;

use App\Models\MealPlan;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    public function index()
    {
        return MealPlan::with(['client', 'coach'])->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required','exists:clients,id'],
            'coach_id' => ['required','exists:coaches,id'],
            'description' => ['nullable','string'],
            'notes' => ['nullable','string'],
            'calories' => ['nullable','integer','min:0'],
            'meal_type' => ['nullable','string','max:255'],
            'protein' => ['required','integer','min:0'],
            'carbs' => ['required','integer','min:0'],
            'fats' => ['required','integer','min:0'],
        ]);
        $mealPlan = MealPlan::create($data);
        return response()->json($mealPlan->load(['client', 'coach']), 201);
    }

    public function show(MealPlan $mealPlan)
    {
        return $mealPlan->load(['client', 'coach']);
    }

    public function update(Request $request, MealPlan $mealPlan)
    {
        $data = $request->validate([
            'client_id' => ['sometimes','exists:clients,id'],
            'coach_id' => ['sometimes','exists:coaches,id'],
            'description' => ['nullable','string'],
            'notes' => ['nullable','string'],
            'calories' => ['nullable','integer','min:0'],
            'meal_type' => ['nullable','string','max:255'],
            'protein' => ['sometimes','integer','min:0'],
            'carbs' => ['sometimes','integer','min:0'],
            'fats' => ['sometimes','integer','min:0'],
        ]);
        $mealPlan->update($data);
        return response()->json($mealPlan->load(['client', 'coach']));
    }

    public function destroy(MealPlan $mealPlan)
    {
        $mealPlan->delete();
        return response()->json(null, 204);
    }
}
