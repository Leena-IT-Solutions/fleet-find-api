<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use App\Models\Child;
use App\Models\Grade;
use App\Models\Division;
use App\Models\Route;
use App\Models\Stop;
use App\Models\SubscriptionPlan;
use App\Models\ChildSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class SubscriptionEnrollmentWebTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Set up roles if not present
        \Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
    }

    public function test_guest_cannot_access_enrollments_page(): void
    {
        $response = $this->get(route('organization.enrollments'));
        $response->assertRedirect(route('login'));
    }

    public function test_organization_user_can_access_enrollments_page(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $response = $this->actingAs($user)->get(route('organization.enrollments'));
        $response->assertStatus(200);
    }

    public function test_enrollments_page_displays_empty_state_when_no_active_organization(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        Volt::actingAs($user)
            ->test('pages.organization.enrollments')
            ->assertSee('No Active Organization Selected');
    }

    public function test_enrollments_page_displays_enrollments_and_filters_correctly(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        // Create models
        $child1 = Child::create(['name' => 'Alice Brown', 'parent_id' => $user->id, 'gender' => 'Female']);
        $child2 = Child::create(['name' => 'Bob Miller', 'parent_id' => $user->id, 'gender' => 'Male']);

        $grade = Grade::create(['name' => 'Grade 1', 'organization_id' => $org->id]);
        $division = Division::create(['name' => 'Div A', 'grade_id' => $grade->id]);

        $route = Route::create(['name' => 'Route A', 'organization_id' => $org->id]);
        $stop1 = Stop::create(['name' => 'Stop 1', 'route_id' => $route->id, 'latitude' => 12.34, 'longitude' => 56.78]);
        $stop2 = Stop::create(['name' => 'Stop 2', 'route_id' => $route->id, 'latitude' => 12.35, 'longitude' => 56.79]);

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

        // Create subscriptions
        $sub1 = ChildSubscription::create([
            'child_id' => $child1->id,
            'subscription_plan_id' => $plan1->id,
            'grade_id' => $grade->id,
            'division_id' => $division->id,
            'route_id' => $route->id,
            'pickup_stop_id' => $stop1->id,
            'drop_stop_id' => $stop2->id,
            'parent_id' => $user->id,
            'status' => 'pending',
        ]);

        $sub2 = ChildSubscription::create([
            'child_id' => $child2->id,
            'subscription_plan_id' => $plan2->id,
            'grade_id' => $grade->id,
            'division_id' => $division->id,
            'route_id' => $route->id,
            'pickup_stop_id' => $stop1->id,
            'drop_stop_id' => $stop2->id,
            'parent_id' => $user->id,
            'status' => 'approved',
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.enrollments')
            ->assertSee('Alice Brown')
            ->assertSee('Bob Miller')
            ->assertSee('Monthly Standard Pass')
            ->assertSee('Weekly Express Pass')
            // Apply status filter
            ->set('statusFilter', 'approved')
            ->assertSee('Bob Miller')
            ->assertDontSee('Alice Brown')
            // Reset status filter and apply search filter
            ->set('statusFilter', '')
            ->set('search', 'Alice')
            ->assertSee('Alice Brown')
            ->assertDontSee('Bob Miller')
            // Reset search and apply plan filter
            ->set('search', '')
            ->set('planFilter', $plan2->id)
            ->assertSee('Bob Miller')
            ->assertDontSee('Alice Brown');
    }

    public function test_can_approve_and_disapprove_enrollments(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Organization');

        $org = Organization::create(['name' => 'Transit Corp']);
        $user->organizations()->sync([$org->id => ['access' => 'owner']]);

        $child = Child::create(['name' => 'Alice Brown', 'parent_id' => $user->id, 'gender' => 'Female']);
        $grade = Grade::create(['name' => 'Grade 1', 'organization_id' => $org->id]);
        $division = Division::create(['name' => 'Div A', 'grade_id' => $grade->id]);

        $route = Route::create(['name' => 'Route A', 'organization_id' => $org->id]);
        $stop1 = Stop::create(['name' => 'Stop 1', 'route_id' => $route->id, 'latitude' => 12.34, 'longitude' => 56.78]);
        $stop2 = Stop::create(['name' => 'Stop 2', 'route_id' => $route->id, 'latitude' => 12.35, 'longitude' => 56.79]);

        $plan = $org->subscriptionPlans()->create([
            'name' => 'Monthly Standard Pass',
            'registration_start_date' => '2026-07-01',
            'registration_end_date' => '2026-07-10',
            'valid_till' => '2026-08-10',
            'amount' => 50.00,
        ]);

        $sub = ChildSubscription::create([
            'child_id' => $child->id,
            'subscription_plan_id' => $plan->id,
            'grade_id' => $grade->id,
            'division_id' => $division->id,
            'route_id' => $route->id,
            'pickup_stop_id' => $stop1->id,
            'drop_stop_id' => $stop2->id,
            'parent_id' => $user->id,
            'status' => 'pending',
        ]);

        session(['active_organization_id' => $org->id]);

        Volt::actingAs($user)
            ->test('pages.organization.enrollments')
            ->assertSee('Pending')
            ->call('approveSubscription', $sub->id)
            ->assertSee('Approved');

        $this->assertEquals('approved', $sub->fresh()->status);

        Volt::actingAs($user)
            ->test('pages.organization.enrollments')
            ->call('disapproveSubscription', $sub->id)
            ->assertSee('Disapproved');

        $this->assertEquals('disapproved', $sub->fresh()->status);
    }
}
