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
