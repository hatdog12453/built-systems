<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\SessionPlanController;
use App\Http\Controllers\ProgressTrackerController;
use App\Http\Controllers\PaymentController;

// Auth
Route::post('auth/{role}/register', [AuthController::class, 'register']);
// curl -X POST http://127.0.0.1:8000/api/auth/client/register ^
//   -H "Content-Type: application/json" ^
//   -d "{\"full_name\":\"John Doe\",\"email\":\"john@example.com\",\"password\":\"secret123\"}"
Route::post('auth/{role}/login', [AuthController::class, 'login']);
// curl -X POST http://127.0.0.1:8000/api/auth/client/login ^
//   -H "Content-Type: application/json" ^
//   -d "{\"email\":\"john@example.com\",\"password\":\"secret123\"}"
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// curl -X POST http://127.0.0.1:8000/api/auth/logout ^
//   -H "Authorization: Bearer <token>"

// Admin-only CRUD on admins, coaches, clients, payments
Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    Route::apiResource('admins', AdminController::class);
    // curl http://127.0.0.1:8000/api/admins -H "Authorization: Bearer <token>"
    Route::apiResource('coaches', CoachController::class);
    // curl http://127.0.0.1:8000/api/coaches -H "Authorization: Bearer <token>"
    Route::apiResource('clients', ClientController::class);
    // curl http://127.0.0.1:8000/api/clients -H "Authorization: Bearer <token>"
    Route::apiResource('payments', PaymentController::class);
    // curl http://127.0.0.1:8000/api/payments -H "Authorization: Bearer <token>"
});

// Coach can manage their clients and client resources
Route::middleware(['auth:sanctum','role:coach'])->group(function () {
    Route::get('coach/clients', [ClientController::class, 'index']);
    // curl http://127.0.0.1:8000/api/coach/clients -H "Authorization: Bearer <token>"
    Route::apiResource('meal-plans', MealPlanController::class);
    // curl http://127.0.0.1:8000/api/meal-plans -H "Authorization: Bearer <token>"
    Route::apiResource('session-plans', SessionPlanController::class);
    // curl http://127.0.0.1:8000/api/session-plans -H "Authorization: Bearer <token>"
    Route::apiResource('progress-trackers', ProgressTrackerController::class);
    // curl http://127.0.0.1:8000/api/progress-trackers -H "Authorization: Bearer <token>"
});

// Client access to view own details and related resources
Route::middleware(['auth:sanctum','role:client'])->group(function () {
    Route::get('me', function (\Illuminate\Http\Request $request) {
        return $request->user()->load(['coach','mealPlan','sessionPlan','progressTracker','payments']);
    });
    // curl http://127.0.0.1:8000/api/me -H "Authorization: Bearer <token>"
});


