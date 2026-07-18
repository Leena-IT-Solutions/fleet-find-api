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
                        <div class="pt-4 flex flex-wrap gap-3 select-none">
                            <div class="px-5 py-2.5 rounded-xl border border-lime-500/20 bg-lime-950/10 text-lime-400 text-xs font-bold">
                                🖨️ Export PDF
                            </div>
                            <div class="px-5 py-2.5 rounded-xl border border-slate-800 bg-slate-900/50 text-slate-400 text-xs font-bold">
                                📊 Export Excel
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: High-Fidelity Reports Dashboard Preview -->
                    <div class="lg:col-span-7 relative group">
                        <!-- Glowing accent behind image -->
                        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-lime-500/20 to-blue-500/20 opacity-40 blur-xl group-hover:opacity-60 transition duration-1000"></div>
                        
                        <div class="relative rounded-2xl border border-slate-800 bg-[#0C101A] overflow-hidden shadow-2xl transition duration-300 transform group-hover:scale-[1.01]">
                            <!-- Browser/App Header controls -->
                            <div class="bg-slate-950 px-4 py-3 border-b border-slate-900 flex items-center gap-2">
                                <div class="flex gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500/40"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500/40"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500/40"></span>
                                </div>
                                <div class="bg-slate-900/60 rounded-md text-[9px] text-slate-500 px-3 py-0.5 mx-auto font-mono">
                                    admin.wheelstracker.com/reports
                                </div>
                            </div>
                            <!-- Image display -->
                            <img src="{{ asset('images/reports_dashboard_preview.png') }}" class="w-full h-auto object-cover animate-fade-in" alt="WheelsTracker Reports Dashboard Interface">
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
        <x-footer />

    </div>
</x-guest-layout>
