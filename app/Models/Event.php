<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'church_id',
        'congregation_id',
        'title',
        'description',
        'type',
        'starts_at',
        'ends_at',
        'is_recurring',
        'recurring_frequency',
        'location',
        'status',
        'track_attendance',
        'expected_attendees',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_recurring' => 'boolean',
        'track_attendance' => 'boolean',
        'expected_attendees' => 'boolean',
    ];

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function congregation(): BelongsTo
    {
        return $this->belongsTo(Congregation::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('starts_at');
    }

    public function scopePast($query)
    {
        return $query->where('starts_at', '<', now())
            ->orderByDesc('starts_at');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('starts_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('starts_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
            ]);
    }

    public function getTotalAttendeesAttribute(): int
    {
        return $this->attendances()->where('status', 'present')->count();
    }

    public function getAttendancePercentageAttribute(): float
    {
        if (!$this->expected_attendees || $this->expected_attendees === 0) {
            return 0;
        }

        return ($this->total_attendees / $this->expected_attendees) * 100;
    }

    public function isDuringEvent(): bool
    {
        return now()->between($this->starts_at, $this->ends_at);
    }

    public function hasEnded(): bool
    {
        return $this->ends_at && now()->gt($this->ends_at);
    }
}
