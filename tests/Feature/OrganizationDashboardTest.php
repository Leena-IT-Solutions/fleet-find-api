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

    public function test_organization_dashboard_displays_correct_statistics(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = \App\Models\Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        // Create statistics records
        $org->vehicles()->create(['registration_number' => 'MH05CM5316', 'type' => 'Bus']);
        $org->vehicles()->create(['registration_number' => 'MH05CM5317', 'type' => 'Mini Bus']);

        $driverUser = User::factory()->create();
        $driverUser->assignRole('Driver');
        $org->drivers()->create([
            'user_id' => $driverUser->id,
            'name' => 'John Driver',
            'email' => $driverUser->email,
            'number' => '1234567890'
        ]);

        $attendantUser = User::factory()->create();
        $attendantUser->assignRole('Attendant');
        $org->attendants()->create([
            'user_id' => $attendantUser->id,
            'name' => 'Jane Attendant',
            'email' => $attendantUser->email,
            'number' => '9876543210'
        ]);

        $route = $org->routes()->create(['name' => 'Route A']);
        $route->stops()->create(['name' => 'Stop 1', 'sequence_order' => 1]);
        $route->stops()->create(['name' => 'Stop 2', 'sequence_order' => 2]);

        $org->trips()->create(['name' => 'Trip A']);

        Volt::actingAs($user)
            ->test('pages.organization.dashboard')
            ->assertViewHas('vehiclesCount', 2)
            ->assertViewHas('driversCount', 1)
            ->assertViewHas('attendantsCount', 1)
            ->assertViewHas('routesCount', 1)
            ->assertViewHas('stopsCount', 2)
            ->assertViewHas('tripsCount', 1);
    }
}
