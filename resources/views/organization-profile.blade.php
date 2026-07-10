@if (!auth()->user()->hasRole('Organization'))
    @php abort(403, 'Unauthorized access.'); @endphp
@endif

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-6">
        <div class="max-w-3xl space-y-6">
            <div class="p-6 bg-white border border-slate-200/80 shadow-sm rounded-xl">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-6 bg-white border border-slate-200/80 shadow-sm rounded-xl">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-6 bg-white border border-slate-200/80 shadow-sm rounded-xl">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
