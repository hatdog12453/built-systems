<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\CoachWebController;
use App\Http\Controllers\ClientWebController;
use App\Http\Controllers\PaymentWebController;
use App\Http\Controllers\ChatController;

// Landing Page
Route::get('/', function () {
    $coaches = \App\Models\Coach::withCount('clients')->get();
    return view('home', compact('coaches'));
})->name('home');

// Authentication Routes
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::get('/register/{coach?}', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthWebController::class, 'register']);
Route::get('/forgot-password', [AuthWebController::class, 'showForgotPassword'])->name('password.forgot');
Route::post('/forgot-password', [AuthWebController::class, 'forgotPassword']);
Route::get('/verify-code', [AuthWebController::class, 'showVerifyCode'])->name('password.verify-code');
Route::post('/verify-code', [AuthWebController::class, 'verifyCode']);
Route::get('/reset-password', [AuthWebController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthWebController::class, 'resetPassword']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

// Payment Routes (before registration completion)
Route::get('/payment/create', [PaymentWebController::class, 'create'])->name('payment.create');
Route::post('/payment', [PaymentWebController::class, 'store'])->name('payment.store');

// Admin Routes
Route::middleware(['auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminWebController::class, 'dashboard'])->name('dashboard');
    Route::get('/coaches/create', [AdminWebController::class, 'createCoach'])->name('coaches.create');
    Route::post('/coaches', [AdminWebController::class, 'storeCoach'])->name('coaches.store');
    Route::post('/payments/{payment}/status', [AdminWebController::class, 'updatePaymentStatus'])->name('payments.update-status');
    Route::post('/clients/{client}/status', [AdminWebController::class, 'updateClientStatus'])->name('clients.update-status');
    Route::get('/coaches/{coach}/edit', [AdminWebController::class, 'editCoach'])->name('coaches.edit');
    Route::put('/coaches/{coach}', [AdminWebController::class, 'updateCoach'])->name('coaches.update');
    Route::delete('/coaches/{coach}', [AdminWebController::class, 'deleteCoach'])->name('coaches.delete');
    Route::get('/clients/{client}/edit', [AdminWebController::class, 'editClient'])->name('clients.edit');
    Route::put('/clients/{client}', [AdminWebController::class, 'updateClient'])->name('clients.update');
    Route::delete('/clients/{client}', [AdminWebController::class, 'deleteClient'])->name('clients.delete');
    Route::post('/clients/{client}/send-reminder', [AdminWebController::class, 'sendRenewalReminder'])->name('clients.send-reminder');
    Route::post('/clients/send-bulk-reminders', [AdminWebController::class, 'sendBulkRenewalReminders'])->name('clients.send-bulk-reminders');
});

// Coach Routes
Route::middleware(['auth.coach'])->prefix('coach')->name('coach.')->group(function () {
    Route::get('/dashboard', [CoachWebController::class, 'dashboard'])->name('dashboard');
    Route::get('/clients/{client}', [CoachWebController::class, 'showClient'])->name('client');
    Route::post('/meal-plan', [CoachWebController::class, 'storeMealPlan'])->name('meal-plan.store');
    Route::post('/session-plan', [CoachWebController::class, 'storeSessionPlan'])->name('session-plan.store');
    Route::post('/progress-tracker', [CoachWebController::class, 'storeProgressTracker'])->name('progress-tracker.store');
    Route::delete('/meal-plans/{mealPlan}', [CoachWebController::class, 'deleteMealPlan'])->name('meal-plan.delete');
    Route::delete('/session-plans/{sessionPlan}', [CoachWebController::class, 'deleteSessionPlan'])->name('session-plan.delete');
    Route::delete('/progress-trackers/{progressTracker}', [CoachWebController::class, 'deleteProgressTracker'])->name('progress-tracker.delete');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{client}', [ChatController::class, 'showCoachChat'])->name('chat');
});

// Client Routes
Route::middleware(['auth.client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientWebController::class, 'dashboard'])->name('dashboard');
    Route::post('/subscription', [ClientWebController::class, 'updateSubscription'])->name('subscription.update');
    Route::post('/payment', [ClientWebController::class, 'submitPayment'])->name('payment.submit');
    Route::get('/chat', [ChatController::class, 'showClientChat'])->name('chat');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
});
