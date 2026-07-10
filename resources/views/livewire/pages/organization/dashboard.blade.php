<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\Stop;

new class extends Component
{
    public ?Organization $organization = null;

    public function rendering($view)
    {
        if (auth()->user()->hasRole('Organization')) {
            $view->layout('layouts.app');
        } else {
            $view->layout('layouts.guest', ['plain' => true]);
        }
    }

    public function mount()
    {
        if (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Organization')) {
            return redirect()->route('dashboard');
        }

        $this->loadOrganization();
    }

    private function loadOrganization(): void
    {
        if (!auth()->user()) {
            return;
        }

        $activeOrgId = session('active_organization_id');
        if ($activeOrgId) {
            $this->organization = Organization::find($activeOrgId);
        }

        if (!$this->organization) {
            $firstOrg = auth()->user()->organizations()->first();
            if ($firstOrg) {
                $this->organization = $firstOrg;
                session(['active_organization_id' => $firstOrg->id]);
            }
        }
    }

    public function createOrganizationAccount(): void
    {
        $user = auth()->user();
        $user->assignRole('Organization');

        session()->flash('success', 'Organization account created successfully. Welcome aboard!');
        
        $this->redirectRoute('organization.dashboard');
    }

    public function logout(): void
    {
        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/');
    }

    public function with()
    {
        if (!$this->organization) {
            return [
                'vehiclesCount' => 0,
                'driversCount' => 0,
                'attendantsCount' => 0,
                'routesCount' => 0,
                'tripsCount' => 0,
                'stopsCount' => 0,
            ];
        }

        $routesQuery = $this->organization->routes();
        $routesIds = (clone $routesQuery)->pluck('id');

        return [
            'vehiclesCount' => $this->organization->vehicles()->count(),
            'driversCount' => $this->organization->drivers()->count(),
            'attendantsCount' => $this->organization->attendants()->count(),
            'routesCount' => $routesQuery->count(),
            'tripsCount' => $this->organization->trips()->count(),
            'stopsCount' => Stop::whereIn('route_id', $routesIds)->count(),
        ];
    }
}; ?>

<div>
    @if (auth()->user()->hasRole('Organization'))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-slate-900 leading-tight">
                {{ __('Organization Dashboard') }}
            </h2>
        </x-slot>

        <div class="flex flex-col gap-6">
            @if (session()->has('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-sm flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Organization Fleet Panel</h3>
                <p class="text-slate-600 text-sm">Manage your institution's fleet, map custom routes, and assign drivers/attendants to vehicles.</p>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                <!-- Vehicles Card -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <!-- Vehicle Icon (Bus) -->
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 16c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2V9c0-2 1.5-3.5 3.5-3.5h7C17.5 5.5 19 7 19 9v7zM6 9h12M9 13.5h.01M15 13.5h.01M7.5 16h9" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Fleet</span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Vehicles</span>
                        <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $vehiclesCount }}</h3>
                    </div>
                </div>

                <!-- Drivers Card -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                            <!-- Driver Icon (User Card) -->
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Pilots</span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Drivers</span>
                        <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $driversCount }}</h3>
                    </div>
                </div>

                <!-- Attendants Card -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                            <!-- Attendant Icon (Users) -->
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Helpers</span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Attendants</span>
                        <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $attendantsCount }}</h3>
                    </div>
                </div>

                <!-- Routes Card -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                            <!-- Route Icon (Map/Pin) -->
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-rose-600 bg-rose-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $stopsCount }} Stops</span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Transit Routes</span>
                        <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $routesCount }}</h3>
                    </div>
                </div>

                <!-- Trips Card -->
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-sky-50 text-sky-600 rounded-xl group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                            <!-- Trips Icon (Clock/Calendar) -->
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-sky-600 bg-sky-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Shifts</span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Scheduled Trips</span>
                        <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $tripsCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-slate-50">
            <!-- Card Container -->
            <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200/80 shadow-xl p-8 flex flex-col items-center text-center">
                <!-- App Logo -->
                <div class="mb-6 flex justify-center">
                    <x-application-logo class="w-14 h-14 logo-spin" />
                </div>

                <!-- Welcome Title -->
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-2">
                    Setup Organization
                </h2>
                
                <p class="text-sm text-slate-500 mb-6 max-w-xs">
                    You are currently logged in as a Parent. Do you want to create an organization account to manage fleets and routes?
                </p>

                <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-4 mb-6 text-left w-full">
                    <h4 class="text-xs font-bold text-indigo-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Organization Perks</span>
                    </h4>
                    <ul class="text-xs text-slate-600 space-y-1 list-disc pl-4">
                        <li>Manage vehicles, drivers, and attendants</li>
                        <li>Add and coordinate children routing</li>
                        <li>Real-time fleet tracking and alerts</li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3 w-full">
                    <button wire:click="createOrganizationAccount" 
                            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-sm transition duration-150 focus:outline-none">
                        Yes, Create Organization Account
                    </button>
                    
                    <button wire:click="logout" 
                            class="w-full py-3 px-4 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 hover:text-slate-900 rounded-xl text-sm font-semibold transition duration-150 focus:outline-none">
                        Log Out
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
