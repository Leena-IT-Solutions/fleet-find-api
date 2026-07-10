<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Validation\Rule;

new class extends Component
{
    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public $search = '';
    public $perPage = 10;

    // Modal control states
    public $showAddModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form inputs for adding
    public $newName = '';
    public $newContactName = '';
    public $newNumber = '';
    public $newEmail = '';
    public $newAddress = '';
    public $newLatitude = '';
    public $newLongitude = '';
    public $newEnrollmentEndDate = '';
    public $newLogo = '';
    public $newDisplayDriverPhone = true;
    public $newDisplayAttendantPhone = true;
    public $newShareLocationBy = 'driver';
    public $newUsers = [];

    // Form inputs for editing
    public $editingOrgId = null;
    public $editingName = '';
    public $editingContactName = '';
    public $editingNumber = '';
    public $editingEmail = '';
    public $editingAddress = '';
    public $editingLatitude = '';
    public $editingLongitude = '';
    public $editingEnrollmentEndDate = '';
    public $editingLogo = '';
    public $editingDisplayDriverPhone = true;
    public $editingDisplayAttendantPhone = true;
    public $editingShareLocationBy = 'driver';
    public $editingUsers = [];

    // Delete target state
    public $deletingOrgId = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        if (!auth()->user()->hasRole('Organization')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function updatingSearch(): void
    {
        $this->perPage = 10;
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'perPage']);
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    // Add Organization Modal Actions
    public function openAddModal(): void
    {
        $this->reset([
            'newName', 'newContactName', 'newNumber', 'newEmail', 'newAddress',
            'newLatitude', 'newLongitude', 'newEnrollmentEndDate', 'newLogo',
            'newDisplayDriverPhone', 'newDisplayAttendantPhone', 'newShareLocationBy', 'newUsers'
        ]);
        $this->newDisplayDriverPhone = true;
        $this->newDisplayAttendantPhone = true;
        $this->newShareLocationBy = 'driver';
        $this->showAddModal = true;
        $this->dispatch('open-modal', 'add-org-modal');
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->dispatch('close-modal', 'add-org-modal');
        $this->reset([
            'newName', 'newContactName', 'newNumber', 'newEmail', 'newAddress',
            'newLatitude', 'newLongitude', 'newEnrollmentEndDate', 'newLogo',
            'newDisplayDriverPhone', 'newDisplayAttendantPhone', 'newShareLocationBy', 'newUsers'
        ]);
        $this->resetErrorBag();
    }

    public function createOrganization(): void
    {
        $this->validate([
            'newName' => ['required', 'string', 'max:255'],
            'newContactName' => ['nullable', 'string', 'max:255'],
            'newNumber' => ['nullable', 'string', 'max:20'],
            'newEmail' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'newAddress' => ['nullable', 'string'],
            'newLatitude' => ['nullable', 'numeric', 'between:-90,90'],
            'newLongitude' => ['nullable', 'numeric', 'between:-180,180'],
            'newEnrollmentEndDate' => ['nullable', 'date'],
            'newLogo' => ['nullable', 'string', 'max:255'],
            'newDisplayDriverPhone' => ['required', 'boolean'],
            'newDisplayAttendantPhone' => ['required', 'boolean'],
            'newShareLocationBy' => ['required', 'string', Rule::in(['driver', 'attendant', 'vehicle'])],
            'newUsers' => ['array'],
            'newUsers.*' => ['exists:users,id'],
        ]);

        $org = Organization::create([
            'name' => $this->newName,
            'contact_name' => $this->newContactName,
            'number' => $this->newNumber,
            'email' => $this->newEmail,
            'address' => $this->newAddress,
            'latitude' => $this->newLatitude ?: null,
            'longitude' => $this->newLongitude ?: null,
            'enrollment_end_date' => $this->newEnrollmentEndDate ?: null,
            'logo' => $this->newLogo,
            'display_driver_phone' => $this->newDisplayDriverPhone,
            'display_attendant_phone' => $this->newDisplayAttendantPhone,
            'share_location_by' => $this->newShareLocationBy,
        ]);

        $org->users()->sync($this->newUsers);

        $this->closeAddModal();
        session()->flash('success', 'Organization created successfully.');
    }

    // Edit Organization Modal Actions
    public function openEditModal(int $orgId): void
    {
        $org = Organization::with('users')->findOrFail($orgId);
        $this->editingOrgId = $org->id;
        $this->editingName = $org->name;
        $this->editingContactName = $org->contact_name ?? '';
        $this->editingNumber = $org->number ?? '';
        $this->editingEmail = $org->email ?? '';
        $this->editingAddress = $org->address ?? '';
        $this->editingLatitude = $org->latitude ?? '';
        $this->editingLongitude = $org->longitude ?? '';
        $this->editingEnrollmentEndDate = $org->enrollment_end_date ? $org->enrollment_end_date->format('Y-m-d') : '';
        $this->editingLogo = $org->logo ?? '';
        $this->editingDisplayDriverPhone = $org->display_driver_phone;
        $this->editingDisplayAttendantPhone = $org->display_attendant_phone;
        $this->editingShareLocationBy = $org->share_location_by;
        $this->editingUsers = $org->users->pluck('id')->toArray();
        
        $this->showEditModal = true;
        $this->dispatch('open-modal', 'edit-org-modal');
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->dispatch('close-modal', 'edit-org-modal');
        $this->reset([
            'editingOrgId', 'editingName', 'editingContactName', 'editingNumber', 'editingEmail', 'editingAddress',
            'editingLatitude', 'editingLongitude', 'editingEnrollmentEndDate', 'editingLogo',
            'editingDisplayDriverPhone', 'editingDisplayAttendantPhone', 'editingShareLocationBy', 'editingUsers'
        ]);
        $this->resetErrorBag();
    }

    public function updateOrganization(): void
    {
        $this->validate([
            'editingName' => ['required', 'string', 'max:255'],
            'editingContactName' => ['nullable', 'string', 'max:255'],
            'editingNumber' => ['nullable', 'string', 'max:20'],
            'editingEmail' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'editingAddress' => ['nullable', 'string'],
            'editingLatitude' => ['nullable', 'numeric', 'between:-90,90'],
            'editingLongitude' => ['nullable', 'numeric', 'between:-180,180'],
            'editingEnrollmentEndDate' => ['nullable', 'date'],
            'editingLogo' => ['nullable', 'string', 'max:255'],
            'editingDisplayDriverPhone' => ['required', 'boolean'],
            'editingDisplayAttendantPhone' => ['required', 'boolean'],
            'editingShareLocationBy' => ['required', 'string', Rule::in(['driver', 'attendant', 'vehicle'])],
            'editingUsers' => ['array'],
            'editingUsers.*' => ['exists:users,id'],
        ]);

        $org = Organization::findOrFail($this->editingOrgId);
        $org->update([
            'name' => $this->editingName,
            'contact_name' => $this->editingContactName,
            'number' => $this->editingNumber,
            'email' => $this->editingEmail,
            'address' => $this->editingAddress,
            'latitude' => $this->editingLatitude ?: null,
            'longitude' => $this->editingLongitude ?: null,
            'enrollment_end_date' => $this->editingEnrollmentEndDate ?: null,
            'logo' => $this->editingLogo,
            'display_driver_phone' => $this->editingDisplayDriverPhone,
            'display_attendant_phone' => $this->editingDisplayAttendantPhone,
            'share_location_by' => $this->editingShareLocationBy,
        ]);

        $org->users()->sync($this->editingUsers);

        $this->closeEditModal();
        session()->flash('success', 'Organization updated successfully.');
    }

    // Delete Organization Modal Actions
    public function openDeleteModal(int $orgId): void
    {
        $this->deletingOrgId = $orgId;
        $this->showDeleteModal = true;
        $this->dispatch('open-modal', 'delete-org-modal');
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->dispatch('close-modal', 'delete-org-modal');
        $this->reset(['deletingOrgId']);
    }

    public function deleteOrganization(): void
    {
        $org = Organization::findOrFail($this->deletingOrgId);
        $org->delete();
        $this->closeDeleteModal();
        session()->flash('success', 'Organization deleted successfully.');
    }

    // Computed properties / views helper
    public function with(): array
    {
        $query = Organization::with('users');

        if (!empty($this->search)) {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('contact_name', 'like', $term)
                  ->orWhere('email', 'like', $term);
            });
        }

        // Paginate by taking $perPage records
        $organizations = $query->latest()->take($this->perPage)->get();
        $hasMore = Organization::count() > $this->perPage;

        // Get users with Organization role for modal select dropdown
        $orgUsers = User::whereHas('roles', fn ($q) => $q->where('name', 'Organization'))->get();

        return [
            'organizations' => $organizations,
            'orgUsers' => $orgUsers,
            'hasMore' => $hasMore,
        ];
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Organizations') }}
        </h2>
    </x-slot>

    <!-- Success & Error Alert Messages -->
    @if (session()->has('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search & Action Controls -->
    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-5 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="w-full flex-grow relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <input type="text" 
                   wire:model.live.debounce.300ms="search" 
                   placeholder="Search by name, contact, or email..." 
                   class="block w-full ps-10 pe-4 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
        </div>

        <div class="w-full sm:w-auto flex items-center gap-3 shrink-0">
            @if(!empty($search))
                <button wire:click="resetFilters" 
                        class="w-full sm:w-auto px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-sm font-medium transition duration-150 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Clear</span>
                </button>
            @endif

            <button wire:click="openAddModal" 
                    class="w-full sm:w-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition duration-150 flex items-center justify-center gap-2 shadow-sm focus:outline-none">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Add Organization</span>
            </button>
        </div>
    </div>

    <!-- Organizations Card List -->
    @if($organizations->isEmpty())
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
            <svg class="w-12 h-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h16.5M5.25 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 16.5h1.5M13.5 16.5H15" />
            </svg>
            <h4 class="text-base font-semibold text-slate-800">No organizations found</h4>
            <p class="text-slate-500 text-sm mt-1">Add a new organization profile to get started.</p>
        </div>
    @else
        <div class="flex flex-col gap-4">
            @foreach($organizations as $org)
                <div class="bg-white border border-slate-200/80 hover:border-slate-300 shadow-sm hover:shadow transition duration-200 rounded-xl p-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Details Column -->
                    <div class="flex-grow min-w-0 flex flex-col gap-3">
                        <div class="flex items-center gap-4 min-w-0">
                            <!-- Initials Avatar / Logo -->
                            @php
                                $initials = collect(explode(' ', $org->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                $colors = [
                                    'bg-indigo-50 text-indigo-600',
                                    'bg-cyan-50 text-cyan-600',
                                    'bg-emerald-50 text-emerald-600',
                                    'bg-amber-50 text-amber-600',
                                    'bg-rose-50 text-rose-600'
                                ];
                                $avatarColor = $colors[$org->id % count($colors)];
                            @endphp
                            <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm {{ $avatarColor }} shrink-0">
                                {{ strtoupper($initials) }}
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-base text-slate-800 truncate" title="{{ $org->name }}">{{ $org->name }}</h3>
                                    @if ($org->latitude && $org->longitude)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-50 text-indigo-600 border border-indigo-100/50">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ number_format($org->latitude, 6) }}, {{ number_format($org->longitude, 6) }}</span>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex flex-col lg:flex-row lg:items-center gap-y-1.5 lg:gap-y-0 gap-x-4 mt-1 text-xs text-slate-400">
                                    @if ($org->contact_name)
                                        <span class="flex items-center gap-1.5 text-slate-500">
                                            <strong>Contact:</strong> {{ $org->contact_name }}
                                        </span>
                                    @endif
                                    @if ($org->number)
                                        <span class="text-slate-200 hidden lg:inline">|</span>
                                        <span class="flex items-center gap-1.5">
                                            <strong>Phone:</strong> {{ $org->number }}
                                        </span>
                                    @endif
                                    @if ($org->email)
                                        <span class="text-slate-200 hidden lg:inline">|</span>
                                        <span class="flex items-center gap-1.5">
                                            <strong>Email:</strong> {{ $org->email }}
                                        </span>
                                    @endif
                                    @if ($org->enrollment_end_date)
                                        <span class="text-slate-200 hidden lg:inline">|</span>
                                        <span class="flex items-center gap-1.5 text-amber-600 font-medium">
                                            <strong>End Date:</strong> {{ $org->enrollment_end_date->format('M d, Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Associated Users -->
                        <div class="flex flex-wrap gap-1.5 items-center pl-[60px]">
                            <span class="text-xs text-slate-400 font-medium mr-1">Linked Users:</span>
                            @forelse($org->users as $u)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold tracking-wide bg-indigo-50 text-indigo-600 border border-indigo-100">
                                    {{ $u->name }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic">None</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Right Column: Settings Badges & Actions -->
                    <div class="flex flex-col sm:flex-row lg:flex-col items-start sm:items-center lg:items-end justify-between gap-4 shrink-0">
                        <div class="flex flex-wrap gap-2">
                            <!-- Share Location -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold tracking-wide bg-slate-50 text-slate-600 border border-slate-200">
                                Location by: {{ ucfirst($org->share_location_by) }}
                            </span>
                            <!-- Driver Phone display -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold tracking-wide {{ $org->display_driver_phone ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                Driver Phone: {{ $org->display_driver_phone ? 'Show' : 'Hide' }}
                            </span>
                            <!-- Attendant Phone display -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold tracking-wide {{ $org->display_attendant_phone ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                Attendant Phone: {{ $org->display_attendant_phone ? 'Show' : 'Hide' }}
                            </span>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button wire:click="openEditModal({{ $org->id }})" 
                                    class="px-3 py-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-600 hover:text-slate-800 rounded-lg text-xs font-semibold transition duration-150 flex-grow sm:flex-grow-0 text-center">
                                Edit
                            </button>
                            <button wire:click="openDeleteModal({{ $org->id }})" 
                                    class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 hover:text-rose-800 rounded-lg text-xs font-semibold transition duration-150 flex-grow sm:flex-grow-0 text-center">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($hasMore)
            <div class="flex justify-center mt-6">
                <button wire:click="loadMore" 
                        class="px-6 py-2.5 bg-white border border-slate-200 hover:border-slate-300 shadow-sm hover:shadow rounded-lg text-sm font-semibold text-slate-700 hover:text-slate-900 transition duration-150">
                    Load More Organizations
                </button>
            </div>
        @endif
    @endif

    <!-- Add Organization Modal -->
    <x-modal name="add-org-modal" :show="$showAddModal" focusable>
        <form wire:submit.prevent="createOrganization" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Add New Organization') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Create a new organization record, specify settings, set geolocations, and assign organization owners/users.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Name -->
                <div>
                    <x-input-label for="newName" value="{{ __('Organization Name') }}" />
                    <x-text-input id="newName" type="text" class="mt-1 block w-full" wire:model="newName" required />
                    <x-input-error :messages="$errors->get('newName')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Contact Name -->
                    <div>
                        <x-input-label for="newContactName" value="{{ __('Contact Person') }}" />
                        <x-text-input id="newContactName" type="text" class="mt-1 block w-full" wire:model="newContactName" />
                        <x-input-error :messages="$errors->get('newContactName')" class="mt-2" />
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <x-input-label for="newNumber" value="{{ __('Contact Phone') }}" />
                        <x-text-input id="newNumber" type="text" class="mt-1 block w-full" wire:model="newNumber" />
                        <x-input-error :messages="$errors->get('newNumber')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <x-input-label for="newEmail" value="{{ __('Email Address') }}" />
                        <x-text-input id="newEmail" type="email" class="mt-1 block w-full" wire:model="newEmail" />
                        <x-input-error :messages="$errors->get('newEmail')" class="mt-2" />
                    </div>

                    <!-- Enrollment End Date -->
                    <div>
                        <x-input-label for="newEnrollmentEndDate" value="{{ __('Enrollment End Date') }}" />
                        <x-text-input id="newEnrollmentEndDate" type="date" class="mt-1 block w-full" wire:model="newEnrollmentEndDate" />
                        <x-input-error :messages="$errors->get('newEnrollmentEndDate')" class="mt-2" />
                    </div>
                </div>

                <!-- Geolocation coords (Latitude & Longitude) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 border border-slate-100 rounded-xl">
                    <div class="col-span-1 sm:col-span-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Geographical Coordinates
                    </div>
                    <div>
                        <x-input-label for="newLatitude" value="{{ __('Latitude') }}" />
                        <x-text-input id="newLatitude" type="number" step="0.00000001" placeholder="e.g. 19.0760" class="mt-1 block w-full bg-white" wire:model="newLatitude" />
                        <x-input-error :messages="$errors->get('newLatitude')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="newLongitude" value="{{ __('Longitude') }}" />
                        <x-text-input id="newLongitude" type="number" step="0.00000001" placeholder="e.g. 72.8777" class="mt-1 block w-full bg-white" wire:model="newLongitude" />
                        <x-input-error :messages="$errors->get('newLongitude')" class="mt-2" />
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="newAddress" value="{{ __('Physical Address') }}" />
                    <textarea id="newAddress" rows="2" class="mt-1 block w-full border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 shadow-sm" wire:model="newAddress"></textarea>
                    <x-input-error :messages="$errors->get('newAddress')" class="mt-2" />
                </div>

                <!-- Associated Users (Role Organization) -->
                <div>
                    <x-input-label value="{{ __('Associate Organization Users') }}" />
                    <div class="mt-2 max-h-36 overflow-y-auto border border-slate-200 rounded-lg p-3 bg-slate-50/50 flex flex-col gap-2">
                        @forelse($orgUsers as $uOption)
                            <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" value="{{ $uOption->id }}" wire:model="newUsers" class="rounded border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 font-medium">{{ $uOption->name }} ({{ $uOption->email }})</span>
                            </label>
                        @empty
                            <span class="text-xs text-slate-400 italic">No users with 'Organization' role found.</span>
                        @endforelse
                    </div>
                    <x-input-error :messages="$errors->get('newUsers')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-slate-100 pt-4 mt-2">
                    <!-- Share Location By -->
                    <div>
                        <x-input-label for="newShareLocationBy" value="{{ __('Share Location Basis') }}" />
                        <select id="newShareLocationBy" wire:model="newShareLocationBy" class="mt-1 block w-full border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 shadow-sm">
                            <option value="driver">Driver</option>
                            <option value="attendant">Attendant</option>
                            <option value="vehicle">Vehicle</option>
                        </select>
                        <x-input-error :messages="$errors->get('newShareLocationBy')" class="mt-2" />
                    </div>

                    <!-- Switches -->
                    <div class="flex flex-col gap-3 justify-center">
                        <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" wire:model="newDisplayDriverPhone" class="rounded border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 font-medium">Display Driver Phone</span>
                        </label>
                        <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" wire:model="newDisplayAttendantPhone" class="rounded border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 font-medium">Display Attendant Phone</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-4">
                <x-secondary-button wire:click="closeAddModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Organization Modal -->
    <x-modal name="edit-org-modal" :show="$showEditModal" focusable>
        <form wire:submit.prevent="updateOrganization" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Edit Organization') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Update the details, coordinates, settings, and linked users for this organization.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Name -->
                <div>
                    <x-input-label for="editingName" value="{{ __('Organization Name') }}" />
                    <x-text-input id="editingName" type="text" class="mt-1 block w-full" wire:model="editingName" required />
                    <x-input-error :messages="$errors->get('editingName')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Contact Name -->
                    <div>
                        <x-input-label for="editingContactName" value="{{ __('Contact Person') }}" />
                        <x-text-input id="editingContactName" type="text" class="mt-1 block w-full" wire:model="editingContactName" />
                        <x-input-error :messages="$errors->get('editingContactName')" class="mt-2" />
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <x-input-label for="editingNumber" value="{{ __('Contact Phone') }}" />
                        <x-text-input id="editingNumber" type="text" class="mt-1 block w-full" wire:model="editingNumber" />
                        <x-input-error :messages="$errors->get('editingNumber')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <x-input-label for="editingEmail" value="{{ __('Email Address') }}" />
                        <x-text-input id="editingEmail" type="email" class="mt-1 block w-full" wire:model="editingEmail" />
                        <x-input-error :messages="$errors->get('editingEmail')" class="mt-2" />
                    </div>

                    <!-- Enrollment End Date -->
                    <div>
                        <x-input-label for="editingEnrollmentEndDate" value="{{ __('Enrollment End Date') }}" />
                        <x-text-input id="editingEnrollmentEndDate" type="date" class="mt-1 block w-full" wire:model="editingEnrollmentEndDate" />
                        <x-input-error :messages="$errors->get('editingEnrollmentEndDate')" class="mt-2" />
                    </div>
                </div>

                <!-- Geolocation coords (Latitude & Longitude) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 border border-slate-100 rounded-xl">
                    <div class="col-span-1 sm:col-span-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Geographical Coordinates
                    </div>
                    <div>
                        <x-input-label for="editingLatitude" value="{{ __('Latitude') }}" />
                        <x-text-input id="editingLatitude" type="number" step="0.00000001" placeholder="e.g. 19.0760" class="mt-1 block w-full bg-white" wire:model="editingLatitude" />
                        <x-input-error :messages="$errors->get('editingLatitude')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="editingLongitude" value="{{ __('Longitude') }}" />
                        <x-text-input id="editingLongitude" type="number" step="0.00000001" placeholder="e.g. 72.8777" class="mt-1 block w-full bg-white" wire:model="editingLongitude" />
                        <x-input-error :messages="$errors->get('editingLongitude')" class="mt-2" />
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="editingAddress" value="{{ __('Physical Address') }}" />
                    <textarea id="editingAddress" rows="2" class="mt-1 block w-full border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 shadow-sm" wire:model="editingAddress"></textarea>
                    <x-input-error :messages="$errors->get('editingAddress')" class="mt-2" />
                </div>

                <!-- Associated Users (Role Organization) -->
                <div>
                    <x-input-label value="{{ __('Associate Organization Users') }}" />
                    <div class="mt-2 max-h-36 overflow-y-auto border border-slate-200 rounded-lg p-3 bg-slate-50/50 flex flex-col gap-2">
                        @forelse($orgUsers as $uOption)
                            <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" value="{{ $uOption->id }}" wire:model="editingUsers" class="rounded border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ms-2 font-medium">{{ $uOption->name }} ({{ $uOption->email }})</span>
                            </label>
                        @empty
                            <span class="text-xs text-slate-400 italic">No users with 'Organization' role found.</span>
                        @endforelse
                    </div>
                    <x-input-error :messages="$errors->get('editingUsers')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-slate-100 pt-4 mt-2">
                    <!-- Share Location By -->
                    <div>
                        <x-input-label for="editingShareLocationBy" value="{{ __('Share Location Basis') }}" />
                        <select id="editingShareLocationBy" wire:model="editingShareLocationBy" class="mt-1 block w-full border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 shadow-sm">
                            <option value="driver">Driver</option>
                            <option value="attendant">Attendant</option>
                            <option value="vehicle">Vehicle</option>
                        </select>
                        <x-input-error :messages="$errors->get('editingShareLocationBy')" class="mt-2" />
                    </div>

                    <!-- Switches -->
                    <div class="flex flex-col gap-3 justify-center">
                        <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" wire:model="editingDisplayDriverPhone" class="rounded border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 font-medium">Display Driver Phone</span>
                        </label>
                        <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                            <input type="checkbox" wire:model="editingDisplayAttendantPhone" class="rounded border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 font-medium">Display Attendant Phone</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-4">
                <x-secondary-button wire:click="closeEditModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Organization Modal -->
    <x-modal name="delete-org-modal" :show="$showDeleteModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Are you sure you want to delete this organization?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('This action is permanent. All settings, database relations, and user attachments linked to this organization will be detached.') }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeDeleteModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button wire:click="deleteOrganization" 
                        class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm font-semibold transition duration-150 shadow-sm focus:outline-none">
                    {{ __('Delete') }}
                </button>
            </div>
        </div>
    </x-modal>
</div>
