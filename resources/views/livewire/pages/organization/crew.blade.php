<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\Driver;
use App\Models\Attendant;
use App\Models\User;

new class extends Component
{
    public ?Organization $organization = null;
    
    // Crew Form Fields
    public string $crewIdentity = '';
    public string $crewType = 'driver'; // driver or attendant

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public function mount()
    {
        $this->loadOrganization();
    }

    private function loadOrganization(): void
    {
        $activeOrgId = session('active_organization_id');
        if ($activeOrgId) {
            $this->organization = Organization::find($activeOrgId);
        }

        if (!$this->organization && auth()->user()) {
            $firstOrg = auth()->user()->organizations()->first();
            if ($firstOrg) {
                $this->organization = $firstOrg;
                session(['active_organization_id' => $firstOrg->id]);
            }
        }
    }

    public function hireCrew(): void
    {
        if (!$this->organization) {
            return;
        }

        $this->validate([
            'crewIdentity' => 'required|string',
            'crewType' => 'required|in:driver,attendant',
        ]);

        $user = User::where('email', $this->crewIdentity)
            ->orWhere('mobile', $this->crewIdentity)
            ->first();

        if (!$user) {
            $this->addError('crewIdentity', 'No user found with that email or mobile number.');
            return;
        }

        if ($this->crewType === 'driver') {
            $driver = Driver::firstOrCreate(
                ['user_id' => $user->id],
                ['name' => $user->name, 'email' => $user->email, 'number' => $user->mobile]
            );
            $user->assignRole('Driver');

            if ($driver->organization_id === $this->organization->id) {
                $this->addError('crewIdentity', 'This driver is already hired by this organization.');
                return;
            }

            $driver->update(['organization_id' => $this->organization->id]);
            $this->dispatch('show-toast', message: 'Driver hired successfully.', type: 'success');
        } else {
            $attendant = Attendant::firstOrCreate(
                ['user_id' => $user->id],
                ['name' => $user->name, 'email' => $user->email, 'number' => $user->mobile]
            );
            $user->assignRole('Attendant');

            if ($attendant->organization_id === $this->organization->id) {
                $this->addError('crewIdentity', 'This attendant is already hired by this organization.');
                return;
            }

            $attendant->update(['organization_id' => $this->organization->id]);
            $this->dispatch('show-toast', message: 'Attendant hired successfully.', type: 'success');
        }

        $this->reset(['crewIdentity']);
    }

    public function unhireCrew(string $type, int $id): void
    {
        if ($type === 'driver') {
            $driver = Driver::findOrFail($id);
            $driver->update(['organization_id' => null]);
            $this->dispatch('show-toast', message: 'Driver removed successfully.', type: 'warning');
        } else {
            $attendant = Attendant::findOrFail($id);
            $attendant->update(['organization_id' => null]);
            $this->dispatch('show-toast', message: 'Attendant removed successfully.', type: 'warning');
        }
    }

    public function with()
    {
        if (!$this->organization) {
            return [
                'drivers' => collect(),
                'attendants' => collect(),
            ];
        }

        return [
            'drivers' => $this->organization->drivers()->orderBy('name')->get(),
            'attendants' => $this->organization->attendants()->orderBy('name')->get(),
        ];
    }
}; ?>

