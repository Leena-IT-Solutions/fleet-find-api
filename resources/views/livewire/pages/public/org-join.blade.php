<?php

use App\Models\Organization;
use Livewire\Volt\Component;

new class extends Component
{
    public Organization $organization;

    public function mount($organization): void
    {
        $this->organization = $organization;
    }

    public function rendering($view)
    {
        $view->layout('layouts.guest');
    }
}; ?>

<div class="flex flex-col gap-6 text-center">
    <!-- Org Info -->
    <div class="flex flex-col items-center gap-3">
        <div class="w-20 h-20 border border-slate-100 rounded-2xl flex items-center justify-center bg-slate-50 overflow-hidden shadow-inner">
            @if ($organization->logo)
                <img src="{{ asset('storage/' . $organization->logo) }}" class="w-full h-full object-cover">
            @else
                <svg class="w-10 h-10 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            @endif
        </div>

        <div class="flex flex-col">
            <h2 class="text-lg font-bold text-slate-800">{{ $organization->name }}</h2>
            <span class="text-xs text-slate-400">Invited you to join their transit network</span>
        </div>
    </div>

    <!-- Deep Link Redirect Notice -->
    <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-4 flex flex-col gap-2 items-center">
        <div class="flex items-center gap-2">
            <!-- Loading Spinner -->
            <svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-xs font-bold text-indigo-700">Opening FleetFind mobile app...</span>
        </div>
        <p class="text-[10px] text-indigo-600 leading-normal max-w-[280px]">
            If the app is installed, it should launch automatically. If it doesn't open, choose an option below to proceed.
        </p>
    </div>

    <!-- Store Buttons -->
    <div class="flex flex-col gap-3">
        <a href="#" class="flex items-center justify-center gap-3 px-5 py-3 bg-slate-900 hover:bg-slate-850 text-white rounded-xl font-medium transition shadow-md focus:outline-none">
            <!-- Apple Logo SVG -->
            <svg class="w-5 h-5 flex-shrink-0 text-white" fill="#ffffff" viewBox="0 0 24 24">
                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.06-1 .04-2.21.67-2.93 1.49-.62.69-1.16 1.84-1.01 2.96 1.12.09 2.27-.57 2.95-1.39z"/>
            </svg>
            <div class="text-left leading-none">
                <span class="text-[9px] uppercase tracking-wider opacity-60 block">Download on the</span>
                <span class="text-sm font-semibold block mt-0.5">App Store</span>
            </div>
        </a>

        <a href="#" class="flex items-center justify-center gap-3 px-5 py-3 bg-slate-900 hover:bg-slate-850 text-white rounded-xl font-medium transition shadow-md focus:outline-none">
            <!-- Google Play Logo SVG -->
            <svg class="w-5 h-5 flex-shrink-0 text-white" fill="#ffffff" viewBox="0 0 24 24">
                <path d="M5.23 3.001c-.13 0-.25.03-.35.08l10.87 10.87 2.53-2.53L5.61 3.121c-.11-.07-.25-.12-.38-.12zm-1.01.62c-.08.19-.13.43-.13.69v15.38c0 .26.05.5.13.69l8.47-8.47L4.22 3.621zm9.88 7.37L16.63 12.5l-2.53-2.51-1.02.99 1.02.99zM5.61 20.881l12.67-8.31-2.53-2.53L4.88 20.921c.1.05.22.08.35.08.13 0 .27-.04.38-.12zm13.11-8.59l2.76-1.58c.45-.26.45-.69 0-.95l-2.76-1.58-1.58 2.53 1.58 1.58z"/>
            </svg>
            <div class="text-left leading-none">
                <span class="text-[9px] uppercase tracking-wider opacity-60 block">Get it on</span>
                <span class="text-sm font-semibold block mt-0.5">Google Play</span>
            </div>
        </a>
    </div>

    <!-- Manual Steps Instruction -->
    <div class="border-t border-slate-100 pt-6 flex flex-col gap-4 text-left">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">How to join:</h3>
        <ol class="flex flex-col gap-3">
            <li class="flex gap-3 items-start">
                <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
                <div class="text-xs text-slate-600">
                    <strong>Install FleetFind</strong> app on your device using the links above.
                </div>
            </li>
            <li class="flex gap-3 items-start">
                <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                <div class="text-xs text-slate-600">
                    <strong>Register as a Parent</strong> within the mobile app.
                </div>
            </li>
            <li class="flex gap-3 items-start">
                <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center shrink-0">3</span>
                <div class="text-xs text-slate-600">
                    You'll be automatically routed and synced with <strong>{{ $organization->name }}</strong>.
                </div>
            </li>
        </ol>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var orgId = @json($organization->id);
        var deepLinkUrl = "fleetfind://org/" + orgId;
        window.location.href = deepLinkUrl;
    });
</script>
