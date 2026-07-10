<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_automatically_assigned_parent_role_on_creation(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($user->hasRole('Parent'));
        $this->assertCount(1, $user->roles);
    }

    public function test_user_can_be_assigned_multiple_roles(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Admin');
        $user->assignRole('Organization');

        $this->assertTrue($user->hasRole('Parent'));
        $this->assertTrue($user->hasRole('Admin'));
        $this->assertTrue($user->hasRole('Organization'));
        $this->assertCount(3, $user->refresh()->roles);
    }

    public function test_parent_role_cannot_be_detached_directly(): void
    {
        $user = User::factory()->create();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The Parent role is mandatory and cannot be removed.');

        $user->detachRole('Parent');
    }

    public function test_parent_role_cannot_be_purged_via_sync(): void
    {
        $user = User::factory()->create();

        // Assign Admin role first
        $user->assignRole('Admin');
        $this->assertTrue($user->hasRole('Admin'));
        $this->assertTrue($user->hasRole('Parent'));

        // Sync to only Admin and Driver (without Parent)
        $user->syncRoles(['Admin', 'Driver']);

        // Assert Parent is still present and not purged
        $this->assertTrue($user->hasRole('Parent'));
        $this->assertTrue($user->hasRole('Admin'));
        $this->assertTrue($user->hasRole('Driver'));
        $this->assertCount(3, $user->refresh()->roles);
    }
}
