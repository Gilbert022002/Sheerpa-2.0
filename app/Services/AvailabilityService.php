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
     * Generate available time slots for a guide.
     *
     * @param User $guide The instructor user.
     * @param int $courseDuration The duration of the course in minutes.
     * @param int $daysToLookAhead Number of days to generate slots for.
     * @return array<Carbon> An array of available Carbon instances representing start times.
     */
    public function getAvailableSlots(User $guide, int $courseDuration, int $daysToLookAhead = 30): array
    {
        $guideAvailabilities = $guide->availabilities()->where('is_active', true)->get();
        $oneTimeSlots = $guide->oneTimeSlots()->where('is_available', true)
                                           ->where('start_datetime', '>=', Carbon::now())
                                           ->get();
        $bookings = $guide->bookings()->where('status', 'confirmed')
                                    ->where('start_datetime', '>=', Carbon::now())
                                    ->get();

        $availableSlots = [];
        $now = Carbon::now();

        // Process recurring availabilities
        foreach ($guideAvailabilities as $availability) {
            for ($i = 0; $i < $daysToLookAhead; $i++) {
                $date = $now->copy()->addDays($i);

                // Check if the current day matches the availability's day of week
                if ($date->dayOfWeek === $availability->day_of_week) {
                    $periodStart = $date->copy()->setTimeFromTimeString($availability->start_time);
                    $periodEnd = $date->copy()->setTimeFromTimeString($availability->end_time);

                    // Generate slots within this availability period
                    $interval = CarbonInterval::minutes($courseDuration);
                    // Ensure the period ends correctly to not create slots that start outside the end time
                    $slots = CarbonPeriod::since($periodStart)->interval($interval)->until($periodEnd->copy()->subMinutes($courseDuration)->addSecond());

                    foreach ($slots as $slot) {
                        // Ensure slot is in the future
                        if ($slot->isBefore($now)) {
                            continue;
                        }

                        $slotEnd = $slot->copy()->addMinutes($courseDuration);

                        // Check for conflicts with existing bookings
                        $conflict = $bookings->contains(function (Booking $booking) use ($slot, $slotEnd) {
                            return ($slot->lessThan($booking->end_datetime) && $slotEnd->greaterThan($booking->start_datetime));
                        });

                        if (!$conflict) {
                            $availableSlots[] = $slot;
                        }
                    }
                }
            }
        }

        // Process one-time slots
        foreach ($oneTimeSlots as $oneTimeSlot) {
            $slotStart = Carbon::instance($oneTimeSlot->start_datetime);
            $slotEnd = Carbon::instance($oneTimeSlot->end_datetime);

            // Check if the slot duration matches the course duration
            $actualDuration = $slotStart->diffInMinutes($slotEnd);
            
            if ($actualDuration >= $courseDuration) { // Slot is at least as long as the course
                // Check for conflicts with existing bookings
                $conflict = $bookings->contains(function (Booking $booking) use ($slotStart, $slotEnd) {
                    return ($slotStart->lessThan($booking->end_datetime) && $slotEnd->greaterThan($booking->start_datetime));
                });

                if (!$conflict) {
                    $availableSlots[] = $slotStart;
                }
            }
        }

        // Sort slots chronologically
        usort($availableSlots, function (Carbon $a, Carbon $b) {
            return $a->timestamp - $b->timestamp;
        });

        return $availableSlots;
    }
}