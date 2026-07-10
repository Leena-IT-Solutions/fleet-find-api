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
                <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-indigo-600 to-cyan-600 bg-clip-text text-transparent">FleetFind</span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Profile</span>
                </a>
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
            <span class="text-lg font-bold tracking-tight bg-gradient-to-r from-indigo-600 to-cyan-600 bg-clip-text text-transparent">FleetFind</span>
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
                    <span class="text-lg font-bold tracking-tight bg-gradient-to-r from-indigo-600 to-cyan-600 bg-clip-text text-transparent">FleetFind</span>
                </div>
                <button @click="open = false" class="p-1 rounded-lg text-slate-400 hover:bg-slate-50">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition duration-150 {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-indigo-500' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Profile</span>
                </a>
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
