<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FleetFind - Fleet Tracker</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .hero-glow {
                background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.15) 0%, rgba(0, 0, 0, 0) 50%);
            }
            .glassmorphism {
                background: rgba(15, 23, 42, 0.65);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
        </style>
    </head>
    <body class="antialiased bg-slate-950 text-slate-100 min-h-screen relative overflow-x-hidden flex flex-col justify-between selection:bg-indigo-500 selection:text-white">
        <!-- Background Glows -->
        <div class="absolute inset-0 hero-glow pointer-events-none z-0"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px] pointer-events-none z-0"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

        <!-- Header -->
        <header class="relative w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" class="h-10 w-auto rounded-lg shadow-lg border border-slate-800" alt="FleetFind Logo">
                <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">FleetFind</span>
            </div>

            @if (Route::has('login'))
                <div class="flex items-center">
                    <livewire:welcome.navigation />
                </div>
            @endif
        </header>

        <!-- Main Hero Section -->
        <main class="relative flex-grow flex items-center justify-center px-6 z-10">
            <div class="max-w-xl w-full text-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                    Fleet Tracker
                </div>

                <!-- Headline -->
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-4">
                    Track & Manage Your <br>
                    <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent">Fleet in Real-Time</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-slate-400 text-base md:text-lg mb-8 max-w-md mx-auto leading-relaxed">
                    Sleek, lightweight, and modern tools to monitor, optimize, and organize your fleet logistics operations.
                </p>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-medium shadow-lg shadow-indigo-600/20 transition-all duration-200">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-medium shadow-lg shadow-indigo-600/20 transition-all duration-200">
                            Get Started
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 font-medium border border-slate-800 transition-all duration-200">
                                Register Account
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative w-full max-w-7xl mx-auto px-6 py-6 text-center text-slate-600 text-xs z-10 border-t border-slate-900/50">
            <p>&copy; {{ date('Y') }} FleetFind. All rights reserved.</p>
        </footer>
    </body>
</html>
