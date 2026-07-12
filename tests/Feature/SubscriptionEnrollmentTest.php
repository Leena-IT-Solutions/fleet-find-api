<?php

namespace Tests\Feature;

use App\Models\Child;
use App\Models\ChildSubscription;
use App\Models\Division;
use App\Models\Grade;
use App\Models\Organization;
use App\Models\Route as BusRoute;
use App\Models\Stop;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    private $parent;
    private $organization;
    private $child;
    private $grade;
    private $division;
    private $busRoute;
    private $pickupStop;
    private $dropStop;
    private $plan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parent = User::factory()->create();
        $this->organization = Organization::create(['name' => 'School District']);

        // Create child
        $this->child = Child::create([
            'parent_id' => $this->parent->id,
            'name' => 'John Doe Junior',
            'gender' => 'Male',
        ]);
        $this->child->parents()->syncWithoutDetaching([
            $this->parent->id => ['relationship_type' => 'Father']
        ]);

        // Create Grade and Division
        $this->grade = Grade::create([
            'organization_id' => $this->organization->id,
            'name' => 'Grade 1',
        ]);
        $this->division = Division::create([
            'grade_id' => $this->grade->id,
            'name' => 'A',
        ]);

        // Create Route and Stops
        $this->busRoute = BusRoute::create([
            'organization_id' => $this->organization->id,
            'name' => 'Route 1',
        ]);
        $this->pickupStop = Stop::create([
            'route_id' => $this->busRoute->id,
            'name' => 'Stop Alpha',
            'sequence_order' => 1,
        ]);
        $this->dropStop = Stop::create([
            'route_id' => $this->busRoute->id,
            'name' => 'Stop Beta',
            'sequence_order' => 2,
        ]);

        // Create Subscription Plan (registration active today)
        $this->plan = SubscriptionPlan::create([
            'organization_id' => $this->organization->id,
            'name' => 'Annual Pass',
            'registration_start_date' => now()->subDays(5)->format('Y-m-d'),
            'registration_end_date' => now()->addDays(5)->format('Y-m-d'),
            'valid_till' => now()->addYear()->format('Y-m-d'),
            'amount' => 12000.00,
        ]);

        // Link Route to Plan
        $this->plan->routes()->sync([$this->busRoute->id]);
    }

    public function test_can_fetch_enrollment_options()
    {
        $token = $this->parent->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson("/api/subscription-plans/{$this->plan->id}/enrollment-options");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'children')
            ->assertJsonPath('children.0.name', 'John Doe Junior')
            ->assertJsonCount(1, 'grades')
            ->assertJsonPath('grades.0.name', 'Grade 1')
            ->assertJsonCount(1, 'grades.0.divisions')
            ->assertJsonCount(1, 'routes')
            ->assertJsonCount(2, 'routes.0.stops');
    }

    public function test_can_enroll_successfully()
    {
        $token = $this->parent->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson("/api/subscription-plans/{$this->plan->id}/enroll", [
                'child_id' => $this->child->id,
                'grade_id' => $this->grade->id,
                'division_id' => $this->division->id,
                'route_id' => $this->busRoute->id,
                'pickup_stop_id' => $this->pickupStop->id,
                'drop_stop_id' => $this->dropStop->id,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Subscription request submitted successfully.');

        $this->assertDatabaseHas('child_subscriptions', [
            'child_id' => $this->child->id,
            'subscription_plan_id' => $this->plan->id,
            'grade_id' => $this->grade->id,
            'division_id' => $this->division->id,
            'route_id' => $this->busRoute->id,
            'pickup_stop_id' => $this->pickupStop->id,
            'drop_stop_id' => $this->dropStop->id,
            'parent_id' => $this->parent->id,
            'status' => 'pending',
        ]);
    }

    public function test_cannot_enroll_outside_registration_window()
    {
        // Future plan
        $futurePlan = SubscriptionPlan::create([
            'organization_id' => $this->organization->id,
            'name' => 'Summer Pass',
            'registration_start_date' => now()->addDays(5)->format('Y-m-d'),
            'registration_end_date' => now()->addDays(15)->format('Y-m-d'),
            'valid_till' => now()->addYear()->format('Y-m-d'),
            'amount' => 5000.00,
        ]);

        $token = $this->parent->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson("/api/subscription-plans/{$futurePlan->id}/enroll", [
                'child_id' => $this->child->id,
                'grade_id' => $this->grade->id,
                'division_id' => $this->division->id,
                'route_id' => $this->busRoute->id,
                'pickup_stop_id' => $this->pickupStop->id,
                'drop_stop_id' => $this->dropStop->id,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Registration has not started yet.');
    }

    public function test_cannot_enroll_same_child_twice()
    {
        $token = $this->parent->createToken('test-token')->plainTextToken;

        // First enrollment
        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson("/api/subscription-plans/{$this->plan->id}/enroll", [
                'child_id' => $this->child->id,
                'grade_id' => $this->grade->id,
                'division_id' => $this->division->id,
                'route_id' => $this->busRoute->id,
                'pickup_stop_id' => $this->pickupStop->id,
                'drop_stop_id' => $this->dropStop->id,
            ]);

        // Second enrollment attempt
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson("/api/subscription-plans/{$this->plan->id}/enroll", [
                'child_id' => $this->child->id,
                'grade_id' => $this->grade->id,
                'division_id' => $this->division->id,
                'route_id' => $this->busRoute->id,
                'pickup_stop_id' => $this->pickupStop->id,
                'drop_stop_id' => $this->dropStop->id,
            ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'This child is already enrolled or has a pending enrollment in this plan.');
    }
}
