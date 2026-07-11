<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure roles exist
        Role::firstOrCreate(['name' => 'Parent']);
    }

    /** @test */
    public function test_a_user_can_create_a_group_and_becomes_an_admin()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/groups', [
            'name' => 'Test Group',
            'description' => 'Test Group Description',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('group.name', 'Test Group');

        $this->assertDatabaseHas('groups', [
            'name' => 'Test Group',
            'created_by' => $user->id,
        ]);

        $this->assertDatabaseHas('group_user', [
            'user_id' => $user->id,
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function test_a_group_admin_can_add_another_member_by_email_or_mobile()
    {
        $admin = User::factory()->create();
        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'mobile' => '9876543210',
        ]);

        $group = Group::create([
            'name' => 'Test Group',
            'created_by' => $admin->id,
        ]);
        $group->members()->attach($admin->id, ['role' => 'admin']);

        Sanctum::actingAs($admin);

        // Add by email
        $response = $this->postJson("/api/groups/{$group->id}/members", [
            'search' => 'other@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $this->assertDatabaseHas('group_user', [
            'group_id' => $group->id,
            'user_id' => $otherUser->id,
            'role' => 'member',
        ]);
    }

    /** @test */
    public function test_a_non_admin_cannot_add_members()
    {
        $admin = User::factory()->create();
        $member = User::factory()->create();
        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
        ]);

        $group = Group::create([
            'name' => 'Test Group',
            'created_by' => $admin->id,
        ]);
        $group->members()->attach($admin->id, ['role' => 'admin']);
        $group->members()->attach($member->id, ['role' => 'member']);

        Sanctum::actingAs($member);

        $response = $this->postJson("/api/groups/{$group->id}/members", [
            'search' => 'other@example.com',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function test_a_group_admin_can_promote_and_demote_members()
    {
        $admin = User::factory()->create();
        $member = User::factory()->create();

        $group = Group::create([
            'name' => 'Test Group',
            'created_by' => $admin->id,
        ]);
        $group->members()->attach($admin->id, ['role' => 'admin']);
        $group->members()->attach($member->id, ['role' => 'member']);

        Sanctum::actingAs($admin);

        // Promote to admin
        $response = $this->patchJson("/api/groups/{$group->id}/members/{$member->id}/role", [
            'role' => 'admin',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('group_user', [
            'group_id' => $group->id,
            'user_id' => $member->id,
            'role' => 'admin',
        ]);

        // Demote admin (since there are now 2 admins, this is allowed)
        $response = $this->patchJson("/api/groups/{$group->id}/members/{$member->id}/role", [
            'role' => 'member',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('group_user', [
            'group_id' => $group->id,
            'user_id' => $member->id,
            'role' => 'member',
        ]);
    }

    /** @test */
    public function test_cannot_demote_the_last_admin()
    {
        $admin = User::factory()->create();

        $group = Group::create([
            'name' => 'Test Group',
            'created_by' => $admin->id,
        ]);
        $group->members()->attach($admin->id, ['role' => 'admin']);

        Sanctum::actingAs($admin);

        // Try to demote self (the only admin)
        $response = $this->patchJson("/api/groups/{$group->id}/members/{$admin->id}/role", [
            'role' => 'member',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
    }

    /** @test */
    public function test_a_member_can_leave_the_group()
    {
        $admin = User::factory()->create();
        $member = User::factory()->create();

        $group = Group::create([
            'name' => 'Test Group',
            'created_by' => $admin->id,
        ]);
        $group->members()->attach($admin->id, ['role' => 'admin']);
        $group->members()->attach($member->id, ['role' => 'member']);

        Sanctum::actingAs($member);

        $response = $this->deleteJson("/api/groups/{$group->id}/members/{$member->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('group_user', [
            'group_id' => $group->id,
            'user_id' => $member->id,
        ]);
    }

    /** @test */
    public function test_a_user_can_update_their_location()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->patchJson('/api/location', [
            'latitude' => 23.0225,
            'longitude' => 72.5714,
            'location_sharing_enabled' => true,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('user.latitude', 23.0225);
        $response->assertJsonPath('user.longitude', 72.5714);
        $response->assertJsonPath('user.location_sharing_enabled', true);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'latitude' => 23.0225,
            'longitude' => 72.5714,
            'location_sharing_enabled' => true,
        ]);
    }

    /** @test */
    public function test_a_user_can_get_the_location_interval_setting()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Setting::set('location_update_interval_seconds', '15');

        $response = $this->getJson('/api/settings/location-interval');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('location_update_interval_seconds', 15);
    }
}
