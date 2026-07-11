<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FleetFind') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

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
                        <div class="w-full py-5 px-6 sm:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                {{ $header }}
                            </div>
                            <div x-data="{ 
                                     dateTime: '', 
                                     updateTime() {
                                         const now = new Date();
                                         const options = { 
                                             year: 'numeric', 
                                             month: 'short', 
                                             day: 'numeric',
                                             hour: '2-digit', 
                                             minute: '2-digit', 
                                             second: '2-digit',
                                             hour12: true 
                                         };
                                         this.dateTime = now.toLocaleString('en-US', options);
                                     } 
                                 }" 
                                 x-init="updateTime(); setInterval(() => updateTime(), 1000)" 
                                 class="text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-100 rounded-lg px-3 py-1.5 shadow-sm inline-flex items-center gap-1.5 self-start sm:self-auto">
                                <svg class="w-3.5 h-3.5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="dateTime"></span>
                            </div>
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
