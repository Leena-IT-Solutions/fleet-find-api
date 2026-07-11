<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Child;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ParentRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_relationship_type()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'mobile' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'relationship_type' => 'Father',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('user.relationship_type', 'Father');

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'relationship_type' => 'Father',
        ]);
    }

    public function test_co_parents_link_mutually_when_both_registered()
    {
        // 1. Create first parent
        $parent1 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0987654321',
            'password' => Hash::make('password123'),
            'relationship_type' => 'Mother',
        ]);

        // 2. Register second parent linking to first by email
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'mobile' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'relationship_type' => 'Father',
            'co_parent_phone_or_email' => 'jane@example.com',
        ]);

        $response->assertStatus(201);

        $parent2 = User::where('email', 'john@example.com')->first();
        $parent1->refresh();

        $this->assertEquals($parent1->id, $parent2->co_parent_id);
        $this->assertEquals($parent2->id, $parent1->co_parent_id);
    }

    public function test_pending_co_parent_link_resolves_on_later_registration()
    {
        // 1. Register first parent with pending link
        $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'mobile' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'relationship_type' => 'Father',
            'co_parent_phone_or_email' => 'jane@example.com',
        ]);

        $parent1 = User::where('email', 'john@example.com')->first();
        $this->assertEquals('jane@example.com', $parent1->pending_co_parent_link);

        // 2. Register second parent later
        $this->postJson('/api/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0987654321',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'relationship_type' => 'Mother',
        ]);

        $parent1->refresh();
        $parent2 = User::where('email', 'jane@example.com')->first();

        $this->assertEquals($parent2->id, $parent1->co_parent_id);
        $this->assertEquals($parent1->id, $parent2->co_parent_id);
        $this->assertNull($parent1->pending_co_parent_link);
    }

    public function test_adding_child_auto_links_to_both_co_parents()
    {
        $parent1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'mobile' => '1234567890',
            'password' => Hash::make('password123'),
            'relationship_type' => 'Father',
        ]);

        $parent2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'mobile' => '0987654321',
            'password' => Hash::make('password123'),
            'relationship_type' => 'Mother',
            'co_parent_id' => $parent1->id,
        ]);

        $parent1->co_parent_id = $parent2->id;
        $parent1->save();

        $token = $parent1->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/children', [
                'name' => 'Tommy Doe',
                'dob' => '2015-05-10',
                'gender' => 'Male',
            ]);

        $response->assertStatus(200);

        $childId = $response->json('child.id');

        // Tommy Doe should be linked to both John Doe (Father) and Jane Doe (Mother) in the pivot
        $this->assertDatabaseHas('child_user', [
            'user_id' => $parent1->id,
            'child_id' => $childId,
            'relationship_type' => 'Father',
        ]);

        $this->assertDatabaseHas('child_user', [
            'user_id' => $parent2->id,
            'child_id' => $childId,
            'relationship_type' => 'Mother',
        ]);
    }
}
