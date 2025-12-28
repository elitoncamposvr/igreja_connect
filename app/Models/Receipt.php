<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    protected $fillable = [
        'church_id',
        'member_id',
        'receipt_number',
        'year',
        'total_amount',
        'tithe_amount',
        'offering_amount',
        'special_amount',
        'pdf_path',
        'generated_at',
        'sent_to_member',
        'sent_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'total_amount' => 'decimal:2',
        'tithe_amount' => 'decimal:2',
        'offering_amount' => 'decimal:2',
        'special_amount' => 'decimal:2',
        'generated_at' => 'datetime',
        'sent_to_member' => 'boolean',
        'sent_at' => 'datetime',
    ];

    public function church(): belongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function member(): belongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'R$ ' . number_format($this->total_amount, 2, ',', '.');
    }
}
