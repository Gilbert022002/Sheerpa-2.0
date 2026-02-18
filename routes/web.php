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

    // Notification routes
    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])
        ->name('notifications.index');
    
    Route::post('notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    
    Route::post('notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
        ->name('notifications.read-all');
    
    Route::delete('notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])
        ->name('notifications.destroy');
    
    // AJAX routes for real-time notifications
    Route::get('api/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])
        ->name('api.notifications.unread-count');
    
    Route::get('api/notifications/recent', [\App\Http\Controllers\NotificationController::class, 'getRecent'])
        ->name('api.notifications.recent');


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

        // Category management routes
        Route::prefix('admin')->resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
            ->except(['show'])
            ->names('admin.categories');

        // Course management routes
        Route::prefix('admin')->resource('courses', \App\Http\Controllers\Admin\CourseController::class)
            ->except(['create', 'store', 'show'])
            ->names('admin.courses');

        // User management routes
        Route::prefix('admin')->resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->except(['create', 'store', 'show'])
            ->names('admin.users');
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

            Route::post('profile-info', [ProfileController::class, 'updateProfileInfo'])
                ->name('profile.update.info');

            // Route for tutor to view user profile
            Route::get('users/{user}', [\App\Http\Controllers\Instructor\UserProfileController::class, 'show'])
                ->name('user.profile.show');
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

            // Public tutor profile routes
            Route::get('tutors/{tutor}', [\App\Http\Controllers\PublicTutorController::class, 'show'])
                ->name('tutors.show');

            Route::get('tutors', [\App\Http\Controllers\PublicTutorController::class, 'index'])
                ->name('tutors.index');

            // Favorites routes
            Route::get('favorites', [\App\Http\Controllers\User\FavoriteController::class, 'index'])
                ->name('favorites.index');
                
            Route::post('courses/{course}/favorite', [\App\Http\Controllers\User\FavoriteController::class, 'toggle'])
                ->name('courses.favorite');

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
                
            Route::post('profile-info',
                [ProfileController::class, 'updateProfileInfo'])
                ->name('profile.update.info');
        });
});
