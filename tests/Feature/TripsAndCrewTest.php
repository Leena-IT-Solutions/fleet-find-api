<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Attendant;
use App\Models\Route;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\TripStop;
use App\Models\TripRouteLogistics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class TripsAndCrewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_trips_page(): void
    {
        $response = $this->get(route('organization.trips'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_trips_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.trips'));
        $response->assertStatus(200);
    }

    public function test_trips_page_displays_empty_state_when_no_trips(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.trips')
            ->assertSee('No Journey Logs');
    }

    public function test_trip_can_be_created(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.trips')
            ->set('tripName', 'Morning Shift A1')
            ->call('saveTrip')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('trips', [
            'organization_id' => $org->id,
            'name' => 'Morning Shift A1',
        ]);
    }

    public function test_trip_can_be_updated(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $trip = $org->trips()->create(['name' => 'Old Name']);

        Volt::actingAs($user)
            ->test('pages.organization.trips')
            ->set('editingTripId', $trip->id)
            ->set('tripName', 'New Shift B2')
            ->call('saveTrip')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('trips', [
            'id' => $trip->id,
            'name' => 'New Shift B2',
        ]);
    }

    public function test_trip_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $trip = $org->trips()->create(['name' => 'Temporary Trip']);

        Volt::actingAs($user)
            ->test('pages.organization.trips')
            ->set('deletingTripId', $trip->id)
            ->call('deleteTrip')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('trips', [
            'id' => $trip->id,
        ]);
    }

    public function test_crew_can_be_hired_by_email_or_mobile(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $pilotUser = User::factory()->create([
            'email' => 'pilot@academy.com',
            'mobile' => '9988776655',
            'name' => 'John Pilot',
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.crew')
            ->set('crewType', 'driver')
            ->set('crewIdentity', 'pilot@academy.com')
            ->call('hireCrew')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('drivers', [
            'user_id' => $pilotUser->id,
            'organization_id' => $org->id,
            'name' => 'John Pilot',
        ]);

        $this->assertTrue($pilotUser->fresh()->hasRole('Driver'));
    }

    public function test_crew_can_be_unhired(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $driver = Driver::create([
            'name' => 'Hired Driver',
            'organization_id' => $org->id,
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.crew')
            ->call('unhireCrew', 'driver', $driver->id)
            ->assertHasNoErrors();

        $this->assertNull($driver->fresh()->organization_id);
    }

    public function test_logistics_can_be_saved(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $route = $org->routes()->create(['name' => 'School Route A']);
        $vehicle = $org->vehicles()->create(['registration_number' => 'MH12AA1111', 'type' => 'Bus']);
        $driver = Driver::create(['name' => 'John Pilot', 'organization_id' => $org->id]);
        $attendant = Attendant::create(['name' => 'Jane Crew', 'organization_id' => $org->id]);
        $trip = $org->trips()->create(['name' => 'Main Shift']);

        Volt::actingAs($user)
            ->test('pages.organization.trips')
            ->set("logisticsData.{$trip->id}_{$route->id}", [
                'vehicle_id' => (string)$vehicle->id,
                'driver_id' => (string)$driver->id,
                'attendant_id' => (string)$attendant->id,
            ])
            ->call('saveLogistics', $trip->id, $route->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('trip_route_logistics', [
            'trip_id' => $trip->id,
            'route_id' => $route->id,
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver->id,
            'attendant_id' => $attendant->id,
        ]);
    }

    public function test_route_timings_can_be_saved(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $route = $org->routes()->create(['name' => 'School Route A']);
        $stop1 = Stop::create(['name' => 'Main Gate', 'route_id' => $route->id, 'latitude' => 19.0, 'longitude' => 72.0, 'sequence_order' => 1]);
        $stop2 = Stop::create(['name' => 'Bus Depot', 'route_id' => $route->id, 'latitude' => 19.1, 'longitude' => 72.1, 'sequence_order' => 2]);
        
        $trip = $org->trips()->create(['name' => 'Main Shift']);

        Volt::actingAs($user)
            ->test('pages.organization.trips')
            ->set("timingsData.{$trip->id}_{$stop1->id}", [
                'time' => '07:30',
            ])
            ->set("timingsData.{$trip->id}_{$stop2->id}", [
                'time' => '07:50',
            ])
            ->call('saveRouteTimings', $trip->id, $route->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('trip_stops', [
            'trip_id' => $trip->id,
            'stop_id' => $stop1->id,
            'time' => '07:30',
        ]);

        $this->assertDatabaseHas('trip_stops', [
            'trip_id' => $trip->id,
            'stop_id' => $stop2->id,
            'time' => '07:50',
        ]);
    }

    public function test_stops_order_can_be_toggled(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Star Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $route = $org->routes()->create(['name' => 'School Route A']);
        $trip = $org->trips()->create(['name' => 'Main Shift']);

        Volt::actingAs($user)
            ->test('pages.organization.trips')
            ->call('toggleStopsOrder', $trip->id, $route->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('trip_route_logistics', [
            'trip_id' => $trip->id,
            'route_id' => $route->id,
            'stops_order' => 'desc',
        ]);
    }
}
