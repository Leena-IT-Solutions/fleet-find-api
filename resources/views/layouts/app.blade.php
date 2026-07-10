<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FleetFind') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col md:flex-row bg-slate-50">
            <!-- Sidebar Navigation (Desktop sidebar and Mobile top header in one component) -->
            <livewire:layout.navigation />

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white border-b border-slate-200">
                        <div class="max-w-7xl mx-auto py-5 px-6 sm:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-grow p-6 sm:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
