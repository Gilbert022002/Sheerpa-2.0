<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display the specified user's profile to the instructor.
     */
    public function show(User $user)
    {
        // Check if the authenticated user is an instructor
        $instructor = Auth::user();
        if ($instructor->role !== 'instructor') {
            abort(403, 'Unauthorized access');
        }

        // Check if the user has booked any sessions with this instructor
        $hasBooking = Booking::where('guide_id', $instructor->id)
            ->where('user_id', $user->id)
            ->exists();

        if (!$hasBooking) {
            abort(403, 'You can only view profiles of users who have booked sessions with you');
        }

        return view('instructor.users.profile', compact('user'));
    }
}
