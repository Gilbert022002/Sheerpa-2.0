<?php

namespace App\Services;

use App\Models\Booking; // Added this line

class MeetingService
{
    /**
     * Generate a unique Jitsi meeting link for a given booking.
     *
     * @param Booking $booking
     * @return string The Jitsi meeting URL
     */
    public function createMeetingLink(Booking $booking): string
    {
        try {
            // Jitsi Meet room names should be unique.
            // We can base it on a unique identifier from the booking, e.g., UUID or booking ID + some random string.
            // For simplicity, let's use the booking ID and a hash.
            $roomName = 'sheerpa-meeting-' . $booking->id . '-' . uniqid();

            // Base Jitsi Meet URL (can be configured in .env)
            // For example: JITSI_BASE_URL=https://meet.jit.si/
            $jitsiBaseUrl = config('services.jitsi.base_url', 'https://meet.jit.si/');

            return $jitsiBaseUrl . $roomName;
        } catch (\Exception $e) {
            \Log::error('Error in MeetingService createMeetingLink: ' . $e->getMessage());
            // Return empty link in case of error
            return null;
        }
    }
}