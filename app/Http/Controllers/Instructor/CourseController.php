<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use Illuminate\Validation\Rule; // Added this line

class CourseController extends Controller
{
    /**
     * Display a listing of the instructor's courses.
     */
    public function index()
    {
        $courses = Auth::user()->courses()
            ->withCount(['bookings as bookings_count'])
            ->with(['bookings' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->latest()->get();
        
        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('instructor.courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'], // in minutes
            'level' => ['required', 'string', Rule::in(['débutant', 'intermédiaire', 'avancé'])],
            'category' => ['required', 'string', 'max:255'],
            'thumbnail_url' => ['nullable', 'url', 'max:255'],
        ]);

        Auth::user()->courses()->create($request->all());

        return redirect()->route('instructor.courses.index')->with('status', 'Course created successfully!');
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        if ($course->guide_id !== Auth::id()) {
            abort(403);
        }
        return view('instructor.courses.edit', compact('course'));
    }

    /**
     * Display detailed information about the specified course.
     */
    public function show(Course $course)
    {
        if ($course->guide_id !== Auth::id()) {
            abort(403);
        }

        // Get bookings for this course
        $bookings = $course->bookings()->with('user')->get();
        
        // Calculate statistics
        $totalBookings = $bookings->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        
        // Get upcoming and past bookings
        $upcomingBookings = $bookings->filter(function ($booking) {
            return \Carbon\Carbon::parse($booking->start_datetime)->isFuture();
        })->sortBy('start_datetime');
        
        $pastBookings = $bookings->filter(function ($booking) {
            return \Carbon\Carbon::parse($booking->start_datetime)->isPast();
        })->sortByDesc('start_datetime');

        // Load the course with its guide and course slots
        $course = $course->load(['guide', 'courseSlots']);

        return view('instructor.courses.show', compact(
            'course', 
            'totalBookings', 
            'confirmedBookings', 
            'pendingBookings', 
            'upcomingBookings', 
            'pastBookings'
        ));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        if ($course->guide_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'], // in minutes
            'level' => ['required', 'string', Rule::in(['débutant', 'intermédiaire', 'avancé'])],
            'category' => ['required', 'string', 'max:255'],
            'thumbnail_url' => ['nullable', 'url', 'max:255'],
        ]);

        $course->update($request->all());

        return redirect()->route('instructor.courses.index')->with('status', 'Course updated successfully!');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->guide_id !== Auth::id()) {
            abort(403);
        }
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('status', 'Course deleted successfully!');
    }
}
