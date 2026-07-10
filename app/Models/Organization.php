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
        'enrollment_end_date',
        'logo',
        'display_driver_phone',
        'display_attendant_phone',
        'share_location_by',
    ];

    protected $casts = [
        'enrollment_end_date' => 'date',
        'display_driver_phone' => 'boolean',
        'display_attendant_phone' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user');
    }
}
