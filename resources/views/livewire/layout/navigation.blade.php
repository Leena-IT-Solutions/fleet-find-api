<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
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

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5">
                <a href="{{ auth()->user()->hasRole('Admin') ? route('dashboard') : route('organization.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('dashboard') || request()->routeIs('organization.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') || request()->routeIs('organization.dashboard') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                @if (auth()->user()->hasRole('Organization'))
                    <a href="{{ route('organization.profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
                        <span>Organization</span>
                    </a>

                    <a href="{{ route('organization.profile-settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.profile-settings') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.profile-settings') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
                    </a>
                @endif

                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('users.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('users.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('users.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.03c-2.115 0-4.07-.58-5.75-1.595a4.125 4.125 0 00-5.74 3.447h16.5m-3.92-14.77a3 3 0 11-6 0 3 3 0 016 0zm-7.42 8.25a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>User Manager</span>
                    </a>
                @endif

                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('settings.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('settings.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('settings.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>System Settings</span>
                    </a>
                @endif



                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
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

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5">
                <a href="{{ auth()->user()->hasRole('Admin') ? route('dashboard') : route('organization.dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('dashboard') || request()->routeIs('organization.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') || request()->routeIs('organization.dashboard') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                @if (auth()->user()->hasRole('Organization'))
                    <a href="{{ route('organization.profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
                        <span>Organization</span>
                    </a>

                    <a href="{{ route('organization.profile-settings') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('organization.profile-settings') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('organization.profile-settings') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
                    </a>
                @endif

                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('users.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('users.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('users.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.03c-2.115 0-4.07-.58-5.75-1.595a4.125 4.125 0 00-5.74 3.447h16.5m-3.92-14.77a3 3 0 11-6 0 3 3 0 016 0zm-7.42 8.25a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>User Manager</span>
                    </a>
                @endif

                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('settings.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('settings.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('settings.index') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>System Settings</span>
                    </a>
                @endif



                @if (auth()->user()->hasRole('Admin'))
                    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Profile</span>
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
