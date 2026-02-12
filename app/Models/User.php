<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'instructor_status',
        'experience',
        'stripe_account_id',
        'presentation_video_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the courses for the user (if they are an instructor).
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'guide_id');
    }

    /**
     * Get the availabilities for the user (if they are an instructor).
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'guide_id');
    }

    /**
     * Get the one-time slots for the user (if they are an instructor).
     */
    public function oneTimeSlots()
    {
        return $this->hasMany(OneTimeSlot::class, 'guide_id');
    }

    /**
     * Get the bookings made by the user (as a student).
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    /**
     * Get the bookings received by the user (as a guide/instructor).
     */
    public function receivedBookings()
    {
        return $this->hasMany(Booking::class, 'guide_id');
    }
}
