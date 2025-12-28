<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'church_id',
        'member_id',
        'message_template_id',
        'user_id',
        'channel',
        'recipient',
        'content',
        'status',
        'sent_at',
        'delivered_at',
        'read_at',
        'is_scheduled',
        'scheduled_for',
        'external_id',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'is_scheduled' => 'boolean',
        'scheduled_for' => 'datetime',
    ];

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MessageTemplate::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSent($query)
    {
        return $query->whereIn('status', ['sent', 'delivered', 'read']);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeScheduled($query)
    {
        return $query->where('scheduled', true)
            ->where('scheduled_for', '>', now());
    }
}
