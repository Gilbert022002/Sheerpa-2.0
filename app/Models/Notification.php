<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the notification is unread.
     */
    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    /**
     * Check if the notification is read.
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread(): void
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Get the icon for the notification type.
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'meeting_reservation' => 'calendar_month',
            'meeting_reminder' => 'notifications',
            'meeting_cancelled' => 'cancel',
            'course_created' => 'school',
            'course_updated' => 'edit',
            'course_deleted' => 'delete',
            'booking_confirmed' => 'check_circle',
            'booking_cancelled' => 'cancel',
            default => 'notifications',
        };
    }

    /**
     * Get the color class for the notification type.
     */
    public function getColorAttribute(): string
    {
        return match($this->type) {
            'meeting_reservation', 'booking_confirmed' => 'text-green-600 bg-green-100',
            'meeting_reminder' => 'text-primary bg-primary/10',
            'meeting_cancelled', 'booking_cancelled' => 'text-red-600 bg-red-100',
            'course_created' => 'text-primary bg-primary/10',
            'course_updated' => 'text-blue-600 bg-blue-100',
            'course_deleted' => 'text-gray-600 bg-gray-100',
            default => 'text-text-sub-light bg-slate-100',
        };
    }
}
