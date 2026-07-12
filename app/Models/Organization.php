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
        'show_email',
        'show_phone',
        'display_driver_phone',
        'display_attendant_phone',
        'share_location_by',
        'enrollment_end_date',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'show_email' => 'boolean',
        'show_phone' => 'boolean',
        'display_driver_phone' => 'boolean',
        'display_attendant_phone' => 'boolean',
        'enrollment_end_date' => 'date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_user')->withPivot('access')->withTimestamps();
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function attendants()
    {
        return $this->hasMany(Attendant::class);
    }

    public function subscriptionPlans()
    {
        return $this->hasMany(SubscriptionPlan::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
