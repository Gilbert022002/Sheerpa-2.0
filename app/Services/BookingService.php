<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\Booking;
use Carbon\Carbon;

class BookingService
{
    /**
     * Verify that a given time slot is available for a guide.
     *
     * @param Course $course The course being booked.
     * @param User $guide The instructor user.
     * @param Carbon $startDatetime The desired start datetime of the booking.
     * @param Carbon $endDatetime The desired end datetime of the booking.
     * @throws \Exception If the slot is not available.
     */
    public function verifySlotAvailability(Course $course, User $guide, Carbon $startDatetime, Carbon $endDatetime): void
    {
        // 1. Check if the slot is in the past
        if ($startDatetime->isBefore(Carbon::now())) {
            throw new \Exception('Cannot book a slot in the past.');
        }

        // 2. Check if the slot conflicts with guide's existing confirmed bookings
        $conflict = $guide->receivedBookings()->where('status', 'confirmed')
            ->where(function ($query) use ($startDatetime, $endDatetime) {
                $query->where('start_datetime', '<', $endDatetime)
                      ->where('end_datetime', '>', $startDatetime);
            })->exists();

        if ($conflict) {
            throw new \Exception('This slot is already booked.');
        }

        // 3. Check if the slot conflicts with guide's one-time slots that are marked as unavailable
        $oneTimeSlotConflict = $guide->oneTimeSlots()
            ->where('is_available', false)
            ->where(function ($query) use ($startDatetime, $endDatetime) {
                $query->where('start_datetime', '<', $endDatetime)
                      ->where('end_datetime', '>', $startDatetime);
            })->exists();

        if ($oneTimeSlotConflict) {
            throw new \Exception('This slot is not available.');
        }

        // 4. (Optional but good practice) Check if this slot aligns with guide's recurring availabilities
        // This is a more complex check. For now, we assume the UI (FullCalendar) only shows valid slots based on AvailabilityService.
        // If direct booking without UI interaction is allowed, this check becomes critical here.
        // For simplicity, we trust the AvailabilityService has provided a valid slot based on recurring rules.
    }

    /**
     * Create a new booking.
     *
     * @param array $data Booking data including course_id, guide_id, user_id, start_datetime, end_datetime.
     * @return Booking
     */
    public function createBooking(array $data): Booking
    {
        // Additional checks could go here before creating the booking
        return Booking::create($data);
    }
}