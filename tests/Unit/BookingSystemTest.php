<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Booking;
use App\Models\OneTimeSlot;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class BookingSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_available_slots()
    {
        // Create a user and a guide
        $user = User::factory()->create();
        $guide = User::factory()->create(['role' => 'instructor', 'instructor_status' => 'approved']);

        // Create a one-time slot for the guide
        $oneTimeSlot = OneTimeSlot::create([
            'guide_id' => $guide->id,
            'start_datetime' => Carbon::tomorrow()->setHours(10)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(11)->setMinutes(0),
            'is_available' => true,
        ]);

        // Authenticate as the user
        $this->actingAs($user);

        // Call the API endpoint to get available slots
        $response = $this->getJson(route('user.api.available-slots', [$guide->id, Carbon::tomorrow()->toDateString()]));

        // Assert that the response contains the available slot
        $response->assertStatus(200)
                 ->assertJsonStructure(['slots' => [['id', 'start_datetime', 'end_datetime', 'time_range', 'is_booked']]])
                 ->assertJsonFragment([
                     'start_datetime' => Carbon::tomorrow()->setHours(10)->setMinutes(0)->format('Y-m-d H:i:s'),
                     'is_booked' => false
                 ]);
    }

    public function test_user_can_book_available_slot()
    {
        // Create a user and a guide
        $user = User::factory()->create();
        $guide = User::factory()->create(['role' => 'instructor', 'instructor_status' => 'approved']);

        // Create a one-time slot for the guide
        $oneTimeSlot = OneTimeSlot::create([
            'guide_id' => $guide->id,
            'start_datetime' => Carbon::tomorrow()->setHours(14)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(15)->setMinutes(0),
            'is_available' => true,
        ]);

        // Authenticate as the user
        $this->actingAs($user);

        // Attempt to book the slot
        $response = $this->followingRedirects()->post(route('user.bookings.one-to-one.create'), [
            'guide_id' => $guide->id,
            'start_datetime' => Carbon::tomorrow()->setHours(14)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(15)->setMinutes(0),
        ]);

        // Assert that the booking was created successfully
        $response->assertSuccessful();

        // Check that the booking exists in the database
        $this->assertDatabaseHas('bookings', [
            'guide_id' => $guide->id,
            'user_id' => $user->id,
            'start_datetime' => Carbon::tomorrow()->setHours(14)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(15)->setMinutes(0),
            'status' => 'confirmed',
        ]);
    }

    public function test_booking_prevents_double_booking()
    {
        // Create a user and a guide
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $guide = User::factory()->create(['role' => 'instructor', 'instructor_status' => 'approved']);

        // Create a one-time slot for the guide
        $oneTimeSlot = OneTimeSlot::create([
            'guide_id' => $guide->id,
            'start_datetime' => Carbon::tomorrow()->setHours(16)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(17)->setMinutes(0),
            'is_available' => true,
        ]);

        // Authenticate as the first user and book the slot
        $this->actingAs($user1);

        $response1 = $this->followingRedirects()->post(route('user.bookings.one-to-one.create'), [
            'guide_id' => $guide->id,
            'start_datetime' => Carbon::tomorrow()->setHours(16)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(17)->setMinutes(0),
        ]);

        $response1->assertSuccessful();

        // Authenticate as the second user and try to book the same slot
        $this->actingAs($user2);

        $response2 = $this->post(route('user.bookings.one-to-one.create'), [
            'guide_id' => $guide->id,
            'start_datetime' => Carbon::tomorrow()->setHours(16)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(17)->setMinutes(0),
        ]);

        // The second booking should fail
        $response2->assertSessionHasErrors(); // This assumes the controller returns with errors
        
        // Alternative: Check that only one booking exists for that time slot
        $bookings = Booking::where('guide_id', $guide->id)
                          ->where('start_datetime', Carbon::tomorrow()->setHours(16)->setMinutes(0))
                          ->get();
        
        $this->assertCount(1, $bookings);
    }

    public function test_booking_service_detects_unavailable_slots()
    {
        $bookingService = new BookingService();
        
        // Create a user and a guide
        $user = User::factory()->create();
        $guide = User::factory()->create(['role' => 'instructor', 'instructor_status' => 'approved']);

        // Create an existing booking
        Booking::create([
            'course_id' => null,
            'guide_id' => $guide->id,
            'user_id' => $user->id,
            'start_datetime' => Carbon::tomorrow()->setHours(9)->setMinutes(0),
            'end_datetime' => Carbon::tomorrow()->setHours(10)->setMinutes(0),
            'status' => 'confirmed',
            'payment_status' => 'free',
        ]);

        // Try to check if the same time slot is available
        $isAvailable = $bookingService->isTimeSlotAvailable(
            $guide->id,
            Carbon::tomorrow()->setHours(9)->setMinutes(30), // Overlapping time
            Carbon::tomorrow()->setHours(10)->setMinutes(30)
        );

        $this->assertFalse($isAvailable);
    }
}