<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_access_control_page(): void
    {
        $response = $this->get(route('organization.access-control'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_access_control_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.access-control'));
        $response->assertStatus(200);
    }

    public function test_access_control_page_displays_empty_state_when_no_active_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        Volt::actingAs($user)
            ->test('pages.organization.access-control')
            ->assertDontSee('Organization Members')
            ->assertSee('No Active Organization Selected');
    }

    public function test_access_control_page_loads_and_displays_linked_members(): void
    {
        $userA = User::factory()->create(['name' => 'Owner Person']);
        $userA->assignRole('Organization');

        $userB = User::factory()->create(['name' => 'Manager Person']);
        $userB->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $userA->organizations()->sync([$org->id => ['access' => 'owner']]);
        $userB->organizations()->sync([$org->id => ['access' => 'manager']]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($userA)
            ->test('pages.organization.access-control')
            ->assertSee('Owner Person')
            ->assertSee('Manager Person')
            ->assertSee('Owner')
            ->assertSee('Manager');
    }

    public function test_access_control_user_search_works_correctly(): void
    {
        $userA = User::factory()->create(['name' => 'Sandeep Rathod']);
        $userA->assignRole('Organization');

        $userB = User::factory()->create(['name' => 'Leena Adam', 'email' => 'leenaadam28@gmail.com']);
        $userB->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $userA->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $component = Volt::actingAs($userA)
            ->test('pages.organization.access-control')
            ->set('userSearch', 'Lee');

        $searchResults = $component->get('searchResults');
        $this->assertTrue($searchResults->contains('id', $userB->id));

        $component->set('userSearch', 'San');
        $searchResults = $component->get('searchResults');
        // Should not see Sandeep because he is already a member of this organization
        $this->assertFalse($searchResults->contains('id', $userA->id));
    }

    public function test_access_control_can_add_member_to_organization(): void
    {
        $userA = User::factory()->create(['name' => 'Sandeep Rathod']);
        $userA->assignRole('Organization');

        $userB = User::factory()->create(['name' => 'Leena Adam', 'email' => 'leenaadam28@gmail.com']);

        $org = Organization::create(['name' => 'Starlight Academy']);
        $userA->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $this->assertFalse($userB->hasRole('Organization'));

        Volt::actingAs($userA)
            ->test('pages.organization.access-control')
            ->call('openAddModal')
            ->set('selectedUserId', $userB->id)
            ->set('selectedUserName', $userB->name)
            ->set('accessLevel', 'manager')
            ->call('addMember')
            ->assertHasNoErrors();

        $this->assertTrue($org->users->contains($userB->id));
        $userB->refresh();
        $this->assertTrue($userB->hasRole('Organization'));
        $this->assertEquals('manager', $org->users()->where('users.id', $userB->id)->first()->pivot->access);
    }

    public function test_access_control_can_edit_member_access_level(): void
    {
        $userA = User::factory()->create(['name' => 'Sandeep Rathod']);
        $userA->assignRole('Organization');

        $userB = User::factory()->create(['name' => 'Leena Adam']);
        $userB->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $userA->organizations()->sync([$org->id => ['access' => 'owner']]);
        $userB->organizations()->sync([$org->id => ['access' => 'manager']]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($userA)
            ->test('pages.organization.access-control')
            ->call('openEditModal', $userB->id, 'manager')
            ->set('editingAccessLevel', 'owner')
            ->call('updateMemberAccess')
            ->assertHasNoErrors();

        $this->assertEquals('owner', $org->users()->where('users.id', $userB->id)->first()->pivot->access);
    }

    public function test_access_control_prevents_changing_last_owner_to_manager(): void
    {
        $userA = User::factory()->create(['name' => 'Sandeep Rathod']);
        $userA->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $userA->organizations()->sync([$org->id => ['access' => 'owner']]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($userA)
            ->test('pages.organization.access-control')
            ->call('openEditModal', $userA->id, 'owner')
            ->set('editingAccessLevel', 'manager')
            ->call('updateMemberAccess')
            ->assertSee('Cannot change the last Owner of the organization to Manager.');

        $this->assertEquals('owner', $org->users()->where('users.id', $userA->id)->first()->pivot->access);
    }

    public function test_access_control_can_remove_member(): void
    {
        $userA = User::factory()->create(['name' => 'Sandeep Rathod']);
        $userA->assignRole('Organization');

        $userB = User::factory()->create(['name' => 'Leena Adam']);
        $userB->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $userA->organizations()->sync([$org->id => ['access' => 'owner']]);
        $userB->organizations()->sync([$org->id => ['access' => 'manager']]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($userA)
            ->test('pages.organization.access-control')
            ->call('openRemoveModal', $userB->id)
            ->call('removeMember')
            ->assertHasNoErrors();

        $this->assertFalse($org->users->contains($userB->id));
    }

    public function test_access_control_prevents_removing_any_owner(): void
    {
        $userA = User::factory()->create(['name' => 'Sandeep Rathod']);
        $userA->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $userA->organizations()->sync([$org->id => ['access' => 'owner']]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($userA)
            ->test('pages.organization.access-control')
            ->call('openRemoveModal', $userA->id)
            ->call('removeMember')
            ->assertSee('Cannot remove an Owner from the organization.');

        $this->assertTrue($org->users->contains($userA->id));
    }
}
