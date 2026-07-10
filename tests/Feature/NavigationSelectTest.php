<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class NavigationSelectTest extends TestCase
{
    use RefreshDatabase;

    public function test_navigation_initializes_active_organization_in_session(): void
    {
        $orgUser = User::factory()->create();
        $orgUser->assignRole('Organization');

        $org1 = Organization::create(['name' => 'Starlight Academy']);
        $org2 = Organization::create(['name' => 'Solar High']);

        $orgUser->organizations()->sync([
            $org1->id => ['access' => 'owner'],
            $org2->id => ['access' => 'manager']
        ]);

        $this->assertNull(session('active_organization_id'));

        Volt::actingAs($orgUser)
            ->test('layout.navigation')
            ->assertSet('activeOrgId', $org1->id);

        $this->assertEquals($org1->id, session('active_organization_id'));
    }

    public function test_navigation_updates_active_organization_in_session(): void
    {
        $orgUser = User::factory()->create();
        $orgUser->assignRole('Organization');

        $org1 = Organization::create(['name' => 'Starlight Academy']);
        $org2 = Organization::create(['name' => 'Solar High']);

        $orgUser->organizations()->sync([
            $org1->id => ['access' => 'owner'],
            $org2->id => ['access' => 'manager']
        ]);

        Volt::actingAs($orgUser)
            ->test('layout.navigation')
            ->call('selectOrganization', $org2->id)
            ->assertSet('activeOrgId', $org2->id);

        $this->assertEquals($org2->id, session('active_organization_id'));
    }

    public function test_navigation_initializes_active_organization_for_admin_in_session(): void
    {
        $adminUser = User::factory()->create();
        $adminUser->assignRole('Admin');

        $org1 = Organization::create(['name' => 'Starlight Academy']);
        $org2 = Organization::create(['name' => 'Solar High']);

        $adminUser->organizations()->sync([
            $org1->id => ['access' => 'owner'],
            $org2->id => ['access' => 'manager']
        ]);

        $this->assertNull(session('active_organization_id'));

        Volt::actingAs($adminUser)
            ->test('layout.navigation')
            ->assertSet('activeOrgId', $org1->id);

        $this->assertEquals($org1->id, session('active_organization_id'));
    }

    public function test_navigation_allows_admin_to_select_their_linked_organization(): void
    {
        $adminUser = User::factory()->create();
        $adminUser->assignRole('Admin');

        $org1 = Organization::create(['name' => 'Starlight Academy']);
        $org2 = Organization::create(['name' => 'Solar High']);

        $adminUser->organizations()->sync([
            $org1->id => ['access' => 'owner'],
            $org2->id => ['access' => 'manager']
        ]);

        Volt::actingAs($adminUser)
            ->test('layout.navigation')
            ->call('selectOrganization', $org2->id)
            ->assertSet('activeOrgId', $org2->id);

        $this->assertEquals($org2->id, session('active_organization_id'));
    }

    public function test_navigation_does_not_allow_admin_to_select_unlinked_organization(): void
    {
        $adminUser = User::factory()->create();
        $adminUser->assignRole('Admin');

        $org1 = Organization::create(['name' => 'Starlight Academy']);
        $org2 = Organization::create(['name' => 'Solar High']);

        $adminUser->organizations()->sync([
            $org1->id => ['access' => 'owner']
        ]);

        Volt::actingAs($adminUser)
            ->test('layout.navigation')
            ->call('selectOrganization', $org2->id)
            ->assertSet('activeOrgId', $org1->id);

        $this->assertEquals($org1->id, session('active_organization_id'));
    }
}
