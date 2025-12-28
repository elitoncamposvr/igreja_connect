<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'church_id',
        'congregation_id',
        'name',
        'email',
        'phone',
        'cpf',
        'birth_date',
        'gender',
        'photo_path',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'status',
        'baptism_date',
        'conversion_date',
        'membership_date',
        'marital_status',
        'notes',
        'password',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'baptism_date' => 'date',
        'conversion_date' => 'date',
        'membership_date' => 'date',
        'last_login_at' => 'datetime',
    ];

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function congregations(): BelongsTo
    {
        return $this->belongsTo(Congregation::class);
    }

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class)
            ->withPivot(['relationship'])
            ->withTimestamps();
    }

    public function donations(): HasMany
    {
        return this->hasMany(Donation::class);
    }

    public function eventAttendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', ['member', 'congregant']);
    }

    public function scopeMembers($query)
    {
        return $query->where('status', 'member');
    }

    public function scopeVisitors($query)
    {
        return $query->where('status', 'visitor');
    }

    public function scopeBirthdayThisMonth($query)
    {
        return $query->whereMonth('birth_date', now()->month);
    }

    public function scopeBirthdayToday($query)
    {
        return $query->whereMonth('birth_date', now()->month)
            ->whereDay('birth_date', now()->day);
    }

    public function getFullAddressAttribute(): string
    {
        if (!$this->street){
            return 'Não informado';
        }

        return sprintf(
            '%s, %s - %s, %s/%s',
            $this->street,
            $this->number,
            $this->neighborhood ?? '',
            $this->city ?? '',
            $this->state ?? ''
        );
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function getIsBirthdayTodayAttribute(): bool
    {
        if (!$this->birth_date){
            return false;
        }

        return $this->birth_date->month === now()->month
            && $this->birth_date->day === now()->day;
    }

    public function getYearsSinceBaptismAttribute(): ?int
    {
        return $this->baptism_date ? $this->baptism_date->diffInYears(now()) : null;
    }

    public function totalDonations(): float
    {
        return $this->donations()->sum('amount');
    }

    public function donationsThisYear(): float
    {
        return $this->donations()
            ->whereYear('donated_at', now()->year)
            ->sum('amount');
    }

    public function isActiveDonor(): bool
    {
        return $this->donations()
            ->where('donated_at', '>=', now()->subMonths(3))
            ->exists();
    }

}
