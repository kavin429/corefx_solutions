<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'notifiable_id', 
        'notifiable_type', 
        'sender_id', 
        'sender_type', 
        'title', 
        'message', 
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Get the model (User, Admin, etc.) that this notification belongs to.

    public function notifiable()
    {
        return $this->morphTo();
    }

    // Scope to get unread notifications easily.

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Mark notification as read.

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    
}
