<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Route to display all projects (GET request)
Route::get('/projects', [ProjectController::class, 'index']);

// Route to add a new project (POST request)
Route::post('/projects', [ProjectController::class, 'store']);

// for the edit and update projects
Route::put('/projects/{proj_id}', [ProjectController::class, 'update']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// delete
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
