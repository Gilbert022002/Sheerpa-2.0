<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'guide_id',
        'user_id',
        'start_datetime',
        'end_datetime',
        'status',
        'payment_status',
        'meeting_link',
    ];

    /**
     * Get the course that the booking belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the guide (instructor) for the booking.
     */
    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id');
    }

    /**
     * Get the user who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
