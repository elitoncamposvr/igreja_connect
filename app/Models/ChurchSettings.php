<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChurchSettings extends Model
{
    protected $fillable = [
        'church_id',
        'allow_pix',
        'pix_key',
        'allow_credit_card',
        'allow_recurring_donations',
        'enable_whatsapp',
        'enable_email',
        'enable_sms',
        'public_financial_reports',
        'show_donor_names',
        'require_member_photo',
        'require_cpf',
        'enable_attendance_control',
        'require_qr_code_checkin',
        'timezone',
    ];

    protected $casts = [
        'allow_pix' => 'boolean',
        'allow_credit_card' => 'boolean',
        'allow_recurring_donations' => 'boolean',
        'enable_whatsapp' => 'boolean',
        'enable_email' => 'boolean',
        'enable_sms' => 'boolean',
        'public_financial_reports' => 'boolean',
        'show_donor_names' => 'boolean',
        'require_member_photo' => 'boolean',
        'require_cpf' => 'boolean',
        'enable_attendance_control' => 'boolean',
        'require_qr_code_checkin' => 'boolean',
    ];

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }
}
