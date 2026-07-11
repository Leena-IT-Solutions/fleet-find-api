<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public $activeOrgId;

    public function mount(): void
    {
        $user = auth()->user();
        if ($user) {
            $userOrgs = $user->organizations;
            $this->activeOrgId = session('active_organization_id');
            if (!$this->activeOrgId && $userOrgs->isNotEmpty()) {
                $this->activeOrgId = $userOrgs->first()->id;
                session(['active_organization_id' => $this->activeOrgId]);
            }
        }
    }

    public function selectOrganization($orgId): void
    {
        $user = auth()->user();
        if ($user) {
            $exists = $user->organizations()->where('organizations.id', $orgId)->exists();
            if ($exists) {
                session(['active_organization_id' => $orgId]);
                $this->activeOrgId = $orgId;
                
                $this->dispatch('active-organization-changed', $orgId);
                
                $fallbackRoute = $user->hasRole('Admin') ? route('administrator') : route('organization.dashboard');
                $this->redirect(request()->header('Referer') ?: $fallbackRoute, navigate: true);
            }
        }
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div x-data="{ open: false }" class="shrink-0">
    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex flex-col justify-between w-64 h-screen sticky top-0 bg-white border-r border-slate-200 p-5 z-20">
        <!-- Top Section -->
        <div class="flex flex-col gap-6">
            <!-- Brand -->
            <div class="flex items-center gap-3 px-2">
                <x-application-logo class="h-9 w-auto logo-spin" />
                <span class="text-xl font-bold tracking-tight text-slate-900">FleetFind</span>
            </div>

            <!-- Organization Selector -->
            @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Organization'))
                @php
                    $orgsToShow = auth()->user()->organizations;
                @endphp
                @if ($orgsToShow->isNotEmpty())
                    <div class="px-2 mb-2">
                        <label for="org-select-desktop" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Active Organization</label>
                        <select id="org-select-desktop" 
                                wire:change="selectOrganization($event.target.value)" 
                                class="block w-full border border-slate-200 rounded-lg text-xs bg-slate-50/50 text-slate-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 shadow-sm cursor-pointer font-medium">
                            @foreach($orgsToShow as $org)
                                <option value="{{ $org->id }}" {{ $org->id == $activeOrgId ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endif

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5">
                <!-- Admin Block -->
                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('administrator') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('administrator') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('administrator') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Administrator</span>
                    </a>

                    <a href="{{ route('users.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('users.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('users.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.03c-2.115 0-4.07-.58-5.75-1.595a4.125 4.125 0 00-5.74 3.447h16.5m-3.92-14.77a3 3 0 11-6 0 3 3 0 016 0zm-7.42 8.25a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>User Manager</span>
                    </a>

                    <a href="{{ route('settings.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('settings.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('settings.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>System Settings</span>
                    </a>

                    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
                    </a>
                @endif

                <!-- Divider -->
                @if (auth()->user()->hasRole('Admin') && auth()->user()->hasRole('Organization'))
                    <div class="my-2 border-t border-slate-200/80"></div>
                @endif

                <!-- Organization Block -->
                @if (auth()->user()->hasRole('Organization'))
                    <a href="{{ route('organization.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.dashboard') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('organization.profile-settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.profile-settings') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.profile-settings') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
                    </a>

                    <div class="mt-5 mb-1.5 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Administration
                    </div>

                    <a href="{{ route('organization.organizations') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.organizations') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.organizations') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h16.5M5.25 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 16.5h1.5M13.5 16.5H15" />
                        </svg>
                        <span>Organizations</span>
                    </a>

                    <a href="{{ route('organization.entity-info') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.entity-info') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.entity-info') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Entity Info</span>
                    </a>

                    <a href="{{ route('organization.access-control') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.access-control') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.access-control') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12a3 3 0 100-6 3 3 0 000 6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 114 0 2 2 0 01-4 0zM15 12a5 5 0 00-5.16-4.91 5 5 0 00-4.68 4.91c0 2.21 1.79 4 4 4h1.7a3.001 3.001 0 013.14-4zM22 18v-1.5c0-1.63-1.07-2.95-2.5-3.37m0 0a3.001 3.001 0 00-4.5-2.5" />
                        </svg>
                        <span>Access Control</span>
                    </a>

                    <div class="mt-5 mb-1.5 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Operations
                    </div>

                    <a href="{{ route('organization.crew') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.crew') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.crew') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m0 0L6 18.72a9.094 9.094 0 01-3.741-.479 3 3 0 014.682-2.72m.94 3.198l-.001.031c0 .225.012.447.037.666A11.944 11.944 0 0012 21c2.17 0 4.207-.576 5.963-1.584A6.062 6.062 0 0018 18.72M12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                        </svg>
                        <span>Crew & Roster</span>
                    </a>

                    <a href="{{ route('organization.vehicles') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.vehicles') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.vehicles') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25M3 14.25h6.25a2.625 2.625 0 0 0 5.25 0h3M3 14.25V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v3.75m-18 0h18" />
                        </svg>
                        <span>Vehicles</span>
                    </a>

                    <a href="{{ route('organization.routes') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.routes') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.routes') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7" />
                        </svg>
                        <span>Routes</span>
                    </a>

                    <a href="{{ route('organization.trips') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.trips') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.trips') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Trips</span>
                    </a>

                    <a href="{{ route('organization.subscription-plans') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.subscription-plans') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.subscription-plans') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                        <span>Subscription Plans</span>
                    </a>
                @endif
            </nav>
        </div>

        <!-- Bottom Section -->
        <div class="flex flex-col gap-4 border-t border-slate-100 pt-4">
            <!-- User Info -->
            <div class="px-2">
                <div class="font-semibold text-sm text-slate-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</div>
            </div>

            <!-- Logout Button -->
            <button wire:click="logout" class="flex items-center gap-3 px-3 py-2.5 w-full text-left rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 transition duration-150 focus:outline-none">
                <svg class="w-5 h-5 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                <span>Log Out</span>
            </button>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="md:hidden flex items-center justify-between h-16 px-4 bg-white border-b border-slate-200 sticky top-0 z-20">
        <div class="flex items-center gap-3">
            <x-application-logo class="h-8 w-auto logo-spin" />
            <span class="text-lg font-bold tracking-tight text-slate-900">FleetFind</span>
        </div>

        <button @click="open = !open" class="p-2 rounded-lg text-slate-500 hover:bg-slate-50 focus:outline-none">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </header>

    <!-- Mobile Drawer Sidebar overlay -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false" class="md:hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30"></div>

    <!-- Mobile Drawer Sidebar container -->
    <aside x-show="open" 
           x-transition:enter="transition ease-out duration-200 transform" 
           x-transition:enter-start="-translate-x-full" 
           x-transition:enter-end="translate-x-0" 
           x-transition:leave="transition ease-in duration-150 transform" 
           x-transition:leave-start="translate-x-0" 
           x-transition:leave-end="-translate-x-full" 
           class="md:hidden fixed inset-y-0 left-0 w-64 bg-white p-5 flex flex-col justify-between z-40 shadow-2xl">
        
        <!-- Mobile Top Section -->
        <div class="flex flex-col gap-6">
            <!-- Brand & Close -->
            <div class="flex items-center justify-between px-2">
                <div class="flex items-center gap-3">
                    <x-application-logo class="h-8 w-auto logo-spin" />
                    <span class="text-lg font-bold tracking-tight text-slate-900">FleetFind</span>
                </div>
                <button @click="open = false" class="p-1 rounded-lg text-slate-400 hover:bg-slate-50">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Organization Selector Mobile -->
            @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Organization'))
                @php
                    $orgsToShow = auth()->user()->organizations;
                @endphp
                @if ($orgsToShow->isNotEmpty())
                    <div class="px-2 mb-2">
                        <label for="org-select-mobile" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Active Organization</label>
                        <select id="org-select-mobile" 
                                wire:change="selectOrganization($event.target.value)" 
                                class="block w-full border border-slate-200 rounded-lg text-xs bg-slate-50/50 text-slate-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 shadow-sm cursor-pointer font-medium">
                            @foreach($orgsToShow as $org)
                                <option value="{{ $org->id }}" {{ $org->id == $activeOrgId ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endif

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5">
                <!-- Admin Block -->
                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('administrator') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('administrator') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('administrator') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Administrator</span>
                    </a>

                    <a href="{{ route('users.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('users.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('users.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.03c-2.115 0-4.07-.58-5.75-1.595a4.125 4.125 0 00-5.74 3.447h16.5m-3.92-14.77a3 3 0 11-6 0 3 3 0 016 0zm-7.42 8.25a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>User Manager</span>
                    </a>

                    <a href="{{ route('settings.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('settings.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('settings.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>System Settings</span>
                    </a>

                    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
                    </a>
                @endif

                <!-- Divider -->
                @if (auth()->user()->hasRole('Admin') && auth()->user()->hasRole('Organization'))
                    <div class="my-2 border-t border-slate-200/80"></div>
                @endif

                <!-- Organization Block -->
                @if (auth()->user()->hasRole('Organization'))
                    <a href="{{ route('organization.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.dashboard') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('organization.profile-settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.profile-settings') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.profile-settings') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
                    </a>

                    <div class="mt-5 mb-1.5 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Administration
                    </div>

                    <a href="{{ route('organization.organizations') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.organizations') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.organizations') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h16.5M5.25 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 16.5h1.5M13.5 16.5H15" />
                        </svg>
                        <span>Organizations</span>
                    </a>

                    <a href="{{ route('organization.entity-info') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.entity-info') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.entity-info') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Entity Info</span>
                    </a>

                    <a href="{{ route('organization.access-control') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.access-control') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.access-control') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12a3 3 0 100-6 3 3 0 000 6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 114 0 2 2 0 01-4 0zM15 12a5 5 0 00-5.16-4.91 5 5 0 00-4.68 4.91c0 2.21 1.79 4 4 4h1.7a3.001 3.001 0 013.14-4zM22 18v-1.5c0-1.63-1.07-2.95-2.5-3.37m0 0a3.001 3.001 0 00-4.5-2.5" />
                        </svg>
                        <span>Access Control</span>
                    </a>

                    <div class="mt-5 mb-1.5 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        Operations
                    </div>

                    <a href="{{ route('organization.crew') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.crew') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.crew') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m0 0L6 18.72a9.094 9.094 0 01-3.741-.479 3 3 0 014.682-2.72m.94 3.198l-.001.031c0 .225.012.447.037.666A11.944 11.944 0 0012 21c2.17 0 4.207-.576 5.963-1.584A6.062 6.062 0 0018 18.72M12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                        </svg>
                        <span>Crew & Roster</span>
                    </a>

                    <a href="{{ route('organization.vehicles') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.vehicles') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.vehicles') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25M3 14.25h6.25a2.625 2.625 0 0 0 5.25 0h3M3 14.25V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v3.75m-18 0h18" />
                        </svg>
                        <span>Vehicles</span>
                    </a>

                    <a href="{{ route('organization.routes') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.routes') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.routes') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7" />
                        </svg>
                        <span>Routes</span>
                    </a>

                    <a href="{{ route('organization.trips') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.trips') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.trips') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Trips</span>
                    </a>

                    <a href="{{ route('organization.subscription-plans') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.subscription-plans') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.subscription-plans') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                        <span>Subscription Plans</span>
                    </a>
                @endif
            </nav>
        </div>

        <!-- Mobile Bottom Section -->
        <div class="flex flex-col gap-4 border-t border-slate-100 pt-4">
            <!-- User Info -->
            <div class="px-2">
                <div class="font-semibold text-sm text-slate-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</div>
            </div>

            <!-- Logout Button -->
            <button wire:click="logout" class="flex items-center gap-3 px-3 py-2.5 w-full text-left rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 transition duration-150 focus:outline-none">
                <svg class="w-5 h-5 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                <span>Log Out</span>
            </button>
        </div>
    </aside>
</div>
