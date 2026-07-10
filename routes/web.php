<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use Livewire\Volt\Volt;

Route::middleware(['auth', 'web-roles'])->group(function () {
    Route::get('administrator', function () {
        $totalUsers = \App\Models\User::count();
        $totalOrgs = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Organization'))->count();
        $totalDrivers = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Driver'))->count();
        $totalAttendants = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Attendant'))->count();
        $totalParents = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Parent'))->count();
        $totalChildren = \App\Models\Child::count();

        return view('dashboard', compact(
            'totalUsers',
            'totalOrgs',
            'totalDrivers',
            'totalAttendants',
            'totalParents',
            'totalChildren'
        ));
    })->name('administrator');
    Route::view('profile', 'profile')->name('profile');
    Volt::route('users', 'pages.users.index')->name('users.index');
    Volt::route('settings', 'pages.settings.index')->name('settings.index');
});

Route::middleware(['auth'])->group(function () {
    Volt::route('organization/dashboard', 'pages.organization.dashboard')->name('organization.dashboard');
    Volt::route('organization/profile', 'pages.organization.profile')->name('organization.profile');
    Route::view('organization/profile-settings', 'organization-profile')->name('organization.profile-settings');
});

require __DIR__.'/auth.php';
