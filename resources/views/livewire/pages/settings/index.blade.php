<?php

use Livewire\Volt\Component;
use App\Models\Setting;

new class extends Component
{
    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public function mount()
    {
        if (!auth()->user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access.');
        }

        $this->companyName = Setting::get('company_name', '');
        $this->companyEmail = Setting::get('company_email', '');
        $this->companyContact = Setting::get('company_contact', '');
        
        $this->msg91AuthKey = Setting::get('msg91_auth_key', '');
        $this->msg91TemplateId = Setting::get('msg91_template_id', '');
        $this->registrationOtpEnabled = Setting::get('registration_otp_enabled', '0') === '1';

        $this->mailgunDomain = Setting::get('mailgun_domain', '');
        $this->mailgunSecret = Setting::get('mailgun_secret', '');
        $this->mailgunEndpoint = Setting::get('mailgun_endpoint', 'api.mailgun.net');

        $this->googleMapsApiKey = Setting::get('google_maps_api_key', '');
        $this->mapboxAccessToken = Setting::get('mapbox_access_token', '');
        $this->mapTileUrl = Setting::get('map_tile_url', 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        $this->mapDefaultLat = Setting::get('map_default_lat', '19.18');
        $this->mapDefaultLng = Setting::get('map_default_lng', '73.21');
        $this->mapDefaultZoom = Setting::get('map_default_zoom', '14');
        $this->mapProvider = Setting::get('map_provider', 'leaflet');
    }

    public string $companyName = '';
    public string $companyEmail = '';
    public string $companyContact = '';

    public string $msg91AuthKey = '';
    public string $msg91TemplateId = '';
    public bool $registrationOtpEnabled = false;

    public string $mailgunDomain = '';
    public string $mailgunSecret = '';
    public string $mailgunEndpoint = '';

    public string $googleMapsApiKey = '';
    public string $mapboxAccessToken = '';
    public string $mapTileUrl = '';
    public string $mapDefaultLat = '';
    public string $mapDefaultLng = '';
    public string $mapDefaultZoom = '';
    public string $mapProvider = 'leaflet';

    public function saveSettings(): void
    {
        $this->validate([
            'companyName' => ['required', 'string', 'max:255'],
            'companyEmail' => ['required', 'email', 'max:255'],
            'companyContact' => ['required', 'string', 'max:50'],
            'msg91AuthKey' => ['nullable', 'string', 'max:255'],
            'msg91TemplateId' => ['nullable', 'string', 'max:255'],
            'registrationOtpEnabled' => ['boolean'],
            'mailgunDomain' => ['nullable', 'string', 'max:255'],
            'mailgunSecret' => ['nullable', 'string', 'max:255'],
            'mailgunEndpoint' => ['required', 'string', 'max:255'],
            'googleMapsApiKey' => ['nullable', 'string', 'max:255'],
            'mapboxAccessToken' => ['nullable', 'string', 'max:255'],
            'mapTileUrl' => ['required', 'string', 'max:255'],
            'mapDefaultLat' => ['required', 'numeric', 'between:-90,90'],
            'mapDefaultLng' => ['required', 'numeric', 'between:-180,180'],
            'mapDefaultZoom' => ['required', 'integer', 'between:1,20'],
            'mapProvider' => ['required', 'string', 'in:google_maps,mapbox,leaflet'],
        ]);

        Setting::set('company_name', $this->companyName);
        Setting::set('company_email', $this->companyEmail);
        Setting::set('company_contact', $this->companyContact);

        Setting::set('msg91_auth_key', $this->msg91AuthKey);
        Setting::set('msg91_template_id', $this->msg91TemplateId);
        Setting::set('registration_otp_enabled', $this->registrationOtpEnabled ? '1' : '0');

        Setting::set('mailgun_domain', $this->mailgunDomain);
        Setting::set('mailgun_secret', $this->mailgunSecret);
        Setting::set('mailgun_endpoint', $this->mailgunEndpoint);

        Setting::set('google_maps_api_key', $this->googleMapsApiKey);
        Setting::set('mapbox_access_token', $this->mapboxAccessToken);
        Setting::set('map_tile_url', $this->mapTileUrl);
        Setting::set('map_default_lat', $this->mapDefaultLat);
        Setting::set('map_default_lng', $this->mapDefaultLng);
        Setting::set('map_default_zoom', $this->mapDefaultZoom);
        Setting::set('map_provider', $this->mapProvider);

        // Dynamically update config in current request scope
        config([
            'services.mailgun.domain' => $this->mailgunDomain,
            'services.mailgun.secret' => $this->mailgunSecret,
            'services.mailgun.endpoint' => $this->mailgunEndpoint,
            'services.msg91.otp_enabled' => $this->registrationOtpEnabled,
        ]);

        session()->flash('success', 'System settings updated successfully.');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6">
        <!-- Success Alert Messages -->
        @if (session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-sm flex items-center gap-2 max-w-3xl">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="saveSettings" class="max-w-3xl flex flex-col gap-6">
            <!-- Company Details Section -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 16.5h1.5M13.5 16.5H15" />
                    </svg>
                    <span>Company Details</span>
                </h3>
                
                <div class="flex flex-col gap-4">
                    <div>
                        <x-input-label for="companyName" value="{{ __('Company Name') }}" />
                        <x-text-input id="companyName" type="text" class="mt-1 block w-full" wire:model="companyName" required />
                        <x-input-error :messages="$errors->get('companyName')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="companyEmail" value="{{ __('Company Email') }}" />
                            <x-text-input id="companyEmail" type="email" class="mt-1 block w-full" wire:model="companyEmail" required />
                            <x-input-error :messages="$errors->get('companyEmail')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="companyContact" value="{{ __('Contact Number') }}" />
                            <x-text-input id="companyContact" type="text" class="mt-1 block w-full" wire:model="companyContact" required />
                            <x-input-error :messages="$errors->get('companyContact')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- MSG91 Settings Section -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                        <span>MSG91 SMS Gateway Settings</span>
                    </div>
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" wire:model="registrationOtpEnabled" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20">
                        <span class="text-xs font-semibold text-slate-600 uppercase tracking-wide">Enable OTP</span>
                    </label>
                </h3>
                
                <div class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="msg91AuthKey" value="{{ __('MSG91 Auth Key') }}" />
                            <x-text-input id="msg91AuthKey" type="password" class="mt-1 block w-full" wire:model="msg91AuthKey" />
                            <x-input-error :messages="$errors->get('msg91AuthKey')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="msg91TemplateId" value="{{ __('MSG91 Template ID') }}" />
                            <x-text-input id="msg91TemplateId" type="text" class="mt-1 block w-full" wire:model="msg91TemplateId" />
                            <x-input-error :messages="$errors->get('msg91TemplateId')" class="mt-2" />
                        </div>
                    </div>
                    <p class="text-xs text-slate-400">Settings here are used to dispatch verification SMS messages during user registration when OTP validation is enabled.</p>
                </div>
            </div>

            <!-- Mailgun Settings Section -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <span>Mailgun Mailer Settings</span>
                </h3>
                
                <div class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="mailgunDomain" value="{{ __('Mailgun Domain') }}" />
                            <x-text-input id="mailgunDomain" type="text" class="mt-1 block w-full" wire:model="mailgunDomain" />
                            <x-input-error :messages="$errors->get('mailgunDomain')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="mailgunSecret" value="{{ __('Mailgun API Key (Secret)') }}" />
                            <x-text-input id="mailgunSecret" type="password" class="mt-1 block w-full" wire:model="mailgunSecret" />
                            <x-input-error :messages="$errors->get('mailgunSecret')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="mailgunEndpoint" value="{{ __('Mailgun API Endpoint') }}" />
                        <x-text-input id="mailgunEndpoint" type="text" class="mt-1 block w-full" wire:model="mailgunEndpoint" required />
                        <x-input-error :messages="$errors->get('mailgunEndpoint')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Maps Settings Section -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m-3-3h6m-1.028-9.433C12.628 2.382 12.29 2 11.858 2H5.142c-.43 0-.77.382-.667.807L5.5 7h13l1.025-4.193c.102-.425-.238-.807-.667-.807h-6.716zM5.5 7v10.25c0 .621.504 1.125 1.125 1.125H10m-4.5 0h9.75c.621 0 1.125-.504 1.125-1.125V7M9 21h6" />
                    </svg>
                    <span>Maps & Geolocation Settings</span>
                </h3>
                
                <div class="flex flex-col gap-4">
                    <div>
                        <x-input-label for="mapProvider" value="{{ __('Map Platform Provider') }}" />
                        <select id="mapProvider" wire:model.live="mapProvider" class="mt-1 block w-full border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                            <option value="leaflet">{{ __('Leaflet (OpenStreetMap)') }}</option>
                            <option value="mapbox">{{ __('Mapbox') }}</option>
                            <option value="google_maps">{{ __('Google Maps') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('mapProvider')" class="mt-2" />
                    </div>

                    @if ($mapProvider === 'google_maps')
                        <div class="p-3.5 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-amber-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <span class="font-bold">{{ __('Google Maps Required') }}:</span>
                                <span>{{ __('An API Key is required to load maps using the Google Maps platform.') }}</span>
                            </div>
                        </div>
                    @elseif ($mapProvider === 'mapbox')
                        <div class="p-3.5 bg-sky-50 border border-sky-200 text-sky-800 rounded-xl text-xs flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-sky-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <span class="font-bold">{{ __('Mapbox Access Token') }}:</span>
                                <span>{{ __('A valid Mapbox Access Token is required to render Mapbox styles. Customize the tile template below to target your custom style.') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="googleMapsApiKey" value="{{ __('Google Maps API Key') }}" />
                            <x-text-input id="googleMapsApiKey" type="password" class="mt-1 block w-full" wire:model="googleMapsApiKey" placeholder="AIzaSy..." />
                            <x-input-error :messages="$errors->get('googleMapsApiKey')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="mapboxAccessToken" value="{{ __('Mapbox Access Token') }}" />
                            <x-text-input id="mapboxAccessToken" type="password" class="mt-1 block w-full" wire:model="mapboxAccessToken" placeholder="pk.eyJ1..." />
                            <x-input-error :messages="$errors->get('mapboxAccessToken')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="mapTileUrl" value="{{ __('Map Tile Provider URL Template') }}" />
                        <x-text-input id="mapTileUrl" type="text" class="mt-1 block w-full font-mono text-xs" wire:model="mapTileUrl" required />
                        <x-input-error :messages="$errors->get('mapTileUrl')" class="mt-2" />
                        <p class="text-[10px] text-slate-400 mt-1">Default Leaflet tile template. E.g. <code>https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png</code></p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="mapDefaultLat" value="{{ __('Default Center Latitude') }}" />
                            <x-text-input id="mapDefaultLat" type="text" class="mt-1 block w-full" wire:model="mapDefaultLat" required />
                            <x-input-error :messages="$errors->get('mapDefaultLat')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="mapDefaultLng" value="{{ __('Default Center Longitude') }}" />
                            <x-text-input id="mapDefaultLng" type="text" class="mt-1 block w-full" wire:model="mapDefaultLng" required />
                            <x-input-error :messages="$errors->get('mapDefaultLng')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="mapDefaultZoom" value="{{ __('Default Zoom Level (1-20)') }}" />
                            <x-text-input id="mapDefaultZoom" type="number" min="1" max="20" class="mt-1 block w-full" wire:model="mapDefaultZoom" required />
                            <x-input-error :messages="$errors->get('mapDefaultZoom')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Save System Settings') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
