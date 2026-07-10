<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\Route;
use App\Models\Stop;
use App\Models\Setting;
use Livewire\Attributes\On;

new class extends Component
{
    public ?Organization $organization = null;
    public string $search = '';
    public ?int $selectedRouteId = null;

    // Route Form Fields
    public string $routeName = '';
    public string $routeDescription = '';
    public ?int $editingRouteId = null;

    // Stop Form Fields
    public string $stopName = '';
    public string $stopLatitude = '';
    public string $stopLongitude = '';
    public ?int $editingStopId = null;

    // Modals
    public bool $showRouteModal = false;
    public bool $showDeleteRouteModal = false;
    public bool $showStopModal = false;
    public bool $showDeleteStopModal = false;
    public ?int $deletingStopId = null;
    public string $mapTileUrl = '';
    public string $mapDefaultLat = '';
    public string $mapDefaultLng = '';
    public int $mapDefaultZoom = 14;
    public string $mapProvider = 'leaflet';
    public string $googleMapsApiKey = '';
    public string $mapboxAccessToken = '';

    // Map Location Selection Flow Properties
    public string $clickedLat = '';
    public string $clickedLng = '';
    public bool $showMapActionModal = false;
    public bool $updateOnEdit = false;
    public bool $showEditHint = false;

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public function mount()
    {
        $this->loadOrganization();
        $this->mapTileUrl = Setting::get('map_tile_url', 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        $this->mapDefaultLat = '19.18';
        $this->mapDefaultLng = '73.21';
        $this->mapDefaultZoom = (int)Setting::get('map_default_zoom', 14);
        $this->mapProvider = Setting::get('map_provider', 'leaflet');
        $this->googleMapsApiKey = Setting::get('google_maps_api_key', '');
        $this->mapboxAccessToken = Setting::get('mapbox_access_token', '');
    }

    #[On('active-organization-changed')]
    public function loadOrganization()
    {
        $activeOrgId = session('active_organization_id');
        if ($activeOrgId) {
            $this->organization = auth()->user()->organizations()->find($activeOrgId);
        } else {
            $this->organization = null;
        }
        $this->selectedRouteId = null;
    }

    public function selectRoute(int $routeId): void
    {
        $this->selectedRouteId = $routeId;
        $activeRoute = $this->organization->routes()->with('stops')->find($routeId);
        $stops = $activeRoute ? $activeRoute->stops : collect();
        $this->dispatch('route-selected', stops: $stops->toArray());
    }

    // Route CRUD Actions
    public function openAddRouteModal(): void
    {
        $this->reset(['routeName', 'routeDescription', 'editingRouteId']);
        $this->showRouteModal = true;
        $this->dispatch('open-modal', 'route-modal');
    }

    public function openEditRouteModal(int $id): void
    {
        $route = Route::findOrFail($id);
        $this->editingRouteId = $route->id;
        $this->routeName = $route->name;
        $this->routeDescription = $route->description ?? '';
        $this->showRouteModal = true;
        $this->dispatch('open-modal', 'route-modal');
    }

    public function closeRouteModal(): void
    {
        $this->showRouteModal = false;
        $this->dispatch('close-modal', 'route-modal');
        $this->reset(['routeName', 'routeDescription', 'editingRouteId']);
    }

    public function saveRoute(): void
    {
        if (!$this->organization) {
            return;
        }

        $this->validate([
            'routeName' => 'required|string|max:255',
            'routeDescription' => 'nullable|string|max:1000',
        ]);

        if ($this->editingRouteId) {
            $route = Route::findOrFail($this->editingRouteId);
            $route->update([
                'name' => $this->routeName,
                'description' => $this->routeDescription,
            ]);
            session()->flash('success', 'Route updated successfully.');
        } else {
            $route = $this->organization->routes()->create([
                'name' => $this->routeName,
                'description' => $this->routeDescription,
            ]);
            $this->selectedRouteId = $route->id;
            session()->flash('success', 'Route created successfully.');
        }

        $this->closeRouteModal();
        $this->dispatch('route-updated');
    }

    public function openDeleteRouteModal(int $id): void
    {
        $this->editingRouteId = $id;
        $this->showDeleteRouteModal = true;
        $this->dispatch('open-modal', 'delete-route-modal');
    }

    public function closeDeleteRouteModal(): void
    {
        $this->showDeleteRouteModal = false;
        $this->dispatch('close-modal', 'delete-route-modal');
    }

    public function deleteRoute(): void
    {
        $route = Route::findOrFail($this->editingRouteId);
        $route->delete();
        if ($this->selectedRouteId === $route->id) {
            $this->selectedRouteId = null;
        }
        $this->closeDeleteRouteModal();
        session()->flash('success', 'Route deleted successfully.');
        $this->dispatch('route-updated');
    }

    // Stop CRUD Actions
    public function openMapActionModal(string $lat, string $lng): void
    {
        $this->clickedLat = $lat;
        $this->clickedLng = $lng;
        $this->showMapActionModal = true;
        $this->dispatch('open-modal', 'map-action-modal');
    }

    public function closeMapActionModal(): void
    {
        $this->showMapActionModal = false;
        $this->dispatch('close-modal', 'map-action-modal');
    }

    public function chooseAddStop(): void
    {
        $this->closeMapActionModal();
        $this->openAddStopModal($this->clickedLat, $this->clickedLng);
    }

    public function chooseEditStop(): void
    {
        $this->closeMapActionModal();
        $this->updateOnEdit = true;
        $this->showEditHint = true;
    }

    public function openAddStopModal(?string $latitude = null, ?string $longitude = null): void
    {
        $this->reset(['stopName', 'editingStopId']);
        $this->stopLatitude = $latitude ?? '';
        $this->stopLongitude = $longitude ?? '';
        $this->showStopModal = true;
        $this->dispatch('open-modal', 'stop-modal');
    }

    public function openEditStopModal(int $id): void
    {
        $stop = Stop::findOrFail($id);
        $this->editingStopId = $stop->id;
        $this->stopName = $stop->name;
        
        if ($this->updateOnEdit) {
            $this->stopLatitude = $this->clickedLat;
            $this->stopLongitude = $this->clickedLng;
            $this->updateOnEdit = false;
            $this->showEditHint = false;
        } else {
            $this->stopLatitude = (string)$stop->latitude;
            $this->stopLongitude = (string)$stop->longitude;
        }

        $this->showStopModal = true;
        $this->dispatch('open-modal', 'stop-modal');
    }

    public function closeStopModal(): void
    {
        $this->showStopModal = false;
        $this->dispatch('close-modal', 'stop-modal');
        $this->reset(['stopName', 'stopLatitude', 'stopLongitude', 'editingStopId']);
    }

    public function saveStop(): void
    {
        if (!$this->selectedRouteId) {
            return;
        }

        $this->validate([
            'stopName' => 'required|string|max:255',
            'stopLatitude' => 'nullable|numeric|between:-90,90',
            'stopLongitude' => 'nullable|numeric|between:-180,180',
        ]);

        $route = Route::findOrFail($this->selectedRouteId);

        if ($this->editingStopId) {
            $stop = Stop::findOrFail($this->editingStopId);
            $stop->update([
                'name' => $this->stopName,
                'latitude' => $this->stopLatitude !== '' ? $this->stopLatitude : null,
                'longitude' => $this->stopLongitude !== '' ? $this->stopLongitude : null,
            ]);
            session()->flash('success_stop', 'Stop updated successfully.');
        } else {
            $route->stops()->create([
                'name' => $this->stopName,
                'latitude' => $this->stopLatitude !== '' ? $this->stopLatitude : null,
                'longitude' => $this->stopLongitude !== '' ? $this->stopLongitude : null,
            ]);
            session()->flash('success_stop', 'Stop added successfully.');
        }

        $this->closeStopModal();
        $this->dispatch('stops-updated', stops: $route->stops()->get()->toArray());
    }

    public function openDeleteStopModal(int $id): void
    {
        $this->deletingStopId = $id;
        $this->showDeleteStopModal = true;
        $this->dispatch('open-modal', 'delete-stop-modal');
    }

    public function closeDeleteStopModal(): void
    {
        $this->showDeleteStopModal = false;
        $this->dispatch('close-modal', 'delete-stop-modal');
    }

    public function deleteStop(): void
    {
        $stop = Stop::findOrFail($this->deletingStopId);
        $stop->delete();
        $this->closeDeleteStopModal();
        session()->flash('success_stop', 'Stop deleted successfully.');
        
        $route = Route::findOrFail($this->selectedRouteId);
        $this->dispatch('stops-updated', stops: $route->stops()->get()->toArray());
    }

    public function with()
    {
        if (!$this->organization) {
            return [
                'routes' => collect(),
                'activeRoute' => null,
                'stops' => collect(),
            ];
        }

        $query = $this->organization->routes();

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where('name', 'like', $term);
        }

        $routes = $query->latest()->get();

        $activeRoute = null;
        $stops = collect();
        if ($this->selectedRouteId) {
            $activeRoute = $this->organization->routes()->with('stops')->find($this->selectedRouteId);
            if ($activeRoute) {
                $stops = $activeRoute->stops;
            }
        }

        return [
            'routes' => $routes,
            'activeRoute' => $activeRoute,
            'stops' => $stops,
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Routes & Stops') }}
        </h2>
    </x-slot>

    <!-- Leaflet CDN resources -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @if ($mapProvider === 'google_maps' && $googleMapsApiKey)
        <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&v=weekly&loading=async" defer></script>
    @endif

    <div class="flex flex-col gap-6">
        @if (session()->has('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (!$organization)
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m-3-3h6m-1.028-9.433C12.628 2.382 12.29 2 11.858 2H5.142c-.43 0-.77.382-.667.807L5.5 7h13l1.025-4.193c.102-.425-.238-.807-.667-.807h-6.716zM5.5 7v10.25c0 .621.504 1.125 1.125 1.125H10m-4.5 0h9.75c.621 0 1.125-.504 1.125-1.125V7M9 21h6" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Active Organization Selected</h4>
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the selector in the sidebar to manage routes & stops.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column: Routes List (col-span-4) -->
                <div class="lg:col-span-4 flex flex-col gap-4">
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-2xl p-5 flex flex-col gap-4">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="font-bold text-slate-800 text-base">Routes</h3>
                            <button wire:click="openAddRouteModal" 
                                    class="p-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center gap-1 shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   wire:model.live.debounce.300ms="search" 
                                   placeholder="Search routes..." 
                                   class="block w-full ps-9 pe-4 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                        </div>

                        <!-- Routes Cards -->
                        @if ($routes->isEmpty())
                            <div class="text-center py-8 text-slate-450 text-sm">
                                No routes found.
                            </div>
                        @else
                            <div class="flex flex-col gap-2.5 max-h-[500px] overflow-y-auto pr-1">
                                @foreach ($routes as $route)
                                    <div wire:click="selectRoute({{ $route->id }})" 
                                         class="group p-4 border rounded-xl cursor-pointer transition flex flex-col gap-1.5 relative {{ $selectedRouteId === $route->id ? 'border-indigo-500 bg-indigo-50/20 shadow-sm' : 'border-slate-200/80 hover:border-slate-350 hover:bg-slate-50/40' }}">
                                        <div class="flex items-start justify-between gap-4">
                                            <h4 class="text-sm font-bold truncate pr-8 {{ $selectedRouteId === $route->id ? 'text-indigo-700' : 'text-slate-800' }}">
                                                {{ $route->name }}
                                            </h4>
                                            <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-550">
                                                {{ $route->stops_count ?? $route->stops()->count() }} {{ __('Stops') }}
                                            </span>
                                        </div>
                                        @if ($route->description)
                                            <p class="text-xs text-slate-500 line-clamp-2 pr-6">
                                                {{ $route->description }}
                                            </p>
                                        @endif

                                        <!-- Edit/Delete Hover Controls -->
                                        <div class="absolute right-3 bottom-3 opacity-0 group-hover:opacity-100 flex items-center gap-1 transition">
                                            <button wire:click.stop="openEditRouteModal({{ $route->id }})" 
                                                    title="Edit Route"
                                                    class="p-1 bg-white hover:bg-slate-100 border border-slate-200 text-slate-500 hover:text-slate-700 rounded-md shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </button>
                                            <button wire:click.stop="openDeleteRouteModal({{ $route->id }})" 
                                                    title="Delete Route"
                                                    class="p-1 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 hover:text-rose-700 rounded-md shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Detail View (col-span-8) -->
                <div class="lg:col-span-8">
                    @if (!$activeRoute)
                        <div class="bg-white border border-slate-200/80 shadow-sm rounded-2xl p-12 text-center flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-slate-300 mb-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7" />
                            </svg>
                            <h4 class="text-sm font-semibold text-slate-800">No Route Selected</h4>
                            <p class="text-slate-500 text-xs mt-0.5">Select a route from the list on the left to configure stops and view its path.</p>
                        </div>
                    @else
                        <div class="flex flex-col gap-6">
                            
                             <!-- Leaflet Map Panel -->
                              <div class="bg-white border border-slate-200/80 shadow-sm rounded-2xl overflow-hidden" 
                                   x-data="routeMap({{ $organization->latitude ?? 'null' }}, {{ $organization->longitude ?? 'null' }}, '{{ $mapTileUrl }}', {{ $mapDefaultZoom }}, {{ $mapDefaultLat }}, {{ $mapDefaultLng }}, '{{ $mapProvider }}', '{{ $googleMapsApiKey }}', '{{ $mapboxAccessToken }}')"
                                   x-on:route-selected.window="stops = $event.detail.stops; previousStopsCount = stops.length; initMap();"
                                   x-on:stops-updated.window="let isNew = $event.detail.stops.length > previousStopsCount; stops = $event.detail.stops; initMap(isNew); previousStopsCount = stops.length;">
                                 
                                 <!-- Hidden element to safely pass stops data -->
                                 <script id="initial-stops-data" type="application/json">@json($stops->toArray())</script>
                                <div class="bg-slate-50 border-b border-slate-200 px-5 py-3.5 flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-sm">Visual Route Path</h3>
                                        <span class="text-[10px] text-slate-500">Click anywhere on the map to pick coordinates and add a stop</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-indigo-600 rounded-full border border-white shadow-sm animate-pulse"></div>
                                        <span class="text-xs text-slate-500 font-medium">Map Active</span>
                                    </div>
                                </div>
                                <div class="relative w-full rounded-b-2xl overflow-hidden shadow-inner">
                                    <div id="map" class="h-[300px] w-full z-0 bg-slate-100" wire:ignore></div>
                                    <!-- Floating Locate Me Button -->
                                    <button type="button" 
                                            x-on:click="locateMe()"
                                            class="absolute bottom-3 right-3 z-[1000] p-2.5 bg-white hover:bg-slate-50 text-slate-700 hover:text-indigo-650 rounded-xl shadow-md border border-slate-200 flex items-center justify-center transition-all duration-200"
                                            title="{{ __('Center to Current Location') }}">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="bg-white border border-slate-200/80 shadow-sm rounded-2xl p-5 flex flex-col gap-4">
                                @if ($showEditHint)
                                    <div class="p-3.5 bg-indigo-50 border border-indigo-200 text-indigo-850 rounded-xl text-xs flex items-center justify-between gap-3 shadow-sm animate-pulse">
                                        <div class="flex items-center gap-2.5">
                                            <svg class="w-5 h-5 text-indigo-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <span class="font-bold">{{ __('Update Location') }}:</span>
                                                <span>{{ __('Click the pencil edit icon next to the stop you want to move to coordinates') }} <strong class="font-mono bg-indigo-100/60 px-1 py-0.5 rounded border border-indigo-200/30 text-indigo-800">{{ $clickedLat }}, {{ $clickedLng }}</strong></span>
                                            </div>
                                        </div>
                                        <button wire:click="$set('showEditHint', false)" class="text-indigo-550 hover:text-indigo-750 font-bold text-xs uppercase shrink-0">{{ __('Cancel') }}</button>
                                    </div>
                                @endif
                                @if (session()->has('success_stop'))
                                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-3.5 text-xs flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ session('success_stop') }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-base">{{ $activeRoute->name }} Stops</h3>
                                        @if ($activeRoute->description)
                                            <p class="text-slate-500 text-xs mt-0.5">{{ $activeRoute->description }}</p>
                                        @endif
                                    </div>
                                    <button wire:click="openAddStopModal" 
                                            class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <span>Add Stop</span>
                                    </button>
                                </div>

                                @if ($stops->isEmpty())
                                    <div class="bg-slate-50 border border-dashed border-slate-200 rounded-xl p-10 text-center flex flex-col items-center justify-center">
                                        <p class="text-slate-500 text-xs">No stops configured for this route yet.</p>
                                    </div>
                                @else
                                    <div class="overflow-x-auto border border-slate-100 rounded-xl">
                                        <table class="w-full text-start text-xs border-collapse">
                                            <thead>
                                                <tr class="bg-slate-55/60 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                                                    <th class="py-3 px-4 text-start w-16">Sequence</th>
                                                    <th class="py-3 px-4 text-start">Stop Name</th>
                                                    <th class="py-3 px-4 text-start">Coordinates</th>
                                                    <th class="py-3 px-4 text-end w-28">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100">
                                                @foreach ($stops as $index => $stop)
                                                    <tr class="hover:bg-slate-50/50 text-slate-700">
                                                        <td class="py-3 px-4 font-bold">
                                                            <div class="w-6 h-6 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-full flex items-center justify-center">
                                                                {{ $index + 1 }}
                                                            </div>
                                                        </td>
                                                        <td class="py-3 px-4 font-semibold text-slate-800">
                                                            {{ $stop->name }}
                                                        </td>
                                                        <td class="py-3 px-4 font-mono text-slate-500 text-[10px]">
                                                            @if ($stop->latitude && $stop->longitude)
                                                                {{ $stop->latitude }}, {{ $stop->longitude }}
                                                            @else
                                                                <span class="text-slate-400 italic">No coordinates set</span>
                                                            @endif
                                                        </td>
                                                        <td class="py-3 px-4 text-end">
                                                            <div class="inline-flex items-center gap-1.5">
                                                                <button wire:click="openEditStopModal({{ $stop->id }})" 
                                                                        title="Edit Stop"
                                                                        class="p-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 hover:text-slate-700 rounded-md transition shadow-sm">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                                    </svg>
                                                                </button>
                                                                <button wire:click="openDeleteStopModal({{ $stop->id }})" 
                                                                        title="Delete Stop"
                                                                        class="p-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 hover:text-rose-700 rounded-md transition shadow-sm">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endif
                </div>

            </div>
        @endif

    @if ($organization)
        <!-- Add/Edit Route Modal -->
        <x-modal name="route-modal" :show="$showRouteModal" focusable>
            <form wire:submit.prevent="saveRoute" class="p-6">
                <h2 class="text-lg font-medium text-slate-900">
                    {{ $editingRouteId ? __('Edit Route') : __('Add New Route') }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ __('Define a route name and optional description details.') }}
                </p>

                <div class="mt-6 flex flex-col gap-4">
                    <div>
                        <x-input-label for="routeName" :value="__('Route Name')" />
                        <x-text-input wire:model="routeName" id="routeName" type="text" class="mt-1 block w-full" placeholder="e.g. Route A - North Sector" required />
                        <x-input-error :messages="$errors->get('routeName')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="routeDescription" :value="__('Description')" />
                        <textarea wire:model="routeDescription" id="routeDescription" rows="3" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm" placeholder="Optional details about this route's path or sectors..."></textarea>
                        <x-input-error :messages="$errors->get('routeDescription')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="closeRouteModal">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        {{ $editingRouteId ? __('Save Changes') : __('Create Route') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- Delete Route Modal -->
        <x-modal name="delete-route-modal" :show="$showDeleteRouteModal" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-slate-900">
                    {{ __('Delete Route') }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ __('Are you sure you want to permanently delete this route? All physical stops associated with this route will also be deleted. This action cannot be undone.') }}
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="closeDeleteRouteModal">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <button wire:click="deleteRoute" 
                            class="ms-3 inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest active:bg-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Delete Route') }}
                    </button>
                </div>
            </div>
        </x-modal>

        <!-- Add/Edit Stop Modal -->
        <x-modal name="stop-modal" :show="$showStopModal" focusable>
            <form wire:submit.prevent="saveStop" class="p-6">
                <h2 class="text-lg font-medium text-slate-900">
                    {{ $editingStopId ? __('Edit Stop') : __('Add Stop to Route') }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ __('Specify the name of the stop and coordinates. If you double-clicked the map, coordinates are pre-filled.') }}
                </p>

                <div class="mt-6 flex flex-col gap-4">
                    <div>
                        <x-input-label for="stopName" :value="__('Stop Name')" />
                        <x-text-input wire:model="stopName" id="stopName" type="text" class="mt-1 block w-full" placeholder="e.g. Main Gate, Sector 3" required />
                        <x-input-error :messages="$errors->get('stopName')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="stopLatitude" :value="__('Latitude')" />
                            <x-text-input wire:model="stopLatitude" id="stopLatitude" type="text" class="mt-1 block w-full" placeholder="e.g. 19.1886" />
                            <x-input-error :messages="$errors->get('stopLatitude')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="stopLongitude" :value="__('Longitude')" />
                            <x-text-input wire:model="stopLongitude" id="stopLongitude" type="text" class="mt-1 block w-full" placeholder="e.g. 73.2199" />
                            <x-input-error :messages="$errors->get('stopLongitude')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="closeStopModal">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        {{ $editingStopId ? __('Save Changes') : __('Add Stop') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- Delete Stop Modal -->
        <x-modal name="delete-stop-modal" :show="$showDeleteStopModal" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-slate-900">
                    {{ __('Delete Stop') }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ __('Are you sure you want to permanently delete this stop? This action cannot be undone.') }}
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="closeDeleteStopModal">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <button wire:click="deleteStop" 
                            class="ms-3 inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest active:bg-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Delete Stop') }}
                    </button>
                </div>
            </div>
        </x-modal>

        <!-- Map Action Selection Modal -->
        <x-modal name="map-action-modal" :show="$showMapActionModal" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-slate-900">
                    {{ __('Map Location Selected') }}
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    {{ __('You clicked on coordinates:') }} <span class="font-mono text-slate-800 bg-slate-50 px-1.5 py-0.5 rounded border border-slate-200">{{ $clickedLat }}, {{ $clickedLng }}</span>
                </p>
                <p class="mt-1 text-sm text-slate-500">
                    {{ __('Would you like to add a new stop at this location or update the location of an existing stop?') }}
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button wire:click="closeMapActionModal">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <button wire:click="chooseEditStop" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 text-indigo-700 rounded-lg font-semibold text-xs uppercase tracking-widest active:bg-indigo-200 transition">
                        {{ __('Edit Existing Stop') }}
                    </button>

                    <button wire:click="chooseAddStop" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                        {{ __('Add New Stop') }}
                    </button>
                </div>
            </div>
        </x-modal>
    @endif

    <script>
        function registerRouteMap() {
            if (window.Alpine && !window.Alpine.data('routeMap')) {
                Alpine.data('routeMap', (orgLat, orgLng, tileUrl, defaultZoom, mapFallbackLat, mapFallbackLng, provider, googleMapsApiKey, mapboxAccessToken) => ({
                map: null,
                gmap: null,
                markers: [],
                googleMarkers: [],
                polyline: null,
                googlePolyline: null,
                stops: [],
                previousStopsCount: 0,
                provider: provider || 'leaflet',
                googleMapsApiKey: googleMapsApiKey || '',
                mapboxAccessToken: mapboxAccessToken || '',
                tileUrl: tileUrl || 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                defaultZoom: defaultZoom || 14,
                defaultLat: orgLat || mapFallbackLat || 19.18,
                defaultLng: orgLng || mapFallbackLng || 73.21,

                init() {
                    let initialStopsElement = document.getElementById('initial-stops-data');
                    this.stops = initialStopsElement ? JSON.parse(initialStopsElement.textContent) : [];
                    this.previousStopsCount = this.stops.length;
                    this.initMap();
                },

                initMap(isNewStopAdded) {
                    let mapContainer = document.getElementById('map');
                    if (!mapContainer) return;

                    // Clean up Leaflet
                    if (this.map) {
                        try { this.map.remove(); } catch(e) {}
                        this.map = null;
                    }
                    this.markers = [];
                    this.polyline = null;

                    // Clean up Google Maps
                    if (this.googleMarkers.length > 0) {
                        this.googleMarkers.forEach(m => m.setMap(null));
                        this.googleMarkers = [];
                    }
                    if (this.googlePolyline) {
                        this.googlePolyline.setMap(null);
                        this.googlePolyline = null;
                    }
                    this.gmap = null;

                    // Reset map container classes and inner HTML
                    mapContainer.innerHTML = '';
                    mapContainer.className = 'h-[300px] w-full z-0 bg-slate-100';

                    let centerLat = parseFloat(this.defaultLat);
                    let centerLng = parseFloat(this.defaultLng);
                    let validStops = this.stops.filter(s => s.latitude && s.longitude);

                    if (validStops.length > 0) {
                        centerLat = parseFloat(validStops[0].latitude);
                        centerLng = parseFloat(validStops[0].longitude);
                    }

                    if (this.provider === 'google_maps') {
                        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                            setTimeout(() => this.initMap(isNewStopAdded), 100);
                            return;
                        }

                        this.gmap = new google.maps.Map(mapContainer, {
                            center: { lat: centerLat, lng: centerLng },
                            zoom: this.defaultZoom,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            mapId: 'DEMO_MAP_ID'
                        });

                        this.plotStopsGoogle(validStops, isNewStopAdded);

                        this.gmap.addListener('click', (e) => {
                            let lat = e.latLng.lat().toFixed(8);
                            let lng = e.latLng.lng().toFixed(8);
                            if (this.$wire.get('showStopModal')) {
                                this.$wire.set('stopLatitude', lat);
                                this.$wire.set('stopLongitude', lng);
                            } else {
                                this.$wire.openMapActionModal(lat, lng);
                            }
                        });
                    } else {
                        // Leaflet (OSM or Mapbox tile)
                        if (typeof L === 'undefined') {
                            setTimeout(() => this.initMap(isNewStopAdded), 100);
                            return;
                        }

                        this.map = L.map('map').setView([centerLat, centerLng], this.defaultZoom);

                        let currentTileUrl = this.tileUrl;
                        let attribution = '&copy; OpenStreetMap contributors';

                        if (this.provider === 'mapbox' && this.mapboxAccessToken) {
                            currentTileUrl = `https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=${this.mapboxAccessToken}`;
                            attribution = '&copy; Mapbox contributors';
                        }

                        L.tileLayer(currentTileUrl, {
                            maxZoom: 19,
                            attribution: attribution
                        }).addTo(this.map);

                        this.plotStopsLeaflet(validStops, isNewStopAdded);

                        this.map.on('click', (e) => {
                            let lat = e.latlng.lat.toFixed(8);
                            let lng = e.latlng.lng.toFixed(8);
                            if (this.$wire.get('showStopModal')) {
                                this.$wire.set('stopLatitude', lat);
                                this.$wire.set('stopLongitude', lng);
                            } else {
                                this.$wire.openMapActionModal(lat, lng);
                            }
                        });

                        setTimeout(() => {
                            if (this.map) {
                                this.map.invalidateSize();
                            }
                        }, 200);
                    }

                    // Asynchronously check and center on device location if no stops exist
                    if (validStops.length === 0 && !isNewStopAdded) {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(
                                (position) => {
                                    let lat = position.coords.latitude;
                                    let lng = position.coords.longitude;
                                    this.centerMapOn(lat, lng, 14);
                                },
                                (error) => {
                                    console.warn("Geolocation permission denied or timed out:", error);
                                },
                                { enableHighAccuracy: true, timeout: 4000 }
                            );
                        }
                    }
                },

                plotStopsLeaflet(validStops, isNewStopAdded) {
                    let coordinates = [];

                    validStops.forEach((stop, index) => {
                        let lat = parseFloat(stop.latitude);
                        let lng = parseFloat(stop.longitude);
                        coordinates.push([lat, lng]);

                        let markerHtml = `<div class='w-7 h-7 bg-indigo-600 text-white rounded-full border-2 border-white flex items-center justify-center font-bold text-xs shadow-md'>${index + 1}</div>`;
                        
                        let myIcon = L.divIcon({
                            html: markerHtml,
                            className: 'custom-div-icon',
                            iconSize: [28, 28],
                            iconAnchor: [14, 14]
                        });

                        let m = L.marker([lat, lng], {icon: myIcon})
                            .addTo(this.map)
                            .bindPopup(`<b>${index + 1}. ${stop.name}</b><br><span class='text-[10px] text-slate-500'>${lat}, ${lng}</span>`);
                        
                        this.markers.push(m);
                    });

                    if (coordinates.length > 1) {
                        this.polyline = L.polyline(coordinates, {
                            color: '#4f46e5',
                            weight: 4,
                            opacity: 0.8,
                            dashArray: '8, 8'
                        }).addTo(this.map);

                        if (!isNewStopAdded) {
                            this.map.fitBounds(this.polyline.getBounds(), { padding: [40, 40] });
                        }
                    }

                    // Auto-focus and open popup if a new stop was added
                    if (validStops.length > 0) {
                        let lastIndex = validStops.length - 1;
                        let lastStop = validStops[lastIndex];
                        let lastLat = parseFloat(lastStop.latitude);
                        let lastLng = parseFloat(lastStop.longitude);

                        if (isNewStopAdded || validStops.length === 1) {
                            this.map.setView([lastLat, lastLng], 16);
                            if (this.markers[lastIndex]) {
                                this.markers[lastIndex].openPopup();
                            }
                        }
                    }
                },

                async plotStopsGoogle(validStops, isNewStopAdded) {
                    let pathCoordinates = [];
                    let bounds = new google.maps.LatLngBounds();

                    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

                    validStops.forEach((stop, index) => {
                        let lat = parseFloat(stop.latitude);
                        let lng = parseFloat(stop.longitude);
                        let position = { lat, lng };
                        pathCoordinates.push(position);
                        bounds.extend(position);

                        const markerElement = document.createElement('div');
                        markerElement.className = 'w-7 h-7 bg-indigo-600 text-white rounded-full border-2 border-white flex items-center justify-center font-bold text-xs shadow-md';
                        markerElement.innerText = String(index + 1);

                        let marker = new AdvancedMarkerElement({
                            position,
                            map: this.gmap,
                            content: markerElement,
                            title: stop.name
                        });

                        let infoWindow = new google.maps.InfoWindow({
                            content: `<b>${index + 1}. ${stop.name}</b><br><span class='text-[10px] text-slate-500'>${lat}, ${lng}</span>`
                        });

                        marker.addListener('gmp-click', () => {
                            infoWindow.open(this.gmap, marker);
                        });

                        this.googleMarkers.push(marker);
                    });

                    if (pathCoordinates.length > 1) {
                        this.googlePolyline = new google.maps.Polyline({
                            path: pathCoordinates,
                            geodesic: true,
                            strokeColor: '#4f46e5',
                            strokeOpacity: 0.8,
                            strokeWeight: 4
                        });

                        this.googlePolyline.setMap(this.gmap);
                        
                        if (!isNewStopAdded) {
                            this.gmap.fitBounds(bounds);
                        }
                    }

                    // Auto-focus and open info window if a new stop was added
                    if (validStops.length > 0) {
                        let lastIndex = validStops.length - 1;
                        let lastStop = validStops[lastIndex];
                        let lastLat = parseFloat(lastStop.latitude);
                        let lastLng = parseFloat(lastStop.longitude);
                        let position = { lat: lastLat, lng: lastLng };

                        if (isNewStopAdded || validStops.length === 1) {
                            this.gmap.setCenter(position);
                            this.gmap.setZoom(16);
                            let lastMarker = this.googleMarkers[lastIndex];
                            if (lastMarker) {
                                let infoWindow = new google.maps.InfoWindow({
                                    content: `<b>${lastIndex + 1}. ${lastStop.name}</b><br><span class='text-[10px] text-slate-500'>${lastLat}, ${lastLng}</span>`
                                });
                                infoWindow.open(this.gmap, lastMarker);
                            }
                        }
                    }
                },

                centerMapOn(lat, lng, zoom) {
                    if (this.provider === 'google_maps' && this.gmap) {
                        this.gmap.setCenter({ lat, lng });
                        if (zoom) this.gmap.setZoom(zoom);
                    } else if (this.map) {
                        this.map.setView([lat, lng], zoom || this.map.getZoom());
                    }
                },

                locateMe() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                let lat = position.coords.latitude;
                                let lng = position.coords.longitude;
                                this.centerMapOn(lat, lng, 15);
                            },
                            (error) => {
                                alert("Unable to retrieve location. Please check browser permissions.");
                            },
                            { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                        );
                    } else {
                        alert("Geolocation is not supported by your browser.");
                    }
                }
            }));
            }
        }

        if (window.Alpine) {
            registerRouteMap();
        } else {
            document.addEventListener('alpine:init', registerRouteMap);
        }
    </script>
    </div>
</div>
