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

    /**
     * Check if a time slot is available for a specific guide.
     *
     * @param int $guideId The ID of the guide.
     * @param Carbon $startDateTime The start datetime of the slot.
     * @param Carbon $endDateTime The end datetime of the slot.
     * @return bool True if the slot is available, false otherwise.
     */
    public function isTimeSlotAvailable(int $guideId, Carbon $startDateTime, Carbon $endDateTime): bool
    {
        // Check if there's already a booking for this guide that overlaps with the requested time
        $existingBooking = Booking::where('guide_id', $guideId)
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->where(function ($q) use ($startDateTime, $endDateTime) {
                    $q->where('start_datetime', '<', $endDateTime)
                      ->where('start_datetime', '>=', $startDateTime);
                })
                ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                    $q->where('end_datetime', '>', $startDateTime)
                      ->where('end_datetime', '<=', $endDateTime);
                })
                ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                    $q->where('start_datetime', '<=', $startDateTime)
                      ->where('end_datetime', '>=', $endDateTime);
                });
            })
            ->exists();

        if ($existingBooking) {
            return false;
        }

        // Check if there's a one-time slot that's not available and overlaps with the requested time
        $oneTimeSlot = \App\Models\OneTimeSlot::where('guide_id', $guideId)
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->where(function ($q) use ($startDateTime, $endDateTime) {
                    $q->where('start_datetime', '<', $endDateTime)
                      ->where('start_datetime', '>=', $startDateTime);
                })
                ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                    $q->where('end_datetime', '>', $startDateTime)
                      ->where('end_datetime', '<=', $endDateTime);
                })
                ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                    $q->where('start_datetime', '<=', $startDateTime)
                      ->where('end_datetime', '>=', $endDateTime);
                });
            })
            ->where('is_available', false) // Slot is marked as not available
            ->exists();

        if ($oneTimeSlot) {
            return false;
        }

        return true;
    }
}