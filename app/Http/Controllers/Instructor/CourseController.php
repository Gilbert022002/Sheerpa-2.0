<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Validation\Rule; // Added this line

class CourseController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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
            'category_id' => ['required', 'exists:categories,id'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'], // Allowed formats, Max 2MB
            'course_slots' => ['required', 'array', 'min:1'],
            'course_slots.*.date' => ['required', 'date', 'after_or_equal:today'],
            'course_slots.*.start_time' => ['required', 'date_format:H:i'],
            'course_slots.*.end_time' => ['required', 'date_format:H:i'],
        ]);

        // Custom validation for time slots
        if ($request->has('course_slots')) {
            foreach ($request->course_slots as $index => $slot) {
                if (!empty($slot['date']) && !empty($slot['start_time']) && !empty($slot['end_time'])) {
                    $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $slot['date'] . ' ' . $slot['start_time']);
                    $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $slot['date'] . ' ' . $slot['end_time']);

                    if ($startDateTime >= $endDateTime) {
                        return redirect()->back()
                            ->withErrors(['course_slots.' . $index . '.end_time' => 'L\'heure de fin doit être postérieure à l\'heure de début.'])
                            ->withInput();
                    }
                }
            }
        }

        $courseData = $request->except(['thumbnail', 'course_slots']);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('course-thumbnails', 'public');
            $courseData['thumbnail'] = $thumbnailPath;
        }

        $course = Auth::user()->courses()->create($courseData);

        // Process course slots if provided
        if ($request->has('course_slots')) {
            foreach ($request->course_slots as $slot) {
                if (!empty($slot['date']) && !empty($slot['start_time']) && !empty($slot['end_time'])) {
                    $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $slot['date'] . ' ' . $slot['start_time']);
                    $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $slot['date'] . ' ' . $slot['end_time']);

                    $course->courseSlots()->create([
                        'start_datetime' => $startDateTime,
                        'end_datetime' => $endDateTime,
                        'is_available' => true,
                    ]);
                }
            }
        }

        // Send notification to the tutor about course creation
        $this->notificationService->sendCourseCreatedNotification($course);

        // Send notification to all users about new course available
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $this->notificationService->sendCustomNotification(
                $user,
                'course_created',
                'Nouveau cours disponible',
                sprintf('Le cours "%s" avec %s est maintenant disponible à la réservation!', 
                    $course->title,
                    $course->guide->name
                ),
                ['course_id' => $course->id, 'guide_id' => $course->guide_id]
            );
        }

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
            'category_id' => ['required', 'exists:categories,id'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:2048'], // Allowed formats, Max 2MB
        ]);

        $courseData = $request->except('thumbnail');
        
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                \Storage::disk('public')->delete($course->thumbnail);
            }
            
            $thumbnailPath = $request->file('thumbnail')->store('course-thumbnails', 'public');
            $courseData['thumbnail'] = $thumbnailPath;
        }

        $course->update($courseData);

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
