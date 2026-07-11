<?php

use Livewire\Volt\Component;
use App\Models\Trip;
use App\Models\Grade;
use Livewire\Attributes\On;

new class extends Component
{
    public $trips = [];
    public $grades = [];
    public $activeOrg = null;

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public function mount()
    {
        $this->loadData();
    }

    #[On('active-organization-changed')]
    public function loadData()
    {
        $activeOrgId = session('active_organization_id');
        if ($activeOrgId) {
            $this->activeOrg = auth()->user()->organizations()->find($activeOrgId);
            if ($this->activeOrg) {
                // Fetch trips and grades with divisions pre-loaded
                $this->trips = Trip::where('organization_id', $activeOrgId)
                    ->with('divisions')
                    ->orderBy('name')
                    ->get();
                $this->grades = Grade::where('organization_id', $activeOrgId)
                    ->with('divisions')
                    ->orderBy('name')
                    ->get();
            } else {
                $this->resetData();
            }
        } else {
            $this->resetData();
        }
    }

    private function resetData()
    {
        $this->trips = [];
        $this->grades = [];
        $this->activeOrg = null;
    }

    public function toggleDivision($tripId, $divisionId)
    {
        if (!$this->activeOrg) return;

        // Secure mapping within active organization
        $trip = Trip::where('organization_id', $this->activeOrg->id)->findOrFail($tripId);
        
        // Ensure the division belongs to active organization through grade
        $gradeIds = $this->activeOrg->grades()->pluck('id');
        $divisionExists = \App\Models\Division::whereIn('grade_id', $gradeIds)->where('id', $divisionId)->exists();

        if ($divisionExists) {
            $trip->divisions()->toggle($divisionId);
            $this->loadData();
            session()->flash("success-{$tripId}", "Mappings updated successfully.");
        }
    }

    public function toggleGradeAll($tripId, $gradeId, $select)
    {
        if (!$this->activeOrg) return;

        $trip = Trip::where('organization_id', $this->activeOrg->id)->findOrFail($tripId);
        $grade = Grade::where('organization_id', $this->activeOrg->id)->with('divisions')->findOrFail($gradeId);
        
        $divisionIds = $grade->divisions->pluck('id')->toArray();

        if ($select) {
            $trip->divisions()->syncWithoutDetaching($divisionIds);
        } else {
            $trip->divisions()->detach($divisionIds);
        }

        $this->loadData();
        session()->flash("success-{$tripId}", "All divisions for " . $grade->name . " updated.");
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Trip Mapping') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6">
        @if (!$activeOrg)
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-slate-300 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-3.75-3.75m0 0l-3.75 3.75m3.75-3.75V1.5m10.5 18H3.75" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Active Organization Selected</h4>
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the sidebar to view or manage trip mappings.</p>
            </div>
        @elseif (count($trips) === 0)
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Trips Created Yet</h4>
                <p class="text-slate-500 text-sm mt-1">Please create trips under the <a href="{{ route('organization.trips') }}" class="text-indigo-600 hover:text-indigo-700 font-medium underline">Trips</a> page first before setting up mappings.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($trips as $trip)
                    @php
                        $mappedDivisionIds = $trip->divisions->pluck('id')->toArray();
                    @endphp
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl overflow-hidden flex flex-col h-full" wire:key="trip-card-{{ $trip->id }}">
                        <!-- Card Header -->
                        <div class="px-5 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">{{ $trip->name }}</h3>
                                <span class="text-[10px] text-slate-400">Manage division assignments</span>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ count($mappedDivisionIds) }} Mapped
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-grow flex flex-col gap-5">
                            @if (session()->has("success-{$trip->id}"))
                                <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 text-[10px] rounded-lg px-3 py-2 flex items-center gap-1.5 animate-pulse">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ session("success-{$trip->id}") }}</span>
                                </div>
                            @endif

                            @if (count($grades) === 0)
                                <p class="text-xs text-slate-400 text-center py-4">No Grades & Divisions set up yet. Go to <a href="{{ route('organization.grades-divisions') }}" class="text-indigo-600 hover:underline">Grade & Division</a> page to add some.</p>
                            @else
                                <div class="flex flex-col gap-4 overflow-y-auto max-h-[300px] pr-1">
                                    @foreach ($grades as $grade)
                                        @php
                                            $gradeDivIds = $grade->divisions->pluck('id')->toArray();
                                            $allGradeDivsMapped = count($gradeDivIds) > 0 && empty(array_diff($gradeDivIds, $mappedDivisionIds));
                                        @endphp
                                        <div class="border border-slate-100 rounded-lg p-3 bg-slate-50/50" wire:key="trip-{{ $trip->id }}-grade-{{ $grade->id }}">
                                            <!-- Grade Title & Select All -->
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-xs font-bold text-slate-700">{{ $grade->name }}</span>
                                                @if (count($grade->divisions) > 0)
                                                    <button type="button" 
                                                            wire:click="toggleGradeAll({{ $trip->id }}, {{ $grade->id }}, {{ $allGradeDivsMapped ? 0 : 1 }})"
                                                            class="text-[10px] text-indigo-600 hover:text-indigo-700 font-semibold focus:outline-none select-none">
                                                        {{ $allGradeDivsMapped ? 'Deselect All' : 'Select All' }}
                                                    </button>
                                                @endif
                                            </div>

                                            <!-- Divisions Checklist -->
                                            @if (count($grade->divisions) === 0)
                                                <span class="text-[10px] text-slate-400">No divisions added</span>
                                            @else
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($grade->divisions as $division)
                                                        @php
                                                            $isMapped = in_array($division->id, $mappedDivisionIds);
                                                        @endphp
                                                        <label class="cursor-pointer select-none inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border text-xs transition duration-150 {{ $isMapped ? 'bg-indigo-50 border-indigo-200 text-indigo-700 font-medium' : 'bg-white border-slate-200 text-slate-650 hover:bg-slate-50' }}"
                                                               wire:key="trip-{{ $trip->id }}-div-{{ $division->id }}">
                                                            <input type="checkbox" 
                                                                   class="hidden" 
                                                                   {{ $isMapped ? 'checked' : '' }}
                                                                   wire:click="toggleDivision({{ $trip->id }}, {{ $division->id }})">
                                                            <span>{{ $division->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
