<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'mobile', 'password', 'profile_photo', 'latitude', 'longitude', 'location_sharing_enabled', 'location_updated_at', 'relationship_type', 'co_parent_id', 'pending_co_parent_link'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'location_sharing_enabled' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
            'location_updated_at' => 'datetime',
        ];
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * The groups that the user belongs to.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('role', 'location_sharing_enabled')->withTimestamps();
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string|array $roleNames): bool
    {
        $roleNames = is_array($roleNames) ? $roleNames : [$roleNames];
        return $this->roles()->whereIn('name', $roleNames)->exists();
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(string $roleName): void
    {
        $role = Role::firstOrCreate(['name' => $roleName]);
        if (!$this->roles()->where('role_id', $role->id)->exists()) {
            $this->roles()->attach($role->id);
        }
    }

    /**
     * Detach a role from the user.
     */
    public function detachRole(string $roleName): void
    {
        if (strtolower($roleName) === 'parent') {
            throw new \InvalidArgumentException("The Parent role is mandatory and cannot be removed.");
        }
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->roles()->detach($role->id);
        }
    }

    /**
     * Sync roles for the user, ensuring the Parent role is always preserved.
     */
    public function syncRoles(array $roleNames): void
    {
        // Enforce Parent role is always included
        $hasParent = collect($roleNames)->contains(fn ($value) => strtolower($value) === 'parent');
        if (!$hasParent) {
            $roleNames[] = 'Parent';
        }

        $roleIds = collect($roleNames)->map(function ($name) {
            return Role::firstOrCreate(['name' => $name])->id;
        });

        $this->roles()->sync($roleIds);
    }

    /**
     * Get the children associated with the user (parent).
     */
    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_user')
            ->withPivot('relationship_type')
            ->withTimestamps();
    }

    /**
     * Get the linked co-parent user.
     */
    public function coParent()
    {
        return $this->belongsTo(User::class, 'co_parent_id');
    }

    /**
     * The organizations that belong to the user.
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')->withPivot('access')->withTimestamps();
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function attendant()
    {
        return $this->hasOne(Attendant::class);
    }

    /**
     * Boot the model events.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            $parentRole = Role::firstOrCreate(['name' => 'Parent']);
            $user->roles()->attach($parentRole->id);
        });
    }
}
