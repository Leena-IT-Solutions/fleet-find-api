<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\Vehicle;
use Livewire\Attributes\On;

new class extends Component
{
    public ?Organization $organization = null;
    public string $search = '';
    public int $perPage = 6;

    // Form fields for Add
    public string $newRegistrationNumber = '';
    public string $newType = 'Bus';

    // Form fields for Edit
    public ?int $editingVehicleId = null;
    public string $editingRegistrationNumber = '';
    public string $editingType = 'Bus';

    // Modals state
    public bool $showAddModal = false;
    public bool $showEditModal = false;
    public bool $showDeleteModal = false;
    public ?int $deletingVehicleId = null;

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public function mount()
    {
        $this->loadOrganization();
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
        $this->resetPage();
    }

    public function resetPage()
    {
        $this->perPage = 6;
    }

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function openAddModal(): void
    {
        $this->reset(['newRegistrationNumber', 'newType']);
        $this->newType = 'Bus';
        $this->showAddModal = true;
        $this->dispatch('open-modal', 'add-vehicle-modal');
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->dispatch('close-modal', 'add-vehicle-modal');
    }

    public function createVehicle(): void
    {
        if (!$this->organization) {
            return;
        }

        $this->newRegistrationNumber = strtoupper(trim($this->newRegistrationNumber));

        $this->validate([
            'newRegistrationNumber' => [
                'required', 
                'string', 
                'max:255', 
                'unique:vehicles,registration_number'
            ],
            'newType' => 'required|in:Bus,Rickshaw,Van,Tempo,Car',
        ]);

        $this->organization->vehicles()->create([
            'registration_number' => $this->newRegistrationNumber,
            'type' => $this->newType,
        ]);

        $this->closeAddModal();
        session()->flash('success', 'Vehicle added successfully.');
    }

    public function openEditModal(int $id): void
    {
        $vehicle = Vehicle::findOrFail($id);
        $this->editingVehicleId = $vehicle->id;
        $this->editingRegistrationNumber = $vehicle->registration_number;
        $this->editingType = $vehicle->type;
        $this->showEditModal = true;
        $this->dispatch('open-modal', 'edit-vehicle-modal');
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->dispatch('close-modal', 'edit-vehicle-modal');
        $this->reset(['editingVehicleId', 'editingRegistrationNumber', 'editingType']);
    }

    public function updateVehicle(): void
    {
        $vehicle = Vehicle::findOrFail($this->editingVehicleId);
        $this->editingRegistrationNumber = strtoupper(trim($this->editingRegistrationNumber));

        $this->validate([
            'editingRegistrationNumber' => [
                'required', 
                'string', 
                'max:255', 
                'unique:vehicles,registration_number,' . $vehicle->id
            ],
            'editingType' => 'required|in:Bus,Rickshaw,Van,Tempo,Car',
        ]);

        $vehicle->update([
            'registration_number' => $this->editingRegistrationNumber,
            'type' => $this->editingType,
        ]);

        $this->closeEditModal();
        session()->flash('success', 'Vehicle details updated successfully.');
    }

    public function openDeleteModal(int $id): void
    {
        $this->deletingVehicleId = $id;
        $this->showDeleteModal = true;
        $this->dispatch('open-modal', 'delete-vehicle-modal');
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->dispatch('close-modal', 'delete-vehicle-modal');
        $this->reset(['deletingVehicleId']);
    }

    public function deleteVehicle(): void
    {
        $vehicle = Vehicle::findOrFail($this->deletingVehicleId);
        $vehicle->delete();
        $this->closeDeleteModal();
        session()->flash('success', 'Vehicle deleted successfully.');
    }

    public function resetFilters(): void
    {
        $this->reset('search');
        $this->resetPage();
    }

    public function with()
    {
        if (!$this->organization) {
            return [
                'vehicles' => collect(),
                'hasMore' => false
            ];
        }
        $query = $this->organization->vehicles();

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('registration_number', 'like', $term)
                  ->orWhere('type', 'like', $term);
            });
        }

        $totalCount = $query->count();
        $vehicles = $query->latest()->take($this->perPage)->get();
        $hasMore = $totalCount > $this->perPage;

        return [
            'vehicles' => $vehicles,
            'hasMore' => $hasMore
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Vehicles') }}
        </h2>
    </x-slot>

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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25M3 14.25h6.25a2.625 2.625 0 0 0 5.25 0h3M3 14.25V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v3.75m-18 0h18" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Active Organization Selected</h4>
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the selector in the sidebar to manage vehicles.</p>
            </div>
        @else
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
                           placeholder="Search vehicles by registration plate or type..." 
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
                        <span>Add Vehicle</span>
                    </button>
                </div>
            </div>

            <!-- Vehicles Cards Grid -->
            @if ($vehicles->isEmpty())
                <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                    <p class="text-slate-500 text-sm">No vehicles found matching criteria.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($vehicles as $vehicle)
                        <div class="bg-white border border-slate-200/80 shadow-sm hover:shadow-md rounded-2xl p-6 relative flex flex-col gap-4 transition duration-150">
                            <!-- Actions in top right -->
                            <div class="absolute top-4 right-4 flex items-center gap-1.5">
                                <button wire:click="openEditModal({{ $vehicle->id }})" 
                                        title="Edit Vehicle"
                                        class="p-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 hover:text-slate-700 rounded-lg transition shadow-sm focus:outline-none">
                                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <button wire:click="openDeleteModal({{ $vehicle->id }})" 
                                        title="Delete Vehicle"
                                        class="p-2 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 hover:text-rose-700 rounded-lg transition shadow-sm focus:outline-none">
                                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center gap-4">
                                <!-- Type Icon box -->
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0 border border-indigo-100/50 shadow-sm">
                                    @if ($vehicle->type === 'Bus')
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25M3 14.25h6.25a2.625 2.625 0 0 0 5.25 0h3M3 14.25V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v3.75m-18 0h18" />
                                        </svg>
                                    @elseif ($vehicle->type === 'Rickshaw')
                                        <!-- Rickshaw / 3 Wheeler representation -->
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M12 3v14M6 8h12M4.5 11h15" />
                                            <circle cx="12" cy="6" r="3" />
                                            <circle cx="6" cy="11" r="2" />
                                            <circle cx="18" cy="11" r="2" />
                                        </svg>
                                    @elseif ($vehicle->type === 'Van')
                                        <!-- Van representation -->
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 17a2 2 0 11-4 0M8 17a2 2 0 11-4 0m16-5V8.5A2.5 2.5 0 0017.5 6H3A2 2 0 001 8v6h3m16-2h1.5a1.5 1.5 0 011.5 1.5v1.5a1 1 0 01-1 1h-3M4 14h13" />
                                        </svg>
                                    @elseif ($vehicle->type === 'Tempo')
                                        <!-- Tempo / Light Truck representation -->
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0M15 14.25h4.875a1.125 1.125 0 0 0 1.125-1.125V8.25A2.25 2.25 0 0 0 18.75 6H15m0 8.25v-8.25M1 14.25V9.75A2.25 2.25 0 0 1 3.25 7.5H15M3 11.25h12" />
                                        </svg>
                                    @else
                                        <!-- Car -->
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 17a2 2 0 11-4 0M8 17a2 2 0 11-4 0m16-5V8.5A2.5 2.5 0 0017.5 6H6.5A2.5 2.5 0 004 8.5V12M1 12h22M3 12v3.75c0 .621.504 1.125 1.125 1.125H5m14 0h1.125c.621 0 1.125-.504 1.125-1.125V12" />
                                        </svg>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-slate-800">{{ $vehicle->type }}</h4>
                                    <span class="text-xs text-slate-400">Fleet Vehicle</span>
                                </div>
                            </div>

                            <!-- License Plate Box -->
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-center shadow-inner">
                                <div class="px-5 py-2 bg-amber-50 border-2 border-slate-700/80 text-slate-850 rounded-md font-mono font-bold uppercase tracking-wider text-base shadow-sm flex items-center justify-between w-full">
                                    <span class="text-[10px] text-slate-500 font-sans tracking-normal border-r border-slate-350 pr-2">IND</span>
                                    <span class="flex-grow text-center text-slate-900">{{ $vehicle->registration_number }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($hasMore)
                    <div class="flex justify-center mt-6">
                        <button wire:click="loadMore" 
                                class="px-6 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 hover:text-slate-900 rounded-xl text-xs font-bold transition shadow-sm focus:outline-none flex items-center gap-1.5">
                            <span>Load More</span>
                            <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </div>
                @endif
            @endif
    </div>

    <!-- Add Vehicle Modal -->
    <x-modal name="add-vehicle-modal" :show="$showAddModal" focusable>
        <form wire:submit.prevent="createVehicle" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Add New Vehicle') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Specify the registration number plate and select the vehicle type category.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <div>
                    <x-input-label for="newRegistrationNumber" :value="__('Registration Number')" />
                    <x-text-input wire:model="newRegistrationNumber" 
                                  id="newRegistrationNumber" 
                                  type="text" 
                                  class="mt-1 block w-full uppercase" 
                                  placeholder="e.g. MH12AB1234" 
                                  required />
                    <x-input-error :messages="$errors->get('newRegistrationNumber')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="newType" :value="__('Vehicle Type')" />
                    <select wire:model="newType" id="newType" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                        <option value="Bus">Bus</option>
                        <option value="Rickshaw">Rickshaw</option>
                        <option value="Van">Van</option>
                        <option value="Tempo">Tempo</option>
                        <option value="Car">Car</option>
                    </select>
                    <x-input-error :messages="$errors->get('newType')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeAddModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Vehicle') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Vehicle Modal -->
    <x-modal name="edit-vehicle-modal" :show="$showEditModal" focusable>
        <form wire:submit.prevent="updateVehicle" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Edit Vehicle Details') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Modify the registration code or type parameters for this vehicle.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <div>
                    <x-input-label for="editingRegistrationNumber" :value="__('Registration Number')" />
                    <x-text-input wire:model="editingRegistrationNumber" 
                                  id="editingRegistrationNumber" 
                                  type="text" 
                                  class="mt-1 block w-full uppercase" 
                                  required />
                    <x-input-error :messages="$errors->get('editingRegistrationNumber')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="editingType" :value="__('Vehicle Type')" />
                    <select wire:model="editingType" id="editingType" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                        <option value="Bus">Bus</option>
                        <option value="Rickshaw">Rickshaw</option>
                        <option value="Van">Van</option>
                        <option value="Tempo">Tempo</option>
                        <option value="Car">Car</option>
                    </select>
                    <x-input-error :messages="$errors->get('editingType')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeEditModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Vehicle Modal -->
    <x-modal name="delete-vehicle-modal" :show="$showDeleteModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Delete Vehicle') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Are you sure you want to permanently delete this vehicle? This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeDeleteModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button wire:click="deleteVehicle" 
                        class="ms-3 inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest active:bg-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Delete') }}
                </button>
            </div>
        </div>
    </x-modal>
    @endif
</div>
