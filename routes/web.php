<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Worker routes
    Route::resource('workers', App\Http\Controllers\WorkerController::class);
    
    // Job request routes
    Route::resource('job-requests', App\Http\Controllers\JobRequestController::class);
    Route::post('job-actions', [App\Http\Controllers\JobActionController::class, 'store'])->name('job-actions.store');
    
    // Job estimate routes
    Route::resource('job-estimates', App\Http\Controllers\JobEstimateController::class);
    Route::post('estimate-actions', [App\Http\Controllers\EstimateActionController::class, 'store'])->name('estimate-actions.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
