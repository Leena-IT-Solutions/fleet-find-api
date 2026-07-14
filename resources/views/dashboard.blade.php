<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            @if (auth()->user()->hasRole('Admin'))
                {{ __('Administrator') }}
            @elseif (auth()->user()->hasRole('Organization'))
                {{ __('Organization Dashboard') }}
            @else
                {{ __('Dashboard') }}
            @endif
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6">
        @if (auth()->user()->hasRole('Admin'))
            <!-- Admin Dashboard Page Content -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Welcome to the Administrator Portal</h3>
                <p class="text-slate-600 text-sm">As an Administrator, you have full control over system configurations, role management, and global statistics.</p>
                
                <!-- Category 1: User Accounts & Roles -->
                <div class="mt-8">
                    <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        User Accounts & Roles
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        <!-- Total Users -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Users</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalUsers }}</div>
                        </div>
                        <!-- Admins -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Admins</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalAdmins }}</div>
                        </div>
                        <!-- Organizations -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Organizations</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalOrgs }}</div>
                        </div>
                        <!-- Parents -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Parents</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalParents }}</div>
                        </div>
                        <!-- Drivers -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Drivers</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalDrivers }}</div>
                        </div>
                        <!-- Attendants -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Attendants</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalAttendants }}</div>
                        </div>
                    </div>
                </div>

                <!-- Category 2: Institutional Fleet & Logistics -->
                <div class="mt-8">
                    <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Institutional Fleet & Logistics
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Org Profiles -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Inst. Profiles</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalOrgProfiles }}</div>
                        </div>
                        <!-- Vehicles -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Vehicles/Buses</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalVehicles }}</div>
                        </div>
                        <!-- Routes -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Routes</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalRoutes }}</div>
                        </div>
                        <!-- Stops -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Map Stops</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalStops }}</div>
                        </div>
                        <!-- Trips -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Assigned Trips</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalTrips }}</div>
                        </div>
                    </div>
                </div>

                <!-- Category 3: Consumer & App-Wide Tracking -->
                <div class="mt-8">
                    <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Consumer & App-Wide Tracking
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Tracked Children -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors flex justify-between items-center">
                            <div>
                                <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Tracked Children</div>
                                <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalChildren }}</div>
                            </div>
                            <span class="p-2 rounded-lg bg-sky-50 text-sky-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-3.33 0-10 1.67-10 5v2h20v-2c0-3.33-6.67-5-10-5z"></path></svg>
                            </span>
                        </div>
                        <!-- Parent Location Groups -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors flex justify-between items-center">
                            <div>
                                <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Parent Sharing Groups</div>
                                <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalGroups }}</div>
                            </div>
                            <span class="p-2 rounded-lg bg-indigo-50 text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Category 4: Monetization & Subscriptions -->
                <div class="mt-8">
                    <h4 class="text-sm font-semibold text-slate-700 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Monetization & Subscriptions
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Plans -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                            <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Subscription Plans</div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalPlans }}</div>
                        </div>
                        <!-- Active Subscriptions -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-emerald-50/30 transition-colors">
                            <div class="text-xs font-medium text-emerald-600 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                Active Subscriptions
                            </div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $activeSubscriptions }}</div>
                        </div>
                        <!-- Inactive Subscriptions -->
                        <div class="border border-slate-100 rounded-lg p-4 bg-slate-50 hover:bg-rose-50/30 transition-colors">
                            <div class="text-xs font-medium text-rose-600 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500 inline-block"></span>
                                Expired / Inactive
                            </div>
                            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $inactiveSubscriptions }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Git Update Actions -->
            <livewire:pages.dashboard.git-updater />
        @elseif (auth()->user()->hasRole('Organization'))
            <!-- Organization Dashboard Page Content -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Organization Fleet Panel</h3>
                <p class="text-slate-600 text-sm">Manage your institution's fleet, map custom routes, and assign drivers/attendants to vehicles.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    <!-- Total Users -->
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Users</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalUsers }}</div>
                    </div>
                    <!-- Total Organizations -->
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Organizations</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalOrgs }}</div>
                    </div>
                    <!-- Total Drivers -->
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Drivers</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalDrivers }}</div>
                    </div>
                    <!-- Total Attendants -->
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Attendants</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalAttendants }}</div>
                    </div>
                    <!-- Total Parents -->
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Parents</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalParents }}</div>
                    </div>
                    <!-- Total Children -->
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Children</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalChildren }}</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- User Acquisition Widget -->
        <livewire:pages.dashboard.user-acquisition />
    </div>
</x-app-layout>
