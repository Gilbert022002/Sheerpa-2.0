<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\AvailabilityController;
use App\Http\Controllers\Instructor\CourseSlotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CourseController as UserCourseController;

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

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


    /*
    |--------------------------------------------------------------------------
    | Instructor Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/instructor/dashboard', function () {

        if (auth()->user()->role !== 'instructor') {
            return redirect()->route('dashboard');
        }

        $upcomingSessions = \App\Models\Booking::where('guide_id', auth()->id())
            ->where('status', 'confirmed')
            ->where('start_datetime', '>', now())
            ->orderBy('start_datetime', 'asc')
            ->with(['course', 'course.bookings'])
            ->get();

        return view('instructeur dashboard', compact('upcomingSessions'));
    })->name('instructor.dashboard');

    Route::post('/instructor/details', [InstructorController::class, 'storeDetails'])
        ->name('instructor.storeDetails');


    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::post('/admin/instructors/{instructor}/approve', [AdminController::class, 'approveInstructor'])
            ->name('admin.instructors.approve');

        Route::post('/admin/instructors/{instructor}/reject', [AdminController::class, 'rejectInstructor'])
            ->name('admin.instructors.reject');
    });


    /*
    |--------------------------------------------------------------------------
    | Instructor Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['can:instructor'])
        ->prefix('guide')
        ->name('instructor.')
        ->group(function () {

            Route::resource('courses', CourseController::class);

            Route::post('courses/{course}/slots', [CourseSlotController::class, 'store'])
                ->name('courses.slots.store');

            Route::delete('courses/slots/{courseSlot}', [CourseSlotController::class, 'destroy'])
                ->name('courses.slots.destroy');

            Route::get('availabilities', [AvailabilityController::class, 'index'])
                ->name('availabilities.index');

            Route::post('availabilities', [AvailabilityController::class, 'store'])
                ->name('availabilities.store');

            Route::delete('availabilities/{availability}', [AvailabilityController::class, 'destroy'])
                ->name('availabilities.destroy');

            Route::get('one-time-slots', [\App\Http\Controllers\Instructor\OneTimeSlotController::class, 'index'])
                ->name('one-time-slots.index');

            Route::post('one-time-slots', [\App\Http\Controllers\Instructor\OneTimeSlotController::class, 'store'])
                ->name('one-time-slots.store');

            Route::delete('one-time-slots/{oneTimeSlot}', [\App\Http\Controllers\Instructor\OneTimeSlotController::class, 'destroy'])
                ->name('one-time-slots.destroy');

            Route::get('meetings', [\App\Http\Controllers\Instructor\MeetingController::class, 'index'])
                ->name('meetings.index');

            // Profile
            Route::get('profile', function () {
                return view('instructor.profile');
            })->name('profile');

            Route::post('profile-picture', [ProfileController::class, 'updateProfilePicture'])
                ->name('profile.update.picture');
        });


    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('courses', [UserCourseController::class, 'index'])
                ->name('courses.index');

            Route::get('courses/{course}', [UserCourseController::class, 'show'])
                ->name('courses.show');

            Route::post('courses/{course}/book', [UserCourseController::class, 'book'])
                ->name('courses.book');

            Route::get('bookings', [UserCourseController::class, 'bookings'])
                ->name('bookings.index');

            /*
            |--------------------------------------------------
            | One-to-One Booking (Gilbert)
            |--------------------------------------------------
            */

            Route::get('bookings/one-to-one',
                [\App\Http\Controllers\User\OneToOneBookingController::class, 'index'])
                ->name('bookings.one-to-one.index');

            Route::post('bookings/one-to-one',
                [\App\Http\Controllers\User\OneToOneBookingController::class, 'createBooking'])
                ->name('bookings.one-to-one.create');

            Route::get('api/available-slots/{guideId}/{date}',
                [\App\Http\Controllers\User\OneToOneBookingController::class, 'getAvailableSlots'])
                ->name('api.available-slots');


            /*
            |--------------------------------------------------
            | Extra User Pages (Tiavina)
            |--------------------------------------------------
            */

            Route::get('aspirations', function () {
                return view('user.aspirations');
            })->name('aspirations');

            Route::get('invoices', function () {
                return view('user.invoices');
            })->name('invoices');

            Route::get('profile', function () {
                return view('user.profile');
            })->name('profile');

            Route::post('profile-picture',
                [ProfileController::class, 'updateProfilePicture'])
                ->name('profile.update.picture');
        });
});
