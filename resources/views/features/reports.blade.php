<x-guest-layout :plain="true">
    <style>
        .transition-all-300 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .pulse-lime { animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(163, 230, 53, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(163, 230, 53, 0); }
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="min-h-screen bg-[#080B11] text-slate-100 flex flex-col justify-between">
        
        <!-- Header -->
        <header class="sticky top-0 z-40 w-full border-b border-slate-900/60 bg-[#080B11]/85 backdrop-blur-xl transition-all-300 text-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-lime-400 shadow-md shadow-lime-500/20 group-hover:scale-105 transition-all-300">
                        <img src="{{ asset('logo.png') }}" class="h-6 w-auto" alt="WheelsTracker Logo">
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-200">WheelsTracker</span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="/features" class="font-semibold text-lime-400">Features</a>
                    <a href="/solutions" class="text-slate-300 hover:text-lime-400 transition-colors">Solutions</a>
                    <a href="/pricing" class="text-slate-300 hover:text-lime-400 transition-colors">Pricing</a>
                    <a href="/case-studies" class="text-slate-300 hover:text-lime-400 transition-colors">Case Studies</a>
                    <a href="/blog" class="text-slate-300 hover:text-lime-400 transition-colors">Blog</a>
                    <a href="/about" class="text-slate-300 hover:text-lime-400 transition-colors">About</a>
                    <a href="/contact" class="text-slate-300 hover:text-lime-400 transition-colors">Contact</a>
                </nav>
                <div class="flex items-center gap-4">
                    <a href="/login" class="hidden sm:inline-flex text-sm font-semibold text-slate-300 hover:text-lime-400 transition-colors">Sign In</a>
                    <a href="/book-demo" class="pulse-lime px-5 py-2.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm font-semibold shadow-lg shadow-lime-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all-300">Book Demo</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Sub Navigation Header -->
            <section class="bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 pt-12 pb-4 text-center">
                <div class="mx-auto max-w-4xl px-6 space-y-4">
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Reports & Diagnostics</h1>
                    
                    <!-- Horizontal Switches -->
                    <div class="flex justify-start md:justify-center gap-4 border-b border-slate-900/60 pt-8 text-xs sm:text-sm overflow-x-auto whitespace-nowrap scrollbar-none pb-1">
                        <a href="/features/parent-app" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            👶 Parent App
                        </a>
                        <a href="/features/driver-app" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            👨‍✈️ Driver App
                        </a>
                        <a href="/features/school-dashboard" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            🏫 School Dashboard
                        </a>
                        <a href="/features/live-gps-tracking" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            📡 Live GPS Tracking
                        </a>
                        <a href="/features/notifications" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            🔔 Notifications
                        </a>
                        <a href="/features/reports" class="pb-3 text-lime-400 border-b-2 border-lime-400 font-bold px-2 flex-shrink-0">
                            📊 Reports
                        </a>
                    </div>
                </div>
            </section>

            <!-- Interactive Console Mockup -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Text support details -->
                    <div class="lg:col-span-5 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Reports Console Mockup</span>
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">Total Transit Analytics at Your Fingertips.</h2>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Generate high-fidelity daily logs, check driver shift records, inspect distance mileage metrics, and filter trip history data points.
                        </p>
                        <div class="pt-4 flex flex-wrap gap-3">
                            <button onclick="alert('Exporting PDF...')" class="px-5 py-2.5 rounded-xl border border-lime-500/20 bg-lime-950/10 text-lime-400 hover:bg-lime-400 hover:text-slate-950 text-xs font-bold transition-all-300">
                                🖨️ Export PDF
                            </button>
                            <button onclick="alert('Exporting Excel...')" class="px-5 py-2.5 rounded-xl border border-slate-800 bg-slate-900 text-slate-350 hover:bg-slate-800 hover:text-white text-xs font-bold transition-all-300">
                                📊 Export Excel
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: Interactive Report Panel Mockup -->
                    <div class="lg:col-span-7 bg-[#121824] p-6 rounded-3xl border border-slate-850 shadow-2xl space-y-6">
                        <div class="flex flex-wrap gap-2 pb-4 border-b border-slate-850 text-[10px]">
                            <button class="px-3 py-1.5 rounded-lg bg-lime-400 text-slate-950 font-bold">Daily</button>
                            <button class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 font-medium">Monthly</button>
                            <button class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 font-medium">Vehicle</button>
                            <button class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 font-medium">Attendance</button>
                            <button class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 font-medium">Route</button>
                            <button class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 font-medium">Driver</button>
                        </div>

                        <!-- Data table -->
                        <div class="overflow-x-auto text-left">
                            <table class="w-full text-[10px] sm:text-xs">
                                <thead>
                                    <tr class="border-b border-slate-800 text-slate-400">
                                        <th class="py-2">Vehicle ID</th>
                                        <th class="py-2">Route Name</th>
                                        <th class="py-2">Mileage</th>
                                        <th class="py-2">Trip History</th>
                                        <th class="py-2 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-850 text-slate-300">
                                    <tr>
                                        <td class="py-3 font-semibold text-white">Bus #04</td>
                                        <td class="py-3">Oakwood North Loop</td>
                                        <td class="py-3 font-mono">112.4 km</td>
                                        <td class="py-3 text-slate-400">AM / PM Completed</td>
                                        <td class="py-3 text-right text-lime-400 font-bold">✓ Clean</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 font-semibold text-white">Van #11</td>
                                        <td class="py-3">St. Jude's Express</td>
                                        <td class="py-3 font-mono">48.2 km</td>
                                        <td class="py-3 text-slate-400">AM Completed</td>
                                        <td class="py-3 text-right text-lime-400 font-bold">✓ Clean</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 font-semibold text-white">Rickshaw #03</td>
                                        <td class="py-3">Shanti Bazaar Pool</td>
                                        <td class="py-3 font-mono">22.1 km</td>
                                        <td class="py-3 text-slate-400">AM Completed</td>
                                        <td class="py-3 text-right text-lime-400 font-bold">✓ Clean</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Grid of Report Capabilities -->
            <section class="py-16 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Report Suite Modules</span>
                        <h2 class="text-3xl font-bold text-white">Comprehensive Diagnostic Options</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Daily Reports -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-xl">📅</span>
                            <h4 class="text-base font-bold text-white">Daily Reports</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                Review individual daily shift durations, completed checkpoints timestamps, and speed limit violations checklists.
                            </p>
                        </div>

                        <!-- Monthly Reports -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-xl">📆</span>
                            <h4 class="text-base font-bold text-white">Monthly Reports</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                Aggregate monthly fleet performance grades, total operational mileage summaries, and driver compliance ratings.
                            </p>
                        </div>

                        <!-- Vehicle Reports -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-xl">🚌</span>
                            <h4 class="text-base font-bold text-white">Vehicle Reports</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                Track diesel consumption stats, vehicle idle times, geofencing counts, and scheduled mechanic maintenance warnings.
                            </p>
                        </div>

                        <!-- Attendance Reports -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-xl">📇</span>
                            <h4 class="text-base font-bold text-white">Attendance Reports</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                Inspect student boarding scan logs, absent list timelines, and check-in confirmation logs for parents audits.
                            </p>
                        </div>

                        <!-- Route Reports -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-xl">🗺️</span>
                            <h4 class="text-base font-bold text-white">Route Reports</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                Audit path deviations notifications, stop timing records, and coordinates accuracy metrics per assigned route.
                            </p>
                        </div>

                        <!-- Driver Reports -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-xl">👨‍✈️</span>
                            <h4 class="text-base font-bold text-white">Driver Reports</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">
                                Measure acceleration levels, harsh braking telemetry records, shift on-time grades, and parent feedback ratings.
                            </p>
                        </div>

                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-[#05070A] text-slate-400 py-12 border-t border-slate-950">
            <div class="mx-auto max-w-7xl px-6 text-center space-y-4">
                <p class="text-sm font-medium">&copy; {{ date('Y') }} WheelsTracker. All rights reserved.</p>
                <div class="flex justify-center gap-6 text-xs">
                    <a href="/features" class="hover:text-lime-400">Features</a>
                    <a href="/solutions" class="hover:text-lime-400">Solutions</a>
                    <a href="/pricing" class="hover:text-lime-400">Pricing</a>
                    <a href="/privacy-policy" class="hover:text-lime-400">Privacy Policy</a>
                    <a href="/terms-conditions" class="hover:text-lime-400">Terms & Conditions</a>
                    <a href="/contact" class="hover:text-lime-400">Contact</a>
                </div>
            </div>
        </footer>

    </div>
</x-guest-layout>
