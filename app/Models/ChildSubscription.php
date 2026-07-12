<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'child_id',
    'subscription_plan_id',
    'grade_id',
    'division_id',
    'route_id',
    'pickup_stop_id',
    'drop_stop_id',
    'parent_id',
    'status',
])]
class ChildSubscription extends Model
{
    use HasFactory;

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function pickupStop()
    {
        return $this->belongsTo(Stop::class, 'pickup_stop_id');
    }

    public function dropStop()
    {
        return $this->belongsTo(Stop::class, 'drop_stop_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
