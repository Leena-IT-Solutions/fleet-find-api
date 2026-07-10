<x-guest-layout :plain="true">
    <!-- Header -->
    <header class="relative w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" class="h-10 w-auto rounded-lg shadow-lg border border-slate-200 logo-spin" alt="FleetFind Logo">
            <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-indigo-600 to-cyan-600 bg-clip-text text-transparent">FleetFind</span>
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
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold uppercase tracking-wider mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                Fleet Tracker
            </div>

            <!-- Headline -->
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-slate-900 mb-4">
                Track & Manage Your <br>
                <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent">Fleet in Real-Time</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-slate-600 text-base md:text-lg mb-8 max-w-md mx-auto leading-relaxed">
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
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3 rounded-lg bg-white hover:bg-slate-50 text-slate-700 font-medium border border-slate-200 shadow-sm transition-all duration-200">
                            Register Account
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative w-full max-w-7xl mx-auto px-6 py-6 text-center text-slate-400 text-xs z-10 border-t border-slate-200">
        <p>&copy; {{ date('Y') }} FleetFind. All rights reserved.</p>
    </footer>
</x-guest-layout>
