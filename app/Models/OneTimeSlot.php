<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimeSlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guide_id',
        'start_datetime',
        'end_datetime',
        'is_available',
    ];

    /**
     * Get the guide that owns the one-time slot.
     */
    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id');
    }
}
