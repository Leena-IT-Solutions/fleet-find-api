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

    public function test_admin_can_access_dashboard_and_see_admin_portal(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
        $response->assertSee('Welcome to the Admin Portal');
    }



    public function test_organization_can_access_dashboard_and_see_organization_panel(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get('/organization/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Organization Dashboard');
        $response->assertSee('Organization Fleet Panel');
    }

    public function test_user_without_admin_or_organization_role_is_denied_access(): void
    {
        // Default user only has the Parent role
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('organization.dashboard'));
    }
}
