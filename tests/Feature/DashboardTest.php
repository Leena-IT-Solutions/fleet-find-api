<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Child;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard_with_correct_metrics(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        // Create other role users to populate metrics
        $org = User::factory()->create();
        $org->assignRole('Organization');

        $driver = User::factory()->create();
        $driver->assignRole('Driver');

        $attendant = User::factory()->create();
        $attendant->assignRole('Attendant');

        $parent = User::factory()->create();
        $parent->assignRole('Parent');

        // Add 2 children to parent
        Child::create(['parent_id' => $parent->id, 'name' => 'Child A']);
        Child::create(['parent_id' => $parent->id, 'name' => 'Child B']);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200)
            ->assertViewHasAll([
                'totalUsers',
                'totalOrgs',
                'totalDrivers',
                'totalAttendants',
                'totalParents',
                'totalChildren'
            ]);

        // Total users = admin, org, driver, attendant, parent = 5 users
        $this->assertEquals(5, $response->viewData('totalUsers'));
        $this->assertEquals(1, $response->viewData('totalOrgs'));
        $this->assertEquals(1, $response->viewData('totalDrivers'));
        $this->assertEquals(1, $response->viewData('totalAttendants'));
        $this->assertEquals(5, $response->viewData('totalParents'));
        $this->assertEquals(2, $response->viewData('totalChildren'));
    }
}
