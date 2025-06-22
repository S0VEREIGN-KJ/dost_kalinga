<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminPanelController;
use Illuminate\Support\Facades\Route;
use App\Models\PstcoKalinga;

Route::get('/', function () {
    return view('home');
});

// Route to display all projects (GET request)
Route::get('/projects', [ProjectController::class, 'index']);

// Route to add a new project (POST request)
Route::post('/projects', [ProjectController::class, 'store']);

// for the edit and update projects
Route::put('/projects/{proj_id}', [ProjectController::class, 'update']);

// delete
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

// Project API Routes
Route::prefix('projects')->group(function () {
    // Get all projects
    Route::get('/', [ProjectController::class, 'index']);
    
    // Get unique municipalities
    Route::get('/municipalities', [ProjectController::class, 'municipalities']);
    
    // Get projects statistics
    Route::get('/statistics', [ProjectController::class, 'statistics']);
    
    // Get projects by municipality
    Route::get('/municipality/{municipality}', [ProjectController::class, 'byMunicipality']);
    
    // Get single project
    Route::get('/{id}', [ProjectController::class, 'show']);
});

// Alternative grouped routes (if you prefer this structure)
Route::apiResource('projects', ProjectController::class)->only(['index', 'show']);

Route::get('/static-points', function () {
    return PstcoKalinga::all();
});

// Admin login form route (GET request to show the form)
Route::get('/admin/login', [App\Http\Controllers\AdminPanelController::class, 'showLoginForm'])->name('admin.login');

// Admin login route (POST request to handle login)
Route::post('/admin/login', [App\Http\Controllers\AdminPanelController::class, 'login'])->name('admin.login.submit');

// Admin dashboard
Route::get('/admin', [AdminPanelController::class, 'dashboard'])
    ->middleware('auth:admin')
    ->name('admin.dashboard');

// Admin logout
Route::post('/admin/logout', [AdminPanelController::class, 'logout'])
    ->middleware('auth:admin')
    ->name('admin.logout');


