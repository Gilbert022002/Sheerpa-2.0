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
        // Get available slots for this course's guide
        // This now includes both recurring availabilities and one-time slots
        $availableSlots = $this->availabilityService->getAvailableSlots($course->guide, $course->duration, 30); // 30 days

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
        $end_datetime = $start_datetime->copy()->addMinutes($course->duration);

        // Prevent double booking at the database level using transaction
        try {
            DB::transaction(function () use ($course, $guide, $user, $start_datetime, $end_datetime) {
                // Verify that the slot is still available and not already booked
                $this->bookingService->verifySlotAvailability($course, $guide, $start_datetime, $end_datetime);

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

                    // Create Jitsi meeting link
                    $meetingLink = $this->meetingService->createMeetingLink($booking);
                    $booking->meeting_link = $meetingLink;
                    $booking->save();
                } else {
                    $booking->payment_status = 'free'; // For free courses
                    $booking->status = 'confirmed';
                    $booking->save();
                    
                    // Create Jitsi meeting link for free courses
                    $meetingLink = $this->meetingService->createMeetingLink($booking);
                    $booking->meeting_link = $meetingLink;
                    $booking->save();
                }

                // Mark any corresponding one-time slot as unavailable
                $oneTimeSlot = $guide->oneTimeSlots()
                    ->where('start_datetime', $start_datetime)
                    ->where('end_datetime', $end_datetime)
                    ->first();
                
                if ($oneTimeSlot) {
                    $oneTimeSlot->is_available = false;
                    $oneTimeSlot->save();
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('user.bookings.index')->with('status', 'Course booked successfully! Check your bookings.');
    }
}
