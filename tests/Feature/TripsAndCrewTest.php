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

        $driverUser = User::factory()->create(['name' => 'Hired Driver']);

        $driver = Driver::create([
            'user_id' => $driverUser->id,
            'organization_id' => $org->id,
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.crew')
            ->call('unhireCrew', 'driver', $driver->id)
            ->assertHasNoErrors();

        $this->assertNull(Driver::find($driver->id));
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

        $driverUser = User::factory()->create(['name' => 'John Pilot']);
        $attendantUser = User::factory()->create(['name' => 'Jane Crew']);

        $driver = Driver::create(['user_id' => $driverUser->id, 'organization_id' => $org->id]);
        $attendant = Attendant::create(['user_id' => $attendantUser->id, 'organization_id' => $org->id]);
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

    public function test_driver_can_get_assigned_trips(): void
    {
        $driverUser = User::factory()->create(['name' => 'John Driver']);
        $driverUser->assignRole('Driver');

        $org = Organization::create(['name' => 'Main Org']);
        $driver = Driver::create([
            'user_id' => $driverUser->id,
            'organization_id' => $org->id,
        ]);

        $vehicle = $org->vehicles()->create([
            'registration_number' => 'DRV-101',
            'type' => 'Bus',
            'model' => 'Tata Starbus',
        ]);

        $route = $org->routes()->create(['name' => 'Route B']);
        $stop1 = $route->stops()->create(['name' => 'Stop One', 'latitude' => 19.0, 'longitude' => 73.0, 'sequence_order' => 1]);
        $stop2 = $route->stops()->create(['name' => 'Stop Two', 'latitude' => 19.1, 'longitude' => 73.1, 'sequence_order' => 2]);

        // Another route whose stops should be filtered out
        $otherRoute = $org->routes()->create(['name' => 'Route C']);
        $otherStop = $otherRoute->stops()->create(['name' => 'Other Stop', 'latitude' => 19.2, 'longitude' => 73.2, 'sequence_order' => 1]);

        $trip = $org->trips()->create(['name' => 'Morning Route']);
        $trip->tripStops()->create(['stop_id' => $stop1->id, 'time' => '08:00:00']);
        $trip->tripStops()->create(['stop_id' => $stop2->id, 'time' => '08:30:00']);
        $trip->tripStops()->create(['stop_id' => $otherStop->id, 'time' => '08:45:00']);

        TripRouteLogistics::create([
            'trip_id' => $trip->id,
            'route_id' => $route->id,
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver->id,
            'stops_order' => 'asc',
        ]);

        $response = $this->actingAs($driverUser)->getJson('/api/driver/trips');
        $response->assertStatus(200);

        $response->assertJsonPath('success', true);
        $response->assertJsonPath('driver.name', 'John Driver');
        $response->assertJsonCount(1, 'trips');
        $response->assertJsonPath('trips.0.name', 'Morning Route');
        $response->assertJsonPath('trips.0.vehicle.registration_number', 'DRV-101');
        $response->assertJsonCount(2, 'trips.0.stops'); // Assert other route stop is filtered out
        $response->assertJsonPath('trips.0.stops.0.name', 'Stop One');
        $response->assertJsonPath('trips.0.stops.0.time', '08:00:00');
    }
}
