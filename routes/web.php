<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\AvailabilityController;
use App\Http\Controllers\Instructor\CourseSlotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CourseController as UserCourseController; // Added this line

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
        
        $courses = \App\Models\Course::with('guide')->latest()->take(3)->get();
        return view('dashboardUser', compact('courses'));
    })->name('dashboard');

    Route::get('/instructor/dashboard', function () {
        if (auth()->user()->role !== 'instructor') {
            return redirect()->route('dashboard');
        }
        return view('instructeur dashboard');
    })->name('instructor.dashboard');

    Route::post('/instructor/details', [InstructorController::class, 'storeDetails'])->name('instructor.storeDetails');

    // Admin routes
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/admin/instructors/{instructor}/approve', [AdminController::class, 'approveInstructor'])->name('admin.instructors.approve');
        Route::post('/admin/instructors/{instructor}/reject', [AdminController::class, 'rejectInstructor'])->name('admin.instructors.reject');
    });

    // Instructor routes
    Route::middleware(['auth', 'can:instructor'])->prefix('guide')->name('instructor.')->group(function () {
        // Course Management
        Route::resource('courses', CourseController::class);
        Route::get('courses/{course}/details', [CourseController::class, 'show'])->name('courses.show');
        Route::post('courses/{course}/slots', [CourseSlotController::class, 'store'])->name('courses.slots.store');
        Route::delete('courses/slots/{courseSlot}', [CourseSlotController::class, 'destroy'])->name('courses.slots.destroy');

        // Availability Management
        Route::get('availabilities', [AvailabilityController::class, 'index'])->name('availabilities.index');
        Route::post('availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
        Route::delete('availabilities/{availability}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');

        // One-Time Slots Management
        Route::get('one-time-slots', [\App\Http\Controllers\Instructor\OneTimeSlotController::class, 'index'])->name('one-time-slots.index');
        Route::post('one-time-slots', [\App\Http\Controllers\Instructor\OneTimeSlotController::class, 'store'])->name('one-time-slots.store');
        Route::delete('one-time-slots/{oneTimeSlot}', [\App\Http\Controllers\Instructor\OneTimeSlotController::class, 'destroy'])->name('one-time-slots.destroy');

        // Meetings Management
        Route::get('meetings', [\App\Http\Controllers\Instructor\MeetingController::class, 'index'])->name('meetings.index');
        
        // Profile Management
        Route::get('profile', function () {
            return view('instructor.profile');
        })->name('profile');
        
        Route::post('profile-picture', [ProfileController::class, 'updateProfilePicture'])->name('instructor.profile.update.picture');
    });

    // User routes
    Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
        Route::get('courses', [UserCourseController::class, 'index'])->name('courses.index');
        Route::get('courses/{course}', [UserCourseController::class, 'show'])->name('courses.show');
        Route::post('courses/{course}/book', [UserCourseController::class, 'book'])->name('courses.book');
        // User bookings index
        Route::get('bookings', [UserCourseController::class, 'bookings'])->name('bookings.index');
        // User aspirations
        Route::get('aspirations', function () {
            return view('user.aspirations');
        })->name('aspirations');
        // User invoices
        Route::get('invoices', function () {
            return view('user.invoices');
        })->name('invoices');
        
        // Profile management
        Route::get('profile', function () {
            return view('user.profile');
        })->name('profile');
        
        Route::post('profile-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update.picture');
    });
});
