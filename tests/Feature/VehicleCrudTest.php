<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class VehicleCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_vehicles_page(): void
    {
        $response = $this->get(route('organization.vehicles'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_vehicles_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.vehicles'));
        $response->assertStatus(200);
    }

    public function test_vehicles_page_displays_empty_state_when_no_active_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        Volt::actingAs($user)
            ->test('pages.organization.vehicles')
            ->assertDontSee('Add Vehicle')
            ->assertSee('No Active Organization Selected');
    }

    public function test_vehicles_page_loads_and_displays_linked_vehicles(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $vehicle1 = $org->vehicles()->create([
            'registration_number' => 'MH12AA1111',
            'type' => 'Bus',
        ]);

        $vehicle2 = $org->vehicles()->create([
            'registration_number' => 'MH12BB2222',
            'type' => 'Van',
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.vehicles')
            ->assertSee('MH12AA1111')
            ->assertSee('MH12BB2222')
            ->assertSee('Bus')
            ->assertSee('Van');
    }

    public function test_vehicles_search_works_correctly(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $vehicle1 = $org->vehicles()->create([
            'registration_number' => 'MH12AA1111',
            'type' => 'Bus',
        ]);

        $vehicle2 = $org->vehicles()->create([
            'registration_number' => 'MH12BB2222',
            'type' => 'Van',
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.vehicles')
            ->set('search', 'MH12AA')
            ->assertSee('MH12AA1111')
            ->assertDontSee('MH12BB2222')
            ->set('search', 'Van')
            ->assertSee('MH12BB2222')
            ->assertDontSee('MH12AA1111');
    }

    public function test_vehicles_can_be_created(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.vehicles')
            ->call('openAddModal')
            ->set('newRegistrationNumber', 'MH12XY9999')
            ->set('newType', 'Tempo')
            ->call('createVehicle')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('vehicles', [
            'organization_id' => $org->id,
            'registration_number' => 'MH12XY9999',
            'type' => 'Tempo',
        ]);
    }

    public function test_vehicles_create_validates_required_and_unique_fields(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $org->vehicles()->create([
            'registration_number' => 'MH12AA1111',
            'type' => 'Bus',
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.vehicles')
            ->set('newRegistrationNumber', '')
            ->set('newType', 'Bus')
            ->call('createVehicle')
            ->assertHasErrors(['newRegistrationNumber' => 'required'])
            ->set('newRegistrationNumber', 'MH12AA1111')
            ->call('createVehicle')
            ->assertHasErrors(['newRegistrationNumber' => 'unique']);
    }

    public function test_vehicles_can_be_edited(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $vehicle = $org->vehicles()->create([
            'registration_number' => 'MH12AA1111',
            'type' => 'Bus',
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.vehicles')
            ->call('openEditModal', $vehicle->id)
            ->assertSet('editingRegistrationNumber', 'MH12AA1111')
            ->set('editingRegistrationNumber', 'MH12CC3333')
            ->set('editingType', 'Rickshaw')
            ->call('updateVehicle')
            ->assertHasNoErrors();

        $vehicle->refresh();
        $this->assertEquals('MH12CC3333', $vehicle->registration_number);
        $this->assertEquals('Rickshaw', $vehicle->type);
    }

    public function test_vehicles_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $vehicle = $org->vehicles()->create([
            'registration_number' => 'MH12AA1111',
            'type' => 'Bus',
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.vehicles')
            ->call('openDeleteModal', $vehicle->id)
            ->call('deleteVehicle')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('vehicles', ['id' => $vehicle->id]);
    }
}
