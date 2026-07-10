<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class OrganizationDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_user_can_access_organization_dashboard(): void
    {
        $user = User::factory()->create(); // only has Parent role

        $this->actingAs($user)
            ->get(route('organization.dashboard'))
            ->assertStatus(200);
    }

    public function test_parent_user_can_upgrade_to_organization_account(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->hasRole('Organization'));

        Volt::actingAs($user)
            ->test('pages.organization.dashboard')
            ->call('createOrganizationAccount')
            ->assertRedirect(route('organization.dashboard'));

        $this->assertTrue($user->refresh()->hasRole('Organization'));
    }

    public function test_user_with_organization_role_can_access_organization_dashboard(): void
    {
        $org = User::factory()->create();
        $org->assignRole('Organization');

        $response = $this->actingAs($org)->get(route('organization.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Organization Dashboard');
    }

    public function test_user_with_both_roles_can_access_organization_dashboard_and_sees_go_to_admin_portal_button(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Go to Admin Portal');
    }
}
