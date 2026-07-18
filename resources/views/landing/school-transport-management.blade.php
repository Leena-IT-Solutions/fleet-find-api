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
        
        /* Dial rotation animation */
        @keyframes rotate-needle {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(120deg); }
        }
        .needle-rotate-effect { transform-origin: 50px 50px; animation: rotate-needle 6s ease-in-out infinite; }
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
                    <a href="/features" class="text-slate-350 hover:text-lime-400 transition-colors">Features</a>
                    <a href="/solutions" class="text-slate-350 hover:text-lime-400 transition-colors">Solutions</a>
                    <a href="/pricing" class="text-slate-350 hover:text-lime-400 transition-colors">Pricing</a>
                    <a href="/blog" class="text-slate-350 hover:text-lime-400 transition-colors">Blog</a>
                    <a href="/contact" class="text-slate-350 hover:text-lime-400 transition-colors">Contact</a>
                </nav>
                <div class="flex items-center gap-4">
                    <a href="/login" class="hidden sm:inline-flex text-sm font-semibold text-slate-300 hover:text-lime-400 transition-colors">Sign In</a>
                    <a href="/book-demo" class="pulse-lime px-5 py-2.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm shadow-lg shadow-lime-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all-300">Book Demo</a>
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
                        🛡️ Complete Transit Administration
                    </div>
                    
                    <!-- Exact Primary Keyword in H1 -->
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        End-to-End <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">School Transport Management Software</span>
                    </h1>
                    
                    <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                        Simplify scheduling, coordinate driver rosters, monitor live vehicle coordinates, and deliver self-service ETAs to parents. An all-in-one operational framework built to secure student transits and lower district administrative overhead.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Book Platform Demo
                        </a>
                        <a href="https://wa.me/919096189183?text=Hi%20WheelsTracker,%20I%20am%20interested%20in%20School%20Transport%20Management%20Software." target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-bold text-sm uppercase tracking-wider transition-all-300 text-center flex items-center justify-center gap-2">
                            <span>WhatsApp Sales</span>
                            <span class="text-emerald-400 text-xs">• Active</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Value Proposition -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Operational control center</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Unified Transit Management</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Upgrade from manual scheduling models. WheelsTracker coordinates vehicles, routing rosters, and passenger check-ins under a central console.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/30 border border-lime-500/20 flex items-center justify-center text-2xl">
                                📅
                            </div>
                            <h3 class="text-lg font-bold text-white">Smart Dispatch Scheduling</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Build active routing profiles, assign backup vehicles when breakdowns occur, and sync driver shifts without coordination bottlenecks.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-emerald-950/30 border border-emerald-500/20 flex items-center justify-center text-2xl">
                                🛡️
                            </div>
                            <h3 class="text-lg font-bold text-white">Security & RTO Standards</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Maintain complete records of speed violations, geofence breaches, and ignition diagnostic alerts. Fully compliant with school district regulations.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-cyan-950/30 border border-cyan-500/20 flex items-center justify-center text-2xl">
                                🤝
                            </div>
                            <h3 class="text-lg font-bold text-white">Parent-Admin Collaboration</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Self-service proximity pings, ETA countdown timers, and stop logs allow parents to track transit details proactively, reducing manual call volumes.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Section: Custom Dial/Gauge SVG Animation -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Text Info Column -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Control Console</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Live Operations Monitoring</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Access real-time diagnostic performance metrics of all routes. Traces average speed thresholds, on-time rating dials, driver behavior violations, and geofence events under a unified system.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Interactive operations console mockup designs</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Overspeed warning tags and audit logs</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Geofenced drop-off validation registries</span></div>
                        </div>
                    </div>

                    <!-- Visual Animation Column -->
                    <div class="lg:col-span-6 flex items-center justify-center">
                        <div class="w-full max-w-lg bg-[#121824] border border-slate-850 p-6 rounded-3xl shadow-2xl relative overflow-hidden text-left space-y-6">
                            
                            <!-- Header Info Panel -->
                            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-white">District-Wide Operations</h4>
                                    <p class="text-[10px] text-slate-400">Delhi-NCR Transit Center</p>
                                </div>
                                <span class="text-[10px] bg-lime-450/20 text-lime-400 border border-lime-500/30 px-2 py-0.5 rounded font-black">94.8% EFFICIENT</span>
                            </div>

                            <!-- Dial Gauge Visual Representation -->
                            <div class="h-44 flex items-center justify-center relative">
                                <svg width="100" height="100" viewBox="0 0 100 100" class="w-32 h-32">
                                    <!-- Dial Arc -->
                                    <path d="M 18 82 A 40 40 0 1 1 82 82" fill="none" stroke="#1c273e" stroke-width="8" stroke-linecap="round"/>
                                    <path d="M 18 82 A 40 40 0 1 1 72 28" fill="none" stroke="#a3e635" stroke-width="8" stroke-linecap="round"/>
                                    
                                    <!-- Center hub -->
                                    <circle cx="50" cy="50" r="5" fill="#ffffff" />
                                    
                                    <!-- Animated needle -->
                                    <line x1="50" y1="50" x2="50" y2="15" stroke="#ffffff" stroke-width="3" stroke-linecap="round" class="needle-rotate-effect" />
                                </svg>
                                <div class="absolute bottom-2 text-center">
                                    <p class="text-xs font-bold text-white">On-Time Performance</p>
                                    <p class="text-[10px] text-lime-400">Excellent Rating</p>
                                </div>
                            </div>

                            <!-- Live Telemetry Stats -->
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Active Fleet</span>
                                    <p class="text-xs font-bold text-white mt-0.5">32 Vehicles</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Today's Trips</span>
                                    <p class="text-xs font-bold text-white mt-0.5">148 Completed</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Geofence Hits</span>
                                    <p class="text-xs font-bold text-white mt-0.5">912 Checked</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Complete System Integrations (Parent, Driver, Admin) -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Comprehensive Ecosystem</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Connected Institutional Software</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            A complete solution covering all roles in school transport logistics.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Admin -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                            <span class="text-3xl">💻</span>
                            <h3 class="text-lg font-bold text-white">Central Admin Dashboard</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Manage pupil databases, update routes, check driver logs, trace speed compliance scorecards, and extract monthly billing Excel rosters.
                            </p>
                        </div>
                        <!-- Driver -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                            <span class="text-3xl">👨‍✈️</span>
                            <h3 class="text-lg font-bold text-white">Driver Assistant App</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Easy hands-free smartphone assistant. Oversized indicator screens, passenger checklist, and automatic route maps setup.
                            </p>
                        </div>
                        <!-- Parent -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                            <span class="text-3xl">📱</span>
                            <h3 class="text-lg font-bold text-white">Parent Portal Channels</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Direct self-service mobile browser tracking link sharing. Real-time ETA updates, geofenced proximity pings, and safety alerts.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 text-left">
                    <div class="text-center space-y-4 mb-16">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Help Desk</span>
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">System FAQ</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Can the system import student database lists directly?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. The School Dashboard features clean CSV and Excel imports tools to map grades, student rosters, and stops registries in bulk.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">How does geofenced dropoff verification operate?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                When a vehicle enters the geofence surrounding the campus or student stop, our backend auto-logs the check-in and updates the parent panel dashboard.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Are details hosted securely under server systems?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. All user details and coordinate logs are archived securely under SSL encrypted database tables, meeting modern corporate privacy standards.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Banner -->
            <section class="py-24 bg-gradient-to-r from-blue-950 to-slate-900 text-white relative overflow-hidden border-t border-slate-900/60">
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
                <div class="relative z-10 max-w-4xl mx-auto text-center space-y-8 px-6">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-blue-300">Upgrade District Safety Ratios</span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                        Deploy Next-Gen Transport Software.
                    </h2>
                    <p class="text-slate-350 text-sm sm:text-base max-w-2xl mx-auto">
                        Connect with our engineering sales coordinators to map out custom configurations, request pricing formats, and set up test accounts.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300">
                            Book Live Platform Demo
                        </a>
                        <a href="tel:9096189183" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white/10 hover:bg-white/15 text-white border border-white/10 font-bold text-sm uppercase tracking-wider transition-all-300 flex items-center justify-center gap-2">
                            <span>📞 Call Sales: 9096189183</span>
                        </a>
                    </div>
                </div>
            </section>

        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-900 bg-[#080B11] text-slate-400 text-xs py-12">
            <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold tracking-tight text-white">WheelsTracker</span>
                    <span>© {{ date('Y') }} WheelsTracker. All rights reserved.</span>
                </div>
                <div class="flex gap-6">
                    <a href="/privacy-policy" class="hover:text-lime-400">Privacy Policy</a>
                    <a href="/terms-conditions" class="hover:text-lime-400">Terms & Conditions</a>
                </div>
            </div>
        </footer>

    </div>
</x-guest-layout>
