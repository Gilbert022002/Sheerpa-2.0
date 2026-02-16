<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class PublicTutorController extends Controller
{
    /**
     * Display a listing of all tutors.
     */
    public function index()
    {
        $tutors = User::where('role', 'instructor')
            ->where('instructor_status', 'approved')
            ->withCount('courses')
            ->get();

        return view('public.tutors.index', compact('tutors'));
    }

    /**
     * Display the specified tutor's profile.
     */
    public function show(User $tutor)
    {
        // Check if the user is an instructor and approved
        if ($tutor->role !== 'instructor' || $tutor->instructor_status !== 'approved') {
            abort(404);
        }

        $courses = Course::where('guide_id', $tutor->id)
            ->with('bookings')
            ->get();

        return view('public.tutors.show', compact('tutor', 'courses'));
    }
}
