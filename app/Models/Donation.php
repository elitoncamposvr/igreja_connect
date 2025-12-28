<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'church_id',
        'member_id',
        'payment_method_id',
        'user_id',
        'type',
        'amount',
        'donated_at',
        'external_id',
        'payment_status',
        'receipt_issued',
        'receipt_issued_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'donated_at' => 'date',
        'receipt_issued' => 'boolean',
        'receipt_issued_at' => 'date',
    ];

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeTithes($query)
    {
        return $query->where('type', 'tithe');
    }

    public function scopeOfferings($query)
    {
        return $query->where('type', 'offering');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('payment_status', 'confirmed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('donated_at', now()->year)
            ->whereMonth('donated_at', now()->month);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('donated_at', now()->year);
    }

    public function scopeByYear($query, int $year)
    {
        return $query->whereYear('donated_at', $year);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getTypeNameAttribute(): string
    {
        $types = [
            'tithe' => 'Dízimo',
            'offering' => 'Oferta',
            'special' => 'Doação Especial',
            'mission' => 'Missões',
            'other' => 'Outro',
        ];

        return $types[$this->type] ?? 'Não definido';
    }
}
