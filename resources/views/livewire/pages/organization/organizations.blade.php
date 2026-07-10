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
    public $newLogo = '';

    // Form inputs for editing
    public $editingOrgId = null;
    public $editingName = '';
    public $editingContactName = '';
    public $editingNumber = '';
    public $editingEmail = '';
    public $editingAddress = '';
    public $editingLatitude = '';
    public $editingLongitude = '';
    public $editingLogo = '';

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
            'newLatitude', 'newLongitude', 'newLogo'
        ]);
        $this->showAddModal = true;
        $this->dispatch('open-modal', 'add-org-modal');
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->dispatch('close-modal', 'add-org-modal');
        $this->reset([
            'newName', 'newContactName', 'newNumber', 'newEmail', 'newAddress',
            'newLatitude', 'newLongitude', 'newLogo'
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
            'newLogo' => ['nullable', 'string', 'max:255'],
        ]);

        $org = Organization::create([
            'name' => $this->newName,
            'contact_name' => $this->newContactName,
            'number' => $this->newNumber,
            'email' => $this->newEmail,
            'address' => $this->newAddress,
            'latitude' => $this->newLatitude ?: null,
            'longitude' => $this->newLongitude ?: null,
            'logo' => $this->newLogo,
        ]);

        // Connect the user who is creating the organization with 'owner' access
        $org->users()->sync([auth()->id() => ['access' => 'owner']]);

        $this->closeAddModal();
        session()->flash('success', 'Organization created successfully.');
    }

    // Edit Organization Modal Actions
    public function openEditModal(int $orgId): void
    {
        $org = Organization::findOrFail($orgId);
        $this->editingOrgId = $org->id;
        $this->editingName = $org->name;
        $this->editingContactName = $org->contact_name ?? '';
        $this->editingNumber = $org->number ?? '';
        $this->editingEmail = $org->email ?? '';
        $this->editingAddress = $org->address ?? '';
        $this->editingLatitude = $org->latitude ?? '';
        $this->editingLongitude = $org->longitude ?? '';
        $this->editingLogo = $org->logo ?? '';
        
        $this->showEditModal = true;
        $this->dispatch('open-modal', 'edit-org-modal');
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->dispatch('close-modal', 'edit-org-modal');
        $this->reset([
            'editingOrgId', 'editingName', 'editingContactName', 'editingNumber', 'editingEmail', 'editingAddress',
            'editingLatitude', 'editingLongitude', 'editingLogo'
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
            'editingLogo' => ['nullable', 'string', 'max:255'],
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
            'logo' => $this->editingLogo,
        ]);

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
        $query = auth()->user()->organizations();

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
        $hasMore = auth()->user()->organizations()->count() > $this->perPage;

        return [
            'organizations' => $organizations,
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                <div class="bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition duration-200 rounded-xl p-5 flex flex-col gap-4">
                    <!-- Top section: Avatar, Title, and Actions -->
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <!-- Initials Avatar / Logo -->
                            @php
                                $initials = collect(explode(' ', $org->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                $colors = [
                                    'bg-indigo-50 text-indigo-600 border-indigo-100/50',
                                    'bg-cyan-50 text-cyan-600 border-cyan-100/50',
                                    'bg-emerald-50 text-emerald-600 border-emerald-100/50',
                                    'bg-amber-50 text-amber-600 border-amber-100/50',
                                    'bg-rose-50 text-rose-600 border-rose-100/50'
                                ];
                                $avatarColor = $colors[$org->id % count($colors)];
                            @endphp
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sm border {{ $avatarColor }} shrink-0 shadow-sm overflow-hidden bg-slate-50">
                                @if ($org->logo)
                                    <img src="{{ asset('storage/' . $org->logo) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper($initials) }}
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-bold text-base md:text-lg text-slate-800 tracking-tight truncate" title="{{ $org->name }}">
                                    {{ $org->name }}
                                </h3>
                                @if ($org->latitude && $org->longitude)
                                    <span class="inline-flex items-center gap-1 mt-0.5 px-2 py-0.5 rounded text-[10px] font-medium bg-slate-50 text-slate-500 border border-slate-200/60">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ number_format($org->latitude, 4) }}, {{ number_format($org->longitude, 4) }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions (Always aligned to top right) -->
                        <div class="flex items-center gap-2 shrink-0">
                            <button wire:click="openEditModal({{ $org->id }})" 
                                    title="Edit"
                                    class="p-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 hover:text-slate-700 rounded-lg transition duration-150 shadow-sm focus:outline-none">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </button>
                            <button wire:click="openDeleteModal({{ $org->id }})" 
                                    title="Delete"
                                    class="p-2 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 hover:text-rose-700 rounded-lg transition duration-150 shadow-sm focus:outline-none">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Bottom section: Metadata (Grid layout for fields) -->
                    @if ($org->contact_name || $org->number || $org->email)
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-3 border-t border-slate-100">
                            @if ($org->contact_name)
                                <div class="flex items-center gap-2 text-slate-600 bg-slate-50 border border-slate-100 rounded-lg p-2 min-w-0">
                                    <div class="p-1 bg-white border border-slate-200/60 rounded-md text-slate-400 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider leading-none">Contact</div>
                                        <div class="text-xs font-semibold text-slate-700 truncate mt-0.5">{{ $org->contact_name }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($org->number)
                                <div class="flex items-center gap-2 text-slate-600 bg-slate-50 border border-slate-100 rounded-lg p-2 min-w-0">
                                    <div class="p-1 bg-white border border-slate-200/60 rounded-md text-slate-400 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7.5V5z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider leading-none">Phone</div>
                                        <div class="text-xs font-semibold text-slate-700 truncate mt-0.5">{{ $org->number }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($org->email)
                                <div class="flex items-center gap-2 text-slate-600 bg-slate-50 border border-slate-100 rounded-lg p-2 min-w-0">
                                    <div class="p-1 bg-white border border-slate-200/60 rounded-md text-slate-400 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider leading-none">Email</div>
                                        <div class="text-xs font-semibold text-slate-700 truncate mt-0.5">{{ $org->email }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
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
                {{ __('Create a new organization record, specify details, and configure geographical coordinates.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Name -->
                <div>
                    <x-input-label for="newName" value="{{ __('Organization Name') }}" />
                    <x-text-input id="newName" type="text" class="mt-1 block w-full" wire:model="newName" required />
                    <x-input-error :messages="$errors->get('newName')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Contact Person -->
                    <div>
                        <x-input-label for="newContactName" value="{{ __('Contact Person') }}" />
                        <x-text-input id="newContactName" type="text" class="mt-1 block w-full" wire:model="newContactName" />
                        <x-input-error :messages="$errors->get('newContactName')" class="mt-2" />
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <x-input-label for="newNumber" value="{{ __('Contact Phone') }}" />
                        <x-text-input id="newNumber" type="text" class="mt-1 block w-full" wire:model="newNumber" />
                        <x-input-error :messages="$errors->get('newNumber')" class="mt-2" />
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="newEmail" value="{{ __('Email Address') }}" />
                    <x-text-input id="newEmail" type="email" class="mt-1 block w-full" wire:model="newEmail" />
                    <x-input-error :messages="$errors->get('newEmail')" class="mt-2" />
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
                {{ __('Update the details and geographical coordinates for this organization.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Name -->
                <div>
                    <x-input-label for="editingName" value="{{ __('Organization Name') }}" />
                    <x-text-input id="editingName" type="text" class="mt-1 block w-full" wire:model="editingName" required />
                    <x-input-error :messages="$errors->get('editingName')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Contact Person -->
                    <div>
                        <x-input-label for="editingContactName" value="{{ __('Contact Person') }}" />
                        <x-text-input id="editingContactName" type="text" class="mt-1 block w-full" wire:model="editingContactName" />
                        <x-input-error :messages="$errors->get('editingContactName')" class="mt-2" />
                    </div>

                    <!-- Contact Phone -->
                    <div>
                        <x-input-label for="editingNumber" value="{{ __('Contact Phone') }}" />
                        <x-text-input id="editingNumber" type="text" class="mt-1 block w-full" wire:model="editingNumber" />
                        <x-input-error :messages="$errors->get('editingNumber')" class="mt-2" />
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="editingEmail" value="{{ __('Email Address') }}" />
                    <x-text-input id="editingEmail" type="email" class="mt-1 block w-full" wire:model="editingEmail" />
                    <x-input-error :messages="$errors->get('editingEmail')" class="mt-2" />
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
