<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Route;
use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class SubscriptionPlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_subscription_plans_page(): void
    {
        $response = $this->get(route('organization.subscription-plans'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_subscription_plans_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.subscription-plans'));
        $response->assertStatus(200);
    }

    public function test_subscription_plans_page_displays_empty_state_when_no_active_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        Volt::actingAs($user)
            ->test('pages.organization.subscription-plans')
            ->assertDontSee('Add Plan')
            ->assertSee('No Active Organization Selected');
    }

    public function test_plans_page_loads_and_displays_plans(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $plan1 = $org->subscriptionPlans()->create([
            'name' => 'Monthly Standard Pass',
            'registration_start_date' => '2026-07-01',
            'registration_end_date' => '2026-07-10',
            'valid_till' => '2026-08-10',
            'amount' => 50.00,
        ]);

        $plan2 = $org->subscriptionPlans()->create([
            'name' => 'Weekly Express Pass',
            'registration_start_date' => '2026-07-01',
            'registration_end_date' => '2026-07-05',
            'valid_till' => '2026-07-12',
            'amount' => 15.50,
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.subscription-plans')
            ->assertSee('Monthly Standard Pass')
            ->assertSee('Weekly Express Pass')
            ->assertSee('₹50.00')
            ->assertSee('₹15.50');
    }

    public function test_plans_search_works_correctly(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $plan1 = $org->subscriptionPlans()->create([
            'name' => 'Monthly Standard Pass',
            'registration_start_date' => '2026-07-01',
            'registration_end_date' => '2026-07-10',
            'valid_till' => '2026-08-10',
            'amount' => 50.00,
        ]);

        $plan2 = $org->subscriptionPlans()->create([
            'name' => 'Weekly Express Pass',
            'registration_start_date' => '2026-07-01',
            'registration_end_date' => '2026-07-05',
            'valid_till' => '2026-07-12',
            'amount' => 15.50,
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.subscription-plans')
            ->set('search', 'Standard')
            ->assertSee('Monthly Standard Pass')
            ->assertDontSee('Weekly Express Pass')
            ->set('search', 'Weekly')
            ->assertSee('Weekly Express Pass')
            ->assertDontSee('Monthly Standard Pass');
    }

    public function test_plan_can_be_created_with_routes(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $route1 = $org->routes()->create(['name' => 'Route Alpha']);
        $route2 = $org->routes()->create(['name' => 'Route Beta']);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.subscription-plans')
            ->set('newName', 'Super Pass')
            ->set('newRegistrationStartDate', '2026-07-01')
            ->set('newRegistrationEndDate', '2026-07-05')
            ->set('newValidTill', '2026-07-31')
            ->set('newAmount', '99.99')
            ->set('newRouteIds', [$route1->id, $route2->id])
            ->call('createPlan')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('subscription_plans', [
            'organization_id' => $org->id,
            'name' => 'Super Pass',
            'amount' => '99.99',
        ]);

        $plan = SubscriptionPlan::where('name', 'Super Pass')->first();
        $this->assertCount(2, $plan->routes);
    }

    public function test_plan_update_syncs_routes(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $route1 = $org->routes()->create(['name' => 'Route Alpha']);
        $route2 = $org->routes()->create(['name' => 'Route Beta']);

        $plan = $org->subscriptionPlans()->create([
            'name' => 'Super Pass',
            'registration_start_date' => '2026-07-01',
            'registration_end_date' => '2026-07-10',
            'valid_till' => '2026-07-31',
            'amount' => 100.00,
        ]);
        $plan->routes()->attach([$route1->id]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.subscription-plans')
            ->call('openEditModal', $plan->id)
            ->set('editingName', 'Super Pass Premium')
            ->set('editingRouteIds', [$route2->id]) // remove route1, add route2
            ->call('updatePlan')
            ->assertHasNoErrors();

        $plan->refresh();
        $this->assertEquals('Super Pass Premium', $plan->name);
        $this->assertCount(1, $plan->routes);
        $this->assertEquals($route2->id, $plan->routes->first()->id);
    }

    public function test_plan_deletion_cascades_pivot(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $route = $org->routes()->create(['name' => 'Route Alpha']);

        $plan = $org->subscriptionPlans()->create([
            'name' => 'Super Pass',
            'registration_start_date' => '2026-07-01',
            'registration_end_date' => '2026-07-10',
            'valid_till' => '2026-07-31',
            'amount' => 100.00,
        ]);
        $plan->routes()->attach([$route->id]);

        session(['active_organization_id' => $org->id]);

        $this->assertDatabaseHas('subscription_plan_route', [
            'subscription_plan_id' => $plan->id,
            'route_id' => $route->id,
        ]);

        Volt::actingAs($user)
            ->test('pages.organization.subscription-plans')
            ->set('deletingPlanId', $plan->id)
            ->call('deletePlan')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('subscription_plans', ['id' => $plan->id]);
        $this->assertDatabaseMissing('subscription_plan_route', [
            'subscription_plan_id' => $plan->id,
        ]);
    }

    public function test_plan_validation_fails_for_invalid_date_order(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.subscription-plans')
            ->set('newName', 'Super Pass')
            ->set('newRegistrationStartDate', '2026-07-10')
            ->set('newRegistrationEndDate', '2026-07-05') // invalid: before start
            ->set('newValidTill', '2026-07-31')
            ->set('newAmount', '99.99')
            ->call('createPlan')
            ->assertHasErrors(['newRegistrationEndDate' => 'after_or_equal']);
    }
}
