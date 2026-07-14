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
                'liveTrackingCount' => 0,
                'gradesCount' => 0,
                'divisionsCount' => 0,
                'enrolledChildrenCount' => 0,
                'plansCount' => 0,
                'activeSubscriptionsCount' => 0,
                'inactiveSubscriptionsCount' => 0,
            ];
        }

        $routesQuery = $this->organization->routes();
        $routesIds = (clone $routesQuery)->pluck('id');
        $gradesIds = $this->organization->grades()->pluck('id');

        return [
            'vehiclesCount' => $this->organization->vehicles()->count(),
            'driversCount' => $this->organization->drivers()->count(),
            'attendantsCount' => $this->organization->attendants()->count(),
            'routesCount' => $routesQuery->count(),
            'tripsCount' => $this->organization->trips()->count(),
            'stopsCount' => Stop::whereIn('route_id', $routesIds)->count(),
            'liveTrackingCount' => \App\Models\TripRouteLogistics::whereIn('route_id', $routesIds)->where('is_tracking', true)->count(),
            'gradesCount' => $gradesIds->count(),
            'divisionsCount' => \App\Models\Division::whereIn('grade_id', $gradesIds)->count(),
            'enrolledChildrenCount' => \App\Models\ChildSubscription::whereIn('route_id', $routesIds)->count(),
            'plansCount' => $this->organization->subscriptionPlans()->count(),
            'activeSubscriptionsCount' => \App\Models\ChildSubscription::whereIn('route_id', $routesIds)->where('status', 'active')->count(),
            'inactiveSubscriptionsCount' => \App\Models\ChildSubscription::whereIn('route_id', $routesIds)->where('status', '!=', 'active')->count(),
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
            <!-- Category 1: Institutional Fleet & Personnel -->
            <div class="mt-4">
                <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Fleet & Personnel
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Vehicles Card -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 16c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2V9c0-2 1.5-3.5 3.5-3.5h7C17.5 5.5 19 7 19 9v7zM6 9h12M9 13.5h.01M15 13.5h.01M7.5 16h9" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Fleet</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Vehicles / Buses</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $vehiclesCount }}</h3>
                        </div>
                    </div>

                    <!-- Drivers Card -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
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
                </div>
            </div>

            <!-- Category 2: Transit & Live Logistics -->
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7"></path></svg>
                    Transit & Live Logistics
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Transit Routes -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-rose-600 bg-rose-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Routes</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Transit Routes</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $routesCount }}</h3>
                        </div>
                    </div>

                    <!-- Stops -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-teal-50 text-teal-600 rounded-xl group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-teal-600 bg-teal-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Stops</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Map Stops</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $stopsCount }}</h3>
                        </div>
                    </div>

                    <!-- Scheduled Trips -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-sky-50 text-sky-600 rounded-xl group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
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

                    <!-- Live Active Trips -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                <span class="relative flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                </span>
                            </div>
                            <span class="text-[10px] font-bold text-rose-600 bg-rose-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Live</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Active Live Tracking</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $liveTrackingCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category 3: Academic Setup & Enrollments -->
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Academic Setup & Enrollments
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Grades -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-sky-50 text-sky-600 rounded-xl group-hover:bg-sky-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-sky-600 bg-sky-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Grades</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Grades</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $gradesCount }}</h3>
                        </div>
                    </div>

                    <!-- Divisions -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-violet-50 text-violet-600 rounded-xl group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-violet-600 bg-violet-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Divisions</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Divisions</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $divisionsCount }}</h3>
                        </div>
                    </div>

                    <!-- Enrolled Children -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group flex justify-between items-center">
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Enrolled Children</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $enrolledChildrenCount }}</h3>
                        </div>
                        <span class="p-3 rounded-xl bg-teal-50 text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-3.33 0-10 1.67-10 5v2h20v-2c0-3.33-6.67-5-10-5z"></path></svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Category 4: Monetization & Subscription Plans -->
            <div class="mt-6">
                <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Monetization & Subscriptions
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Plans -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-amber-600 bg-amber-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Plans</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Active Custom Plans</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $plansCount }}</h3>
                        </div>
                    </div>

                    <!-- Active Subscriptions -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Paid</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Active Paid Pupils</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $activeSubscriptionsCount }}</h3>
                        </div>
                    </div>

                    <!-- Inactive Subscriptions -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span>
                            </div>
                            <span class="text-[10px] font-bold text-rose-600 bg-rose-50/50 px-2 py-0.5 rounded-full uppercase tracking-wider">Unpaid / Expired</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Inactive / Unpaid</span>
                            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $inactiveSubscriptionsCount }}</h3>
                        </div>
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
