<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class OrganizationProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_organization_user_is_blocked_from_organization_profile(): void
    {
        $parent = User::factory()->create(); // only Parent role

        $this->actingAs($parent)
            ->get(route('organization.profile'))
            ->assertStatus(403);
    }

    public function test_organization_user_can_access_and_update_profile(): void
    {
        $org = User::factory()->create([
            'name' => 'Original Org Name',
            'email' => 'org@example.com',
            'mobile' => '9999988888',
        ]);
        $org->assignRole('Organization');

        // Verify page access
        $this->actingAs($org)
            ->get(route('organization.profile'))
            ->assertStatus(200);

        // Verify Volt component logic and update profile
        Volt::actingAs($org)
            ->test('pages.organization.profile')
            ->assertSet('name', 'Original Org Name')
            ->assertSet('email', 'org@example.com')
            ->assertSet('mobile', '9999988888')
            ->set('name', 'Updated Org Name')
            ->set('email', 'updatedorg@example.com')
            ->set('mobile', '8888877777')
            ->call('updateProfile')
            ->assertHasNoErrors();

        // Verify DB update
        $org->refresh();
        $this->assertEquals('Updated Org Name', $org->name);
        $this->assertEquals('updatedorg@example.com', $org->email);
        $this->assertEquals('8888877777', $org->mobile);
    }
}
