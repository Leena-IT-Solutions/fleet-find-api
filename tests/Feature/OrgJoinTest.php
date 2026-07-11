<?php

namespace Tests\Feature;

use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrgJoinTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_join_page_is_publicly_accessible(): void
    {
        $org = Organization::create([
            'name' => 'School District 101',
            'email' => 'district@school.org',
        ]);

        $response = $this->get(route('org.join', $org->id));

        $response->assertStatus(200);
        $response->assertSee('School District 101');
        $response->assertSee('Invited you to join their transit network');
        $response->assertSee('App Store');
        $response->assertSee('Google Play');
    }

    public function test_parent_join_page_returns_404_for_invalid_organization(): void
    {
        $response = $this->get('/org/999999/join');
        $response->assertStatus(404);
    }
}
