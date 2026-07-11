<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Grade;
use App\Models\Division;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class GradeDivisionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_grades_divisions_page(): void
    {
        $response = $this->get(route('organization.grades-divisions'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_grades_divisions_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.grades-divisions'));
        $response->assertStatus(200);
    }

    public function test_grades_divisions_page_displays_empty_state_when_no_active_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->assertDontSee('Search grades by name...')
            ->assertSee('No Active Organization Selected');
    }

    public function test_grades_page_loads_and_displays_grades_and_divisions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $grade1 = $org->grades()->create(['name' => 'Grade 10']);
        $grade2 = $org->grades()->create(['name' => 'Grade 11']);

        $divisionA = $grade1->divisions()->create(['name' => 'A']);
        $divisionB = $grade1->divisions()->create(['name' => 'B']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->assertSee('Grade 10')
            ->assertSee('Grade 11')
            ->assertSee('A')
            ->assertSee('B');
    }

    public function test_grades_search_works_correctly(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $org->grades()->create(['name' => 'Grade 9']);
        $org->grades()->create(['name' => 'Grade 10']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->set('search', '9')
            ->assertSee('Grade 9')
            ->assertDontSee('Grade 10')
            ->set('search', '10')
            ->assertSee('Grade 10')
            ->assertDontSee('Grade 9');
    }

    public function test_grade_can_be_created(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->set('newGradeName', 'Grade 1')
            ->call('createGrade')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('grades', [
            'organization_id' => $org->id,
            'name' => 'Grade 1',
        ]);
    }

    public function test_cannot_create_duplicate_grade_under_same_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        $org->grades()->create(['name' => 'Grade 1']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->set('newGradeName', 'Grade 1')
            ->call('createGrade')
            ->assertHasErrors(['newGradeName' => 'unique']);
    }

    public function test_grade_name_can_be_updated(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        $grade = $org->grades()->create(['name' => 'Grade 1']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->call('openEditGradeModal', $grade->id)
            ->set('editingGradeName', 'Grade 1 Premium')
            ->call('updateGrade')
            ->assertHasNoErrors();

        $grade->refresh();
        $this->assertEquals('Grade 1 Premium', $grade->name);
    }

    public function test_grade_deletion_cascades_divisions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        
        $grade = $org->grades()->create(['name' => 'Grade 1']);
        $division = $grade->divisions()->create(['name' => 'A']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->call('openDeleteGradeModal', $grade->id)
            ->call('deleteGrade')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('grades', ['id' => $grade->id]);
        $this->assertDatabaseMissing('divisions', ['id' => $division->id]);
    }

    public function test_division_can_be_added_to_grade(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        
        $grade = $org->grades()->create(['name' => 'Grade 1']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->set('newDivisionNames.' . $grade->id, 'A')
            ->call('addDivision', $grade->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('divisions', [
            'grade_id' => $grade->id,
            'name' => 'A',
        ]);
    }

    public function test_division_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School Board']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        
        $grade = $org->grades()->create(['name' => 'Grade 1']);
        $division = $grade->divisions()->create(['name' => 'A']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.grades-divisions')
            ->call('deleteDivision', $division->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('divisions', ['id' => $division->id]);
    }
}
