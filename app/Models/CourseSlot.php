<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'start_datetime',
        'end_datetime',
        'is_available',
    ];

    /**
     * Get the course that owns the slot.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
