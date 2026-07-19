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
                        🏫 GPS SOFTWARE FOR SCHOOLS
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        GPS Tracking Software <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">For Modern School Fleets.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Increase parent satisfaction, ensure absolute route safety adherence, and coordinate driver crews using our unified cloud-based telemetry system.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Schedule A Demo
                        </a>
                        <a href="/pricing" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Explore Pricing
                        </a>
                    </div>
                </div>
            </section>

            <!-- Benefits Grid Section -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="text-center max-w-3xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Operational Value</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Key Institutional Benefits</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Designed to satisfy school administrative boards, fleet dispatch managers, and student guardians simultaneously.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Benefit 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left">
                            <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl">⏱️</div>
                            <h3 class="text-lg font-bold text-white">85% Support Ticket Relief</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Parents trace bus arrival times independently, reducing daily dispatch inquiry telephone call volumes to school front offices.
                            </p>
                        </div>
                        <!-- Benefit 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left">
                            <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl">⛽</div>
                            <h3 class="text-lg font-bold text-white">15.4% Fuel Cost Savings</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Automate path layouts, trace route overlaps, and audit excessive vehicle idling logs to optimize fuel efficiency metrics.
                            </p>
                        </div>
                        <!-- Benefit 3 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left">
                            <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl">🎒</div>
                            <h3 class="text-lg font-bold text-white">100% Boarding Audits</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Digital RFID passes register check-in coordinates at every stop. Know exactly which student boarded which bus.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 1: Parent Satisfaction -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Parent Satisfaction</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Delight Parents with Instant ETA Updates</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Silent front desk phones, satisfied guardians. Give parents access to clean mobile interfaces to track bus coordinates and receive push notifications when the vehicle is approaching.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-300">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Estimated Arrival Timers updating in real-time</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Geofence announcements triggered 1km away from stopping points</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Rider check-in push alerts when RFID cards are scanned</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="relative w-[280px] h-[520px] rounded-[36px] bg-[#0A0D16] border-4 border-slate-800 shadow-2xl p-3 flex flex-col justify-between overflow-hidden">
                            <div class="flex-grow bg-[#111625] rounded-[28px] overflow-hidden p-4 flex flex-col justify-between relative mt-2 text-left">
                                <div class="flex justify-between items-center text-[8.5px] font-bold text-slate-400">
                                    <span>Parent Dashboard</span>
                                    <span class="text-lime-400 animate-pulse font-mono">● LIVE</span>
                                </div>
                                <div class="bg-[#1C273E] p-3.5 rounded-xl border border-slate-800 space-y-2 mt-4">
                                    <span class="text-[7.5px] uppercase font-bold text-slate-450 block">Assigned Transport</span>
                                    <p class="text-xs font-extrabold text-white">🚌 Bus #04 - Sector 12 Route</p>
                                </div>
                                <div class="flex-grow my-4 bg-[#151D30] rounded-xl border border-slate-800 p-3 space-y-3 relative overflow-hidden">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[8px] font-bold text-slate-400">Stopping Schedule</span>
                                        <span class="text-[7.5px] text-lime-400 font-mono">ETA 4 MINS</span>
                                    </div>
                                    <div class="relative h-20 w-full bg-[#1C273E] rounded border border-slate-800 overflow-hidden flex items-center justify-center">
                                        <svg class="absolute inset-0 w-full h-full p-2" viewBox="0 0 100 100">
                                            <path d="M 0 50 L 100 50" stroke="#253556" stroke-width="4"/>
                                            <circle cx="20" cy="50" r="3" fill="#ef4444"/>
                                            <g transform="translate(62, 45)">
                                                <circle cx="5" cy="5" r="6" fill="#a3e635" class="animate-ping"/>
                                                <rect width="10" height="7" rx="1.5" fill="#a3e635"/>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div class="bg-[#1C273E]/70 p-3.5 rounded-xl text-[8.5px] border border-slate-850">
                                    <span class="text-slate-450 uppercase font-black block text-[7px]">Last Scanned Boarding Badge</span>
                                    <p class="text-xs font-black text-emerald-400 mt-1">✓ Aarav checked in (08:04 AM)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 2: Safety -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 flex justify-center order-last lg:order-first">
                        <div class="w-full max-w-sm bg-[#121824] border border-slate-850 p-6 rounded-3xl space-y-4 text-left shadow-2xl">
                            <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                                <span class="text-[9px] text-lime-400 uppercase font-black font-mono">Driver Scorecard</span>
                                <span class="text-[8px] bg-emerald-950/20 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded font-bold font-mono">EXCELLENT</span>
                            </div>
                            <div class="space-y-3 text-xs">
                                <div class="flex justify-between"><span>Speed Adherence Limit:</span><span class="text-slate-300 font-bold font-mono">98.2%</span></div>
                                <div class="flex justify-between"><span>Route Adherence Rate:</span><span class="text-slate-300 font-bold font-mono">100.0%</span></div>
                                <div class="flex justify-between"><span>Active Diagnostics:</span><span class="text-emerald-400 font-bold">No Faults</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">02 / Safety</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Absolute Safety for Every Student</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Keep student safety at the center of operations. Trace active speeds, configure route adherence zones, and get instantly alarmed of any route deviations or sudden braking.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-300">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Real-time driver speed tracking and audio safety compliance alerts</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Geofenced boundary alarms triggering instantly on route deviations</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Direct parent emergency SOS notifications on route delays</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 3: Admissions -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">03 / Admissions</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Leverage Modern Transport to Drive Enrollments</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Modern parents look for institutions with top-tier technology. Showcase your WheelsTracker campus transport tracking setup during admission campaigns to build instant enrollment trust.
                        </p>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="w-full max-w-sm bg-[#121824] border border-slate-850 p-8 rounded-3xl text-left space-y-4 shadow-2xl">
                            <span class="text-lime-400 font-black text-3xl font-mono block">12.4%</span>
                            <h4 class="text-sm font-bold text-white">Enrollment Conversion Lift</h4>
                            <p class="text-slate-450 text-xs leading-relaxed">
                                Schools utilizing live transport tracking amenities report higher parent onboarding scores during admissions.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 4: Digital Transformation -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <div class="text-center max-w-3xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">04 / Digital Transformation</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight">100% Digitized Route Auditing</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Replaces clipboard roster checkups. Trace student check-ins, driver rosters timesheets, and vehicle fuel logs with simple cloud-based charts.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                        <!-- Old Way Card -->
                        <div class="bg-[#121824]/40 p-8 rounded-3xl border border-slate-850/60 text-left space-y-4">
                            <span class="text-[10px] text-rose-400 font-bold bg-rose-950/20 px-2 py-0.5 rounded border border-rose-500/20 uppercase tracking-widest">Manual Way</span>
                            <ul class="space-y-2.5 text-slate-450 text-xs">
                                <li class="flex items-center gap-2"><span>✗</span><span>Manual clipboard paper check sheets</span></li>
                                <li class="flex items-center gap-2"><span>✗</span><span>Frequent parent call congestion delays</span></li>
                                <li class="flex items-center gap-2"><span>✗</span><span>No speed audits or route history records</span></li>
                            </ul>
                        </div>
                        <!-- WheelsTracker Card -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-lime-500/20 text-left space-y-4 shadow-xl">
                            <span class="text-[10px] text-lime-400 font-bold bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/20 uppercase tracking-widest">WheelsTracker Way</span>
                            <ul class="space-y-2.5 text-slate-200 text-xs">
                                <li class="flex items-center gap-2"><span class="text-lime-400">✓</span><span>100% automatic RFID scan badge checkpoints</span></li>
                                <li class="flex items-center gap-2"><span class="text-lime-400">✓</span><span>Parent self-service coordinates checking</span></li>
                                <li class="flex items-center gap-2"><span class="text-lime-400">✓</span><span>Detailed driver safe-drive audit compliance logs</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dashboard Showcase Console -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Administrative Panel</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">School Administration Console Dashboard</h2>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Monitor fleet lists, verify driver license registry status, check active speed metrics, and generate route paths reports from a single centralized dashboard.
                        </p>
                    </div>
                    <div class="lg:col-span-5 bg-[#090D1A] rounded-[24px] border border-slate-800 shadow-2xl p-4 min-h-[300px]">
                        <div class="w-full rounded-xl bg-[#111625] border border-slate-800 shadow-xl flex flex-col overflow-hidden text-white text-[8px]">
                            <div class="flex items-center justify-between pb-1.5 border-b border-slate-900 px-3 pt-2">
                                <span class="text-slate-500 font-mono">admin.wheelstracker.app/dashboard</span>
                            </div>
                            <div class="bg-[#151D30] p-4 text-left min-h-[180px] flex flex-col justify-between">
                                <h4 class="text-[10px] font-black">Central Fleet Roster</h4>
                                <div class="space-y-1 mt-2">
                                    <div class="flex justify-between bg-[#1C273E] p-2 rounded"><span>🚌 Bus #04 (Sector 12 Route)</span><span class="text-emerald-400 font-bold">ONLINE (42 km/h)</span></div>
                                    <div class="flex justify-between bg-[#1C273E] p-2 rounded"><span>🚌 Bus #11 (Central Station Route)</span><span class="text-emerald-400 font-bold">ONLINE (38 km/h)</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>
</x-guest-layout>
