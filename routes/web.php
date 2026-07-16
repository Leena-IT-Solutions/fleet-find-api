<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('/parent-app', function() {
    return view('features', ['activeTab' => 'parent']);
})->name('parent-app');

Route::get('/driver-app', function() {
    return view('features', ['activeTab' => 'driver']);
})->name('driver-app');

Route::view('/features', 'features')->name('features');
Route::view('/features/parent-app', 'features.parent-app')->name('features.parent-app');
Route::view('/features/driver-app', 'features.driver-app')->name('features.driver-app');
Route::view('/features/school-dashboard', 'features.school-dashboard')->name('features.school-dashboard');
Route::view('/features/live-gps-tracking', 'features.live-gps-tracking')->name('features.live-gps-tracking');
Route::view('/features/notifications', 'features.notifications')->name('features.notifications');
Route::view('/features/reports', 'features.reports')->name('features.reports');
Route::view('/school-bus-tracking-software', 'landing.school-bus-tracking-software')->name('landing.school-bus-tracking-software');
Route::view('/solutions', 'solutions')->name('solutions');
Route::view('/solutions/schools', 'solutions.schools')->name('solutions.schools');
Route::view('/solutions/school-bus-operators', 'solutions.school-bus-operators')->name('solutions.school-bus-operators');
Route::view('/solutions/van-operators', 'solutions.van-operators')->name('solutions.van-operators');
Route::view('/solutions/auto-rickshaw-operators', 'solutions.auto-rickshaw-operators')->name('solutions.auto-rickshaw-operators');
Route::view('/solutions/transport-contractors', 'solutions.transport-contractors')->name('solutions.transport-contractors');
Route::view('/pricing', 'pricing')->name('pricing');
Route::view('/case-studies', 'case-studies')->name('case-studies');
Route::view('/blog', 'blog')->name('blog');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/book-demo', 'book-demo')->name('book-demo');
Route::view('/privacy-policy', 'privacy-policy')->name('privacy-policy');
Route::view('/terms-conditions', 'terms-conditions')->name('terms-conditions');

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
