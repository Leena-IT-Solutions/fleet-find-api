<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Validation\Rule;

new class extends Component
{
    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public string $name = '';
    public string $email = '';
    public string $mobile = '';

    public function mount()
    {
        if (!auth()->user()->hasRole('Organization')) {
            abort(403, 'Unauthorized access.');
        }

        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->mobile ?? '';
    }

    public function updateProfile(): void
    {
        $user = auth()->user();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'mobile' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile ?: null,
        ]);

        session()->flash('success', 'Organization details updated successfully.');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Organization Details') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6">
        @if (session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-sm flex items-center gap-2 max-w-xl">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6 max-w-xl">
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                </svg>
                <span>Organization Profile Information</span>
            </h3>

            <form wire:submit.prevent="updateProfile" class="flex flex-col gap-4">
                <div>
                    <x-input-label for="name" value="{{ __('Organization Name') }}" />
                    <x-text-input id="name" type="text" class="mt-1 block w-full" wire:model="name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="{{ __('Email Address') }}" />
                    <x-text-input id="email" type="email" class="mt-1 block w-full" wire:model="email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="mobile" value="{{ __('Contact Number') }}" />
                    <x-text-input id="mobile" type="text" class="mt-1 block w-full" wire:model="mobile" />
                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-2">
                    <x-primary-button>
                        {{ __('Save Details') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
