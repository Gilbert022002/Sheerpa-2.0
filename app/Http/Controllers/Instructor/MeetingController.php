<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class MeetingController extends Controller
{
    /**
     * Display a listing of the instructor's meetings.
     */
    public function index()
    {
        $instructor = Auth::user();
        $bookings = $instructor->receivedBookings()->with(['user', 'course'])->get();
        
        return view('instructor.meetings.index', compact('bookings'));
    }
}
