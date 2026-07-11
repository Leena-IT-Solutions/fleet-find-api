<?php

use App\Models\Organization;
use App\Models\Grade;
use App\Models\Division;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

new class extends Component
{
    use WithPagination;

    public ?Organization $organization = null;
    public string $search = '';
    public int $perPage = 6;

    // Add Grade Form
    public string $newGradeName = '';
    public string $newDivisionInput = '';
    public array $newDivisions = []; // Array of strings
    public bool $showAddGradeModal = false;

    // Edit Grade Form
    public ?int $editingGradeId = null;
    public string $editingGradeName = '';
    public string $editingDivisionInput = '';
    public array $editingDivisions = []; // Array of ['id' => int|null, 'name' => string]
    public bool $showEditGradeModal = false;

    // Delete Grade Form
    public ?int $deletingGradeId = null;
    public bool $showDeleteGradeModal = false;

    public function rendering($view)
    {
        $view->layout('layouts.app');
    }

    public function mount(): void
    {
        $this->loadOrganization();
    }

    public function loadOrganization(): void
    {
        $activeOrgId = session('active_organization_id');
        if ($activeOrgId) {
            $this->organization = auth()->user()->organizations()->find($activeOrgId);
        } else {
            $this->organization = null;
        }
        $this->resetPage();
    }

    public function loadMore(): void
    {
        $this->perPage += 6;
    }

    // --- Add Grade Form Actions ---

    public function openAddGradeModal(): void
    {
        $this->reset(['newGradeName', 'newDivisionInput', 'newDivisions']);
        $this->showAddGradeModal = true;
        $this->dispatch('open-modal', 'add-grade-modal');
    }

    public function closeAddGradeModal(): void
    {
        $this->showAddGradeModal = false;
        $this->dispatch('close-modal', 'add-grade-modal');
    }

    public function addDivisionToAddForm(): void
    {
        $val = trim($this->newDivisionInput);
        if (empty($val)) {
            $this->addError('newDivisionInput', 'Division name cannot be empty.');
            return;
        }

        if (in_array(strtolower($val), array_map('strtolower', $this->newDivisions))) {
            $this->addError('newDivisionInput', 'This division is already added.');
            return;
        }

        $this->newDivisions[] = $val;
        $this->newDivisionInput = '';
        $this->resetErrorBag('newDivisionInput');
    }

    public function removeDivisionFromAddForm(int $index): void
    {
        if (isset($this->newDivisions[$index])) {
            unset($this->newDivisions[$index]);
            $this->newDivisions = array_values($this->newDivisions);
        }
    }

    public function createGrade(): void
    {
        if (!$this->organization) {
            return;
        }

        $this->validate([
            'newGradeName' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('grades', 'name')
                    ->where('organization_id', $this->organization->id),
            ],
        ], [
            'newGradeName.unique' => 'This grade has already been added to this organization.',
        ]);

        DB::transaction(function () {
            $grade = $this->organization->grades()->create([
                'name' => $this->newGradeName,
            ]);

            foreach ($this->newDivisions as $divName) {
                $grade->divisions()->create([
                    'name' => $divName,
                ]);
            }
        });

        $this->closeAddGradeModal();
        session()->flash('success', 'Grade and divisions created successfully.');
    }

    // --- Edit Grade Form Actions ---

    public function openEditGradeModal(int $id): void
    {
        $grade = Grade::with('divisions')->findOrFail($id);
        $this->editingGradeId = $grade->id;
        $this->editingGradeName = $grade->name;
        $this->editingDivisionInput = '';
        $this->editingDivisions = $grade->divisions->map(fn($d) => [
            'id' => $d->id,
            'name' => $d->name,
        ])->toArray();

        $this->showEditGradeModal = true;
        $this->dispatch('open-modal', 'edit-grade-modal');
    }

    public function closeEditGradeModal(): void
    {
        $this->showEditGradeModal = false;
        $this->dispatch('close-modal', 'edit-grade-modal');
        $this->reset(['editingGradeId', 'editingGradeName', 'editingDivisionInput', 'editingDivisions']);
    }

    public function addDivisionToEditForm(): void
    {
        $val = trim($this->editingDivisionInput);
        if (empty($val)) {
            $this->addError('editingDivisionInput', 'Division name cannot be empty.');
            return;
        }

        $existingNames = array_map('strtolower', array_column($this->editingDivisions, 'name'));
        if (in_array(strtolower($val), $existingNames)) {
            $this->addError('editingDivisionInput', 'This division is already added.');
            return;
        }

        $this->editingDivisions[] = [
            'id' => null,
            'name' => $val,
        ];
        $this->editingDivisionInput = '';
        $this->resetErrorBag('editingDivisionInput');
    }

    public function removeDivisionFromEditForm(int $index): void
    {
        if (isset($this->editingDivisions[$index])) {
            unset($this->editingDivisions[$index]);
            $this->editingDivisions = array_values($this->editingDivisions);
        }
    }

    public function updateGrade(): void
    {
        if (!$this->organization) {
            return;
        }

        $grade = Grade::findOrFail($this->editingGradeId);

        $this->validate([
            'editingGradeName' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('grades', 'name')
                    ->where('organization_id', $this->organization->id)
                    ->ignore($grade->id),
            ],
        ], [
            'editingGradeName.unique' => 'This grade name is already in use.',
        ]);

        DB::transaction(function () use ($grade) {
            $grade->update([
                'name' => $this->editingGradeName,
            ]);

            // Sync divisions
            $keepIds = array_filter(array_column($this->editingDivisions, 'id'));
            
            // Delete divisions that are removed
            $grade->divisions()->whereNotIn('id', $keepIds)->delete();

            // Insert new divisions
            foreach ($this->editingDivisions as $div) {
                if (is_null($div['id'])) {
                    $grade->divisions()->create([
                        'name' => $div['name'],
                    ]);
                }
            }
        });

        $this->closeEditGradeModal();
        session()->flash('success', 'Grade updated successfully.');
    }

    // --- Delete Grade Actions ---

    public function openDeleteGradeModal(int $id): void
    {
        $this->deletingGradeId = $id;
        $this->showDeleteGradeModal = true;
        $this->dispatch('open-modal', 'delete-grade-modal');
    }

    public function closeDeleteGradeModal(): void
    {
        $this->showDeleteGradeModal = false;
        $this->dispatch('close-modal', 'delete-grade-modal');
        $this->reset(['deletingGradeId']);
    }

    public function deleteGrade(): void
    {
        $grade = Grade::findOrFail($this->deletingGradeId);
        $grade->delete();
        $this->closeDeleteGradeModal();
        session()->flash('success', 'Grade and its divisions deleted successfully.');
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
                'grades' => collect(),
                'hasMore' => false
            ];
        }

        $query = $this->organization->grades();

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where('name', 'like', $term);
        }

        $totalCount = $query->count();
        $grades = $query->with('divisions')->latest()->take($this->perPage)->get();
        $hasMore = $totalCount > $this->perPage;

        return [
            'grades' => $grades,
            'hasMore' => $hasMore
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Grade & Division') }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.142" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6.75M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                </svg>
                <h4 class="text-base font-semibold text-slate-800">No Active Organization Selected</h4>
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the selector in the sidebar to manage grades & divisions.</p>
            </div>
        @else
            <!-- Search & Add Actions -->
            <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-5 flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="w-full flex-grow relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Search grades by name..." 
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

                    <button wire:click="openAddGradeModal" 
                            class="w-full sm:w-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition duration-150 flex items-center justify-center gap-2 shadow-sm focus:outline-none">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Add Grade</span>
                    </button>
                </div>
            </div>

            <!-- Grades Grid -->
            @if ($grades->isEmpty())
                <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-12 text-center flex flex-col items-center justify-center">
                    <p class="text-slate-500 text-sm">No grades found. Create one to start assigning divisions.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($grades as $grade)
                        <div wire:key="grade-card-{{ $grade->id }}" class="bg-white border border-slate-200 rounded-xl shadow-sm flex flex-col justify-between overflow-hidden">
                            <!-- Card Header -->
                            <div class="p-5 flex items-center justify-between">
                                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <span>{{ $grade->name }}</span>
                                </h3>
                                
                                <div class="flex items-center gap-1">
                                    <button wire:click="openEditGradeModal({{ $grade->id }})" 
                                            title="Edit Grade & Divisions"
                                            class="p-1.5 hover:bg-slate-100 text-slate-400 hover:text-slate-700 rounded-lg transition focus:outline-none">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button wire:click="openDeleteGradeModal({{ $grade->id }})" 
                                            title="Delete Grade"
                                            class="p-1.5 hover:bg-rose-50 text-slate-400 hover:text-rose-600 rounded-lg transition focus:outline-none">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Body: Divisions list -->
                            <div class="px-5 pb-5">
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Divisions</div>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse ($grade->divisions as $division)
                                        <span wire:key="division-tag-{{ $division->id }}" 
                                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            {{ $division->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">No divisions assigned.</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($hasMore)
                    <div class="flex justify-center mt-6">
                        <button wire:click="loadMore" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 hover:text-slate-900 rounded-lg text-xs font-semibold transition duration-150 shadow-sm focus:outline-none">
                            Load More Grades
                        </button>
                    </div>
                @endif
            @endif
        @endif
    </div>

    <!-- Add Grade Modal -->
    <x-modal name="add-grade-modal" :show="$showAddGradeModal" focusable>
        <form wire:submit.prevent="createGrade" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Add New Grade') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Specify a name for the new grade and add its divisions.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <div>
                    <x-input-label for="newGradeName" :value="__('Grade Name')" />
                    <x-text-input wire:model="newGradeName" id="newGradeName" type="text" class="mt-1 block w-full" placeholder="e.g. Grade 1" required />
                    <x-input-error :messages="$errors->get('newGradeName')" class="mt-2" />
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <x-input-label :value="__('Divisions')" />
                    
                    <!-- Division Pills Input & Display -->
                    <div class="mt-2 flex flex-wrap gap-1.5 p-3 border border-slate-200 rounded-lg bg-slate-50/50 min-h-[48px]">
                        @forelse ($newDivisions as $index => $divName)
                            <span wire:key="new-div-pill-{{ $index }}" 
                                  class="inline-flex items-center gap-1.5 pl-2.5 pr-1 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <span>{{ $divName }}</span>
                                <button type="button" 
                                        wire:click="removeDivisionFromAddForm({{ $index }})" 
                                        class="p-0.5 rounded-full hover:bg-indigo-100 text-indigo-400 hover:text-indigo-600 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        @empty
                            <span class="text-xs text-slate-400 italic">No divisions added yet. Use the field below to add divisions.</span>
                        @endforelse
                    </div>

                    <!-- Add Division Form field inside modal -->
                    <div class="mt-3 flex gap-2 items-center">
                        <div class="flex-grow">
                            <input type="text" 
                                   wire:model="newDivisionInput" 
                                   wire:keydown.enter.prevent="addDivisionToAddForm"
                                   placeholder="Add division (e.g. A)" 
                                   class="block w-full border border-slate-200 rounded-lg text-sm bg-white text-slate-800 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        </div>
                        <button type="button" 
                                wire:click="addDivisionToAddForm" 
                                class="px-4 py-2 bg-slate-850 hover:bg-slate-900 text-white rounded-lg text-sm font-semibold transition duration-150 shadow-sm focus:outline-none">
                            Add
                        </button>
                    </div>
                    @error('newDivisionInput')
                        <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-4">
                <x-secondary-button wire:click="closeAddGradeModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Grade') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Edit Grade Modal -->
    <x-modal name="edit-grade-modal" :show="$showEditGradeModal" focusable>
        <form wire:submit.prevent="updateGrade" class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Edit Grade & Divisions') }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ __('Modify the grade name and manage its divisions.') }}
            </p>

            <div class="mt-6 flex flex-col gap-4">
                <div>
                    <x-input-label for="editingGradeName" :value="__('Grade Name')" />
                    <x-text-input wire:model="editingGradeName" id="editingGradeName" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('editingGradeName')" class="mt-2" />
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <x-input-label :value="__('Divisions')" />
                    
                    <!-- Division Pills display inside Edit modal -->
                    <div class="mt-2 flex flex-wrap gap-1.5 p-3 border border-slate-200 rounded-lg bg-slate-50/50 min-h-[48px]">
                        @forelse ($editingDivisions as $index => $div)
                            <span wire:key="edit-div-pill-{{ $index }}" 
                                  class="inline-flex items-center gap-1.5 pl-2.5 pr-1 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <span>{{ $div['name'] }}</span>
                                <button type="button" 
                                        wire:click="removeDivisionFromEditForm({{ $index }})" 
                                        class="p-0.5 rounded-full hover:bg-indigo-100 text-indigo-400 hover:text-indigo-600 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        @empty
                            <span class="text-xs text-slate-400 italic">No divisions added yet. Use the field below to add divisions.</span>
                        @endforelse
                    </div>

                    <!-- Add Division Form field inside Edit modal -->
                    <div class="mt-3 flex gap-2 items-center">
                        <div class="flex-grow">
                            <input type="text" 
                                   wire:model="editingDivisionInput" 
                                   wire:keydown.enter.prevent="addDivisionToEditForm"
                                   placeholder="Add division (e.g. A)" 
                                   class="block w-full border border-slate-200 rounded-lg text-sm bg-white text-slate-800 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-150">
                        </div>
                        <button type="button" 
                                wire:click="addDivisionToEditForm" 
                                class="px-4 py-2 bg-slate-850 hover:bg-slate-900 text-white rounded-lg text-sm font-semibold transition duration-150 shadow-sm focus:outline-none">
                            Add
                        </button>
                    </div>
                    @error('editingDivisionInput')
                        <span class="text-xs text-rose-600 font-medium mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-4">
                <x-secondary-button wire:click="closeEditGradeModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Grade Modal -->
    <x-modal name="delete-grade-modal" :show="$showDeleteGradeModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Are you sure you want to delete this grade?') }}
            </h2>

            <p class="mt-1 text-sm text-rose-600 font-medium bg-rose-50 border border-rose-100 rounded-xl p-3">
                {{ __('Warning: Deleting this grade will also delete all of its divisions. This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button wire:click="closeDeleteGradeModal">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button wire:click="deleteGrade" class="inline-flex items-center px-4 py-2 bg-rose-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-500 active:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3">
                    {{ __('Delete Grade') }}
                </button>
            </div>
        </div>
    </x-modal>
</div>
