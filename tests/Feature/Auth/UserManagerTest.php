<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class UserManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_organization_can_access_user_manager(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $org = User::factory()->create();
        $org->assignRole('Organization');

        $parent = User::factory()->create(); // Default has Parent role

        $this->actingAs($admin)->get(route('users.index'))->assertStatus(200);
        $this->actingAs($org)->get(route('users.index'))->assertStatus(200);
        $this->actingAs($parent)->get(route('users.index'))->assertStatus(403);
    }

    public function test_user_manager_displays_users_list(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user1 = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $user2 = User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Jane Smith');
    }

    public function test_user_manager_search_filter(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user1 = User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        $user2 = User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        Volt::actingAs($admin)
            ->test('pages.users.index')
            ->set('search', 'John')
            ->assertSee('John Doe')
            ->assertDontSee('Jane Smith');
    }

    public function test_user_manager_role_filter(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user1 = User::factory()->create(['name' => 'John Driver']);
        $user1->assignRole('Driver');

        $user2 = User::factory()->create(['name' => 'Jane Parent']); // Only has default Parent role

        Volt::actingAs($admin)
            ->test('pages.users.index')
            ->set('selectedRole', 'Driver')
            ->assertSee('John Driver')
            ->assertDontSee('Jane Parent');
    }
}
