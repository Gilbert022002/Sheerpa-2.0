<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AdminController; // Added this line

// Page d'accueil, redirige vers le login pour le moment
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Routes des dashboards protégées par le middleware d'authentification
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'instructor') {
            return redirect()->route('instructor.dashboard');
        }
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboardUser');
    })->name('dashboard');

    Route::get('/instructor/dashboard', function () {
        if (auth()->user()->role !== 'instructor') {
            return redirect()->route('dashboard');
        }
        return view('instructeur dashboard');
    })->name('instructor.dashboard');

    Route::post('/instructor/details', [InstructorController::class, 'storeDetails'])->name('instructor.storeDetails');

    // Admin routes
    Route::middleware(['can:admin'])->group(function () { // Using a 'can' middleware for admin role
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/admin/instructors/{instructor}/approve', [AdminController::class, 'approveInstructor'])->name('admin.instructors.approve');
        Route::post('/admin/instructors/{instructor}/reject', [AdminController::class, 'rejectInstructor'])->name('admin.instructors.reject');
    });
});

