<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Organization;
use App\Models\Trip;
use App\Models\Grade;
use App\Models\Division;
use Livewire\Volt\Volt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TripMappingTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_trip_mapping(): void
    {
        $response = $this->get('/organization/trip-mapping');
        $response->assertRedirect('/login');
    }

    public function test_organization_user_can_view_trip_mapping(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School District']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $trip = $org->trips()->create(['name' => 'Trip A']);
        $grade = $org->grades()->create(['name' => 'Grade 5']);
        $division = $grade->divisions()->create(['name' => 'A']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.trip-mapping')
            ->assertSee('Trip A')
            ->assertSee('Grade 5')
            ->assertSee('A');
    }

    public function test_can_toggle_division_mapping(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School District']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $trip = $org->trips()->create(['name' => 'Trip A']);
        $grade = $org->grades()->create(['name' => 'Grade 5']);
        $division = $grade->divisions()->create(['name' => 'A']);

        session(['active_organization_id' => $org->id]);

        // Toggle on
        Volt::actingAs($user)
            ->test('pages.organization.trip-mapping')
            ->call('toggleDivision', $trip->id, $division->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('trip_division', [
            'trip_id' => $trip->id,
            'division_id' => $division->id,
        ]);

        // Toggle off
        Volt::actingAs($user)
            ->test('pages.organization.trip-mapping')
            ->call('toggleDivision', $trip->id, $division->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('trip_division', [
            'trip_id' => $trip->id,
            'division_id' => $division->id,
        ]);
    }

    public function test_can_toggle_all_grade_divisions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'School District']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $trip = $org->trips()->create(['name' => 'Trip A']);
        $grade = $org->grades()->create(['name' => 'Grade 5']);
        $divisionA = $grade->divisions()->create(['name' => 'A']);
        $divisionB = $grade->divisions()->create(['name' => 'B']);

        session(['active_organization_id' => $org->id]);

        // Select all
        Volt::actingAs($user)
            ->test('pages.organization.trip-mapping')
            ->call('toggleGradeAll', $trip->id, $grade->id, 1)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('trip_division', ['trip_id' => $trip->id, 'division_id' => $divisionA->id]);
        $this->assertDatabaseHas('trip_division', ['trip_id' => $trip->id, 'division_id' => $divisionB->id]);

        // Deselect all
        Volt::actingAs($user)
            ->test('pages.organization.trip-mapping')
            ->call('toggleGradeAll', $trip->id, $grade->id, 0)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('trip_division', ['trip_id' => $trip->id, 'division_id' => $divisionA->id]);
        $this->assertDatabaseMissing('trip_division', ['trip_id' => $trip->id, 'division_id' => $divisionB->id]);
    }

    public function test_trip_cascade_delete_cleans_up_pivot(): void
    {
        $org = Organization::create(['name' => 'School District']);
        $trip = $org->trips()->create(['name' => 'Trip A']);
        $grade = $org->grades()->create(['name' => 'Grade 5']);
        $division = $grade->divisions()->create(['name' => 'A']);

        $trip->divisions()->attach($division->id);

        $this->assertDatabaseHas('trip_division', [
            'trip_id' => $trip->id,
            'division_id' => $division->id,
        ]);

        $trip->delete();

        $this->assertDatabaseMissing('trip_division', [
            'division_id' => $division->id,
        ]);
    }

    public function test_division_cascade_delete_cleans_up_pivot(): void
    {
        $org = Organization::create(['name' => 'School District']);
        $trip = $org->trips()->create(['name' => 'Trip A']);
        $grade = $org->grades()->create(['name' => 'Grade 5']);
        $division = $grade->divisions()->create(['name' => 'A']);

        $trip->divisions()->attach($division->id);

        $this->assertDatabaseHas('trip_division', [
            'trip_id' => $trip->id,
            'division_id' => $division->id,
        ]);

        $division->delete();

        $this->assertDatabaseMissing('trip_division', [
            'trip_id' => $trip->id,
        ]);
    }
}
