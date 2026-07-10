<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            @if (auth()->user()->hasRole('Admin'))
                {{ __('Admin Dashboard') }}
            @elseif (auth()->user()->hasRole('Organization'))
                {{ __('Organization Dashboard') }}
            @else
                {{ __('Dashboard') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-6">
        @if (auth()->user()->hasRole('Admin'))
            <!-- Admin Dashboard Page Content -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-2">Welcome to the Admin Portal</h3>
                        <p class="text-slate-600 text-sm">As an Administrator, you have full control over system configurations, role management, and global statistics.</p>
                    </div>
                    @if (auth()->user()->hasRole('Organization'))
                        <div class="flex-shrink-0">
                            <a href="{{ route('organization.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-indigo-200 rounded-lg text-sm font-medium text-indigo-700 bg-indigo-50/50 hover:bg-indigo-50 hover:text-indigo-800 transition shadow-sm">
                                <svg class="w-4 h-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                <span>Go to Organization Portal</span>
                            </a>
                        </div>
                    @endif
                </div>
                
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
