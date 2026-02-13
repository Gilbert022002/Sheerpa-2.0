<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\OneTimeSlot;
use App\Services\BookingService;
use App\Services\MeetingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OneToOneBookingController extends Controller
{
    protected $bookingService;
    protected $meetingService;

    public function __construct(BookingService $bookingService, MeetingService $meetingService)
    {
        $this->bookingService = $bookingService;
        $this->meetingService = $meetingService;
    }

    /**
     * Display the booking calendar for one-to-one sessions.
     */
    public function index()
    {
        $guides = User::where('role', 'instructor')
            ->where('instructor_status', 'approved')
            ->get();

        return view('booking.calendar', compact('guides'));
    }

    /**
     * Get available time slots for a specific guide and date.
     */
    public function getAvailableSlots($guideId, $date)
    {
        $guide = User::findOrFail($guideId);

        // Parse the date
        $targetDate = Carbon::parse($date);

        // Get all one-time slots for the guide on the specific date
        $oneTimeSlots = OneTimeSlot::where('guide_id', $guideId)
            ->whereDate('start_datetime', $targetDate)
            ->get();

        // Get all bookings for the guide on the specific date
        $bookings = Booking::where('guide_id', $guideId)
            ->whereDate('start_datetime', $targetDate)
            ->get();

        // Combine and process the slots
        $availableSlots = [];

        foreach ($oneTimeSlots as $slot) {
            $isBooked = false;
            
            // Check if this slot is already booked
            foreach ($bookings as $booking) {
                if (
                    ($slot->start_datetime >= $booking->start_datetime && $slot->start_datetime < $booking->end_datetime) ||
                    ($slot->end_datetime > $booking->start_datetime && $slot->end_datetime <= $booking->end_datetime) ||
                    ($slot->start_datetime <= $booking->start_datetime && $slot->end_datetime >= $booking->end_datetime)
                ) {
                    $isBooked = true;
                    break;
                }
            }

            if (!$isBooked && $slot->is_available) {
                $availableSlots[] = [
                    'id' => $slot->id,
                    'start_datetime' => $slot->start_datetime,
                    'end_datetime' => $slot->end_datetime,
                    'time_range' => Carbon::parse($slot->start_datetime)->format('H:i') . ' - ' . Carbon::parse($slot->end_datetime)->format('H:i'),
                    'is_booked' => false
                ];
            }
        }

        // Also check recurring availability for this day of week
        $dayOfWeek = $targetDate->dayOfWeek; // 0 for Sunday, 1 for Monday, etc.
        
        $recurringAvailabilities = $guide->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get();

        foreach ($recurringAvailabilities as $availability) {
            $slotStart = $targetDate->copy()->setTimeFromTimeString($availability->start_time);
            $slotEnd = $targetDate->copy()->setTimeFromTimeString($availability->end_time);

            // Check if this recurring slot conflicts with any existing bookings
            $hasConflict = false;
            foreach ($bookings as $booking) {
                $bookingStart = Carbon::parse($booking->start_datetime);
                $bookingEnd = Carbon::parse($booking->end_datetime);

                // Check for overlap
                if (
                    ($slotStart < $bookingEnd && $slotEnd > $bookingStart)
                ) {
                    $hasConflict = true;
                    break;
                }
            }

            // Check if this recurring slot conflicts with any one-time slots that are booked
            if (!$hasConflict) {
                foreach ($oneTimeSlots as $oneTimeSlot) {
                    if (!$oneTimeSlot->is_available) { // If the one-time slot is booked
                        $oneTimeSlotStart = Carbon::parse($oneTimeSlot->start_datetime);
                        $oneTimeSlotEnd = Carbon::parse($oneTimeSlot->end_datetime);

                        if (
                            ($slotStart < $oneTimeSlotEnd && $slotEnd > $oneTimeSlotStart)
                        ) {
                            $hasConflict = true;
                            break;
                        }
                    }
                }
            }

            // If no conflicts, add this recurring availability as an available slot
            if (!$hasConflict) {
                // Create hourly slots within the recurring availability window
                $currentSlotStart = $slotStart->copy();
                
                while ($currentSlotStart < $slotEnd) {
                    $currentSlotEnd = $currentSlotStart->copy()->addHour();
                    
                    // Make sure we don't exceed the availability end time
                    if ($currentSlotEnd > $slotEnd) {
                        $currentSlotEnd = $slotEnd;
                    }
                    
                    // Check if this specific hour conflicts with any existing bookings
                    $hourHasConflict = false;
                    foreach ($bookings as $booking) {
                        $bookingStart = Carbon::parse($booking->start_datetime);
                        $bookingEnd = Carbon::parse($booking->end_datetime);

                        if (
                            ($currentSlotStart < $bookingEnd && $currentSlotEnd > $bookingStart)
                        ) {
                            $hourHasConflict = true;
                            break;
                        }
                    }
                    
                    // Check against booked one-time slots
                    if (!$hourHasConflict) {
                        foreach ($oneTimeSlots as $oneTimeSlot) {
                            if (!$oneTimeSlot->is_available) { // If the one-time slot is booked
                                $oneTimeSlotStart = Carbon::parse($oneTimeSlot->start_datetime);
                                $oneTimeSlotEnd = Carbon::parse($oneTimeSlot->end_datetime);

                                if (
                                    ($currentSlotStart < $oneTimeSlotEnd && $currentSlotEnd > $oneTimeSlotStart)
                                ) {
                                    $hourHasConflict = true;
                                    break;
                                }
                            }
                        }
                    }
                    
                    if (!$hourHasConflict) {
                        // Check if this slot already exists in availableSlots to avoid duplicates
                        $alreadyExists = false;
                        foreach ($availableSlots as $existingSlot) {
                            if (
                                $existingSlot['start_datetime'] == $currentSlotStart &&
                                $existingSlot['end_datetime'] == $currentSlotEnd
                            ) {
                                $alreadyExists = true;
                                break;
                            }
                        }
                        
                        if (!$alreadyExists) {
                            $availableSlots[] = [
                                'id' => null, // No specific one-time slot ID for recurring availability
                                'start_datetime' => $currentSlotStart,
                                'end_datetime' => $currentSlotEnd,
                                'time_range' => $currentSlotStart->format('H:i') . ' - ' . $currentSlotEnd->format('H:i'),
                                'is_booked' => false
                            ];
                        }
                    }
                    
                    $currentSlotStart = $currentSlotEnd;
                }
            }
        }

        // Sort slots by start time
        usort($availableSlots, function ($a, $b) {
            return strtotime($a['start_datetime']) - strtotime($b['start_datetime']);
        });

        return response()->json(['slots' => $availableSlots]);
    }

    /**
     * Create a new booking for a one-to-one session.
     */
    public function createBooking(Request $request)
    {
        $request->validate([
            'guide_id' => 'required|exists:users,id',
            'start_datetime' => 'required|date|after_or_equal:now',
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $guide = User::findOrFail($request->guide_id);
        $user = Auth::user();
        $startDateTime = Carbon::parse($request->start_datetime);
        $endDateTime = Carbon::parse($request->end_datetime);

        // Check if the requested time slot is still available
        $isAvailable = $this->bookingService->isTimeSlotAvailable($guide->id, $startDateTime, $endDateTime);
        
        if (!$isAvailable) {
            return back()->with('error', 'Le créneau sélectionné n\'est plus disponible. Veuillez en sélectionner un autre.');
        }

        try {
            DB::transaction(function () use ($guide, $user, $startDateTime, $endDateTime) {
                // Create the booking
                $booking = Booking::create([
                    'course_id' => null, // One-to-one session, not tied to a specific course
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                    'start_datetime' => $startDateTime,
                    'end_datetime' => $endDateTime,
                    'status' => 'confirmed', // Since it's a one-to-one session, we can confirm immediately
                    'payment_status' => 'free', // For now, assuming one-to-one sessions are free
                ]);

                try {
                    // Create Jitsi meeting link for the booking
                    $meetingLink = $this->meetingService->createMeetingLink($booking);
                    $booking->meeting_link = $meetingLink;
                    $booking->save();
                } catch (\Exception $e) {
                    \Log::error('Error creating meeting link: ' . $e->getMessage());
                    // Still continue with the booking, but log the error
                }
            });

            return redirect()->route('user.bookings.index')->with('status', 'Votre session a été réservée avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la réservation: ' . $e->getMessage());
        }
    }
}