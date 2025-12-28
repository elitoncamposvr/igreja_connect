<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class Church extends Model
{

    use HasFactory, softDeletes;
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'cnpj',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'status',
        'denomination',
        'founded_at',
        'logo_path',
        'banner_path',
        'plan',
        'subscription_started_at',
        'subscription_ends_at',
        'is_trial',
    ];

    protected $casts = [
        'founded_at' => 'date',
        'subscription_started_at' => 'date',
        'subscription_ends_at' => 'date',
        'is_trial' => 'boolean',
    ];

    public function settings(): HasOne
    {
        return $this->hasOne(ChurchSettings::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function congregations(): HasMany
    {
        return $this->hasMany(Congregation::class);
    }

    public function categories():  hasMany
    {
        return $this->hasMany(Category::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function messageTemplates(): HasMany
    {
        return $this->hasMany(MessageTemplate::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithValidSubscription($query)
    {
        return $query->where('subscription_end_at', '>=', now())
            ->orWhere('is_trial', true);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    public function getSubscriptionDaysRemainingAttribute(): int
    {
        if (!$this->subscription_ends_at){
            return 0;
        }

        return max(0, now()->diffInDays($this->subscription_ends_at, false));
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription_ends_at >= now() || $this->is_trial;
    }

    public function getPlanLimits(): array
    {
        $limits = [
            'pequena' => ['max_members' => 100 , 'max_users' => 2],
            'media' => ['max_members' => 300 , 'max_users' => 5],
            'grande' => ['max_members' => 1000, 'max_users' => 10],
            'rede' => ['max_members' => null, 'max_users' => null],
        ];

        return $limits[$this->plan] ?? $limits['pequena'];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($church) {
            if (empty($church->slug)) {
                $church->slug = Str::slug($church->name);
            }
        });
    }


}
