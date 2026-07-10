<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class EntityInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_entity_info_page(): void
    {
        $response = $this->get(route('organization.entity-info'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_entity_info_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.entity-info'));
        $response->assertStatus(200);
    }

    public function test_entity_info_page_displays_empty_state_when_no_active_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        Volt::actingAs($user)
            ->test('pages.organization.entity-info')
            ->assertDontSee('General Information')
            ->assertSee('No Active Organization Selected');
    }

    public function test_entity_info_page_loads_and_saves_active_organization_data(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create([
            'name' => 'Starlight Secondary School',
            'contact_name' => 'John Doe',
            'number' => '1234567890',
            'email' => 'starlight@school.edu',
            'address' => '123 Milky Way Drive',
            'latitude' => 23.0225,
            'longitude' => 72.5714,
            'display_driver_phone' => true,
            'display_attendant_phone' => false,
            'share_location_by' => 'driver',
        ]);

        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        // Put active organization ID in the session
        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.entity-info')
            ->assertSet('name', 'Starlight Secondary School')
            ->assertSet('contactName', 'John Doe')
            ->assertSet('displayDriverPhone', true)
            ->assertSet('displayAttendantPhone', false)
            ->assertSet('shareLocationBy', 'driver')
            ->set('contactName', 'Jane Doe')
            ->set('displayAttendantPhone', true)
            ->set('shareLocationBy', 'attendant')
            ->call('updateEntityInfo')
            ->assertHasNoErrors();

        $org->refresh();
        $this->assertEquals('Jane Doe', $org->contact_name);
        $this->assertTrue($org->display_attendant_phone);
        $this->assertEquals('attendant', $org->share_location_by);
    }
}
