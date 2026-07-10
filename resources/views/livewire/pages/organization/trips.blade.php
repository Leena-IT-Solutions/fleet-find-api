<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\Route;
use App\Models\Stop;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Attendant;
use App\Models\Trip;
use App\Models\TripStop;
use App\Models\TripRouteLogistics;
use App\Models\User;

new class extends Component
{
    public ?Organization $organization = null;
    
    // Active Tab (trips, crew)
    public string $activeTab = 'trips';
    
    // Trip Form Fields
    public string $tripName = '';
    public ?int $editingTripId = null;
    public bool $showTripModal = false;
    public bool $showDeleteTripModal = false;
    public ?int $deletingTripId = null;

    // Logistics & Timings State
    public array $logisticsData = [];
    public array $timingsData = [];

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
        $this->loadLogistics();
        $this->loadTimings();
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

    public function loadLogistics(): void
    {
        $this->logisticsData = [];
        if ($this->organization) {
            $trips = $this->organization->trips()->with('routeLogistics')->get();
            foreach ($trips as $trip) {
                foreach ($trip->routeLogistics as $l) {
                    $this->logisticsData["{$trip->id}_{$l->route_id}"] = [
                        'vehicle_id' => $l->vehicle_id ? (string)$l->vehicle_id : '',
                        'driver_id' => $l->driver_id ? (string)$l->driver_id : '',
                        'attendant_id' => $l->attendant_id ? (string)$l->attendant_id : '',
                    ];
                }
            }
        }
    }

    public function loadTimings(): void
    {
        $this->timingsData = [];
        if ($this->organization) {
            $trips = $this->organization->trips()->with('tripStops')->get();
            foreach ($trips as $trip) {
                foreach ($trip->tripStops as $ts) {
                    $this->timingsData["{$trip->id}_{$ts->stop_id}"] = [
                        'pickup_time' => $ts->pickup_time ? substr($ts->pickup_time, 0, 5) : '',
                        'drop_time' => $ts->drop_time ? substr($ts->drop_time, 0, 5) : '',
                    ];
                }
            }
        }
    }

    public function openAddTripModal(): void
    {
        $this->reset(['tripName', 'editingTripId']);
        $this->showTripModal = true;
        $this->dispatch('open-modal', 'trip-modal');
    }

    public function openEditTripModal(int $id): void
    {
        $trip = Trip::findOrFail($id);
        $this->editingTripId = $trip->id;
        $this->tripName = $trip->name;
        $this->showTripModal = true;
        $this->dispatch('open-modal', 'trip-modal');
    }

    public function closeTripModal(): void
    {
        $this->showTripModal = false;
        $this->dispatch('close-modal', 'trip-modal');
        $this->reset(['tripName', 'editingTripId']);
    }

    public function saveTrip(): void
    {
        if (!$this->organization) {
            return;
        }

        $this->validate([
            'tripName' => 'required|string|max:255',
        ]);

        if ($this->editingTripId) {
            $trip = Trip::findOrFail($this->editingTripId);
            $trip->update(['name' => $this->tripName]);
            session()->flash('success_trip', 'Trip updated successfully.');
        } else {
            $this->organization->trips()->create(['name' => $this->tripName]);
            session()->flash('success_trip', 'Trip created successfully.');
        }

        $this->closeTripModal();
        $this->loadLogistics();
        $this->loadTimings();
    }

    public function openDeleteTripModal(int $id): void
    {
        $this->deletingTripId = $id;
        $this->showDeleteTripModal = true;
        $this->dispatch('open-modal', 'delete-trip-modal');
    }

    public function closeDeleteTripModal(): void
    {
        $this->showDeleteTripModal = false;
        $this->dispatch('close-modal', 'delete-trip-modal');
    }

    public function deleteTrip(): void
    {
        $trip = Trip::findOrFail($this->deletingTripId);
        $trip->delete();
        $this->closeDeleteTripModal();
        session()->flash('success_trip', 'Trip cancelled successfully.');
        $this->loadLogistics();
        $this->loadTimings();
    }

    public function saveLogistics(int $tripId, int $routeId): void
    {
        $data = $this->logisticsData["{$tripId}_{$routeId}"] ?? [];

        TripRouteLogistics::updateOrCreate(
            ['trip_id' => $tripId, 'route_id' => $routeId],
            [
                'vehicle_id' => !empty($data['vehicle_id']) ? (int)$data['vehicle_id'] : null,
                'driver_id' => !empty($data['driver_id']) ? (int)$data['driver_id'] : null,
                'attendant_id' => !empty($data['attendant_id']) ? (int)$data['attendant_id'] : null,
            ]
        );

        session()->flash('success_logistics', 'Logistics saved successfully.');
    }

    public function saveRouteTimings(int $tripId, int $routeId): void
    {
        $route = Route::findOrFail($routeId);
        foreach ($route->stops as $stop) {
            $data = $this->timingsData["{$tripId}_{$stop->id}"] ?? [];
            TripStop::updateOrCreate(
                ['trip_id' => $tripId, 'stop_id' => $stop->id],
                [
                    'pickup_time' => !empty($data['pickup_time']) ? $data['pickup_time'] : null,
                    'drop_time' => !empty($data['drop_time']) ? $data['drop_time'] : null,
                ]
            );
        }

        session()->flash('success_timings', 'Timings saved successfully.');
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
            session()->flash('success_crew', 'Driver hired successfully.');
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
            session()->flash('success_crew', 'Attendant hired successfully.');
        }

        $this->reset(['crewIdentity']);
        $this->loadLogistics();
    }

    public function unhireCrew(string $type, int $id): void
    {
        if ($type === 'driver') {
            $driver = Driver::findOrFail($id);
            $driver->update(['organization_id' => null]);
            session()->flash('success_crew', 'Driver removed successfully.');
        } else {
            $attendant = Attendant::findOrFail($id);
            $attendant->update(['organization_id' => null]);
            session()->flash('success_crew', 'Attendant removed successfully.');
        }
        $this->loadLogistics();
    }

    public function with()
    {
        if (!$this->organization) {
            return [
                'trips' => collect(),
                'vehicles' => collect(),
                'drivers' => collect(),
                'attendants' => collect(),
                'routes' => collect(),
            ];
        }

        return [
            'trips' => $this->organization->trips()->latest()->get(),
            'vehicles' => $this->organization->vehicles()->orderBy('registration_number')->get(),
            'drivers' => $this->organization->drivers()->orderBy('name')->get(),
            'attendants' => $this->organization->attendants()->orderBy('name')->get(),
            'routes' => $this->organization->routes()->with('stops')->get(),
        ];
    }
}; ?>

