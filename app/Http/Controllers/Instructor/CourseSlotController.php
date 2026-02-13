<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseSlot;
use App\Models\Course;
use Carbon\Carbon;

class CourseSlotController extends Controller
{
    /**
     * Display a listing of the course slots for a specific course.
     */
    public function index(Course $course)
    {
        if ($course->guide_id !== Auth::id()) {
            abort(403);
        }

        $courseSlots = $course->courseSlots()->orderBy('start_datetime')->get();
        return view('instructor.course-slots.index', compact('course', 'courseSlots'));
    }

    /**
     * Store a newly created course slot in storage.
     */
    public function store(Request $request, Course $course)
    {
        if ($course->guide_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'start_datetime' => ['required', 'date', 'after_or_equal:now'],
            'end_datetime' => ['required', 'date', 'after:start_datetime'],
        ]);

        $start_datetime = Carbon::parse($request->start_datetime);
        $end_datetime = Carbon::parse($request->end_datetime);

        // Check if the slot overlaps with existing bookings
        $existingBooking = $course->bookings()
            ->where('status', 'confirmed')
            ->where(function ($query) use ($start_datetime, $end_datetime) {
                $query->where('start_datetime', '<', $end_datetime)
                      ->where('end_datetime', '>', $start_datetime);
            })
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Ce créneau chevauche une réservation existante.');
        }

        $courseSlot = $course->courseSlots()->create([
            'start_datetime' => $start_datetime,
            'end_datetime' => $end_datetime,
            'is_available' => true,
        ]);

        \Log::info('New course slot created:', ['slot_id' => $courseSlot->id, 'course_id' => $course->id]);

        return redirect()->route('instructor.courses.show', $course)->with('status', 'Créneau horaire ajouté avec succès !');
    }

    /**
     * Remove the specified course slot from storage.
     */
    public function destroy(CourseSlot $courseSlot)
    {
        if ($courseSlot->course->guide_id !== Auth::id()) {
            abort(403);
        }

        $course = $courseSlot->course;
        $courseSlot->delete();
        
        return redirect()->route('instructor.courses.show', $course)->with('status', 'Créneau horaire supprimé avec succès !');
    }
}
