<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\Booking;
use Carbon\Carbon;

class BookingService
{
    /**
     * Verify that a given time slot is available for a course.
     *
     * @param Course $course The course being booked.
     * @param Carbon $startDatetime The desired start datetime of the booking.
     * @param Carbon $endDatetime The desired end datetime of the booking.
     * @throws \Exception If the slot is not available.
     */
    public function verifySlotAvailability(Course $course, Carbon $startDatetime, Carbon $endDatetime): void
    {
        // 1. Check if the slot is in the past
        if ($startDatetime->isBefore(Carbon::now())) {
            throw new \Exception('Cannot book a slot in the past.');
        }

        // 2. Check if the slot conflicts with course's existing confirmed bookings
        $conflict = $course->bookings()->where('status', 'confirmed')
            ->where(function ($query) use ($startDatetime, $endDatetime) {
                $query->where('start_datetime', '<', $endDatetime)
                      ->where('end_datetime', '>', $startDatetime);
            })->exists();

        if ($conflict) {
            throw new \Exception('This slot is already booked.');
        }

        // 3. Check if the slot exists in the course's available time slots
        $courseSlot = $course->courseSlots()
            ->where('start_datetime', $startDatetime->format('Y-m-d H:i:s'))
            ->where('end_datetime', $endDatetime->format('Y-m-d H:i:s'))
            ->first();

        if (!$courseSlot) {
            throw new \Exception('This slot is not defined for this course.');
        }

        // 4. Check if the slot is still available (not marked as unavailable)
        if (!$courseSlot->is_available) {
            throw new \Exception('This slot is not available.');
        }
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