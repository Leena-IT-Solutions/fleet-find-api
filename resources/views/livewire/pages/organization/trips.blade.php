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
    
    // Master-Detail Selected Trip and Route IDs
    public ?int $selectedTripId = null;
    public ?int $selectedRouteId = null;
    
    // Trip Form Fields
    public string $tripName = '';
    public ?int $editingTripId = null;
    public bool $showTripModal = false;
    public bool $showDeleteTripModal = false;
    public ?int $deletingTripId = null;

    // Logistics & Timings State
    public array $logisticsData = [];
    public array $timingsData = [];
    public array $stopsOrder = [];

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public function mount()
    {
        $this->loadOrganization();
        $this->loadLogistics();
        $this->loadTimings();
        
        // Select the first trip by default if available
        if ($this->organization) {
            $firstTrip = $this->organization->trips()->latest()->first();
            if ($firstTrip) {
                $this->selectTrip($firstTrip->id);
            }
        }
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
        $this->stopsOrder = [];
        if ($this->organization) {
            $trips = $this->organization->trips()->with('routeLogistics')->get();
            foreach ($trips as $trip) {
                foreach ($trip->routeLogistics as $l) {
                    $this->logisticsData["{$trip->id}_{$l->route_id}"] = [
                        'vehicle_id' => $l->vehicle_id ? (string)$l->vehicle_id : '',
                        'driver_id' => $l->driver_id ? (string)$l->driver_id : '',
                        'attendant_id' => $l->attendant_id ? (string)$l->attendant_id : '',
                    ];
                    $this->stopsOrder["{$trip->id}_{$l->route_id}"] = $l->stops_order ?? 'asc';
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
                        'time' => $ts->time ? substr($ts->time, 0, 5) : '',
                    ];
                }
            }
        }
    }

    public function selectTrip(?int $tripId): void
    {
        $this->selectedTripId = $tripId;
        if ($tripId) {
            $trip = Trip::find($tripId);
            if ($trip && $this->organization) {
                $firstRoute = $this->organization->routes()->first();
                $this->selectedRouteId = $firstRoute ? $firstRoute->id : null;
            } else {
                $this->selectedRouteId = null;
            }
        } else {
            $this->selectedRouteId = null;
        }
    }

    public function selectRoute(?int $routeId): void
    {
        $this->selectedRouteId = $routeId;
    }

    public function getTripStatus(Trip $trip): string
    {
        $routes = $this->organization ? $this->organization->routes : collect();
        if ($routes->isEmpty()) {
            return 'draft';
        }

        $logistics = $trip->routeLogistics;
        $stops = $trip->tripStops;

        // Check if there are any assignments or timings
        $hasAnyLogistics = $logistics->contains(fn($l) => $l->vehicle_id || $l->driver_id || $l->attendant_id);
        $hasAnyTimings = $stops->contains(fn($s) => $s->time);

        if (!$hasAnyLogistics && !$hasAnyTimings) {
            return 'draft';
        }

        // Count expected total assignments
        $expectedLogisticsCount = $routes->count();
        $expectedStopsCount = Stop::whereIn('route_id', $routes->pluck('id'))->count();

        // Count actual complete assignments
        $completeLogisticsCount = $logistics->filter(fn($l) => $l->vehicle_id && $l->driver_id && $l->attendant_id)->count();
        $completeStopsCount = $stops->filter(fn($s) => $s->time)->count();

        if ($completeLogisticsCount === $expectedLogisticsCount && $completeStopsCount === $expectedStopsCount) {
            return 'ready';
        }

        return 'partial';
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
            $this->dispatch('show-toast', message: 'Trip updated successfully.', type: 'success');
        } else {
            $trip = $this->organization->trips()->create(['name' => $this->tripName]);
            $this->selectTrip($trip->id);
            $this->dispatch('show-toast', message: 'Trip created successfully.', type: 'success');
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
        
        $firstTrip = $this->organization->trips()->latest()->first();
        if ($firstTrip) {
            $this->selectTrip($firstTrip->id);
        } else {
            $this->selectTrip(null);
        }
        
        $this->dispatch('show-toast', message: 'Trip cancelled successfully.', type: 'warning');
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

        $this->dispatch('show-toast', message: 'Logistics saved successfully.', type: 'success');
    }

    public function saveRouteTimings(int $tripId, int $routeId): void
    {
        $route = Route::findOrFail($routeId);
        foreach ($route->stops as $stop) {
            $data = $this->timingsData["{$tripId}_{$stop->id}"] ?? [];
            TripStop::updateOrCreate(
                ['trip_id' => $tripId, 'stop_id' => $stop->id],
                [
                    'time' => !empty($data['time']) ? $data['time'] : null,
                ]
            );
        }

        $this->loadTimings();
        if ($this->organization) {
            $this->organization->refresh();
        }

        $this->dispatch('show-toast', message: 'Timings saved successfully.', type: 'success');
    }

    public function toggleStopsOrder(int $tripId, int $routeId): void
    {
        $key = "{$tripId}_{$routeId}";
        $current = $this->stopsOrder[$key] ?? 'asc';
        $newOrder = $current === 'asc' ? 'desc' : 'asc';
        
        $this->stopsOrder[$key] = $newOrder;

        TripRouteLogistics::updateOrCreate(
            ['trip_id' => $tripId, 'route_id' => $routeId],
            ['stops_order' => $newOrder]
        );

        $this->dispatch('show-toast', message: 'Stop sequence order updated.', type: 'success');
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
            'trips' => $this->organization->trips()->with(['tripStops', 'routeLogistics'])->latest()->get(),
            'vehicles' => $this->organization->vehicles()->orderBy('registration_number')->get(),
            'drivers' => $this->organization->drivers()->with('user')->get()->sortBy('name'),
            'attendants' => $this->organization->attendants()->with('user')->get()->sortBy('name'),
            'routes' => $this->organization->routes()->with('stops')->get(),
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
            {{ __('Journey Management (Trips & Crew)') }}
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
        <!-- TAB 1: SCHEDULED TRIPS (Master-Detail Split Layout) -->
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Left Panel: Trip Master List Sidebar -->
                <div class="w-full lg:w-80 shrink-0 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Deployments</h3>
                            <span class="text-[10px] text-slate-400 font-semibold">{{ $trips->count() }} Shifts scheduled</span>
                        </div>
                        <button wire:click="openAddTripModal" 
                                class="p-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition shadow-sm flex items-center justify-center"
                                title="Add Shift Trip">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </div>

                    @if ($trips->isEmpty())
                        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center flex flex-col items-center justify-center shadow-sm">
                            <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                            <p class="text-slate-805 font-bold text-xs">No Journey Logs</p>
                            <p class="text-slate-400 text-[10px] mt-0.5">Start by scheduling your first operational shift.</p>
                        </div>
                    @else
                        <div class="space-y-2 max-h-[600px] overflow-y-auto pr-1">
                            @foreach ($trips as $trip)
                                @php $status = $this->getTripStatus($trip); @endphp
                                <div wire:click="selectTrip({{ $trip->id }})" 
                                     wire:key="trip-card-{{ $trip->id }}"
                                     class="w-full text-left p-4 rounded-xl border transition-all cursor-pointer bg-white {{ $selectedTripId === $trip->id ? 'border-indigo-500 ring-2 ring-indigo-500/10 shadow-sm' : 'border-slate-200 hover:bg-slate-50/50 hover:border-slate-300' }}">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wide truncate">{{ $trip->name }}</h4>
                                            <div class="flex items-center gap-1.5 mt-1.5">
                                                <!-- Status Badge Pill -->
                                                <span class="w-2 h-2 rounded-full {{ $status === 'ready' ? 'bg-emerald-500' : ($status === 'partial' ? 'bg-amber-400' : 'bg-slate-300') }}"></span>
                                                <span class="text-[9px] uppercase tracking-wider font-bold text-slate-400">
                                                    {{ $status === 'ready' ? 'Ready' : ($status === 'partial' ? 'Partial' : 'Draft') }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-1 shrink-0">
                                            <button wire:click.stop="openEditTripModal({{ $trip->id }})" class="p-1 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 rounded-md transition" title="Edit Trip">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                            </button>
                                            <button wire:click.stop="openDeleteTripModal({{ $trip->id }})" class="p-1 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 rounded-md transition" title="Delete Trip">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Panel: Trip Details, Logistics, and Stop Timings -->
                <div class="flex-grow">
                    @if (!$selectedTripId)
                        <div class="bg-white border border-slate-200 rounded-2xl p-16 text-center flex flex-col items-center justify-center h-full min-h-[300px]">
                            <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7" /></svg>
                            <h4 class="text-slate-800 font-bold text-sm">No Trip Selected</h4>
                            <p class="text-slate-400 text-xs mt-1">Select a scheduled trip on the left panel to edit timings and crew assignments.</p>
                        </div>
                    @else
                        @php 
                            $activeTrip = $trips->firstWhere('id', $selectedTripId); 
                            $activeTripStatus = $activeTrip ? $this->getTripStatus($activeTrip) : 'draft';
                        @endphp
                        @if ($activeTrip)
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-6">
                                <!-- Detail Header -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-4 gap-4">
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-base font-bold text-slate-850 uppercase tracking-wide">{{ $activeTrip->name }}</h3>
                                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider border {{ $activeTripStatus === 'ready' ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : ($activeTripStatus === 'partial' ? 'bg-amber-50 border-amber-100 text-amber-800' : 'bg-slate-50 border-slate-250 text-slate-600') }}">
                                            {{ $activeTripStatus === 'ready' ? 'Deploy Ready' : ($activeTripStatus === 'partial' ? 'Partial Settings' : 'Draft') }}
                                        </span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Active Configuration Panel</div>
                                </div>

                                <!-- Route Horizontal Sub-Tabs -->
                                @if ($routes->isEmpty())
                                    <div class="text-center py-8">
                                        <p class="text-slate-500 text-xs italic">No routes configured in your organization yet.</p>
                                    </div>
                                @else
                                    <div class="space-y-6">
                                        <div class="border-b border-slate-200">
                                            <nav class="flex flex-wrap gap-2 -mb-px">
                                                @foreach ($routes as $route)
                                                    <button wire:click="selectRoute({{ $route->id }})" 
                                                            wire:key="route-tab-{{ $route->id }}"
                                                            class="pb-3 px-4 text-xs font-semibold uppercase tracking-wider transition-all border-b-2 {{ $selectedRouteId === $route->id ? 'border-indigo-600 text-indigo-700 font-bold' : 'border-transparent text-slate-400 hover:text-slate-700 hover:border-slate-300' }}">
                                                        {{ $route->name }}
                                                    </button>
                                                @endforeach
                                            </nav>
                                        </div>

                                        <!-- Detail view for Active Selected Route -->
                                        @php $activeRoute = $routes->firstWhere('id', $selectedRouteId); @endphp
                                        @if ($activeRoute)
                                            <div class="space-y-6">
                                                @php
                                                    $logisticRecord = \App\Models\TripRouteLogistics::where('trip_id', $activeTrip->id)
                                                        ->where('route_id', $activeRoute->id)
                                                        ->first();
                                                @endphp

                                                <!-- Live Tracking Dashboard (Polled every 5 seconds) -->
                                                <div wire:poll.keep-alive.5s class="bg-indigo-50/50 border border-indigo-100 p-5 rounded-2xl space-y-4">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center gap-2">
                                                            <span class="relative flex h-2 w-2">
                                                                @if ($logisticRecord && $logisticRecord->is_tracking)
                                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                                @else
                                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-400"></span>
                                                                @endif
                                                            </span>
                                                            <h4 class="text-xs font-bold text-indigo-900 uppercase tracking-wide">Live Route Tracking Dashboard</h4>
                                                        </div>
                                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Autorefreshes every 5s</span>
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                                                        <!-- Coordinates -->
                                                        <div class="bg-white border border-slate-200/60 p-3.5 rounded-xl shadow-sm space-y-1">
                                                            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Coordinates</span>
                                                            <span class="text-xs font-extrabold text-slate-800">
                                                                @if ($logisticRecord && $logisticRecord->is_tracking && $logisticRecord->latitude && $logisticRecord->longitude)
                                                                    {{ number_format($logisticRecord->latitude, 6) }}, {{ number_format($logisticRecord->longitude, 6) }}
                                                                @else
                                                                    Offline
                                                                @endif
                                                            </span>
                                                        </div>

                                                        <!-- Speed -->
                                                        <div class="bg-white border border-slate-200/60 p-3.5 rounded-xl shadow-sm space-y-1">
                                                            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Speed</span>
                                                            <span class="text-xs font-extrabold text-slate-800">
                                                                @if ($logisticRecord && $logisticRecord->is_tracking && $logisticRecord->latitude && $logisticRecord->longitude)
                                                                    {{ $logisticRecord->speed ? number_format($logisticRecord->speed * 3.6, 1) . ' km/h' : '0.0 km/h' }}
                                                                @else
                                                                    Offline
                                                                @endif
                                                            </span>
                                                        </div>

                                                        <!-- Last Updated -->
                                                        <div class="bg-white border border-slate-200/60 p-3.5 rounded-xl shadow-sm space-y-1">
                                                            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Last Updated</span>
                                                            <span class="text-xs font-extrabold text-slate-800">
                                                                @if ($logisticRecord && $logisticRecord->is_tracking && $logisticRecord->updated_at)
                                                                    {{ $logisticRecord->updated_at->timezone('Asia/Kolkata')->format('h:i:s A') }}
                                                                @else
                                                                    Offline
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card 1: Logistics Assignment -->
                                                <div class="bg-slate-50/50 border border-slate-200/80 p-5 rounded-2xl space-y-4">
                                                    <div class="flex items-center justify-between">
                                                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide">Crew & Vehicle Manifest</h4>
                                                        <!-- Configuration indicator badge -->
                                                        @php 
                                                            $hasVehicle = !empty($logisticsData["{$activeTrip->id}_{$activeRoute->id}"]['vehicle_id']);
                                                            $hasDriver = !empty($logisticsData["{$activeTrip->id}_{$activeRoute->id}"]['driver_id']);
                                                            $hasAttendant = !empty($logisticsData["{$activeTrip->id}_{$activeRoute->id}"]['attendant_id']);
                                                            $logisticsComplete = $hasVehicle && $hasDriver && $hasAttendant;
                                                        @endphp
                                                        <span class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider {{ $logisticsComplete ? 'text-emerald-600' : 'text-amber-600' }}">
                                                            <span class="w-1.5 h-1.5 rounded-full {{ $logisticsComplete ? 'bg-emerald-500' : 'bg-amber-400' }}"></span>
                                                            {{ $logisticsComplete ? 'Assigned' : 'Incomplete' }}
                                                        </span>
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                                        <div class="space-y-1">
                                                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Route Vehicle</label>
                                                            <select wire:model="logisticsData.{{ $activeTrip->id }}_{{$activeRoute->id}}.vehicle_id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer shadow-sm">
                                                                <option value="">No Vehicle Assigned</option>
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="space-y-1">
                                                             <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Route Pilot/Driver</label>
                                                             <select wire:model="logisticsData.{{ $activeTrip->id }}_{{ $activeRoute->id }}.driver_id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer shadow-sm">
                                                                 <option value="">No Driver Assigned</option>
                                                                 @foreach ($drivers as $driver)
                                                                     <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                                                 @endforeach
                                                             </select>
                                                         </div>

                                                         <div class="space-y-1">
                                                             <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-0.5">Route Assistant</label>
                                                             <select wire:model="logisticsData.{{ $activeTrip->id }}_{{ $activeRoute->id }}.attendant_id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:ring-4 focus:ring-indigo-500/10 cursor-pointer shadow-sm">
                                                                 <option value="">No Attendant Assigned</option>
                                                                 @foreach ($attendants as $attendant)
                                                                     <option value="{{ $attendant->id }}">{{ $attendant->name }}</option>
                                                                 @endforeach
                                                             </select>
                                                         </div>

                                                        <div>
                                                            <button wire:click="saveLogistics({{ $activeTrip->id }}, {{ $activeRoute->id }})" 
                                                                    class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 shadow-sm">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                                <span>Assign Crew</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card 2: Stop Schedule & Timings Timeline -->
                                                @if ($activeRoute->stops->isEmpty())
                                                    <div class="bg-slate-50/50 p-6 rounded-2xl text-center italic text-slate-400 text-xs">
                                                        No stops are added to this route yet.
                                                    </div>
                                                @else
                                                    <div class="space-y-4">
                                                        <div class="flex items-center justify-between">
                                                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide">Stop Schedule & Timings</h4>
                                                            <button wire:click="toggleStopsOrder({{ $activeTrip->id }}, {{ $activeRoute->id }})" 
                                                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-55 border border-slate-200 hover:bg-slate-100 text-slate-650 rounded-lg text-[10px] font-bold transition-all shadow-sm">
                                                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                    @if (($stopsOrder["{$activeTrip->id}_{$activeRoute->id}"] ?? 'asc') === 'asc')
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                                    @else
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                                                    @endif
                                                                </svg>
                                                                <span>Order: {{ ($stopsOrder["{$activeTrip->id}_{$activeRoute->id}"] ?? 'asc') === 'asc' ? 'Ascending (Up)' : 'Descending (Down)' }}</span>
                                                            </button>
                                                        </div>
                                                        <div class="divide-y divide-slate-100 border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-sm">
                                                            @php
                                                                $order = $stopsOrder["{$activeTrip->id}_{$activeRoute->id}"] ?? 'asc';
                                                                $orderedStops = $order === 'desc' 
                                                                    ? $activeRoute->stops->sortByDesc('sequence_order') 
                                                                    : $activeRoute->stops->sortBy('sequence_order');
                                                            @endphp
                                                            @foreach ($orderedStops->values() as $stopIndex => $stop)
                                                                <div wire:key="trip-stop-{{ $activeTrip->id }}-{{ $stop->id }}-{{ $stopIndex }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 hover:bg-slate-50/30 transition">
                                                                    <div class="flex items-center gap-3">
                                                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-700 shadow-sm shrink-0">
                                                                            {{ $stopIndex + 1 }}
                                                                        </div>
                                                                        <div>
                                                                            <p class="text-xs font-bold text-slate-800 flex items-center gap-1">
                                                                                <svg class="w-3 h-3 text-indigo-550 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                                                <span>{{ $stop->name }}</span>
                                                                            </p>
                                                                            <p class="text-[9px] text-slate-400 font-semibold tracking-wide mt-0.5">{{ $stop->sequence_order ? __('Sequence Position ').$stop->sequence_order : __('Core Network Stop') }}</p>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="flex items-center gap-3 self-end sm:self-auto">
                                                                        <div class="flex items-center gap-1.5">
                                                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Scheduled Time</span>
                                                                            <input type="time" wire:model="timingsData.{{ $activeTrip->id }}_{{ $stop->id }}.time" class="bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1 text-xs text-indigo-650 font-bold focus:ring-4 focus:ring-indigo-500/10">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        
                                                        <div class="flex justify-end">
                                                            <button wire:click="saveRouteTimings({{ $activeTrip->id }}, {{ $activeRoute->id }})" 
                                                                    class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all flex items-center gap-1.5 shadow-md">
                                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                                <span>Update Timing Manifest</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            </div>


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
