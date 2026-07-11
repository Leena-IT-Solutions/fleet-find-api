<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'photo', 'dob', 'gender', 'parent_id'])]
class Child extends Model
{
    use HasFactory;

    /**
     * Get the parents associated with the child.
     */
    public function parents()
    {
        return $this->belongsToMany(User::class, 'child_user')
            ->withPivot('relationship_type')
            ->withTimestamps();
    }

    /**
     * Get the parent_id for backward compatibility.
     */
    public function getParentIdAttribute()
    {
        return $this->parents()->first()?->id;
    }

    /**
     * Boot the model events.
     */
    protected static function booted(): void
    {
        static::created(function (Child $child) {
            // Retrieve parent_id directly from raw attributes to bypass the getParentIdAttribute accessor
            $parentId = $child->getAttributes()['parent_id'] ?? null;
            if ($parentId) {
                $user = User::find($parentId);
                if ($user) {
                    $child->parents()->syncWithoutDetaching([$user->id => ['relationship_type' => 'Other']]);
                }
            }
        });
    }
}
