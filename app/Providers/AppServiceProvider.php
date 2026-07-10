<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dynamically override configurations from database settings when running in web requests
        if (!app()->runningInConsole()) {
            try {
                if ($mailgunDomain = \App\Models\Setting::get('mailgun_domain')) {
                    config(['services.mailgun.domain' => $mailgunDomain]);
                }
                if ($mailgunSecret = \App\Models\Setting::get('mailgun_secret')) {
                    config(['services.mailgun.secret' => $mailgunSecret]);
                }
                if ($mailgunEndpoint = \App\Models\Setting::get('mailgun_endpoint')) {
                    config(['services.mailgun.endpoint' => $mailgunEndpoint]);
                }

                $otpEnabledSetting = \App\Models\Setting::get('registration_otp_enabled');
                if ($otpEnabledSetting !== null) {
                    config(['services.msg91.otp_enabled' => $otpEnabledSetting === '1']);
                }
            } catch (\Exception $e) {
                // Fail silently if database is not migrated yet
            }
        }
    }
}
