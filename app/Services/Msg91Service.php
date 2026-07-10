<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Msg91Service
{
    protected string $authKey;
    protected string $templateId;

    public function __construct()
    {
        $this->authKey = \App\Models\Setting::get('msg91_auth_key', config('services.msg91.auth_key', ''));
        $this->templateId = \App\Models\Setting::get('msg91_template_id', config('services.msg91.template_id', ''));
    }

    /**
     * Send OTP to a mobile number.
     */
    public function sendOtp(string $mobile): bool
    {
        // Prepend country code 91 if it's a 10-digit number
        $formattedMobile = $this->formatMobile($mobile);

        if (empty($this->authKey) || empty($this->templateId)) {
            Log::warning('MSG91 credentials are not configured. Mocking OTP send for testing.');
            return true; // Mock success if not configured
        }

        try {
            $response = Http::withHeaders([
                'authkey' => $this->authKey,
                'Content-Type' => 'application/json',
            ])->post("https://control.msg91.com/api/v5/otp", [
                'template_id' => $this->templateId,
                'mobile' => $formattedMobile,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return isset($data['type']) && $data['type'] === 'success';
            }

            Log::error('MSG91 OTP Send failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('MSG91 OTP Send exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify the OTP received on a mobile number.
     */
    public function verifyOtp(string $mobile, string $otp): bool
    {
        $formattedMobile = $this->formatMobile($mobile);

        // Mock verification for local testing/development when credentials are empty
        if (empty($this->authKey) || empty($this->templateId)) {
            Log::info('MSG91 credentials are not configured. Checking mock OTP (123456).');
            return $otp === '123456';
        }

        try {
            $response = Http::withHeaders([
                'authkey' => $this->authKey,
            ])->get("https://control.msg91.com/api/v5/otp/verify", [
                'otp' => $otp,
                'mobile' => $formattedMobile,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return isset($data['type']) && $data['type'] === 'success';
            }

            Log::error('MSG91 OTP Verify failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('MSG91 OTP Verify exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper to format mobile number to include country code.
     */
    protected function formatMobile(string $mobile): string
    {
        // Strip any non-digit characters
        $digits = preg_replace('/\D/', '', $mobile);

        if (strlen($digits) === 10) {
            return '91' . $digits;
        }

        return $digits;
    }
}
