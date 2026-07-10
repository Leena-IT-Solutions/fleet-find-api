<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\User;
use Livewire\Attributes\On;

new class extends Component
{
    public ?Organization $organization = null;
    public string $search = '';
    public string $userSearch = '';
    public ?int $selectedUserId = null;
    public ?string $selectedUserName = null;
    public string $accessLevel = 'manager';

    // Modals state
    public bool $showAddModal = false;
    public bool $showEditModal = false;
    public bool $showRemoveModal = false;

    // For editing / removing
    public ?int $targetMemberId = null;
    public ?string $targetMemberName = null;
    public string $editingAccessLevel = 'manager';

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
    }

    public function getMembersProperty()
    {
        if (!$this->organization) {
            return collect();
        }

        $query = $this->organization->users()->withPivot('access');

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('email', 'like', $term)
                  ->orWhere('mobile', 'like', $term);
            });
        }

        return $query->get();
    }

    public function getSearchResultsProperty()
    {
        if (strlen(trim($this->userSearch)) < 3) {
            return collect();
        }

        $term = '%' . trim($this->userSearch) . '%';
        
        // Find users matching search criteria who are not already members of this organization
        return User::where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('email', 'like', $term)
                  ->orWhere('mobile', 'like', $term);
            })
            ->whereDoesntHave('organizations', function ($q) {
                $q->where('organizations.id', $this->organization->id);
            })
            ->take(5)
            ->get();
    }

    public function selectUser(int $userId, string $userName)
    {
        $this->selectedUserId = $userId;
        $this->selectedUserName = $userName;
        $this->userSearch = '';
    }

    public function openAddModal()
    {
        $this->reset(['userSearch', 'selectedUserId', 'selectedUserName', 'accessLevel']);
        $this->showAddModal = true;
        $this->dispatch('open-modal', 'add-member-modal');
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->dispatch('close-modal', 'add-member-modal');
    }

    public function addMember()
    {
        if (!$this->organization || !$this->selectedUserId) {
            return;
        }

        $this->validate([
            'selectedUserId' => 'required|exists:users,id',
            'accessLevel' => 'required|in:owner,manager',
        ]);

        // Attach user to organization
        $this->organization->users()->attach($this->selectedUserId, ['access' => $this->accessLevel]);

        // Assign Organization role automatically if not already assigned
        $user = User::find($this->selectedUserId);
        if ($user && !$user->hasRole('Organization')) {
            $user->assignRole('Organization');
        }

        $this->closeAddModal();
        session()->flash('success', 'Member added to organization successfully.');
    }

    public function openEditModal(int $memberId, string $access)
    {
        $member = User::findOrFail($memberId);
        $this->targetMemberId = $member->id;
        $this->targetMemberName = $member->name;
        $this->editingAccessLevel = $access;
        $this->showEditModal = true;
        $this->dispatch('open-modal', 'edit-member-modal');
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->dispatch('close-modal', 'edit-member-modal');
    }

    public function updateMemberAccess()
    {
        if (!$this->organization || !$this->targetMemberId) {
            return;
        }

        $this->validate([
            'editingAccessLevel' => 'required|in:owner,manager',
        ]);

        // Verify we aren't changing the last owner
        if ($this->editingAccessLevel === 'manager') {
            $ownerCount = $this->organization->users()->wherePivot('access', 'owner')->count();
            $targetIsOwner = $this->organization->users()->where('users.id', $this->targetMemberId)->wherePivot('access', 'owner')->exists();
            if ($ownerCount <= 1 && $targetIsOwner) {
                session()->flash('error', 'Cannot change the last Owner of the organization to Manager.');
                $this->closeEditModal();
                return;
            }
        }

        $this->organization->users()->updateExistingPivot($this->targetMemberId, ['access' => $this->editingAccessLevel]);

        $this->closeEditModal();
        session()->flash('success', 'Member access role updated successfully.');
    }

    public function openRemoveModal(int $memberId)
    {
        $member = User::findOrFail($memberId);
        $this->targetMemberId = $member->id;
        $this->targetMemberName = $member->name;
        $this->showRemoveModal = true;
        $this->dispatch('open-modal', 'remove-member-modal');
    }

    public function closeRemoveModal()
    {
        $this->showRemoveModal = false;
        $this->dispatch('close-modal', 'remove-member-modal');
    }

    public function removeMember()
    {
        if (!$this->organization || !$this->targetMemberId) {
            return;
        }

        // Verify we aren't removing the last owner
        $ownerCount = $this->organization->users()->wherePivot('access', 'owner')->count();
        $targetIsOwner = $this->organization->users()->where('users.id', $this->targetMemberId)->wherePivot('access', 'owner')->exists();
        if ($ownerCount <= 1 && $targetIsOwner) {
            session()->flash('error', 'Cannot remove the last Owner of the organization.');
            $this->closeRemoveModal();
            return;
        }

        $this->organization->users()->detach($this->targetMemberId);

        $this->closeRemoveModal();
        session()->flash('success', 'Member removed from organization successfully.');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Access Control') }}
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

        @if (session()->has('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-xl p-4 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (!$organization)
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h16.5M5.25 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 16.5h1.5M13.5 16.5H15" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Active Organization Selected</h4>
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the selector in the sidebar to manage access privileges.</p>
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
                           placeholder="Search members by name, email, or mobile..." 
                           class="block w-full ps-10 pe-4 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <div class="w-full sm:w-auto flex items-center gap-3 shrink-0">
                    @if(!empty($search))
                        <button wire:click="$set('search', '')" 
                                class="w-full sm:w-auto px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-sm font-medium transition duration-150 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            <span>Clear</span>
                        </button>
                    @endif

                    <button wire:click="openAddModal" 
                            class="w-full sm:w-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition duration-150 flex items-center justify-center gap-2 shadow-sm focus:outline-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span>Add Member</span>
                    </button>
                </div>
            </div>

            <!-- Members List Card -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-base text-slate-800">Organization Members</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">
                        {{ $this->members->count() }} {{ Str::plural('member', $this->members->count()) }}
                    </span>
                </div>

                @if ($this->members->isEmpty())
                    <div class="p-12 text-center flex flex-col items-center justify-center">
                        <p class="text-slate-500 text-sm">No members are currently linked to this organization.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Member</th>
                                    <th scope="col" class="px-6 py-3 class='hidden md:table-cell' text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Contact</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Role Access</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach ($this->members as $member)
                                    @php
                                        $initials = collect(explode(' ', $member->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                        $avatarColors = [
                                            'bg-indigo-50 text-indigo-600',
                                            'bg-cyan-50 text-cyan-600',
                                            'bg-emerald-50 text-emerald-600',
                                            'bg-amber-50 text-amber-600',
                                            'bg-rose-50 text-rose-600'
                                        ];
                                        $color = $avatarColors[$member->id % count($avatarColors)];
                                        $access = $member->pivot->access;
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs {{ $color }} shrink-0">
                                                    {{ strtoupper($initials) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-semibold text-slate-800 truncate">{{ $member->name }}</div>
                                                    <div class="text-xs text-slate-400 truncate">{{ $member->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            <div>{{ $member->mobile ?: '—' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($access === 'owner')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                                    <span>Owner</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                                    <span>Manager</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <button wire:click="openEditModal({{ $member->id }}, '{{ $access }}')" 
                                                        title="Edit Access"
                                                        class="p-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 hover:text-slate-700 rounded-lg transition shadow-sm focus:outline-none">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </button>
                                                <button wire:click="openRemoveModal({{ $member->id }})" 
                                                        title="Remove Member"
                                                        class="p-2 bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-500 hover:text-rose-700 rounded-lg transition shadow-sm focus:outline-none">
                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-5.25a3 3 0 11-6 0 3 3 0 016 0zm-7.5 15.75a6 6 0 0110.74-3.436M21 21v-1.5a1.5 1.5 0 00-1.5-1.5h-3m1.5 3H15m3 0h3" />
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
        @endif
    </div>

    <!-- Add Member Modal -->
    <x-modal name="add-member-modal" :show="$showAddModal" focusable>
        <form wire:submit.prevent="addMember" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Add New Member') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Search user by Name, Email, or Mobile to grant access to the active organization.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Search Section -->
                <div class="relative">
                    <x-input-label for="userSearch" :value="__('Search User')" />
                    <x-text-input wire:model.live.debounce.300ms="userSearch" 
                                  id="userSearch" 
                                  type="text" 
                                  class="mt-1 block w-full" 
                                  placeholder="Type at least 3 characters..." />
                    
                    @if ($selectedUserName)
                        <div class="mt-2 flex items-center justify-between bg-slate-50 border border-slate-200 rounded-lg p-2.5">
                            <span class="text-xs font-semibold text-slate-700">Selected: <strong class="text-slate-900">{{ $selectedUserName }}</strong></span>
                            <button type="button" 
                                    wire:click="$reset('selectedUserId', 'selectedUserName')" 
                                    class="text-[10px] text-rose-600 font-bold hover:underline">
                                Change
                            </button>
                        </div>
                    @endif

                    @if ($this->userSearch && $this->searchResults->isNotEmpty())
                        <div class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            @foreach ($this->searchResults as $user)
                                <button type="button" 
                                        wire:click="selectUser({{ $user->id }}, '{{ $user->name }}')" 
                                        class="w-full text-left px-4 py-2.5 hover:bg-slate-50 text-xs border-b border-slate-100 last:border-0 flex justify-between items-center">
                                    <div>
                                        <div class="font-bold text-slate-700">{{ $user->name }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $user->email }} ({{ $user->mobile ?: 'No Phone' }})</div>
                                    </div>
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[9px] font-bold">Select</span>
                                </button>
                            @endforeach
                        </div>
                    @elseif (strlen($this->userSearch) >= 3 && $this->searchResults->isEmpty())
                        <div class="absolute z-10 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg p-3 text-center text-xs text-slate-400">
                            No users found matching criteria
                        </div>
                    @endif
                </div>

                <!-- Access Level -->
                <div>
                    <x-input-label for="accessLevel" :value="__('Access Role')" />
                    <select wire:model="accessLevel" id="accessLevel" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                        <option value="manager">Manager (Read & Update)</option>
                        <option value="owner">Owner (Full Admin Access)</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeAddModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3" :disabled="!$selectedUserId">
                    {{ __('Add Member') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Member Access Modal -->
    <x-modal name="edit-member-modal" :show="$showEditModal" focusable>
        <form wire:submit.prevent="updateMemberAccess" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Edit Member Access') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Modify the access role parameters for') }} <strong class="text-slate-800">{{ $targetMemberName }}</strong>.
            </p>

            <div class="mt-6">
                <x-input-label for="editingAccessLevel" :value="__('Access Role')" />
                <select wire:model="editingAccessLevel" id="editingAccessLevel" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                    <option value="manager">Manager (Read & Update)</option>
                    <option value="owner">Owner (Full Admin Access)</option>
                </select>
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

    <!-- Remove Member Modal -->
    <x-modal name="remove-member-modal" :show="$showRemoveModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Remove Member Access') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Are you sure you want to remove organization access privileges for') }} <strong class="text-slate-800">{{ $targetMemberName }}</strong>? {{ __('They will no longer be able to manage this organization.') }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeRemoveModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button wire:click="removeMember" 
                        class="ms-3 inline-flex items-center px-4 py-2 bg-rose-600 hover:bg-rose-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest active:bg-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Remove Access') }}
                </button>
            </div>
        </div>
    </x-modal>
</div>
