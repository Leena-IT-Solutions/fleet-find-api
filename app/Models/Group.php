<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'created_by'])]
class Group extends Model
{
    use HasFactory;

    /**
     * The members that belong to the group.
     */
    public function members()
    {
        return $this->belongsToMany(User::class)->withPivot('role', 'location_sharing_enabled')->withTimestamps();
    }

    /**
     * The admins that belong to the group.
     */
    public function admins()
    {
        return $this->members()->wherePivot('role', 'admin');
    }

    /**
     * The user who created the group.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if a user is an admin of this group.
     */
    public function isAdmin(User $user): bool
    {
        return $this->admins()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if a user is a member of this group.
     */
    public function isMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }
}
