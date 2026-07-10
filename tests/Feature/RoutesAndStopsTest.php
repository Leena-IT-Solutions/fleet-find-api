<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Route;
use App\Models\Stop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RoutesAndStopsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_routes_page(): void
    {
        $response = $this->get(route('organization.routes'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_routes_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.routes'));
        $response->assertStatus(200);
    }

    public function test_routes_page_displays_empty_state_when_no_active_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->assertDontSee('Routes')
            ->assertSee('No Active Organization Selected');
    }

    public function test_routes_page_loads_and_displays_linked_routes(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $route1 = $org->routes()->create([
            'name' => 'Route A - North Sector',
            'description' => 'Serves North areas',
        ]);

        $route2 = $org->routes()->create([
            'name' => 'Route B - South Sector',
            'description' => 'Serves South areas',
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->assertSee('Route A - North Sector')
            ->assertSee('Route B - South Sector')
            ->assertSee('Serves North areas')
            ->assertSee('Serves South areas');
    }

    public function test_routes_search_works_correctly(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $route1 = $org->routes()->create([
            'name' => 'Route A - North Sector',
            'description' => 'Serves North areas',
        ]);

        $route2 = $org->routes()->create([
            'name' => 'Route B - South Sector',
            'description' => 'Serves South areas',
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->set('search', 'Route A')
            ->assertSee('Route A - North Sector')
            ->assertDontSee('Route B - South Sector');
    }

    public function test_routes_can_be_created(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->call('openAddRouteModal')
            ->set('routeName', 'Route C - East Sector')
            ->set('routeDescription', 'Serves East areas')
            ->call('saveRoute')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('routes', [
            'organization_id' => $org->id,
            'name' => 'Route C - East Sector',
            'description' => 'Serves East areas',
        ]);
    }

    public function test_routes_create_validates_required_fields(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->set('routeName', '')
            ->call('saveRoute')
            ->assertHasErrors(['routeName' => 'required']);
    }

    public function test_routes_can_be_edited(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $route = $org->routes()->create([
            'name' => 'Route A - North Sector',
            'description' => 'Serves North areas',
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->call('openEditRouteModal', $route->id)
            ->assertSet('routeName', 'Route A - North Sector')
            ->set('routeName', 'Route A Updated')
            ->set('routeDescription', 'Updated description')
            ->call('saveRoute')
            ->assertHasNoErrors();

        $route->refresh();
        $this->assertEquals('Route A Updated', $route->name);
        $this->assertEquals('Updated description', $route->description);
    }

    public function test_routes_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $route = $org->routes()->create([
            'name' => 'Route A - North Sector',
            'description' => 'Serves North areas',
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->call('openDeleteRouteModal', $route->id)
            ->call('deleteRoute')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('routes', ['id' => $route->id]);
    }

    public function test_stops_can_be_managed_on_active_route(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Starlight Academy']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);
        session(['active_organization_id' => $org->id]);

        $route = $org->routes()->create([
            'name' => 'Route A - North Sector',
        ]);

        // Add Stop
        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->set('selectedRouteId', $route->id)
            ->call('openAddStopModal')
            ->set('stopName', 'Stop 1')
            ->set('stopLatitude', '19.1886')
            ->set('stopLongitude', '73.2199')
            ->call('saveStop')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('stops', [
            'route_id' => $route->id,
            'name' => 'Stop 1',
            'latitude' => 19.1886,
            'longitude' => 73.2199,
        ]);

        $stop = Stop::where('name', 'Stop 1')->first();

        // Edit Stop
        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->set('selectedRouteId', $route->id)
            ->call('openEditStopModal', $stop->id)
            ->assertSet('stopName', 'Stop 1')
            ->set('stopName', 'Stop 1 Updated')
            ->call('saveStop')
            ->assertHasNoErrors();

        $stop->refresh();
        $this->assertEquals('Stop 1 Updated', $stop->name);

        // Delete Stop
        Volt::actingAs($user)
            ->test('pages.organization.routes-and-stops')
            ->set('selectedRouteId', $route->id)
            ->call('openDeleteStopModal', $stop->id)
            ->call('deleteStop')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('stops', ['id' => $stop->id]);
    }
}