<div class="space-y-6" x-data="{
    toasts: [],
    addToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }, 3000);
    }
}" @show-toast.window="addToast($event.detail.message, $event.detail.type || 'success')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Crew & Roster') }}
        </h2>
    </x-slot>

    <!-- Toast Notifications Container -->
    <div class="fixed top-5 right-5 z-50 space-y-2 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-300 transform translate-y-[-10px] opacity-0"
                 x-transition:enter-start="transform translate-y-[-10px] opacity-0"
                 x-transition:enter-end="transform translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200 transform translate-y-[-10px] opacity-0"
                 class="px-4 py-3 rounded-xl shadow-lg border text-xs font-semibold flex items-center gap-2 pointer-events-auto min-w-[200px]"
                 :class="{
                     'bg-emerald-50 border-emerald-100 text-emerald-800': toast.type === 'success',
                     'bg-amber-50 border-amber-100 text-amber-800': toast.type === 'warning',
                     'bg-rose-50 border-rose-100 text-rose-800': toast.type === 'error'
                 }">
                <template x-if="toast.type === 'success'">
                    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </template>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    @if (!$organization)
        <div class="bg-white border border-slate-200 p-8 rounded-2xl shadow-sm text-center">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="text-sm font-semibold text-slate-800">No Organization Selected</h3>
            <p class="text-xs text-slate-500 mt-1">Please configure or select an active organization profile first.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Hiring Roster Form Card -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                <h3 class="text-sm font-bold text-slate-855 mb-1">Add Crew Member</h3>
                <p class="text-xs text-slate-400 mb-4">Link a registered user to your organization as a Pilot/Driver or travel assistant.</p>

                <form wire:submit.prevent="hireCrew" class="space-y-4">
                    <div>
                        <x-input-label for="crewIdentity" :value="__('User Email or Mobile')" />
                        <x-text-input wire:model="crewIdentity" id="crewIdentity" type="text" class="mt-1 block w-full text-xs" placeholder="e.g. pilot@school.com" required />
                        <x-input-error :messages="$errors->get('crewIdentity')" class="mt-2" />
                    </div>

                    <div class="space-y-1.5">
                        <x-input-label :value="__('Select Crew Role')" />
                        <!-- Pill Selector Buttons -->
                        <div class="grid grid-cols-2 gap-2 bg-slate-100 p-1 rounded-xl border border-slate-200">
                            <button type="button" wire:click="$set('crewType', 'driver')" 
                                    class="py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 {{ $crewType === 'driver' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                                <span>🚗</span>
                                <span>Driver</span>
                            </button>
                            <button type="button" wire:click="$set('crewType', 'attendant')" 
                                    class="py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 {{ $crewType === 'attendant' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                                <span>👥</span>
                                <span>Attendant</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-primary-button class="w-full justify-center text-xs py-2.5 font-bold uppercase tracking-wider">
                            {{ __('Hire Crew Member') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Crew Members List Roster -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Crew Roster</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Hired Drivers and Attendants registered with your organization.</p>
                </div>

                <div class="space-y-6">
                    <!-- Drivers Section -->
                    <div class="space-y-3">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Drivers / Pilots</h4>
                        @if ($drivers->isEmpty())
                            <p class="text-slate-500 text-xs italic pl-0.5">No drivers hired yet.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($drivers as $driver)
                                    @php
                                        $initials = collect(explode(' ', $driver->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                    @endphp
                                    <div class="flex items-center justify-between gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs uppercase shadow-sm">
                                                {{ $initials }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-slate-800 truncate">{{ $driver->name }}</p>
                                                <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $driver->number }}</p>
                                            </div>
                                        </div>
                                        <button wire:click="unhireCrew('driver', {{ $driver->id }})" 
                                                wire:confirm="Are you sure you want to remove this driver from the organization?"
                                                type="button"
                                                class="p-1.5 text-slate-350 hover:text-rose-600 transition" 
                                                title="{{ __('Remove Driver') }}">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Attendants Section -->
                    <div class="space-y-3">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Attendants / Crew Assistants</h4>
                        @if ($attendants->isEmpty())
                            <p class="text-slate-500 text-xs italic pl-0.5">No attendants hired yet.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($attendants as $attendant)
                                    @php
                                        $initials = collect(explode(' ', $attendant->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                    @endphp
                                    <div class="flex items-center justify-between gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition bg-white shadow-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-700 font-bold text-xs uppercase shadow-sm">
                                                {{ $initials }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-slate-800 truncate">{{ $attendant->name }}</p>
                                                <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $attendant->number }}</p>
                                            </div>
                                        </div>
                                        <button wire:click="unhireCrew('attendant', {{ $attendant->id }})" 
                                                wire:confirm="Are you sure you want to remove this attendant from the organization?"
                                                type="button"
                                                class="p-1.5 text-slate-350 hover:text-rose-600 transition" 
                                                title="{{ __('Remove Attendant') }}">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
