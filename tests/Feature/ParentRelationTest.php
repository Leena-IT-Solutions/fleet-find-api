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

    public function test_can_fetch_single_child_with_all_relationships()
    {
        $parent1 = User::factory()->create();
        $parent2 = User::factory()->create();

        $child = Child::create([
            'parent_id' => $parent1->id,
            'name' => 'Tommy Doe',
            'gender' => 'Male',
        ]);

        // Link second parent to this child
        $child->parents()->syncWithoutDetaching([
            $parent2->id => ['relationship_type' => 'Father']
        ]);

        $token = $parent1->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->getJson("/api/children/{$child->id}");

        $response->assertStatus(200)
            ->assertJsonPath('child.name', $child->name)
            ->assertJsonCount(2, 'child.relationships');
    }

    public function test_can_link_new_parent_relationship_to_child()
    {
        $parent1 = User::factory()->create();
        $parent2 = User::factory()->create(['email' => 'other@example.com']);

        $child = Child::create([
            'parent_id' => $parent1->id,
            'name' => 'Tommy Doe',
            'gender' => 'Male',
        ]);

        $token = $parent1->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson("/api/children/{$child->id}/relationships", [
                'email_or_mobile' => 'other@example.com',
                'relationship_type' => 'Father',
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('child_user', [
            'user_id' => $parent2->id,
            'child_id' => $child->id,
            'relationship_type' => 'Father',
        ]);
    }

    public function test_cannot_remove_last_relationship_from_child()
    {
        $parent1 = User::factory()->create();
        $child = Child::create([
            'parent_id' => $parent1->id,
            'name' => 'Tommy Doe',
            'gender' => 'Male',
        ]);

        $token = $parent1->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->deleteJson("/api/children/{$child->id}/relationships/{$parent1->id}");

        $response->assertStatus(422)
            ->assertJsonPath('message', 'A child profile must have at least one linked parent or guardian.');
    }
}
