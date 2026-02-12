<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'guide_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_active',
    ];

    /**
     * Get the guide that owns the availability.
     */
    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id');
    }
}
