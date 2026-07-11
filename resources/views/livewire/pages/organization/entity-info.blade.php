<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Organization;
use Livewire\Attributes\On;

new class extends Component
{
    use WithFileUploads;

    public ?Organization $organization = null;
    public string $name = '';
    public string $contactName = '';
    public string $number = '';
    public string $email = '';
    public string $address = '';
    public string $latitude = '';
    public string $longitude = '';
    public $logoFile; // For file uploads
    public ?string $logoPath = null;
    public bool $displayDriverPhone = true;
    public bool $displayAttendantPhone = true;
    public string $shareLocationBy = 'driver';
    public ?string $enrollmentEndDate = null;

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
            if ($this->organization) {
                $this->name = $this->organization->name;
                $this->contactName = $this->organization->contact_name ?? '';
                $this->number = $this->organization->number ?? '';
                $this->email = $this->organization->email ?? '';
                $this->address = $this->organization->address ?? '';
                $this->latitude = $this->organization->latitude ?? '';
                $this->longitude = $this->organization->longitude ?? '';
                $this->logoPath = $this->organization->logo;
                $this->displayDriverPhone = (bool)$this->organization->display_driver_phone;
                $this->displayAttendantPhone = (bool)$this->organization->display_attendant_phone;
                $this->shareLocationBy = $this->organization->share_location_by ?? 'driver';
                $this->enrollmentEndDate = $this->organization->enrollment_end_date ? $this->organization->enrollment_end_date->format('Y-m-d') : null;
            } else {
                $this->resetForm();
            }
        } else {
            $this->resetForm();
        }
    }

    private function resetForm()
    {
        $this->organization = null;
        $this->reset(['name', 'contactName', 'number', 'email', 'address', 'latitude', 'longitude', 'logoFile', 'logoPath', 'displayDriverPhone', 'displayAttendantPhone', 'shareLocationBy', 'enrollmentEndDate']);
    }

    public function updateEntityInfo()
    {
        if (!$this->organization) {
            session()->flash('error', 'No active organization selected.');
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'contactName' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'logoFile' => 'nullable|image|max:1024', // 1MB Max
            'shareLocationBy' => 'required|in:driver,attendant',
            'enrollmentEndDate' => 'nullable|date',
        ]);

        $updateData = [
            'name' => $this->name,
            'contact_name' => $this->contactName ?: null,
            'number' => $this->number ?: null,
            'email' => $this->email ?: null,
            'address' => $this->address ?: null,
            'latitude' => $this->latitude ?: null,
            'longitude' => $this->longitude ?: null,
            'display_driver_phone' => $this->displayDriverPhone,
            'display_attendant_phone' => $this->displayAttendantPhone,
            'share_location_by' => $this->shareLocationBy,
            'enrollment_end_date' => $this->enrollmentEndDate ?: null,
        ];

        if ($this->logoFile) {
            if ($this->organization->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($this->organization->logo);
            }
            $path = $this->logoFile->store('logos', 'public');
            $updateData['logo'] = $path;
            $this->logoPath = $path;
        }

        $this->organization->update($updateData);

        session()->flash('success', 'Entity Information updated successfully.');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Entity Info') }}
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
                <p class="text-slate-500 text-sm mt-1">Please select an organization from the selector in the sidebar to view or edit its Entity Info.</p>
            </div>
        @else
            <form wire:submit.prevent="updateEntityInfo" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left/Middle Columns: Details & Settings -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <!-- Basic Information Card -->
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>General Information</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Organization Name')" />
                                <x-text-input wire:model="name" id="name" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Contact Name -->
                            <div>
                                <x-input-label for="contactName" :value="__('Contact Person')" />
                                <x-text-input wire:model="contactName" id="contactName" type="text" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('contactName')" />
                            </div>

                            <!-- Number -->
                            <div>
                                <x-input-label for="number" :value="__('Phone Number')" />
                                <x-text-input wire:model="number" id="number" type="text" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('number')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input wire:model="email" id="email" type="email" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Address -->
                            <div class="sm:col-span-2">
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea wire:model="address" id="address" rows="3" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm"></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('address')" />
                            </div>
                        </div>
                    </div>

                    <!-- Geolocation Card -->
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Geographical Location</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Latitude -->
                            <div>
                                <x-input-label for="latitude" :value="__('Latitude')" />
                                <x-text-input wire:model="latitude" id="latitude" type="text" class="mt-1 block w-full" placeholder="e.g. 23.0225" />
                                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            </div>

                            <!-- Longitude -->
                            <div>
                                <x-input-label for="longitude" :value="__('Longitude')" />
                                <x-text-input wire:model="longitude" id="longitude" type="text" class="mt-1 block w-full" placeholder="e.g. 72.5714" />
                                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings & Actions -->
                <div class="flex flex-col gap-6">
                    <!-- Branding Card -->
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Entity Logo</span>
                        </h3>

                        <div class="flex flex-col items-center gap-4">
                            <!-- Preview -->
                            <div class="relative w-28 h-28 border border-slate-200 rounded-2xl flex items-center justify-center bg-slate-50 overflow-hidden shadow-inner">
                                @if ($logoFile)
                                    <img src="{{ $logoFile->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif ($logoPath)
                                    <img src="{{ asset('storage/' . $logoPath) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs text-slate-400 font-medium">No Logo</span>
                                @endif
                            </div>

                            <!-- File Input -->
                            <div class="w-full">
                                <input type="file" wire:model="logoFile" id="logoFile" class="hidden">
                                <label for="logoFile" class="block w-full text-center px-4 py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 rounded-lg text-xs font-semibold text-slate-700 cursor-pointer transition shadow-sm">
                                    {{ __('Choose File') }}
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('logoFile')" />
                            </div>
                        </div>
                    </div>

                    <!-- Parent Deep Link Card -->
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                        <h3 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            <span>Parent App Invitation Link</span>
                        </h3>
                        <p class="text-xs text-slate-500 mb-4 leading-normal">
                            Share this link with parents. It opens the FleetFind app if installed, or redirects to download it from the store, pre-linked to your organization.
                        </p>

                        <div x-data="{ copied: false, shareUrl: '{{ route('org.join', $organization->id) }}' }" class="flex flex-col gap-3">
                            <div class="flex gap-2">
                                <input type="text" :value="shareUrl" readonly class="block w-full border border-slate-200 rounded-lg text-xs bg-slate-50 text-slate-500 px-3 py-2.5 focus:outline-none">
                                <button type="button" 
                                        @click="navigator.clipboard.writeText(shareUrl).then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                                        class="px-4 py-2 border border-slate-200 rounded-lg text-xs font-semibold bg-slate-50 hover:bg-slate-100 text-slate-700 transition flex items-center gap-1.5 focus:outline-none select-none shrink-0">
                                    <span x-show="!copied" class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m-6 4h10m-5-5h5M11 12h5m-5 4h5" />
                                        </svg>
                                        <span>Copy</span>
                                    </span>
                                    <span x-show="copied" class="flex items-center gap-1 text-emerald-600 font-bold" style="display: none;">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Copied!</span>
                                    </span>
                                </button>
                            </div>
                            
                            <div class="flex gap-2">
                                <!-- Share on WhatsApp -->
                                <a :href="'https://api.whatsapp.com/send?text=Please%20download%20the%20FleetFind%20app%20to%20track%20our%20bus%20routes%20live.%20Join%20our%20network%20via%20this%20link:%20' + encodeURIComponent(shareUrl)" 
                                   target="_blank"
                                   class="flex-grow text-center py-2 px-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center gap-1.5 focus:outline-none select-none shadow-sm shadow-emerald-600/10">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.665.989 3.3 1.563 5.361 1.564 5.429 0 9.849-4.417 9.852-9.848.002-2.63-1.018-5.1-2.868-6.95C17.093 2.07 14.621.982 12.01.982c-5.432 0-9.853 4.419-9.856 9.852-.001 2.076.547 4.104 1.585 5.9l-.993 3.626 3.71-.974zm12.08-6.945c-.273-.137-1.611-.795-1.86-.884-.249-.09-.43-.136-.61.137-.18.272-.696.884-.853 1.066-.157.18-.314.202-.587.066-.273-.136-1.15-.425-2.193-1.355-.808-.722-1.353-1.616-1.512-1.888-.159-.272-.017-.419.12-.555.123-.122.273-.318.41-.477.136-.159.182-.272.273-.454.09-.18.045-.34-.023-.477-.068-.136-.61-1.477-.835-2.022-.22-.527-.44-.454-.61-.464-.157-.01-.337-.01-.518-.01-.18 0-.476.068-.724.34-.249.273-.951.93-1.951 2.268.22.527-.44-.454-.61-.464-.157-.01-.337-.01-.518-.01-.18 0-.476.068-.724.34-.249.273-.951.93-1.951 2.268 0 .272.362.454.545.681.18.228.362.454.545.681.045.068.09.136.136.204-.317-.454-1.043-1.159-2.043-.659-.545-.228-1.09-.454-1.635-.681.272-.18.454-.363.681-.545.228-.18.454-.363.681-.545.068-.045.136-.09.204-.136z"/>
                                    </svg>
                                    <span>WhatsApp</span>
                                </a>

                                <!-- Share Native -->
                                <button type="button"
                                        @click="if (navigator.share) { navigator.share({ title: 'FleetFind Invitation', text: 'Please download the FleetFind app to track school bus routes live.', url: shareUrl }) } else { alert('Native sharing is not supported in this browser. Please use Copy Link.') }"
                                        class="flex-grow text-center py-2 px-3 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center gap-1.5 focus:outline-none select-none shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 10.742l5.084-2.542m0 0a3 3 0 10-1.242-2.484m1.242 2.484L8.684 13.258m0 0a3 3 0 101.242 2.484m-1.242-2.484l5.084 2.542m0 0a3 3 0 101.242-2.484" />
                                    </svg>
                                    <span>Share</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Config / settings Card -->
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-6">
                        <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            <span>Preferences & Settings</span>
                        </h3>

                        <div class="flex flex-col gap-4">
                            <!-- Display Driver Phone Toggle -->
                            <div class="flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-700">Display Driver Phone</span>
                                    <span class="text-[10px] text-slate-400">Allow parents to view driver phone numbers</span>
                                </div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="displayDriverPhone" class="sr-only peer">
                                    <div class="relative w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <!-- Display Attendant Phone Toggle -->
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-slate-700">Display Attendant Phone</span>
                                    <span class="text-[10px] text-slate-400">Allow parents to view attendant phone numbers</span>
                                </div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="displayAttendantPhone" class="sr-only peer">
                                    <div class="relative w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <!-- Share Location By Select -->
                            <div class="pt-3 border-t border-slate-100">
                                <x-input-label for="shareLocationBy" :value="__('Share Location Via')" />
                                <select wire:model="shareLocationBy" id="shareLocationBy" class="mt-1 block w-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-xs">
                                    <option value="driver">Driver Device</option>
                                    <option value="attendant">Attendant Device</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('shareLocationBy')" />
                            </div>

                            <!-- Enrollment End Date -->
                            <div class="pt-3 border-t border-slate-100">
                                <x-input-label for="enrollmentEndDate" :value="__('Enrollment End Date')" />
                                <x-text-input wire:model="enrollmentEndDate" id="enrollmentEndDate" type="date" class="mt-1 block w-full text-xs" />
                                <x-input-error class="mt-2" :messages="$errors->get('enrollmentEndDate')" />
                            </div>
                        </div>
                    </div>

                    <!-- Save Actions -->
                    <div class="bg-white border border-slate-200/80 shadow-sm rounded-xl p-4 flex justify-end">
                        <button type="submit" 
                                class="w-full text-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition shadow-sm focus:outline-none flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
