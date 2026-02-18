<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendMeetingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meetings:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send meeting reminders 1 hour before the meeting starts';

    protected NotificationService $notificationService;

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService): int
    {
        $this->notificationService = $notificationService;

        // Find meetings starting in exactly 1 hour (between 55-65 minutes from now to account for execution time)
        $now = Carbon::now();
        $inOneHour = $now->copy()->addHour();
        
        $bookings = Booking::where('status', 'confirmed')
            ->whereBetween('start_datetime', [
                $now->copy()->addMinutes(55),
                $now->copy()->addMinutes(65)
            ])
            ->with(['user', 'guide', 'course'])
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No meetings starting in the next hour.');
            return Command::SUCCESS;
        }

        $this->info("Found {$bookings->count()} meeting(s) starting in the next hour.");

        foreach ($bookings as $booking) {
            try {
                $this->notificationService->sendMeetingOneHourReminderNotification($booking);
                $this->info("✓ Sent reminder for meeting #{$booking->id} ({$booking->user->name} with {$booking->guide->name})");
            } catch (\Exception $e) {
                $this->error("✗ Failed to send reminder for meeting #{$booking->id}: {$e->getMessage()}");
            }
        }

        $this->info("Successfully sent {$bookings->count()} meeting reminder(s).");
        
        return Command::SUCCESS;
    }
}
