<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordOtpMail;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_via_api(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'mobile' => '1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'mobile'],
                'roles',
                'access_token',
                'token_type'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_cannot_register_with_existing_email(): void
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'Another John',
            'email' => 'john@example.com',
            'mobile' => '0987654321',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_user_can_login_via_api(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'mobile'],
                'roles',
                'access_token',
                'token_type'
            ]);
    }

    public function test_user_can_login_via_api_with_mobile_number(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'mobile' => '9664588677',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => '9664588677',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'mobile'],
                'roles',
                'access_token',
                'token_type'
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid login credentials.'
            ]);
    }

    public function test_user_can_request_forgot_password_otp(): void
    {
        Mail::fake();

        $user = User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/forgot-password', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Verification code sent successfully to your email.'
            ]);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'john@example.com',
        ]);

        Mail::assertSent(ResetPasswordOtpMail::class);
    }

    public function test_user_can_reset_password_with_valid_otp(): void
    {
        $user = User::factory()->create(['email' => 'john@example.com']);
        
        $otp = '123456';
        DB::table('password_reset_tokens')->insert([
            'email' => 'john@example.com',
            'token' => Hash::make($otp),
            'created_at' => now(),
        ]);

        $response = $this->postJson('/api/reset-password', [
            'email' => 'john@example.com',
            'code' => $otp,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Your password has been successfully reset.'
            ]);

        $this->assertTrue(Hash::check('newpassword123', $user->refresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_can_logout_via_api(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out.'
            ]);
    }

    public function test_user_can_update_profile_via_api(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'mobile' => '1111111111',
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/profile/update', [
                'name' => 'New Name',
                'email' => 'new@example.com',
                'mobile' => '2222222222',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('user.name', 'New Name')
            ->assertJsonPath('user.email', 'new@example.com')
            ->assertJsonPath('user.mobile', '2222222222');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
            'mobile' => '2222222222',
        ]);
    }

    public function test_user_can_change_password_via_api(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/profile/password', [
                'current_password' => 'oldpassword',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Password updated successfully.'
            ]);

        $this->assertTrue(Hash::check('newpassword123', $user->refresh()->password));
    }

    public function test_user_can_delete_account_via_api(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson('/api/profile/delete');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Account deleted successfully.'
            ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_updating_profile_photo_removes_old_file(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'mobile' => '1234567890',
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        // 1. Upload first base64 photo
        $base64_1 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/profile/update', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'mobile' => '1234567890',
                'profile_photo' => $base64_1,
            ]);

        $response->assertStatus(200);
        $user->refresh();
        $this->assertNotNull($user->profile_photo);
        $firstPath = public_path($user->profile_photo);
        $this->assertFileExists($firstPath);

        // 2. Upload second base64 photo - this should delete the first file
        $base64_2 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
        $response2 = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/profile/update', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'mobile' => '1234567890',
                'profile_photo' => $base64_2,
            ]);

        $response2->assertStatus(200);
        $user->refresh();
        $secondPath = public_path($user->profile_photo);
        $this->assertFileExists($secondPath);
        $this->assertFileDoesNotExist($firstPath);

        // 3. Delete account - this should delete the second file
        $deleteResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson('/api/profile/delete');

        $deleteResponse->assertStatus(200);
        $this->assertFileDoesNotExist($secondPath);
    }

    public function test_user_can_retrieve_organization_details(): void
    {
        $user = User::factory()->create();
        $organization = Organization::create([
            'name' => 'Test Org',
            'contact_name' => 'Org Contact',
            'number' => '9999999999',
            'email' => 'org@example.com',
            'address' => '123 Test St',
        ]);
        $organization->users()->attach($user->id, ['access' => 'owner']);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/organization');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('organization.name', 'Test Org')
            ->assertJsonStructure([
                'success',
                'organization' => [
                    'id', 'name', 'contact_name', 'number', 'email', 'address',
                    'vehicles_count', 'drivers_count', 'attendants_count', 'routes_count', 'trips_count',
                    'vehicles', 'drivers', 'attendants'
                ]
            ]);
    }

    public function test_user_can_search_organizations()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        Organization::create([
            'name' => 'Acme Transit',
            'email' => 'acme@example.com',
            'address' => '123 Acme Way'
        ]);
        Organization::create([
            'name' => 'Globe Bus Service',
            'email' => 'globe@example.com',
            'address' => '456 Globe Blvd'
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/organizations/search?q=Acme');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'organizations')
            ->assertJsonPath('organizations.0.name', 'Acme Transit');

        $responseEmpty = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/organizations/search?q=XYZNonExistent');

        $responseEmpty->assertStatus(200)
            ->assertJsonCount(0, 'organizations');
    }
}
