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
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Welcome to the Admin Portal</h3>
                <p class="text-slate-600 text-sm">As an Administrator, you have full control over system configurations, role management, and global statistics.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Registered Users</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">1,248</div>
                    </div>
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Active Organizations</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">42</div>
                    </div>
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">System Operations</div>
                        <div class="text-2xl font-bold text-green-600 mt-1">Healthy</div>
                    </div>
                </div>
            </div>
        @elseif (auth()->user()->hasRole('Organization'))
            <!-- Organization Dashboard Page Content -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-2">Organization Fleet Panel</h3>
                <p class="text-slate-600 text-sm">Manage your institution's fleet, map custom routes, and assign drivers/attendants to vehicles.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Active Vehicles</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">18</div>
                    </div>
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Assigned Drivers</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">15</div>
                    </div>
                    <div class="border border-slate-100 rounded-lg p-4 bg-slate-50">
                        <div class="text-xs font-medium text-slate-400 uppercase tracking-wider">Assigned Attendants</div>
                        <div class="text-2xl font-bold text-slate-900 mt-1">12</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
