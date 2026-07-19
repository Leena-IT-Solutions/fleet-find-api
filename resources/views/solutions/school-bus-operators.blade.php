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
                    <a href="/features" class="text-slate-300 hover:text-lime-400 transition-colors">Features</a>
                    <a href="/solutions" class="font-semibold text-lime-400">Solutions</a>
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
            
            <!-- Hero Header -->
            <section class="relative py-24 sm:py-32 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-7xl px-6 relative z-10 text-center space-y-8">
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-lime-950/20 border border-lime-500/30 text-lime-400 text-xs font-bold uppercase tracking-widest">
                        💼 FOR BUS CONTRACTORS & OPERATORS
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        GPS & Fleet Management <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">For School Bus Operators.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Scale your B2B transit operations, win school contracts, verify driver compliance routes, and offer white-label trackers tools.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Schedule A Demo
                        </a>
                        <a href="/contact" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Contact Sales
                        </a>
                    </div>
                </div>
            </section>

            <!-- Key Offerings / Switch Modules Navigation -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="text-center max-w-3xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Solution Suite</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Operator Core Modules</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            A robust ecosystem designed to coordinate contractor dispatch workflows and satisfy school boards audits.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <!-- Module 1 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">🚛</span>
                            <h4 class="text-sm font-bold text-white">Fleet Tracking</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Live status, active stops diagnostics, and coordinate updates.</p>
                        </div>
                        <!-- Module 2 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">📊</span>
                            <h4 class="text-sm font-bold text-white">Trip Reports</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Detailed fuel audits, delay logs, and Excel rosters exports.</p>
                        </div>
                        <!-- Module 3 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">📍</span>
                            <h4 class="text-sm font-bold text-white">GPS Route Optimization</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">AI routing loops to minimize vehicle diesel cost.</p>
                        </div>
                        <!-- Module 4 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">👤</span>
                            <h4 class="text-sm font-bold text-white">Driver Monitoring</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Overspeed compliance scoring and instant SOS alarms.</p>
                        </div>
                        <!-- Module 5 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">📱</span>
                            <h4 class="text-sm font-bold text-white">Parent App</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Self-service proximity notifications to relieve dispatch boards.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 1: Fleet Tracking -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Fleet Tracking</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Live Fleet Commands Panel</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Monitor 10 to 1,000+ vehicles under a unified grid. Check live coordinates, see ignition states, trace vehicle health diagnostics, and dispatch backup buses instantly when delays occur.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Complete timeline diagnostics for every active bus route</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Interactive status tags (Online, Idle, Stop, Offline)</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">Live Fleet Roster Status</h4>
                        <div class="space-y-2">
                            <div class="bg-[#1C273E] p-2.5 rounded flex justify-between text-[10px]">
                                <span>🚌 Bus Operator #41</span>
                                <span class="text-emerald-400 font-bold">ACTIVE (Sector 4 Route)</span>
                            </div>
                            <div class="bg-[#1C273E] p-2.5 rounded flex justify-between text-[10px]">
                                <span>🚌 Bus Operator #18</span>
                                <span class="text-amber-400 font-bold">IDLING (12 Mins Stop)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 2: Trip Reports -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 order-last lg:order-first shadow-xl">
                        <h4 class="text-xs font-bold text-white">Monthly Analytics Export</h4>
                        <div class="space-y-2 text-[10px] text-slate-400">
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>Total Trips:</span><span class="text-white font-bold">148 Trips</span></div>
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>Idle Ratio:</span><span class="text-white font-bold">4.2% (Fuel optimized)</span></div>
                            <div class="flex justify-between"><span>On-Time Compliance:</span><span class="text-emerald-400 font-bold">98.4%</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">02 / Trip Reports</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Automated B2B Compliance Analytics</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Generate PDF audit timelines matching schools requirements. Confirm exact drop-off timings, verify delay parameters, and export mileage registers worksheets for monthly billing cycles.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Download CSV datasets for vehicle maintenance checks</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Interactive maps routing logs stored for 365 days</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 3: GPS -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">03 / GPS</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">High-Precision GPS & AI Routing</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Minimize transit overheads. Our high-precision GPS tracing module analyzes real-time traffic status, maps the fastest multi-stop pickup sequences, and saves up to 15% on monthly fuel usage.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Sub-second coordinates polling accuracy</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Auto-re-routing updates triggered on major traffic blockages</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">AI Route Optimization</h4>
                        <div class="bg-[#1C273E] p-3.5 rounded-xl border border-slate-850 flex justify-between items-center text-[10px]">
                            <div>
                                <span class="text-slate-450 block text-[8px] uppercase">Fuel Cost Drop</span>
                                <span class="text-emerald-400 font-black text-base">-15.4%</span>
                            </div>
                            <div>
                                <span class="text-slate-450 block text-[8px] uppercase">Time Saved Daily</span>
                                <span class="text-white font-black text-base">42 mins</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 4: Driver Monitoring -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 order-last lg:order-first shadow-xl">
                        <h4 class="text-xs font-bold text-white">Alert Registry</h4>
                        <div class="space-y-2 text-[9px]">
                            <div class="bg-rose-950/20 text-rose-400 border border-rose-500/20 p-2 rounded">⚠️ Overspeed Alarm: Operator #11 (58 km/h in school zone)</div>
                            <div class="bg-emerald-950/20 text-emerald-400 border border-emerald-500/20 p-2 rounded">✓ SOS Checked: Operator #41 (Confirmed safe)</div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">04 / Driver Monitoring</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Protect Passenger & Driver Safety</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Trace compliance metrics. Rate driver behaviors, flag harsh braking, check speed profiles, and get instantaneous alarm alerts for route deviation parameters.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Safety rating reports sent weekly to operators dashboard</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Driver-app integrated SOS alarm toggle button</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 5: Parent App -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">05 / Parent App Integration</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Reduce Call Congestion at Dispatch Command Centers</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Our white-labeled mobile Parent App lets guardians verify live bus ETA timers directly, eliminating up to 85% of incoming phone inquiries.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Self-service proximity zones customizable warnings</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Automatic push alerts upon drop-complete check-ins</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">White-label Parent View</h4>
                        <div class="bg-[#1C273E] p-4 rounded-xl border border-slate-850 text-center">
                            <p class="text-[10px] text-slate-300">"ETA alerts updated automatically. No phone support needed."</p>
                            <span class="text-[9px] text-lime-400 block mt-2 font-bold">— Dispatch Manager Review</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Scale Your Transport Contracts</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        Join fleet operators utilizing WheelsTracker to win new enterprise school contracts.
                    </p>
                    <div class="pt-4">
                        <a href="/book-demo" class="pulse-lime px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 inline-block">
                            Schedule A Demo
                        </a>
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
                    <a href="/contact" class="hover:text-lime-400">Contact</a>
                </div>
            </div>
        </footer>

    </div>
</x-guest-layout>
