<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;

new class extends Component
{
    use WithPagination;

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public $search = '';
    public $selectedRole = '';

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
            'users' => $query->latest()->paginate(12),
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
        <!-- Search & Filter Controls -->
        <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-5 flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="w-full md:w-auto flex-1 flex flex-col sm:flex-row gap-3">
                <!-- Search Input -->
                <div class="relative flex-1 max-w-md">
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
                <div class="w-full sm:w-48">
                    <select wire:model.live="selectedRole" 
                            class="block w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        <option value="">All Roles</option>
                        @foreach($roles as $roleOption)
                            <option value="{{ $roleOption->name }}">{{ $roleOption->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Reset Filters -->
            @if(!empty($search) || !empty($selectedRole))
                <button wire:click="resetFilters" 
                        class="w-full md:w-auto px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-sm font-medium transition duration-150 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Clear Filters</span>
                </button>
            @endif
        </div>

        <!-- User Cards Grid -->
        @if($users->isEmpty())
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No users found</h4>
                <p class="text-slate-500 text-sm mt-1">Try adjusting your search query or filter criteria.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($users as $u)
                    <div class="bg-white border border-slate-200/80 hover:border-slate-300 shadow-sm hover:shadow-md transition duration-200 rounded-xl p-5 flex flex-col justify-between h-56">
                        <!-- Top details -->
                        <div class="flex items-start gap-4">
                            <!-- Initials Avatar -->
                            @php
                                $initials = collect(explode(' ', $u->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                // Generate a semi-stable color theme for the avatar based on user ID
                                $colors = [
                                    'bg-indigo-50 text-indigo-600',
                                    'bg-cyan-50 text-cyan-600',
                                    'bg-emerald-50 text-emerald-600',
                                    'bg-amber-50 text-amber-600',
                                    'bg-rose-50 text-rose-600'
                                ];
                                $avatarColor = $colors[$u->id % count($colors)];
                            @endphp
                            <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-base {{ $avatarColor }} shrink-0">
                                {{ strtoupper($initials) }}
                            </div>

                            <div class="min-w-0">
                                <h3 class="font-semibold text-base text-slate-800 truncate">{{ $u->name }}</h3>
                                <p class="text-xs text-slate-400 truncate mt-0.5">{{ $u->email }}</p>
                                
                                @if($u->mobile)
                                    <div class="flex items-center gap-1.5 text-slate-500 text-xs mt-2">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                        </svg>
                                        <span>{{ $u->mobile }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Role Badges & Joined Info -->
                        <div class="border-t border-slate-100 pt-4 mt-4 flex flex-col gap-2">
                            <!-- Roles -->
                            <div class="flex flex-wrap gap-1">
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

                            <!-- Joined info -->
                            <div class="text-[10px] text-slate-400 mt-1 flex items-center justify-between">
                                <span>Joined {{ $u->created_at->format('M d, Y') }}</span>
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
</div>
