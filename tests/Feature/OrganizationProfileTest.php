<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_organization_user_blocked_from_profile_settings(): void
    {
        $parent = User::factory()->create();

        $this->actingAs($parent)
            ->get(route('organization.profile-settings'))
            ->assertStatus(403);
    }

    public function test_organization_user_can_access_profile_settings(): void
    {
        $org = User::factory()->create();
        $org->assignRole('Organization');

        $this->actingAs($org)
            ->get(route('organization.profile-settings'))
            ->assertStatus(200);
    }
}
