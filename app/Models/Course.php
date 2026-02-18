<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Added this line

class Course extends Model
{
    use HasFactory, SoftDeletes; // Added SoftDeletes trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'guide_id',
        'category_id',
        'duration',
        'level',
        'category',
        'thumbnail',
    ];

    /**
     * Get the category name attribute (accessor for backward compatibility).
     */
    public function getCategoryAttribute()
    {
        return $this->categoryModel ? $this->categoryModel->name : null;
    }

    /**
     * Get the guide that owns the course.
     */
    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id');
    }

    /**
     * Get the category this course belongs to.
     */
    public function categoryModel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the bookings for the course.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the time slots for the course.
     */
    public function courseSlots()
    {
        return $this->hasMany(CourseSlot::class);
    }

    /**
     * Get the users who have favorited this course.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Check if the course is favorited by a specific user.
     */
    public function isFavoritedBy($userId)
    {
        return $this->favoritedBy()->where('user_id', $userId)->exists();
    }
}
