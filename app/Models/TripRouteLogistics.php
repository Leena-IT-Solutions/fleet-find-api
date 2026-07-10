<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripRouteLogistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'route_id',
        'vehicle_id',
        'driver_id',
        'attendant_id',
        'stops_order',
        'is_tracking',
        'latitude',
        'longitude',
        'speed',
    ];

    protected $casts = [
        'is_tracking' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'speed' => 'decimal:2',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function attendant(): BelongsTo
    {
        return $this->belongsTo(Attendant::class);
    }
}