<div class="space-y-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Journey Management (Trips & Crew)') }}
        </h2>
    </x-slot>

    @if (!$organization)
        <div class="bg-white border border-slate-200 p-8 rounded-2xl shadow-sm text-center">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="text-sm font-semibold text-slate-800">No Organization Selected</h3>
            <p class="text-xs text-slate-500 mt-1">Please configure or select an active organization profile first.</p>
        </div>
    @else
        <!-- Premium Tabs Controller -->
        <div class="flex items-center gap-1 bg-slate-200/50 p-1 rounded-xl self-start inline-flex border border-slate-200">
            <button wire:click="$set('activeTab', 'trips')" 
                    class="px-5 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all {{ $activeTab === 'trips' ? 'bg-white text-indigo-650 shadow-sm border border-slate-200/40' : 'text-slate-500 hover:text-slate-900' }}">
                {{ __('Scheduled Trips') }}
            </button>
            <button wire:click="$set('activeTab', 'crew')" 
                    class="px-5 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all {{ $activeTab === 'crew' ? 'bg-white text-indigo-650 shadow-sm border border-slate-200/40' : 'text-slate-500 hover:text-slate-900' }}">
                {{ __('Crew & Roster') }}
            </button>
        </div>

        @if ($activeTab === 'trips')
            <!-- TAB 1: SCHEDULED TRIPS -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Scheduled Trips</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Manage operational shifts, logistics crew deployments, and pickup/drop timing schedules.</p>
                    </div>
                    <button wire:click="openAddTripModal" 
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Initialize Trip</span>
                    </button>
                </div>

                @if (session()->has('success_trip'))
                    <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl p-4 text-xs flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        <span>{{ session('success_trip') }}</span>
                    </div>
                @endif

                @if ($trips->isEmpty())
                    <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center flex flex-col items-center justify-center">
                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        <p class="text-slate-850 font-bold text-sm">No Journey Logs</p>
                        <p class="text-slate-400 text-xs mt-1">Start by scheduling your first operational journey.</p>
                    </div>
                @else
                    <div class="space-y-4" x-data="{ openTripId: null }">
                        @foreach ($trips as $trip)
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-300">
                                <!-- Accordion Header -->
                                <div class="w-full px-6 py-4 flex items-center justify-between hover:bg-slate-50/50 cursor-pointer" @click="openTripId = openTripId === {{ $trip->id }} ? null : {{ $trip->id }}">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-855 uppercase tracking-wide">{{ $trip->name }}</h4>
                                            <span class="text-[10px] text-slate-400 tracking-wider uppercase font-semibold">Shift Configured</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3" @click.stop="">
                                        <button wire:click="openEditTripModal({{ $trip->id }})" class="p-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 rounded-md transition shadow-sm" title="Edit Trip">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                        </button>
                                        <button wire:click="openDeleteTripModal({{ $trip->id }})" class="p-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 rounded-md transition shadow-sm" title="Delete Trip">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                        <div class="w-px h-6 bg-slate-200 mx-1"></div>
                                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="openTripId === {{ $trip->id }} ? 'rotate-180 text-indigo-650' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>

                                <!-- Accordion Body -->
                                <div x-show="openTripId === {{ $trip->id }}" x-collapse class="border-t border-slate-100 p-6 bg-slate-50/20 space-y-8">
                                    @if ($routes->isEmpty())
                                        <div class="text-center py-6">
                                            <p class="text-slate-500 text-xs italic">No routes configured in your organization yet.</p>
                                        </div>
                                    @else
                                        <!-- Configured Routes loop -->
                                        @foreach ($routes as $route)
                                            <div class="space-y-6 p-6 bg-slate-50/50 rounded-2xl border border-slate-200/60 shadow-inner">
                                                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                                                    <div class="flex items-center gap-2">
                                                        <span class="px-2.5 py-1 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-lg text-[10px] font-bold uppercase tracking-wider">{{ $route->name }}</span>
                                                        <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Deployments</span>
                                                    </div>
                                                    <span class="text-[10px] text-slate-400 font-medium italic">{{ count($route->stops) }} Stops configured</span>
                                                </div>

                                                <!-- Logistics Manifest Grid -->
                                                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4">
                                                    <h5 class="text-[10px] font-bold text-slate-700 uppercase tracking-wider">Crew & Vehicle Manifest</h5>
                                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                                        <div class="space-y-1">
                                                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Route Vehicle</label>
                                                            <select wire:model="logisticsData.{{ $trip->id }}_{{ $route->id }}.vehicle_id" class="w-full bg-slate-50 border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer">
                                                                <option value="">No Vehicle Assigned</option>
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="space-y-1">
                                                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Route Pilot/Driver</label>
                                                            <select wire:model="logisticsData.{{ $trip->id }}_{{ $route->id }}.driver_id" class="w-full bg-slate-50 border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer">
                                                                <option value="">No Driver Assigned</option>
                                                                @foreach ($drivers as $driver)
                                                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="space-y-1">
                                                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Route Assistant</label>
                                                            <select wire:model="logisticsData.{{ $trip->id }}_{{ $route->id }}.attendant_id" class="w-full bg-slate-50 border-slate-200 rounded-lg px-3 py-1.5 text-xs text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer">
                                                                <option value="">No Attendant Assigned</option>
                                                                @foreach ($attendants as $attendant)
                                                                    <option value="{{ $attendant->id }}">{{ $attendant->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <button wire:click="saveLogistics({{ $trip->id }}, {{ $route->id }})" 
                                                                    class="w-full py-2 bg-indigo-650 hover:bg-indigo-700 text-white rounded-lg font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                                <span>Assign Crew</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @if (session()->has('success_logistics'))
                                                        <span class="text-[10px] text-emerald-600 font-semibold block mt-1">✓ {{ session('success_logistics') }}</span>
                                                    @endif
                                                </div>

                                                <!-- Timings Config -->
                                                @if ($route->stops->isEmpty())
                                                    <p class="text-slate-400 text-xs italic">No stops are added to this route yet.</p>
                                                @else
                                                    <div class="space-y-3">
                                                        <h5 class="text-[10px] font-bold text-slate-700 uppercase tracking-wider">Stop Schedule & Timings</h5>
                                                        <div class="divide-y divide-slate-200 border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                                                            @foreach ($route->stops as $stopIndex => $stop)
                                                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 hover:bg-slate-50/50 transition">
                                                                    <div class="flex items-center gap-3">
                                                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-700 shadow-sm">{{ $stopIndex + 1 }}</div>
                                                                        <div>
                                                                            <p class="text-xs font-bold text-slate-800">{{ $stop->name }}</p>
                                                                            <p class="text-[10px] text-slate-400 font-mono">{{ $stop->latitude }}, {{ $stop->longitude }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex items-center gap-2 self-end sm:self-auto">
                                                                        <div class="flex items-center gap-1">
                                                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Pickup</span>
                                                                            <input type="time" wire:model="timingsData.{{ $trip->id }}_{{ $stop->id }}.pickup_time" class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-xs text-indigo-650 font-bold focus:ring-4 focus:ring-indigo-500/10">
                                                                        </div>
                                                                        <div class="flex items-center gap-1">
                                                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Drop</span>
                                                                            <input type="time" wire:model="timingsData.{{ $trip->id }}_{{ $stop->id }}.drop_time" class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-xs text-amber-600 font-bold focus:ring-4 focus:ring-amber-500/10">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="flex justify-end">
                                                            <button wire:click="saveRouteTimings({{ $trip->id }}, {{ $route->id }})" 
                                                                    class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-1.5 shadow-md">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                                <span>Update Timing Manifest</span>
                                                            </button>
                                                        </div>
                                                        @if (session()->has('success_timings'))
                                                            <span class="text-[10px] text-emerald-600 font-semibold block text-right mt-1">✓ {{ session('success_timings') }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <!-- TAB 2: CREW & ROSTER -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Hiring Roster Form -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm h-fit">
                    <h3 class="text-sm font-bold text-slate-800 mb-1">Add Crew Member</h3>
                    <p class="text-xs text-slate-500 mb-4">Link a registered user to your organization as a Pilot/Driver or travel assistant.</p>

                    <form wire:submit.prevent="hireCrew" class="space-y-4">
                        <div>
                            <x-input-label for="crewIdentity" :value="__('User Email or Mobile')" />
                            <x-text-input wire:model="crewIdentity" id="crewIdentity" type="text" class="mt-1 block w-full text-xs" placeholder="e.g. pilot@school.com" required />
                            <x-input-error :messages="$errors->get('crewIdentity')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="crewType" :value="__('Select Crew Role')" />
                            <select wire:model="crewType" id="crewType" class="mt-1 block w-full bg-white border border-slate-300 text-slate-700 rounded-lg text-xs p-2.5 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="driver">{{ __('Driver (Pilot)') }}</option>
                                <option value="attendant">{{ __('Attendant (Crew Assistant)') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('crewType')" class="mt-2" />
                        </div>

                        <div class="flex justify-end pt-2">
                            <x-primary-button class="w-full justify-center">
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

                    @if (session()->has('success_crew'))
                        <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl p-4 text-xs flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                            <span>{{ session('success_crew') }}</span>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <!-- Drivers Section -->
                        <div class="space-y-2">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Drivers / Pilots</h4>
                            @if ($drivers->isEmpty())
                                <p class="text-slate-500 text-xs italic pl-0.5">No drivers hired yet.</p>
                            @else
                                <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                                    @foreach ($drivers as $driver)
                                        <div class="flex items-center justify-between gap-4 p-3 hover:bg-slate-50/50 transition">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-650 font-bold text-xs">D</div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-850">{{ $driver->name }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $driver->email }} | {{ $driver->number }}</p>
                                                </div>
                                            </div>
                                            <button wire:click="unhireCrew('driver', {{ $driver->id }})" 
                                                    type="button"
                                                    class="p-1 text-slate-400 hover:text-rose-600 transition" 
                                                    title="{{ __('Remove Driver') }}">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Attendants Section -->
                        <div class="space-y-2">
                            <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Attendants / Crew Assistants</h4>
                            @if ($attendants->isEmpty())
                                <p class="text-slate-500 text-xs italic pl-0.5">No attendants hired yet.</p>
                            @else
                                <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                                    @foreach ($attendants as $attendant)
                                        <div class="flex items-center justify-between gap-4 p-3 hover:bg-slate-50/50 transition">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-650 font-bold text-xs">A</div>
                                                <div>
                                                    <p class="text-xs font-bold text-slate-855">{{ $attendant->name }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $attendant->email }} | {{ $attendant->number }}</p>
                                                </div>
                                            </div>
                                            <button wire:click="unhireCrew('attendant', {{ $attendant->id }})" 
                                                    type="button"
                                                    class="p-1 text-slate-400 hover:text-rose-600 transition" 
                                                    title="{{ __('Remove Attendant') }}">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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

        <!-- ADD/EDIT TRIP MODAL -->
        <x-modal name="trip-modal" :show="$showTripModal" focusable>
            <form wire:submit.prevent="saveTrip" class="p-6">
                <h2 class="text-lg font-medium text-slate-900">
                    {{ $editingTripId ? __('Edit Scheduled Trip') : __('Initialize Global Trip') }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ __('Define the name/shift code for this journey schedule.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="tripName" :value="__('Trip Name / Shift Name')" />
                    <x-text-input wire:model="tripName" id="tripName" type="text" class="mt-1 block w-full" placeholder="e.g. Morning Shift, Route A1 Primary" required />
                    <x-input-error :messages="$errors->get('tripName')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="closeTripModal">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        {{ $editingTripId ? __('Save Changes') : __('Initialize Trip') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- DELETE TRIP MODAL -->
        <x-modal name="delete-trip-modal" :show="$showDeleteTripModal" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-slate-900">
                    {{ __('Cancel Operational Trip') }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ __('Are you sure you want to permanently cancel this scheduled trip? All timing specifications and crew logistics assignments will be deleted.') }}
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="closeDeleteTripModal">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <button wire:click="deleteTrip" 
                            class="ms-3 inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest active:bg-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Cancel Trip') }}
                    </button>
                </div>
            </div>
        </x-modal>
    @endif
</div>
