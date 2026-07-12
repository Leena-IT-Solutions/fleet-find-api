<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Attendant;
use App\Models\Route;
use App\Models\Trip;
use App\Models\TripRouteLogistics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TripTrackingTest extends TestCase
{
    use RefreshDatabase;

    private function createTripWithCrew()
    {
        $org = Organization::create(['name' => 'Star Academy']);
        
        $driverUser = User::factory()->create();
        $driverUser->assignRole('Driver');
        $driver = Driver::create([
            'user_id' => $driverUser->id,
            'organization_id' => $org->id,
            'name' => 'Sandeep Driver',
            'number' => '9664588677',
        ]);

        $attendantUser = User::factory()->create();
        $attendantUser->assignRole('Attendant');
        $attendant = Attendant::create([
            'user_id' => $attendantUser->id,
            'organization_id' => $org->id,
            'name' => 'Leena Attendant',
            'number' => '9769409405',
        ]);

        $route = Route::create([
            'organization_id' => $org->id,
            'name' => 'Ambernath Route',
        ]);

        $trip = Trip::create([
            'organization_id' => $org->id,
            'name' => 'Morning Pickup',
        ]);

        $logistic = TripRouteLogistics::create([
            'trip_id' => $trip->id,
            'route_id' => $route->id,
            'driver_id' => $driver->id,
            'attendant_id' => $attendant->id,
            'is_tracking' => false,
        ]);

        return [$trip, $driverUser, $attendantUser, $logistic];
    }

    public function test_guest_blocked_from_trip_tracking(): void
    {
        list($trip, $driverUser, $attendantUser, $logistic) = $this->createTripWithCrew();

        $this->postJson("/api/trip/{$trip->id}/toggle-tracking", ['is_tracking' => true])
            ->assertStatus(401);

        $this->postJson("/api/trip/{$trip->id}/location", ['latitude' => 19.123, 'longitude' => 73.123])
            ->assertStatus(401);
    }

    public function test_unassigned_user_blocked_from_trip_tracking(): void
    {
        list($trip, $driverUser, $attendantUser, $logistic) = $this->createTripWithCrew();
        $randomUser = User::factory()->create();
        $randomUser->assignRole('Driver');

        $this->actingAs($randomUser)
            ->postJson("/api/trip/{$trip->id}/toggle-tracking", ['is_tracking' => true])
            ->assertStatus(403);
    }

    public function test_assigned_driver_can_toggle_tracking_on_and_off(): void
    {
        list($trip, $driverUser, $attendantUser, $logistic) = $this->createTripWithCrew();

        // Toggle ON
        $response = $this->actingAs($driverUser)
            ->postJson("/api/trip/{$trip->id}/toggle-tracking", ['is_tracking' => true]);
        
        $response->assertStatus(200);
        $this->assertTrue(TripRouteLogistics::first()->is_tracking);

        // Update location coordinates
        $this->actingAs($driverUser)
            ->postJson("/api/trip/{$trip->id}/location", [
                'latitude' => 19.213124,
                'longitude' => 73.141526,
                'speed' => 35.5
            ])
            ->assertStatus(200);

        $fresh = TripRouteLogistics::first();
        $this->assertEquals(19.213124, $fresh->latitude);
        $this->assertEquals(73.141526, $fresh->longitude);
        $this->assertEquals(35.5, $fresh->speed);

        // Toggle OFF - should clear coordinates and speed
        $response = $this->actingAs($driverUser)
            ->postJson("/api/trip/{$trip->id}/toggle-tracking", ['is_tracking' => false]);
            
        $response->assertStatus(200);
        
        $fresh = TripRouteLogistics::first();
        $this->assertFalse($fresh->is_tracking);
        $this->assertNull($fresh->latitude);
        $this->assertNull($fresh->longitude);
        $this->assertNull($fresh->speed);
    }

    public function test_assigned_attendant_can_toggle_tracking(): void
    {
        list($trip, $driverUser, $attendantUser, $logistic) = $this->createTripWithCrew();

        $response = $this->actingAs($attendantUser)
            ->postJson("/api/trip/{$trip->id}/toggle-tracking", ['is_tracking' => true]);
        
        $response->assertStatus(200);
        $this->assertTrue(TripRouteLogistics::first()->is_tracking);
    }
}
