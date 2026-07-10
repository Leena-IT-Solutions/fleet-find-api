<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    }

    public function test_new_users_can_register_without_otp_verification(): void
    {
        config(['services.msg91.otp_enabled' => false]);

        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('mobile', '9876543210')
            ->set('password', 'password')
            ->set('password_confirmation', 'password');

        $component->call('register');

        $component->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    public function test_new_users_can_register_with_otp_verification(): void
    {
        config(['services.msg91.otp_enabled' => true]);

        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('mobile', '9876543210')
            ->set('password', 'password')
            ->set('password_confirmation', 'password');

        // Step 1: Submit form details to request OTP
        $component->call('register');
        $component->assertSet('otpSent', true);

        // Step 2: Set the mock OTP code and verify/register
        $component->set('otp', '123456');
        $component->call('register');

        $component->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    }
}
