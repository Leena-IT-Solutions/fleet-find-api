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
            
            <!-- Hero -->
            <section class="relative py-24 sm:py-32 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-7xl px-6 relative z-10 text-center space-y-8">
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-lime-950/20 border border-lime-500/30 text-lime-400 text-xs font-bold uppercase tracking-widest">
                        🛠️ CORE FEATURES DIRECTORY
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        Explore Our Advanced <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Tracking Capabilities.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        WheelsTracker connects school owners, fleet operators, drivers, and parents in a unified B2B tracking matrix. Choose a module below to inspect its sub-features.
                    </p>
                </div>
            </section>

            <!-- Features Grid (6 Cards) -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Card 1: Parent App -->
                        <a href="/features/parent-app" class="group bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left flex flex-col justify-between min-h-[250px] shadow-lg">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-all-300">📱</div>
                                <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Parent App</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Live passenger ETAs status tracking maps, coordinates checks, and automatic RFID drop push alerts.
                                </p>
                            </div>
                            <span class="text-lime-400 text-xs font-bold uppercase tracking-wider flex items-center gap-2 pt-4">Explore Parent App ➔</span>
                        </a>

                        <!-- Card 2: Driver App -->
                        <a href="/features/driver-app" class="group bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left flex flex-col justify-between min-h-[250px] shadow-lg">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-all-300">👨‍✈️</div>
                                <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Driver App</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    One-tap transit start/stop controls, automatic coordinates streaming, and simplified passenger checklists.
                                </p>
                            </div>
                            <span class="text-lime-400 text-xs font-bold uppercase tracking-wider flex items-center gap-2 pt-4">Explore Driver App ➔</span>
                        </a>

                        <!-- Card 3: School Dashboard -->
                        <a href="/features/school-dashboard" class="group bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left flex flex-col justify-between min-h-[250px] shadow-lg">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-all-300">🏫</div>
                                <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">School Dashboard</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Central fleet status dashboards, assign route networks schedules, and manage active passenger lists.
                                </p>
                            </div>
                            <span class="text-lime-400 text-xs font-bold uppercase tracking-wider flex items-center gap-2 pt-4">Explore Dashboard ➔</span>
                        </a>

                        <!-- Card 4: Live GPS Tracking -->
                        <a href="/features/live-gps-tracking" class="group bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left flex flex-col justify-between min-h-[250px] shadow-lg">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-all-300">📡</div>
                                <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Live GPS Tracking</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Low-latency GPS tracking coordinates polling, geofence alarm alerts, and historical path audits.
                                </p>
                            </div>
                            <span class="text-lime-400 text-xs font-bold uppercase tracking-wider flex items-center gap-2 pt-4">Explore GPS Tracking ➔</span>
                        </a>

                        <!-- Card 5: Notifications -->
                        <a href="/features/notifications" class="group bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left flex flex-col justify-between min-h-[250px] shadow-lg">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-all-300">🔔</div>
                                <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Notifications</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Instant overspeeding flags, passenger proximity alerts, and B2B emergency SOS broadcasts.
                                </p>
                            </div>
                            <span class="text-lime-400 text-xs font-bold uppercase tracking-wider flex items-center gap-2 pt-4">Explore Notifications ➔</span>
                        </a>

                        <!-- Card 6: Reports -->
                        <a href="/features/reports" class="group bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left flex flex-col justify-between min-h-[250px] shadow-lg">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-all-300">📊</div>
                                <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Reports</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Automated diesel fuel efficiency metrics logs, driver shift timesheets, and drop-complete checklists audits.
                                </p>
                            </div>
                            <span class="text-lime-400 text-xs font-bold uppercase tracking-wider flex items-center gap-2 pt-4">Explore Reports ➔</span>
                        </a>

                    </div>
                </div>
            </section>

        </main>

        <!-- Footer -->
        <x-footer />

    </div>
</x-guest-layout>
