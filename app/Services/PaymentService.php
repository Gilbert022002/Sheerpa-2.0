<?php

namespace App\Services;

use App\Models\Booking; // Added this line
use App\Models\Course; // Added this line

class PaymentService
{
    /**
     * Process payment for a booking.
     * This is a placeholder for actual payment gateway integration (e.g., Stripe).
     *
     * @param Booking $booking The booking instance.
     * @param float $amount The amount to charge.
     * @return bool True if payment is successful, false otherwise.
     */
    public function processPayment(Booking $booking, float $amount): bool
    {
        // In a real application, this would integrate with a payment gateway (e.g., Stripe)
        // It would involve:
        // 1. Creating a Payment Intent or charging a customer.
        // 2. Handling 3D Secure or other verification flows.
        // 3. Updating booking status based on payment outcome (often via webhooks for async processing).

        // For now, simulate a successful payment if amount > 0, otherwise it's free/handled separately.
        if ($amount > 0) {
            // Simulate payment processing time
            sleep(1); 
            // Simulate a 90% success rate for demonstration
            return (rand(1, 10) <= 9); 
        }

        return true; // Free courses don't require external payment
    }
}