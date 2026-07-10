<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
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
            .hero-glow {
                background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.15) 0%, rgba(0, 0, 0, 0) 50%);
            }
        </style>
    </head>
    <body class="antialiased bg-slate-950 text-slate-100 min-h-screen relative overflow-x-hidden flex flex-col justify-between selection:bg-indigo-500 selection:text-white">
        <!-- Background Glows -->
        <div class="absolute inset-0 hero-glow pointer-events-none z-0"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

        <div class="relative z-10 flex-grow flex flex-col justify-between">
            @if ($plain ?? false)
                {{ $slot }}
            @else
                <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                    <div>
                        <a href="/" wire:navigate>
                            <x-application-logo class="w-16 h-16 rounded-xl shadow-lg border border-slate-800" />
                        </a>
                    </div>

                    <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-slate-900/40 backdrop-blur-xl border border-slate-800/80 shadow-2xl shadow-slate-950/80 overflow-hidden rounded-2xl">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </div>
    </body>
</html>
