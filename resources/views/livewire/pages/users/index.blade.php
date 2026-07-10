<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\Rule;

new class extends Component
{
    use WithPagination;

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public $search = '';
    public $selectedRole = '';

    // Modal control states
    public $showAddModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form inputs for adding
    public $newName = '';
    public $newEmail = '';
    public $newMobile = '';
    public $newPassword = '';
    public $newRoles = [];

    // Form inputs for editing
    public $editingUserId = null;
    public $editingName = '';
    public $editingEmail = '';
    public $editingMobile = '';
    public $editingRoles = [];

    // Delete target state
    public $deletingUserId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedRole' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedRole(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'selectedRole']);
        $this->resetPage();
    }

    // Add User Modal Actions
    public function openAddModal(): void
    {
        $this->reset(['newName', 'newEmail', 'newMobile', 'newPassword', 'newRoles']);
        $this->showAddModal = true;
        $this->dispatch('open-modal', 'add-user-modal');
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->dispatch('close-modal', 'add-user-modal');
        $this->reset(['newName', 'newEmail', 'newMobile', 'newPassword', 'newRoles']);
        $this->resetErrorBag();
    }

    public function createUser(): void
    {
        $this->validate([
            'newName' => ['required', 'string', 'max:255'],
            'newEmail' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'newMobile' => ['nullable', 'string', 'max:20', 'unique:users,mobile'],
            'newPassword' => ['required', 'string', 'min:8'],
            'newRoles' => ['array'],
        ]);

        $user = User::create([
            'name' => $this->newName,
            'email' => $this->newEmail,
            'mobile' => $this->newMobile,
            'password' => Illuminate\Support\Facades\Hash::make($this->newPassword),
        ]);

        // Sync roles (User model will auto-enforce keeping the Parent role)
        $user->syncRoles($this->newRoles);

        $this->closeAddModal();
        session()->flash('success', 'User created successfully.');
    }

    // Modal Actions
    public function openEditModal(int $userId): void
    {
        $user = User::with('roles')->findOrFail($userId);
        $this->editingUserId = $user->id;
        $this->editingName = $user->name;
        $this->editingEmail = $user->email;
        $this->editingMobile = $user->mobile;
        $this->editingRoles = $user->roles->pluck('name')->toArray();
        
        $this->showEditModal = true;
        $this->dispatch('open-modal', 'edit-user-modal');
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->dispatch('close-modal', 'edit-user-modal');
        $this->reset(['editingUserId', 'editingName', 'editingEmail', 'editingMobile', 'editingRoles']);
        $this->resetErrorBag();
    }

    public function updateUser(): void
    {
        $this->validate([
            'editingName' => ['required', 'string', 'max:255'],
            'editingEmail' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')->ignore($this->editingUserId)],
            'editingMobile' => ['nullable', 'string', 'max:20', Rule::unique(User::class, 'mobile')->ignore($this->editingUserId)],
            'editingRoles' => ['array'],
        ]);

        $user = User::findOrFail($this->editingUserId);
        $user->update([
            'name' => $this->editingName,
            'email' => $this->editingEmail,
            'mobile' => $this->editingMobile,
        ]);

        // Sync roles (User model will auto-enforce keeping the Parent role)
        $user->syncRoles($this->editingRoles);

        $this->closeEditModal();
        session()->flash('success', 'User updated successfully.');
    }

    public function openDeleteModal(int $userId): void
    {
        if (auth()->id() === $userId) {
            session()->flash('error', 'You cannot delete your own logged-in user profile.');
            return;
        }

        $this->deletingUserId = $userId;
        $this->showDeleteModal = true;
        $this->dispatch('open-modal', 'delete-user-modal');
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->dispatch('close-modal', 'delete-user-modal');
        $this->reset('deletingUserId');
    }

    public function deleteUser(): void
    {
        if (auth()->id() === $this->deletingUserId) {
            session()->flash('error', 'You cannot delete your own logged-in user profile.');
            $this->closeDeleteModal();
            return;
        }

        $user = User::findOrFail($this->deletingUserId);
        $user->delete();

        $this->closeDeleteModal();
        session()->flash('success', 'User deleted successfully.');
    }

    public function with(): array
    {
        $query = User::with('roles');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('mobile', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->selectedRole)) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->selectedRole);
            });
        }

        return [
            'users' => $query->latest()->paginate(10),
            'roles' => Role::all(),
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('User Manager') }}
        </h2>
    </x-slot>

    <div class="py-6 flex flex-col gap-6">
        <!-- Success & Error Alert Messages -->
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

        <!-- Search & Filter Controls -->
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-5 flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="w-full lg:flex-grow flex flex-col sm:flex-row gap-3">
                <!-- Search Input -->
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Search by name, email, or mobile..." 
                           class="block w-full ps-10 pe-4 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Role Filter -->
                <div class="w-full sm:w-48 shrink-0">
                    <select wire:model.live="selectedRole" 
                            class="block w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">All Roles</option>
                        @foreach($roles as $roleOption)
                            <option value="{{ $roleOption->name }}">{{ $roleOption->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Actions (Reset & Add User) -->
            <div class="w-full lg:w-auto flex flex-col sm:flex-row items-center gap-3 shrink-0">
                @if(!empty($search) || !empty($selectedRole))
                    <button wire:click="resetFilters" 
                            class="w-full sm:w-auto px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-sm font-medium transition duration-150 flex items-center justify-center gap-2 shrink-0">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span>Clear Filters</span>
                    </button>
                @endif

                <button wire:click="openAddModal" 
                        class="w-full sm:w-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition duration-150 flex items-center justify-center gap-2 shadow-sm focus:outline-none">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Add User</span>
                </button>
            </div>
        </div>

        <!-- Full-Width User Cards List -->
        @if($users->isEmpty())
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No users found</h4>
                <p class="text-slate-500 text-sm mt-1">Try adjusting your search query or filter criteria.</p>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach($users as $u)
                    <div class="bg-white border border-slate-200/80 hover:border-slate-300 shadow-sm hover:shadow transition duration-200 rounded-xl p-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Left & Middle Content Column -->
                        <div class="flex-grow min-w-0 flex flex-col gap-3">
                            <!-- User Identity Details -->
                            <div class="flex items-center gap-4 min-w-0">
                                <!-- Initials Avatar -->
                                @php
                                    $initials = collect(explode(' ', $u->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                    $colors = [
                                        'bg-indigo-50 text-indigo-600',
                                        'bg-cyan-50 text-cyan-600',
                                        'bg-emerald-50 text-emerald-600',
                                        'bg-amber-50 text-amber-600',
                                        'bg-rose-50 text-rose-600'
                                    ];
                                    $avatarColor = $colors[$u->id % count($colors)];
                                @endphp
                                <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm {{ $avatarColor }} shrink-0">
                                    {{ strtoupper($initials) }}
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-base text-slate-800 truncate" title="{{ $u->name }}">{{ $u->name }}</h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-0.5 text-xs text-slate-400">
                                        <span class="flex items-center gap-1.5 text-slate-400 min-w-0">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                            </svg>
                                            <span class="truncate block max-w-[180px] sm:max-w-none" title="{{ $u->email }}">{{ $u->email }}</span>
                                        </span>
                                        @if($u->mobile)
                                            <span class="text-slate-200 hidden sm:inline">|</span>
                                            <span class="flex items-center gap-1 shrink-0">
                                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                                </svg>
                                                <span>{{ $u->mobile }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Roles Row: directly underneath, left-aligned with user info text -->
                            <div class="flex flex-wrap gap-1.5 items-center pl-[60px]">
                                @foreach($u->roles as $userRole)
                                    @php
                                        $badgeColor = match(strtolower($userRole->name)) {
                                            'admin' => 'bg-rose-50 text-rose-600 border border-rose-100',
                                            'organization' => 'bg-indigo-50 text-indigo-600 border border-indigo-100',
                                            'driver' => 'bg-cyan-50 text-cyan-600 border border-cyan-100',
                                            'attendant' => 'bg-amber-50 text-amber-600 border border-amber-100',
                                            default => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold tracking-wide {{ $badgeColor }}">
                                        {{ $userRole->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Right Section: Joined Date & Action Buttons -->
                        <div class="flex flex-row lg:flex-col lg:items-end justify-between lg:justify-center gap-2 border-t border-slate-100 lg:border-0 pt-3 lg:pt-0 shrink-0">
                            <div class="flex items-center gap-2">
                                <!-- Edit Button -->
                                <button wire:click="openEditModal({{ $u->id }})" 
                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 transition duration-150 focus:outline-none">
                                    <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    <span>Edit</span>
                                </button>

                                <!-- Delete Button -->
                                @if(auth()->id() !== $u->id)
                                    <button wire:click="openDeleteModal({{ $u->id }})" 
                                            class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1 transition duration-150 focus:outline-none">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        <span>Delete</span>
                                    </button>
                                @else
                                    <span class="text-slate-400 bg-slate-100 cursor-not-allowed px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5" title="You cannot delete yourself">
                                        <svg class="w-3.5 h-3.5 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                        </svg>
                                        <span>Locked</span>
                                    </span>
                                @endif
                            </div>

                            <div class="text-[10px] text-slate-400 font-medium tracking-wide">
                                Joined {{ $u->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Add User Modal -->
    <x-modal name="add-user-modal" :show="$showAddModal" focusable>
        <form wire:submit.prevent="createUser" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Add New User') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Create a new user profile with personal details, contact number, password, and system roles.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Name -->
                <div>
                    <x-input-label for="newName" value="{{ __('Name') }}" />
                    <x-text-input id="newName" type="text" class="mt-1 block w-full" wire:model="newName" required />
                    <x-input-error :messages="$errors->get('newName')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="newEmail" value="{{ __('Email') }}" />
                    <x-text-input id="newEmail" type="email" class="mt-1 block w-full" wire:model="newEmail" required />
                    <x-input-error :messages="$errors->get('newEmail')" class="mt-2" />
                </div>

                <!-- Mobile -->
                <div>
                    <x-input-label for="newMobile" value="{{ __('Mobile') }}" />
                    <x-text-input id="newMobile" type="text" class="mt-1 block w-full" wire:model="newMobile" />
                    <x-input-error :messages="$errors->get('newMobile')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="newPassword" value="{{ __('Password') }}" />
                    <x-text-input id="newPassword" type="password" class="mt-1 block w-full" wire:model="newPassword" required />
                    <x-input-error :messages="$errors->get('newPassword')" class="mt-2" />
                </div>

                <!-- Roles Checkboxes -->
                <div>
                    <x-input-label value="{{ __('Assigned System Roles') }}" />
                    
                    <div class="grid grid-cols-2 gap-3 mt-2">
                        @foreach($roles as $role)
                            @php
                                $isParent = strtolower($role->name) === 'parent';
                            @endphp
                            <label class="inline-flex items-center gap-2 p-2 border border-slate-100 rounded-lg hover:bg-slate-50 cursor-pointer text-sm text-slate-700">
                                @if($isParent)
                                    <!-- Parent role is checked and disabled (can't uncheck) -->
                                    <input type="checkbox" 
                                           checked 
                                           disabled 
                                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20 cursor-not-allowed">
                                    <input type="hidden" wire:model="newRoles" value="Parent">
                                @else
                                    <input type="checkbox" 
                                           value="{{ $role->name }}" 
                                           wire:model="newRoles" 
                                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20">
                                @endif
                                <span>{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('newRoles')" class="mt-2" />
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeAddModal" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Create User') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit User Modal -->
    <x-modal name="edit-user-modal" :show="$showEditModal" focusable>
        <form wire:submit.prevent="updateUser" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Edit User Details') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Update user personal details, contact number, and system access roles.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Name -->
                <div>
                    <x-input-label for="editingName" value="{{ __('Name') }}" />
                    <x-text-input id="editingName" type="text" class="mt-1 block w-full" wire:model="editingName" required />
                    <x-input-error :messages="$errors->get('editingName')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="editingEmail" value="{{ __('Email') }}" />
                    <x-text-input id="editingEmail" type="email" class="mt-1 block w-full" wire:model="editingEmail" required />
                    <x-input-error :messages="$errors->get('editingEmail')" class="mt-2" />
                </div>

                <!-- Mobile -->
                <div>
                    <x-input-label for="editingMobile" value="{{ __('Mobile') }}" />
                    <x-text-input id="editingMobile" type="text" class="mt-1 block w-full" wire:model="editingMobile" />
                    <x-input-error :messages="$errors->get('editingMobile')" class="mt-2" />
                </div>

                <!-- Roles Checkboxes -->
                <div>
                    <x-input-label value="{{ __('Assigned System Roles') }}" />
                    
                    <div class="grid grid-cols-2 gap-3 mt-2">
                        @foreach($roles as $role)
                            @php
                                $isParent = strtolower($role->name) === 'parent';
                            @endphp
                            <label class="inline-flex items-center gap-2 p-2 border border-slate-100 rounded-lg hover:bg-slate-50 cursor-pointer text-sm text-slate-700">
                                @if($isParent)
                                    <!-- Parent role is checked and disabled (can't uncheck) -->
                                    <input type="checkbox" 
                                           checked 
                                           disabled 
                                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20 cursor-not-allowed">
                                    <input type="hidden" wire:model="editingRoles" value="Parent">
                                @else
                                    <input type="checkbox" 
                                           value="{{ $role->name }}" 
                                           wire:model="editingRoles" 
                                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20">
                                @endif
                                <span>{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('editingRoles')" class="mt-2" />
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeEditModal" type="button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="delete-user-modal" :show="$showDeleteModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Confirm User Deletion') }}
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                {{ __('Are you sure you want to delete this user profile? All related records associated with this profile will be permanently removed from the system. This operation cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeDeleteModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button wire:click="deleteUser">
                    {{ __('Delete User') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
