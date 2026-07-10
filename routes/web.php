<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use Livewire\Volt\Volt;

Route::middleware(['auth', 'web-roles'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Volt::route('users', 'pages.users.index')->name('users.index');
});

require __DIR__.'/auth.php';
