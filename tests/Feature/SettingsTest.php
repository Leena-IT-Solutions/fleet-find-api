<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_system_settings_and_save_data(): void
    {
        // Seed default settings first
        $this->seed(\Database\Seeders\SettingSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $org = User::factory()->create();
        $org->assignRole('Organization');

        // Verify only Admin can access
        $this->actingAs($org)->get(route('settings.index'))->assertStatus(403);
        $this->actingAs($admin)->get(route('settings.index'))->assertStatus(200);

        // Test saving settings
        Volt::actingAs($admin)
            ->test('pages.settings.index')
            ->assertSet('companyName', 'Fleet Find')
            ->set('companyName', 'New Company Name')
            ->set('companyEmail', 'new@company.com')
            ->set('companyContact', '+91 9999988888')
            ->set('msg91AuthKey', 'new_msg91_key')
            ->set('msg91TemplateId', 'new_template_id')
            ->set('registrationOtpEnabled', true)
            ->set('mailgunDomain', 'new-mailgun.com')
            ->set('mailgunSecret', 'new_mailgun_secret')
            ->set('mailgunEndpoint', 'api.eu.mailgun.net')
            ->call('saveSettings')
            ->assertHasNoErrors();

        // Verify database persistence
        $this->assertEquals('New Company Name', Setting::get('company_name'));
        $this->assertEquals('new@company.com', Setting::get('company_email'));
        $this->assertEquals('+91 9999988888', Setting::get('company_contact'));
        $this->assertEquals('new_msg91_key', Setting::get('msg91_auth_key'));
        $this->assertEquals('new_template_id', Setting::get('msg91_template_id'));
        $this->assertEquals('1', Setting::get('registration_otp_enabled'));
        $this->assertEquals('new-mailgun.com', Setting::get('mailgun_domain'));
        $this->assertEquals('new_mailgun_secret', Setting::get('mailgun_secret'));
        $this->assertEquals('api.eu.mailgun.net', Setting::get('mailgun_endpoint'));
        
        // Check dynamic config override works on subsequent loads
        $this->assertEquals('new-mailgun.com', config('services.mailgun.domain'));
        $this->assertEquals('new_mailgun_secret', config('services.mailgun.secret'));
        $this->assertEquals('api.eu.mailgun.net', config('services.mailgun.endpoint'));
        $this->assertTrue(config('services.msg91.otp_enabled'));
    }
}
