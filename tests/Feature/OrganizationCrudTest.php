<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class OrganizationCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure Parent role is always created
        Role::firstOrCreate(['name' => 'Parent']);
    }

    public function test_guests_cannot_access_organizations_page(): void
    {
        $response = $this->get(route('organization.organizations'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_organization_users_cannot_access_organizations_page(): void
    {
        $user = User::factory()->create(); // holds only Parent role
        $response = $this->actingAs($user)->get(route('organization.organizations'));
        $response->assertStatus(403);
    }

    public function test_organization_users_can_access_organizations_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.organizations'));
        $response->assertStatus(200);
    }

    public function test_organization_user_can_create_organization_with_geolocation_and_users(): void
    {
        $orgUser = User::factory()->create();
        $orgUser->assignRole('Organization');

        $anotherOrgUser = User::factory()->create();
        $anotherOrgUser->assignRole('Organization');

        $component = Volt::actingAs($orgUser)
            ->test('pages.organization.organizations')
            ->set('newName', 'Starlight Academy')
            ->set('newContactName', 'John Doe')
            ->set('newNumber', '1234567890')
            ->set('newEmail', 'contact@starlight.edu')
            ->set('newAddress', '123 Star Lane')
            ->set('newLatitude', '19.0760')
            ->set('newLongitude', '72.8777')
            ->set('newDisplayDriverPhone', true)
            ->set('newDisplayAttendantPhone', false)
            ->set('newShareLocationBy', 'driver')
            ->set('newUsers', [$anotherOrgUser->id]);

        $component->call('createOrganization');

        $component->assertHasNoErrors();

        $this->assertDatabaseHas('organizations', [
            'name' => 'Starlight Academy',
            'contact_name' => 'John Doe',
            'email' => 'contact@starlight.edu',
            'latitude' => '19.07600000',
            'longitude' => '72.87770000',
            'display_driver_phone' => true,
            'display_attendant_phone' => false,
            'share_location_by' => 'driver',
        ]);

        $org = Organization::where('name', 'Starlight Academy')->first();
        $this->assertTrue($org->users->contains($anotherOrgUser->id));
    }

    public function test_organization_user_can_update_organization(): void
    {
        $orgUser = User::factory()->create();
        $orgUser->assignRole('Organization');

        $org = Organization::create([
            'name' => 'Old Academy',
            'contact_name' => 'Old Person',
            'display_driver_phone' => true,
            'display_attendant_phone' => true,
            'share_location_by' => 'driver',
        ]);

        $component = Volt::actingAs($orgUser)
            ->test('pages.organization.organizations')
            ->call('openEditModal', $org->id)
            ->set('editingName', 'New Academy')
            ->set('editingContactName', 'New Person')
            ->set('editingDisplayDriverPhone', false)
            ->set('editingDisplayAttendantPhone', true)
            ->set('editingShareLocationBy', 'attendant');

        $component->call('updateOrganization');
        $component->assertHasNoErrors();

        $this->assertDatabaseHas('organizations', [
            'id' => $org->id,
            'name' => 'New Academy',
            'contact_name' => 'New Person',
            'display_driver_phone' => false,
            'display_attendant_phone' => true,
            'share_location_by' => 'attendant',
        ]);
    }

    public function test_organization_user_can_delete_organization(): void
    {
        $orgUser = User::factory()->create();
        $orgUser->assignRole('Organization');

        $org = Organization::create([
            'name' => 'Trash Academy',
            'display_driver_phone' => true,
            'display_attendant_phone' => true,
            'share_location_by' => 'driver',
        ]);

        $component = Volt::actingAs($orgUser)
            ->test('pages.organization.organizations')
            ->call('openDeleteModal', $org->id)
            ->call('deleteOrganization');

        $component->assertHasNoErrors();
        $this->assertDatabaseMissing('organizations', ['id' => $org->id]);
    }
}
