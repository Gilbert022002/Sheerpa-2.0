<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Services\MeetingService;

class UpdateExistingMeetingLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:existing-meeting-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing bookings with new moderator and participant links';

    protected $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        parent::__construct();
        $this->meetingService = $meetingService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find bookings that have a meeting_link but don't have moderator_link or participant_link
        $bookings = Booking::whereNotNull('meeting_link')
            ->where(function ($query) {
                $query->whereNull('moderator_link')
                      ->orWhereNull('participant_link');
            })
            ->get();

        $this->info("Found {$bookings->count()} bookings to update.");

        foreach ($bookings as $booking) {
            try {
                // Generate new links
                $meetingLinks = $this->meetingService->createMeetingLink($booking);

                // Update the booking with new links
                $booking->update([
                    'moderator_link' => $meetingLinks['moderator_link'],
                    'participant_link' => $meetingLinks['participant_link']
                ]);

                $this->info("Updated booking {$booking->id} with new links.");
            } catch (\Exception $e) {
                $this->error("Failed to update booking {$booking->id}: " . $e->getMessage());
            }
        }

        $this->info("All eligible bookings have been updated.");
    }
}
