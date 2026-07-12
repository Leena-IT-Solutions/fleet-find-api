<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization_id',
    ];

    public function getNameAttribute(): string
    {
        return $this->user->name ?? '';
    }

    public function getEmailAttribute(): ?string
    {
        return $this->user->email ?? null;
    }

    public function getNumberAttribute(): ?string
    {
        return $this->user->mobile ?? null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
