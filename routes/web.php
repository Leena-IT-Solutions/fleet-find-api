<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use Livewire\Volt\Volt;

Volt::route('org/{organization}/join', 'pages.public.org-join')->name('org.join');

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
    Volt::route('organization/organizations', 'pages.organization.organizations')->name('organization.organizations');
    Volt::route('organization/entity-info', 'pages.organization.entity-info')->name('organization.entity-info');
    Volt::route('organization/grades-divisions', 'pages.organization.grades-divisions')->name('organization.grades-divisions');
    Volt::route('organization/access-control', 'pages.organization.access-control')->name('organization.access-control');
    Volt::route('organization/vehicles', 'pages.organization.vehicles')->name('organization.vehicles');
    Volt::route('organization/routes', 'pages.organization.routes-and-stops')->name('organization.routes');
    Volt::route('organization/trips', 'pages.organization.trips')->name('organization.trips');
    Volt::route('organization/trip-mapping', 'pages.organization.trip-mapping')->name('organization.trip-mapping');
    Volt::route('organization/crew', 'pages.organization.crew')->name('organization.crew');
    Volt::route('organization/subscription-plans', 'pages.organization.subscription-plans')->name('organization.subscription-plans');
    Route::view('organization/profile-settings', 'organization-profile')->name('organization.profile-settings');
});

require __DIR__.'/auth.php';
