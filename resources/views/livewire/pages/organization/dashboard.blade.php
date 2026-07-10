<?php

use Livewire\Volt\Component;

new class extends Component
{
    public function rendering($view)
    {
        $view->layout('layouts.guest', ['plain' => true]);
    }

    public function mount()
    {
        if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Organization')) {
            return redirect()->route('dashboard');
        }
    }

    public function createOrganizationAccount(): void
    {
        $user = auth()->user();
        $user->assignRole('Organization');

        session()->flash('success', 'Organization account created successfully. Welcome aboard!');
        
        $this->redirectRoute('dashboard');
    }

    public function logout(): void
    {
        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/');
    }
}; ?>

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
