<?php

use Livewire\Volt\Component;
use App\Models\Organization;
use App\Models\ChildSubscription;
use App\Models\SubscriptionPlan;
use App\Models\Grade;
use App\Models\Division;
use Livewire\Attributes\On;

new class extends Component
{
    public ?Organization $organization = null;
    public string $search = '';
    public string $statusFilter = ''; // Empty string means 'All'
    public string $planFilter = ''; // Empty string means 'All'
    public string $gradeFilter = ''; // Empty string means 'All'
    public string $divisionFilter = ''; // Empty string means 'All'
    public int $perPage = 10;

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
        $this->perPage = 10;
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function approveSubscription(int $id): void
    {
        $sub = ChildSubscription::findOrFail($id);
        $sub->update(['status' => 'approved']);
        session()->flash('success', "Subscription for {$sub->child->name} approved successfully.");
    }

    public function disapproveSubscription(int $id): void
    {
        $sub = ChildSubscription::findOrFail($id);
        $sub->update(['status' => 'disapproved']);
        session()->flash('success', "Subscription for {$sub->child->name} disapproved successfully.");
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'planFilter', 'gradeFilter', 'divisionFilter']);
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'statusFilter', 'planFilter', 'gradeFilter', 'divisionFilter'])) {
            if ($property === 'gradeFilter') {
                $this->divisionFilter = '';
            }
            $this->resetPage();
        }
    }

    public function with()
    {
        if (!$this->organization) {
            return [
                'enrollments' => collect(),
                'plans' => collect(),
                'grades' => collect(),
                'divisions' => collect(),
                'hasMore' => false
            ];
        }

        // Get plans for filter dropdown
        $plans = $this->organization->subscriptionPlans()->get();

        // Get grades for filter dropdown
        $grades = $this->organization->grades()->get();

        // Get divisions for filter dropdown based on grade selection
        $divisions = collect();
        if (!empty($this->gradeFilter)) {
            $divisions = Division::where('grade_id', $this->gradeFilter)->get();
        }

        // Get enrollments query
        $query = ChildSubscription::whereHas('subscriptionPlan', function ($q) {
            $q->where('organization_id', $this->organization->id);
        })->with(['child', 'subscriptionPlan', 'grade', 'division', 'route', 'pickupStop', 'dropStop', 'parent']);

        // Apply Search
        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->whereHas('child', function ($cq) use ($term) {
                    $cq->where('name', 'like', $term);
                })->orWhereHas('parent', function ($pq) use ($term) {
                    $pq->where('name', 'like', $term);
                })->orWhereHas('subscriptionPlan', function ($sq) use ($term) {
                    $sq->where('name', 'like', $term);
                });
            });
        }

        // Apply Status Filter
        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        // Apply Plan Filter
        if (!empty($this->planFilter)) {
            $query->where('subscription_plan_id', $this->planFilter);
        }

        // Apply Grade Filter
        if (!empty($this->gradeFilter)) {
            $query->where('grade_id', $this->gradeFilter);
        }

        // Apply Division Filter
        if (!empty($this->divisionFilter)) {
            $query->where('division_id', $this->divisionFilter);
        }

        $totalCount = $query->count();
        $enrollments = $query->latest()->take($this->perPage)->get();
        $hasMore = $totalCount > $this->perPage;

        return [
            'enrollments' => $enrollments,
            'plans' => $plans,
            'grades' => $grades,
            'divisions' => $divisions,
            'hasMore' => $hasMore
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Subscription Enrollments') }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A9.642 9.642 0 0012 24c-.885-.01-1.748-.128-2.58-.352v-.003c0-1.113.285-2.16.786-3.07M15 19.128c-.015-.072-.03-.146-.046-.22M9.42 19.128A9.642 9.642 0 0112 24c-.885-.01-1.748-.128-2.58-.352v-.003M6.75 19.5a4.5 4.5 0 01-1.41-4.09 4.5 4.5 0 013.91-3.91 4.5 4.5 0 014.09 1.41M12 9.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Active Organization Selected</h4>
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the selector in the sidebar to manage enrollments.</p>
            </div>
        @else
            <!-- Search Control Row -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-5">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Search by student, parent, or plan..." 
                           class="block w-full ps-10 pe-4 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                </div>
            </div>

            <!-- Filters Row -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 items-end">
                    <!-- Grade Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Grade</label>
                        <select wire:model.live="gradeFilter" 
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                            <option value="">All Grades</option>
                            @foreach ($grades as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Division Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Division</label>
                        <select wire:model.live="divisionFilter" 
                                {{ empty($gradeFilter) ? 'disabled' : '' }}
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed">
                            <option value="">All Divisions</option>
                            @foreach ($divisions as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</label>
                        <select wire:model.live="statusFilter" 
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="disapproved">Disapproved</option>
                        </select>
                    </div>

                    <!-- Plan Filter -->
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Subscription Plan</label>
                        <select wire:model.live="planFilter" 
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                            <option value="">All Subscription Plans</option>
                            @foreach ($plans as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Clear Filters -->
                    <div class="flex items-center">
                        @if(!empty($search) || !empty($statusFilter) || !empty($planFilter) || !empty($gradeFilter) || !empty($divisionFilter))
                            <button wire:click="resetFilters" 
                                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-600 hover:text-slate-900 rounded-lg text-sm font-medium transition duration-150 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                <span>Clear Filters</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Enrollments Table Card -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl overflow-hidden">
                @if ($enrollments->isEmpty())
                    <div class="p-12 text-center flex flex-col items-center justify-center">
                        <p class="text-slate-500 text-sm">No subscription enrollments found.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Student Details</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Enrolled Plan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Academic Details</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Route Details</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach ($enrollments as $sub)
                                    <tr class="hover:bg-slate-50/50 transition text-slate-700">
                                        <!-- Student and Parent details -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center shrink-0 overflow-hidden">
                                                    @if($sub->child->photo)
                                                        <img src="{{ url($sub->child->photo) }}" class="object-cover w-full h-full">
                                                    @else
                                                        <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-semibold text-slate-800">{{ $sub->child->name }}</span>
                                                    <span class="text-xs text-slate-400">Parent: {{ $sub->parent->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Subscription Plan name -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex flex-col">
                                                <span class="font-medium text-slate-800">{{ $sub->subscriptionPlan->name }}</span>
                                                <span class="text-xs text-indigo-600 font-bold">₹{{ number_format($sub->subscriptionPlan->amount, 2) }}</span>
                                            </div>
                                        </td>
                                        <!-- Grade & Division -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex flex-col">
                                                <span>{{ $sub->grade->name }}</span>
                                                <span class="text-xs text-slate-400">Division: {{ $sub->division->name }}</span>
                                            </div>
                                        </td>
                                        <!-- Route, Pickup and Drop Stops -->
                                        <td class="px-6 py-4 text-sm max-w-[200px]">
                                            <div class="flex flex-col">
                                                <span class="font-medium text-slate-800">{{ $sub->route->name }}</span>
                                                <span class="text-[11px] text-slate-500 leading-tight">Pick: {{ $sub->pickupStop->name }}</span>
                                                <span class="text-[11px] text-slate-500 leading-tight">Drop: {{ $sub->dropStop->name }}</span>
                                            </div>
                                        </td>
                                        <!-- Status Badge -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($sub->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    Approved
                                                </span>
                                            @elseif($sub->status === 'disapproved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                    Disapproved
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <!-- Action Buttons -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                @if($sub->status !== 'approved')
                                                    <button wire:click="approveSubscription({{ $sub->id }})" 
                                                            class="px-3 py-1 text-white rounded-md text-xs font-semibold shadow-sm transition focus:outline-none hover:opacity-90"
                                                            style="background-color: #059669;">
                                                        Approve
                                                    </button>
                                                @endif
                                                @if($sub->status !== 'disapproved')
                                                    <button wire:click="disapproveSubscription({{ $sub->id }})" 
                                                            class="px-3 py-1 text-white rounded-md text-xs font-semibold shadow-sm transition focus:outline-none hover:opacity-90"
                                                            style="background-color: #e11d48;">
                                                        Disapprove
                                                    </button>
                                                @endif
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
                                Load More Enrollments
                            </button>
                        </div>
                    @endif
                @endif
            </div>
        @endif
    </div>
</div>
