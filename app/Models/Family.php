<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Family extends Model
{
    protected $fillable = [
        'church_id',
        'name',
        'head_member_id'
    ];

    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class);
    }

    public function headMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'head_member_id');
    }

    public function members(): belongsToMany
    {
        return $this->belongsToMany(Member::class)
            ->withPivot('relationship')
            ->withTimestamps();
    }
}
