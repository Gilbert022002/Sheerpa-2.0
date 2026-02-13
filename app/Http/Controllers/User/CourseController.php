<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Booking;
use App\Services\AvailabilityService;
use App\Services\BookingService;
use App\Services\PaymentService;
use App\Services\MeetingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    protected $availabilityService;
    protected $bookingService;
    protected $paymentService;
    protected $meetingService;

    public function __construct(AvailabilityService $availabilityService, BookingService $bookingService, PaymentService $paymentService, MeetingService $meetingService)
    {
        $this->availabilityService = $availabilityService;
        $this->bookingService = $bookingService;
        $this->paymentService = $paymentService;
        $this->meetingService = $meetingService;
    }

    /**
     * Display a listing of all available courses.
     */
    public function index()
    {
        $courses = Course::with('guide')->latest()->paginate(10); // Example, adjust as needed
        return view('user.courses.index', compact('courses'));
    }

    /**
     * Display the specified course, including its calendar for booking.
     */
    public function show(Course $course)
    {
        // Get available slots for this specific course
        $availableSlots = $this->availabilityService->getAvailableSlotsForCourse($course);

        return view('user.courses.show', compact('course', 'availableSlots'));
    }

    /**
     * Handle the booking request for a course.
     */
    public function book(Request $request, Course $course)
    {
        $request->validate([
            'start_datetime' => ['required', 'date', 'after_or_equal:now'],
        ]);

        $guide = $course->guide;
        $user = Auth::user();
        $start_datetime = \Carbon\Carbon::parse($request->start_datetime);
        
        // Find the exact slot to get the correct end time
        $selectedSlot = $course->courseSlots()
            ->where('start_datetime', $start_datetime->format('Y-m-d H:i:s'))
            ->firstOrFail();
        
        $end_datetime = \Carbon\Carbon::parse($selectedSlot->end_datetime);

        // Prevent double booking at the database level using transaction
        try {
            DB::transaction(function () use ($course, $guide, $user, $start_datetime, $end_datetime) {
                // Verify that the slot is still available and not already booked
                $this->bookingService->verifySlotAvailability($course, $start_datetime, $end_datetime);

                // Create booking with pending payment status
                $booking = Booking::create([
                    'course_id' => $course->id,
                    'guide_id' => $guide->id,
                    'user_id' => $user->id,
                    'start_datetime' => $start_datetime,
                    'end_datetime' => $end_datetime,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                ]);

                // Handle payment
                if ($course->price > 0) {
                    // This is a placeholder for actual payment processing (e.g., Stripe Checkout)
                    // The payment service would return a redirect URL or handle the payment flow
                    // For now, we'll simulate success or failure
                    $paymentSuccess = $this->paymentService->processPayment($booking, $course->price);

                    if (!$paymentSuccess) {
                        throw new \Exception('Payment failed.');
                    }
                    $booking->payment_status = 'paid';
                    $booking->status = 'confirmed'; // Confirm only after payment success
                    $booking->save();

                    try {
                        // Create Jitsi meeting link for the booking
                        $meetingLink = $this->meetingService->createMeetingLink($booking);
                        $booking->meeting_link = $meetingLink;
                        $booking->save();
                    } catch (\Exception $e) {
                        \Log::error('Error creating meeting link: ' . $e->getMessage());
                        // Still continue with the booking, but log the error
                    }
                } else {
                    $booking->payment_status = 'free'; // For free courses
                    $booking->status = 'confirmed';
                    $booking->save();
                    
                    try {
                        // Create Jitsi meeting link for the booking
                        $meetingLink = $this->meetingService->createMeetingLink($booking);
                        $booking->meeting_link = $meetingLink;
                        $booking->save();
                    } catch (\Exception $e) {
                        \Log::error('Error creating meeting link: ' . $e->getMessage());
                        // Still continue with the booking, but log the error
                    }
                }

                // Mark the corresponding course slot as unavailable
                $courseSlot = $course->courseSlots()
                    ->where('start_datetime', $start_datetime->format('Y-m-d H:i:s'))
                    ->where('end_datetime', $end_datetime->format('Y-m-d H:i:s'))
                    ->first();
                
                if ($courseSlot) {
                    $courseSlot->is_available = false;
                    $courseSlot->save();
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('user.bookings.index')->with('status', 'Course booked successfully! Check your bookings.');
    }

    /**
     * Display the user's bookings.
     */
    public function bookings()
    {
        $bookings = auth()->user()->bookings()->with(['course', 'guide'])->get();
        return view('user.bookings.index', compact('bookings'));
    }
}
