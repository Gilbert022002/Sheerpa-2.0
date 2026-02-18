<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Booking;
use App\Models\Course;

class NotificationService
{
    /**
     * Send a meeting reservation notification to the tutor.
     */
    public function sendMeetingReservationNotification(Booking $booking): void
    {
        $tutor = $booking->guide;
        
        Notification::create([
            'user_id' => $tutor->id,
            'type' => 'meeting_reservation',
            'title' => 'Nouvelle réservation de meeting',
            'message' => sprintf(
                '%s a réservé un meeting pour le cours "%s" le %s à %s',
                $booking->user->name,
                $booking->course->title ?? 'Session individuelle',
                \Carbon\Carbon::parse($booking->start_datetime)->format('d/m/Y'),
                \Carbon\Carbon::parse($booking->start_datetime)->format('H:i')
            ),
            'data' => [
                'booking_id' => $booking->id,
                'course_id' => $booking->course_id,
                'user_id' => $booking->user_id,
                'start_datetime' => $booking->start_datetime,
            ],
        ]);
    }

    /**
     * Send a meeting reminder notification (on the day of the meeting).
     */
    public function sendMeetingReminderNotification(Booking $booking): void
    {
        $user = $booking->user;
        $tutor = $booking->guide;
        
        // Notify the user
        Notification::create([
            'user_id' => $user->id,
            'type' => 'meeting_reminder',
            'title' => 'Rappel: Meeting aujourd\'hui',
            'message' => sprintf(
                'Votre meeting avec %s pour le cours "%s" est prévu aujourd\'hui à %s',
                $tutor->name,
                $booking->course->title ?? 'Session individuelle',
                \Carbon\Carbon::parse($booking->start_datetime)->format('H:i')
            ),
            'data' => [
                'booking_id' => $booking->id,
                'course_id' => $booking->course_id,
                'start_datetime' => $booking->start_datetime,
            ],
        ]);

        // Notify the tutor
        Notification::create([
            'user_id' => $tutor->id,
            'type' => 'meeting_reminder',
            'title' => 'Rappel: Meeting aujourd\'hui',
            'message' => sprintf(
                'Votre meeting avec %s pour le cours "%s" est prévu aujourd\'hui à %s',
                $user->name,
                $booking->course->title ?? 'Session individuelle',
                \Carbon\Carbon::parse($booking->start_datetime)->format('H:i')
            ),
            'data' => [
                'booking_id' => $booking->id,
                'course_id' => $booking->course_id,
                'user_id' => $booking->user_id,
                'start_datetime' => $booking->start_datetime,
            ],
        ]);
    }

    /**
     * Send a course created notification to the tutor.
     */
    public function sendCourseCreatedNotification(Course $course): void
    {
        $tutor = $course->guide;
        
        Notification::create([
            'user_id' => $tutor->id,
            'type' => 'course_created',
            'title' => 'Nouveau cours créé',
            'message' => sprintf('Votre cours "%s" a été créé avec succès', $course->title),
            'data' => [
                'course_id' => $course->id,
            ],
        ]);
    }

    /**
     * Send a course updated notification to the tutor.
     */
    public function sendCourseUpdatedNotification(Course $course): void
    {
        $tutor = $course->guide;
        
        Notification::create([
            'user_id' => $tutor->id,
            'type' => 'course_updated',
            'title' => 'Cours mis à jour',
            'message' => sprintf('Votre cours "%s" a été mis à jour', $course->title),
            'data' => [
                'course_id' => $course->id,
            ],
        ]);
    }

    /**
     * Send a booking confirmed notification to the user.
     */
    public function sendBookingConfirmedNotification(Booking $booking): void
    {
        $user = $booking->user;
        
        Notification::create([
            'user_id' => $user->id,
            'type' => 'booking_confirmed',
            'title' => 'Réservation confirmée',
            'message' => sprintf(
                'Votre réservation pour le cours "%s" avec %s a été confirmée',
                $booking->course->title ?? 'Session individuelle',
                $booking->guide->name
            ),
            'data' => [
                'booking_id' => $booking->id,
                'course_id' => $booking->course_id,
                'start_datetime' => $booking->start_datetime,
            ],
        ]);
    }

    /**
     * Send a booking cancelled notification.
     */
    public function sendBookingCancelledNotification(Booking $booking): void
    {
        $user = $booking->user;
        $tutor = $booking->guide;
        
        // Notify the user
        Notification::create([
            'user_id' => $user->id,
            'type' => 'booking_cancelled',
            'title' => 'Réservation annulée',
            'message' => sprintf(
                'Votre réservation pour le cours "%s" a été annulée',
                $booking->course->title ?? 'Session individuelle'
            ),
            'data' => [
                'booking_id' => $booking->id,
                'course_id' => $booking->course_id,
            ],
        ]);

        // Notify the tutor
        Notification::create([
            'user_id' => $tutor->id,
            'type' => 'booking_cancelled',
            'title' => 'Réservation annulée',
            'message' => sprintf(
                'La réservation de %s pour le cours "%s" a été annulée',
                $user->name,
                $booking->course->title ?? 'Session individuelle'
            ),
            'data' => [
                'booking_id' => $booking->id,
                'course_id' => $booking->course_id,
                'user_id' => $booking->user_id,
            ],
        ]);
    }

    /**
     * Send a custom notification to a user.
     */
    public function sendCustomNotification(
        User $user,
        string $type,
        string $title,
        string $message,
        array $data = []
    ): void {
        Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Mark all notifications as read for a user.
     */
    public function markAllAsRead(User $user): void
    {
        $user->notifications()->unread()->update(['read_at' => now()]);
    }
}
