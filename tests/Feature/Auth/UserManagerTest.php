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

    public function test_admin_can_edit_user_details_and_roles(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user = User::factory()->create(['name' => 'Original Name', 'email' => 'original@example.com']);

        Volt::actingAs($admin)
            ->test('pages.users.index')
            ->call('openEditModal', $user->id)
            ->assertSet('editingName', 'Original Name')
            ->set('editingName', 'Updated Name')
            ->set('editingEmail', 'updated@example.com')
            ->set('editingRoles', ['Driver']) // User model will enforce Parent role is kept
            ->call('updateUser')
            ->assertHasNoErrors();

        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertTrue($user->hasRole('Parent'));
        $this->assertTrue($user->hasRole('Driver'));
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        Volt::actingAs($admin)
            ->test('pages.users.index')
            ->call('openDeleteModal', $admin->id)
            ->assertSet('showDeleteModal', false); // Delete modal should not open for self

        $this->assertNotNull($admin->fresh());
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user = User::factory()->create();

        Volt::actingAs($admin)
            ->test('pages.users.index')
            ->call('openDeleteModal', $user->id)
            ->assertSet('showDeleteModal', true)
            ->call('deleteUser')
            ->assertSet('showDeleteModal', false);

        $this->assertNull($user->fresh());
    }

    public function test_admin_can_create_new_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        Volt::actingAs($admin)
            ->test('pages.users.index')
            ->call('openAddModal')
            ->set('newName', 'New User')
            ->set('newEmail', 'newuser@example.com')
            ->set('newMobile', '9876543210')
            ->set('newPassword', 'password123')
            ->set('newRoles', ['Driver'])
            ->call('createUser')
            ->assertHasNoErrors()
            ->assertSet('showAddModal', false);

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'mobile' => '9876543210',
        ]);

        $newUser = User::where('email', 'newuser@example.com')->first();
        $this->assertTrue($newUser->hasRole('Parent'));
        $this->assertTrue($newUser->hasRole('Driver'));
    }

    public function test_user_manager_load_more_pagination(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        // Create 15 extra users
        User::factory()->count(15)->create();

        Volt::actingAs($admin)
            ->test('pages.users.index')
            ->assertSet('perPage', 10)
            ->assertViewHas('hasMore', true)
            ->call('loadMore')
            ->assertSet('perPage', 20)
            ->assertViewHas('hasMore', false);
    }
}
