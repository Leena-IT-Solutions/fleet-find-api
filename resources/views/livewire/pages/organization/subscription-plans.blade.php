<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\SubscriptionPlan;
use App\Models\Route;
use Livewire\Attributes\On;

new class extends Component
{
    public ?Organization $organization = null;
    public string $search = '';
    public int $perPage = 6;

    // Form fields for Add
    public string $newName = '';
    public string $newRegistrationStartDate = '';
    public string $newRegistrationEndDate = '';
    public string $newValidTill = '';
    public string $newAmount = '';
    public array $newRouteIds = [];

    // Form fields for Edit
    public ?int $editingPlanId = null;
    public string $editingName = '';
    public string $editingRegistrationStartDate = '';
    public string $editingRegistrationEndDate = '';
    public string $editingValidTill = '';
    public string $editingAmount = '';
    public array $editingRouteIds = [];

    // Modals state
    public bool $showAddModal = false;
    public bool $showEditModal = false;
    public bool $showDeleteModal = false;
    public ?int $deletingPlanId = null;

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
        $this->reset(['newName', 'newRegistrationStartDate', 'newRegistrationEndDate', 'newValidTill', 'newAmount', 'newRouteIds']);
        $this->showAddModal = true;
        $this->dispatch('open-modal', 'add-plan-modal');
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->dispatch('close-modal', 'add-plan-modal');
    }

    public function createPlan(): void
    {
        if (!$this->organization) {
            return;
        }

        $this->validate([
            'newName' => 'required|string|max:255',
            'newRegistrationStartDate' => 'required|date',
            'newRegistrationEndDate' => 'required|date|after_or_equal:newRegistrationStartDate',
            'newValidTill' => 'required|date|after_or_equal:newRegistrationEndDate',
            'newAmount' => 'required|numeric|min:0',
            'newRouteIds' => 'nullable|array',
            'newRouteIds.*' => 'exists:routes,id',
        ], [
            'newRegistrationEndDate.after_or_equal' => 'The registration end date must be after or equal to the start date.',
            'newValidTill.after_or_equal' => 'The valid till date must be after or equal to the registration end date.',
        ]);

        $plan = $this->organization->subscriptionPlans()->create([
            'name' => $this->newName,
            'registration_start_date' => $this->newRegistrationStartDate,
            'registration_end_date' => $this->newRegistrationEndDate,
            'valid_till' => $this->newValidTill,
            'amount' => $this->newAmount,
        ]);

        if (!empty($this->newRouteIds)) {
            $plan->routes()->sync($this->newRouteIds);
        }

        $this->closeAddModal();
        session()->flash('success', 'Subscription plan created successfully.');
    }

    public function openEditModal(int $id): void
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $this->editingPlanId = $plan->id;
        $this->editingName = $plan->name;
        $this->editingRegistrationStartDate = $plan->registration_start_date->format('Y-m-d');
        $this->editingRegistrationEndDate = $plan->registration_end_date->format('Y-m-d');
        $this->editingValidTill = $plan->valid_till->format('Y-m-d');
        $this->editingAmount = (string) $plan->amount;
        $this->editingRouteIds = $plan->routes()->pluck('routes.id')->toArray();
        $this->showEditModal = true;
        $this->dispatch('open-modal', 'edit-plan-modal');
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->dispatch('close-modal', 'edit-plan-modal');
        $this->reset(['editingPlanId', 'editingName', 'editingRegistrationStartDate', 'editingRegistrationEndDate', 'editingValidTill', 'editingAmount', 'editingRouteIds']);
    }

    public function updatePlan(): void
    {
        $plan = SubscriptionPlan::findOrFail($this->editingPlanId);

        $this->validate([
            'editingName' => 'required|string|max:255',
            'editingRegistrationStartDate' => 'required|date',
            'editingRegistrationEndDate' => 'required|date|after_or_equal:editingRegistrationStartDate',
            'editingValidTill' => 'required|date|after_or_equal:editingRegistrationEndDate',
            'editingAmount' => 'required|numeric|min:0',
            'editingRouteIds' => 'nullable|array',
            'editingRouteIds.*' => 'exists:routes,id',
        ], [
            'editingRegistrationEndDate.after_or_equal' => 'The registration end date must be after or equal to the start date.',
            'editingValidTill.after_or_equal' => 'The valid till date must be after or equal to the registration end date.',
        ]);

        $plan->update([
            'name' => $this->editingName,
            'registration_start_date' => $this->editingRegistrationStartDate,
            'registration_end_date' => $this->editingRegistrationEndDate,
            'valid_till' => $this->editingValidTill,
            'amount' => $this->editingAmount,
        ]);

        $plan->routes()->sync($this->editingRouteIds ?? []);

        $this->closeEditModal();
        session()->flash('success', 'Subscription plan updated successfully.');
    }

    public function openDeleteModal(int $id): void
    {
        $this->deletingPlanId = $id;
        $this->showDeleteModal = true;
        $this->dispatch('open-modal', 'delete-plan-modal');
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->dispatch('close-modal', 'delete-plan-modal');
        $this->reset(['deletingPlanId']);
    }

    public function deletePlan(): void
    {
        $plan = SubscriptionPlan::findOrFail($this->deletingPlanId);
        $plan->delete();
        $this->closeDeleteModal();
        session()->flash('success', 'Subscription plan deleted successfully.');
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
                'plans' => collect(),
                'orgRoutes' => collect(),
                'hasMore' => false
            ];
        }

        $query = $this->organization->subscriptionPlans();

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where('name', 'like', $term);
        }

        $totalCount = $query->count();
        $plans = $query->with('routes')->latest()->take($this->perPage)->get();
        $hasMore = $totalCount > $this->perPage;

        $orgRoutes = $this->organization->routes()->get();

        return [
            'plans' => $plans,
            'orgRoutes' => $orgRoutes,
            'hasMore' => $hasMore
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Subscription Plans') }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Active Organization Selected</h4>
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the selector in the sidebar to manage subscription plans.</p>
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
                           placeholder="Search plans by name..." 
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
                        <span>Add Plan</span>
                    </button>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl overflow-hidden">
                @if ($plans->isEmpty())
                    <div class="p-12 text-center flex flex-col items-center justify-center">
                        <p class="text-slate-500 text-sm">No subscription plans found.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Plan Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Registration Window</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Valid Till</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Assigned Routes</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach ($plans as $plan)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-slate-800">{{ $plan->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            <div class="flex flex-col">
                                                <span>Starts: {{ $plan->registration_start_date->format('M d, Y') }}</span>
                                                <span class="text-xs text-slate-400">Ends: {{ $plan->registration_end_date->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                            <span>{{ $plan->valid_till->format('M d, Y') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-indigo-600">₹{{ number_format($plan->amount, 2) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1.5 max-w-[240px]">
                                                @forelse ($plan->routes as $route)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                                        {{ $route->name }}
                                                    </span>
                                                @empty
                                                    <span class="text-xs text-slate-400">—</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button wire:click="openEditModal({{ $plan->id }})" 
                                                        title="Edit Plan"
                                                        class="p-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 hover:text-slate-700 rounded-lg transition shadow-sm focus:outline-none">
                                                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </button>
                                                <button wire:click="openDeleteModal({{ $plan->id }})" 
                                                        title="Delete Plan"
                                                        class="p-2 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 hover:text-rose-700 rounded-lg transition shadow-sm focus:outline-none">
                                                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($hasMore)
                        <div class="p-4 border-t border-slate-100 flex justify-center bg-slate-50/50">
                            <button wire:click="loadMore" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 hover:text-slate-900 rounded-lg text-xs font-semibold transition duration-150 shadow-sm focus:outline-none">
                                Load More Plans
                            </button>
                        </div>
                    @endif
                @endif
            </div>
    </div>

    <!-- Add Plan Modal -->
    <x-modal name="add-plan-modal" :show="$showAddModal" focusable>
        <form wire:submit.prevent="createPlan" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Add New Subscription Plan') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Provide plan specifics and optionally assign active routes.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <div>
                    <x-input-label for="newName" :value="__('Plan Name')" />
                    <x-text-input wire:model="newName" id="newName" type="text" class="mt-1 block w-full" placeholder="e.g. Monthly Standard Route Pass" required />
                    <x-input-error :messages="$errors->get('newName')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="newRegistrationStartDate" :value="__('Registration Start Date')" />
                        <x-text-input wire:model="newRegistrationStartDate" id="newRegistrationStartDate" type="date" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('newRegistrationStartDate')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="newRegistrationEndDate" :value="__('Registration End Date')" />
                        <x-text-input wire:model="newRegistrationEndDate" id="newRegistrationEndDate" type="date" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('newRegistrationEndDate')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="newValidTill" :value="__('Plan Valid Till')" />
                        <x-text-input wire:model="newValidTill" id="newValidTill" type="date" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('newValidTill')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="newAmount" :value="__('Amount (₹)')" />
                        <x-text-input wire:model="newAmount" id="newAmount" type="number" step="0.01" min="0" class="mt-1 block w-full" placeholder="e.g. 50.00" required />
                        <x-input-error :messages="$errors->get('newAmount')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label :value="__('Assign Routes')" />
                    <div class="mt-2 grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-3 border border-slate-200 rounded-lg bg-slate-50/50">
                        @forelse ($orgRoutes as $route)
                            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model="newRouteIds" value="{{ $route->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span>{{ $route->name }}</span>
                            </label>
                        @empty
                            <span class="text-xs text-slate-400 col-span-2">No routes created yet.</span>
                        @endforelse
                    </div>
                    <x-input-error :messages="$errors->get('newRouteIds')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeAddModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Plan') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Plan Modal -->
    <x-modal name="edit-plan-modal" :show="$showEditModal" focusable>
        <form wire:submit.prevent="updatePlan" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Edit Subscription Plan') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Update the plan details and route assignments.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <div>
                    <x-input-label for="editingName" :value="__('Plan Name')" />
                    <x-text-input wire:model="editingName" id="editingName" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('editingName')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="editingRegistrationStartDate" :value="__('Registration Start Date')" />
                        <x-text-input wire:model="editingRegistrationStartDate" id="editingRegistrationStartDate" type="date" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('editingRegistrationStartDate')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="editingRegistrationEndDate" :value="__('Registration End Date')" />
                        <x-text-input wire:model="editingRegistrationEndDate" id="editingRegistrationEndDate" type="date" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('editingRegistrationEndDate')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="editingValidTill" :value="__('Plan Valid Till')" />
                        <x-text-input wire:model="editingValidTill" id="editingValidTill" type="date" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('editingValidTill')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="editingAmount" :value="__('Amount (₹)')" />
                        <x-text-input wire:model="editingAmount" id="editingAmount" type="number" step="0.01" min="0" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('editingAmount')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label :value="__('Assign Routes')" />
                    <div class="mt-2 grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-3 border border-slate-200 rounded-lg bg-slate-50/50">
                        @forelse ($orgRoutes as $route)
                            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" wire:model="editingRouteIds" value="{{ $route->id }}" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span>{{ $route->name }}</span>
                            </label>
                        @empty
                            <span class="text-xs text-slate-400 col-span-2">No routes created yet.</span>
                        @endforelse
                    </div>
                    <x-input-error :messages="$errors->get('editingRouteIds')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeEditModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Update Plan') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Plan Modal -->
    <x-modal name="delete-plan-modal" :show="$showDeleteModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Are you sure you want to delete this subscription plan?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Deleting this subscription plan will unlink all associated routes. This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeDeleteModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deletePlan">
                    {{ __('Delete Plan') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
    @endif
</div>
