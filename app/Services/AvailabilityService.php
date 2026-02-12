<?php

namespace App\Services;

use App\Models\User;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\OneTimeSlot;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval; // Added this line

class AvailabilityService
{
    /**
     * Get available time slots for a specific course.
     *
     * @param \App\Models\Course $course The course to get slots for.
     * @return array<Carbon> An array of available Carbon instances representing start times.
     */
    public function getAvailableSlotsForCourse(\App\Models\Course $course): array
    {
        $courseSlots = $course->courseSlots()->where('is_available', true)->get();
        $bookings = $course->bookings()->where('status', 'confirmed')
                                    ->where('start_datetime', '>=', Carbon::now())
                                    ->get();

        $availableSlots = [];

        foreach ($courseSlots as $slot) {
            $slotStart = Carbon::parse($slot->start_datetime);
            $slotEnd = Carbon::parse($slot->end_datetime);

            // Check for conflicts with existing bookings
            $conflict = $bookings->contains(function (Booking $booking) use ($slotStart, $slotEnd) {
                return ($slotStart->lessThan($booking->end_datetime) && $slotEnd->greaterThan($booking->start_datetime));
            });

            if (!$conflict) {
                // Add both start and end times to the slot object for use in the view
                $slot->start_time = $slotStart;
                $slot->end_time = $slotEnd;
                $availableSlots[] = $slot;
            }
        }

        // Sort slots chronologically
        usort($availableSlots, function ($a, $b) {
            return $a->start_time->timestamp - $b->start_time->timestamp;
        });

        return $availableSlots;
    }
}