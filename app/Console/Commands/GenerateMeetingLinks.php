<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Services\MeetingService;
use Carbon\Carbon;

class GenerateMeetingLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:generate-meeting-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate meeting links for bookings that are starting now';

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
        $now = Carbon::now();
        
        // Find bookings that are starting now (within the last minute to account for scheduling delays)
        $bookings = Booking::whereNull('meeting_link') // Only bookings without a meeting link yet
            ->where('status', 'confirmed') // Only confirmed bookings
            ->whereBetween('start_datetime', [
                $now->copy()->subMinute(), // Started within the last minute
                $now->copy()->addSecond()  // Or starting within the next second
            ])
            ->get();

        foreach ($bookings as $booking) {
            try {
                // Check if meeting link already exists to avoid duplicates
                if (!empty($booking->meeting_link)) {
                    $this->info("Booking {$booking->id} already has a meeting link");
                    continue;
                }

                // Generate the meeting link
                $meetingLink = $this->meetingService->createMeetingLink($booking);

                // Update the booking with the meeting link
                $booking->update(['meeting_link' => $meetingLink]);

                $this->info("Generated meeting link for booking {$booking->id}");
            } catch (\Exception $e) {
                $this->error("Failed to generate meeting link for booking {$booking->id}: " . $e->getMessage());
            }
        }

        if ($bookings->isEmpty()) {
            $this->info("No bookings starting now.");
        }
    }
}
