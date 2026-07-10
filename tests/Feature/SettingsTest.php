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
        $this->actingAs($org)->get(route('settings.index'))->assertRedirect(route('organization.dashboard'));
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
            ->set('googleMapsApiKey', 'new_google_key')
            ->set('mapboxAccessToken', 'new_mapbox_token')
            ->set('mapTileUrl', 'https://{s}.tile.custom.org/{z}/{x}/{y}.png')
            ->set('mapDefaultLat', '20.1234')
            ->set('mapDefaultLng', '74.8765')
            ->set('mapDefaultZoom', 12)
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
        
        $this->assertEquals('new_google_key', Setting::get('google_maps_api_key'));
        $this->assertEquals('new_mapbox_token', Setting::get('mapbox_access_token'));
        $this->assertEquals('https://{s}.tile.custom.org/{z}/{x}/{y}.png', Setting::get('map_tile_url'));
        $this->assertEquals('20.1234', Setting::get('map_default_lat'));
        $this->assertEquals('74.8765', Setting::get('map_default_lng'));
        $this->assertEquals('12', Setting::get('map_default_zoom'));

        // Check dynamic config override works on subsequent loads
        $this->assertEquals('new-mailgun.com', config('services.mailgun.domain'));
        $this->assertEquals('new_mailgun_secret', config('services.mailgun.secret'));
        $this->assertEquals('api.eu.mailgun.net', config('services.mailgun.endpoint'));
        $this->assertTrue(config('services.msg91.otp_enabled'));
    }

    public function test_maps_settings_validation_rules(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        Volt::actingAs($admin)
            ->test('pages.settings.index')
            ->set('mapDefaultLat', '100') // Out of bounds (>90)
            ->set('mapDefaultLng', '-200') // Out of bounds (<-180)
            ->set('mapDefaultZoom', '25') // Out of bounds (>20)
            ->call('saveSettings')
            ->assertHasErrors([
                'mapDefaultLat' => 'between',
                'mapDefaultLng' => 'between',
                'mapDefaultZoom' => 'between',
            ]);
    }
}
