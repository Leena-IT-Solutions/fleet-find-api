<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use Livewire\Volt\Volt;

Route::middleware(['auth', 'web-roles'])->group(function () {
    Route::get('dashboard', function () {
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
    })->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Volt::route('users', 'pages.users.index')->name('users.index');
});

require __DIR__.'/auth.php';
