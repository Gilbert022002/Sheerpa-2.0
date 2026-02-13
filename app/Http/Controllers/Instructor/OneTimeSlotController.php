<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OneTimeSlot;
use Carbon\Carbon;

class OneTimeSlotController extends Controller
{
    /**
     * Display a listing of the instructor's one-time slots.
     */
    public function index()
    {
        // Récupérer les bookings confirmés de l'instructeur avec les relations nécessaires
        $bookings = Auth::user()->receivedBookings()
            ->where('status', 'confirmed')
            ->where('start_datetime', '>', now())
            ->with(['user', 'course'])
            ->orderBy('start_datetime')
            ->get();
        
        return view('instructor.one-time-slots.index', compact('bookings'));
    }

    /**
     * Store a newly created one-time slot in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_datetime' => ['required', 'date', 'after_or_equal:now'],
            'end_datetime' => ['required', 'date', 'after:start_datetime'],
        ]);

        $start_datetime = Carbon::parse($request->start_datetime);
        $end_datetime = Carbon::parse($request->end_datetime);

        // Check if the slot overlaps with existing bookings
        $existingBooking = Auth::user()->receivedBookings()
            ->where('status', 'confirmed')
            ->where(function ($query) use ($start_datetime, $end_datetime) {
                $query->where('start_datetime', '<', $end_datetime)
                      ->where('end_datetime', '>', $start_datetime);
            })
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Ce créneau chevauche une réservation existante.');
        }

        Auth::user()->oneTimeSlots()->create([
            'start_datetime' => $start_datetime,
            'end_datetime' => $end_datetime,
            'is_available' => true,
        ]);

        return redirect()->route('instructor.one-time-slots.index')->with('status', 'Créneau ponctuel créé avec succès !');
    }

    /**
     * Remove the specified one-time slot from storage.
     */
    public function destroy(OneTimeSlot $oneTimeSlot)
    {
        if ($oneTimeSlot->guide_id !== Auth::id()) {
            abort(403);
        }

        $oneTimeSlot->delete();
        
        return redirect()->route('instructor.one-time-slots.index')->with('status', 'Créneau ponctuel supprimé avec succès !');
    }
}
