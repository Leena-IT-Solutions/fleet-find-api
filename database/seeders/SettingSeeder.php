<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'company_name' => 'Fleet Find',
            'company_email' => 'info@fleetfind.com',
            'company_contact' => '+91 9664588677',
            
            'msg91_auth_key' => env('MSG91_AUTH_KEY', ''),
            'msg91_template_id' => env('MSG91_TEMPLATE_ID', ''),
            'registration_otp_enabled' => env('REGISTRATION_OTP_ENABLED', false) ? '1' : '0',
            
            'mailgun_domain' => env('MAILGUN_DOMAIN', ''),
            'mailgun_secret' => env('MAILGUN_SECRET', ''),
            'mailgun_endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
            'location_update_interval_seconds' => '10',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
