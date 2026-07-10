<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_name',
        'number',
        'email',
        'address',
        'latitude',
        'longitude',
        'logo',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }
}
