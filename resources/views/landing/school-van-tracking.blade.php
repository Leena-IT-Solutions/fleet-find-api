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
        
        /* Pulse Animation for Van Node */
        @keyframes van-pulse {
            0% { transform: scale(0.95); opacity: 0.9; }
            50% { transform: scale(1.3); opacity: 0.4; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        .van-pulse-effect { animation: van-pulse 2s infinite ease-out; }
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
            
            <!-- Hero Section -->
            <section class="relative py-24 sm:py-32 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-7xl px-6 relative z-10 text-center space-y-8">
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-lime-950/20 border border-lime-500/30 text-lime-400 text-xs font-bold uppercase tracking-widest">
                        🚐 Compact Fleet GPS Solutions
                    </div>
                    
                    <!-- Exact Primary Keyword in H1 -->
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        High-Precision <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">School Van Tracking Software</span>
                    </h1>
                    
                    <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                        Optimized GPS tracking designed specifically for school vans, multi-utility vehicles, and private pool operators. Cut down fuel costs, optimize routes in tight residential areas, and send real-time ETAs to parents.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Request Demo
                        </a>
                        <a href="https://wa.me/919096189183?text=Hi%20WheelsTracker,%20I%20am%20interested%20in%20School%20Van%20Tracking%20Software." target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-bold text-sm uppercase tracking-wider transition-all-300 text-center flex items-center justify-center gap-2">
                            <span>WhatsApp Connect</span>
                            <span class="text-emerald-400 text-xs">• Active</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Value Proposition -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Tailored for Van Operators</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Smart Tracking for Smaller Fleets</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            School vans operate differently than large buses, taking narrow residential lanes and making rapid stops. Our platform adapts to your vehicle size and route dynamics.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/30 border border-lime-500/20 flex items-center justify-center text-2xl">
                                🏙️
                            </div>
                            <h3 class="text-lg font-bold text-white">Narrow Lane Navigation</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Optimize routes for tight city streets, dead-ends, and residential gates. Minimizes backing up and ensures safer pickup loops for smaller student groups.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-emerald-950/30 border border-emerald-500/20 flex items-center justify-center text-2xl">
                                ⚡
                            </div>
                            <h3 class="text-lg font-bold text-white">Instant Proximity Pings</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Alert parents when the van is 2 minutes away. Keeps pick-up times under 30 seconds per child, preventing traffic bottlenecks on narrow public roads.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-cyan-950/30 border border-cyan-500/20 flex items-center justify-center text-2xl">
                                📊
                            </div>
                            <h3 class="text-lg font-bold text-white">Plug-and-Play Simplicity</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Use simple OBD-II plug trackers or basic driver smartphone setups. No complex auto-electrical wiring or professional technician installation required.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Section: Custom Van Map Animation -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Text Info Column -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Lane-Level Tracking</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Interactive Van Telemetry</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Vans change paths frequently to adapt to morning gridlocks. Our software records telemetry logs, shows live direction updates, checks route adherence thresholds, and alerts you of speeding patterns.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Active route compliance mapping logs</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Virtual geofence boundaries for safe zones</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Passenger boarding tally verification feeds</span></div>
                        </div>
                    </div>

                    <!-- Visual Animation Column -->
                    <div class="lg:col-span-6 flex items-center justify-center">
                        <div class="w-full max-w-lg bg-[#121824] border border-slate-850 p-6 rounded-3xl shadow-2xl relative overflow-hidden text-left space-y-6">
                            
                            <!-- Header Info Panel -->
                            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-white">Transit Pool: Van #12</h4>
                                    <p class="text-[10px] text-slate-400">Delhi-NCR Suburbs Route</p>
                                </div>
                                <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded font-black">ACTIVE</span>
                            </div>

                            <!-- Map Mockup Panel -->
                            <div class="h-48 bg-[#090D1A] rounded-2xl relative overflow-hidden border border-slate-800">
                                <!-- Grid lines pattern -->
                                <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>

                                <!-- Road Network Paths -->
                                <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 300 150" fill="none">
                                    <path d="M 25 25 L 275 25 L 275 125 L 25 125 Z" stroke="#334155" stroke-width="3" stroke-dasharray="6 4" stroke-linecap="round"/>
                                    
                                    <!-- Stops -->
                                    <circle cx="25" cy="25" r="4.5" fill="#f59e0b"/>
                                    <circle cx="275" cy="25" r="4.5" fill="#ef4444"/>
                                    <circle cx="275" cy="125" r="4.5" fill="#3b82f6"/>
                                    <circle cx="25" cy="125" r="4.5" fill="#10b981"/>

                                    <!-- Animated Van node -->
                                    <g id="animated-van">
                                        <animateMotion dur="8s" repeatCount="indefinite" path="M 25 25 L 275 25 L 275 125 L 25 125 Z" />
                                        <circle cx="0" cy="0" r="10" fill="#a3e635" class="van-pulse-effect opacity-50"/>
                                        <circle cx="0" cy="0" r="4.5" fill="#a3e635"/>
                                    </g>
                                </svg>
                                
                                <span class="absolute top-2 left-2 text-[8px] bg-slate-900/90 text-amber-400 px-1.5 py-0.5 rounded">Stop A</span>
                                <span class="absolute bottom-2 left-2 text-[8px] bg-slate-900/90 text-emerald-400 px-1.5 py-0.5 rounded">School Gates</span>
                            </div>

                            <!-- Live Telemetry Stats -->
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Speed Adherence</span>
                                    <p class="text-xs font-bold text-white mt-0.5">34 km/h</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">ETA to Stop B</span>
                                    <p class="text-xs font-bold text-lime-400 mt-0.5">3 Mins</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Capacity Log</span>
                                    <p class="text-xs font-bold text-white mt-0.5">8 / 10 Boarded</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Hardware Versatility (OBD vs Mobile) -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Device Integration options</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Flexible Tracking Methods</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Choose between OBD-II hardware trackers or app-based mobile tracking based on your budget and fleet scale.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- OBD Hardware Option -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 flex flex-col justify-between text-left">
                            <div class="space-y-4">
                                <span class="text-3xl">🔌</span>
                                <h3 class="text-xl font-bold text-white">OBD-II Plug-and-Play Trackers</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Ideal for fleets wanting permanent tracking without driver intervention. Simply plug a standard OBD device into the van's port under the dashboard. Captures ignition data, engine status, and coordinates seamlessly.
                                </p>
                            </div>
                            <div class="pt-6 border-t border-slate-800/80 mt-6 text-xs text-lime-400 flex gap-2 font-bold">
                                <span>✔ No Batteries Needed</span><span>•</span><span>✔ Hardwire Tamper Detection</span>
                            </div>
                        </div>

                        <!-- App-Based Option -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 flex flex-col justify-between text-left">
                            <div class="space-y-4">
                                <span class="text-3xl">📱</span>
                                <h3 class="text-xl font-bold text-white">Driver App Tracking</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Zero hardware cost. Drivers run the lightweight WheelsTracker app on their smartphones during transit times. Handles location logs, student checklist checks, and ETAs.
                                </p>
                            </div>
                            <div class="pt-6 border-t border-slate-800/80 mt-6 text-xs text-lime-400 flex gap-2 font-bold">
                                <span>✔ Zero Upfront Investment</span><span>•</span><span>✔ Android & iOS Apps</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 text-left">
                    <div class="text-center space-y-4 mb-16">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Help & Resources</span>
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">School Van Tracking FAQ</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Can private van operators use this software?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Absolutely. WheelsTracker is built to be scalable, offering flexible pay-as-you-go subscription options that suit small operators with only 1 to 5 vans.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">How do parent proximity alerts work?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                When a van crosses a virtual perimeter boundary (geofence) around a student's home stop, the system triggers a push notification or sms alert automatically.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Is professional installation needed for OBD trackers?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                No, OBD-II devices are plug-and-play. You simply find the OBD port (usually under the driver's steering column) and plug the tracker in. It connects immediately.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Banner -->
            <section class="py-24 bg-gradient-to-r from-blue-950 to-slate-900 text-white relative overflow-hidden border-t border-slate-900/60">
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
                <div class="relative z-10 max-w-4xl mx-auto text-center space-y-8 px-6">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-blue-300">Start Optimizing Your Commutes</span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                        Streamline Your Van Fleet Operations.
                    </h2>
                    <p class="text-slate-350 text-sm sm:text-base max-w-2xl mx-auto">
                        Speak with our product experts to map out your van routing routes, configure OBD testing hardware, and receive a tailored commercial setup.
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
        <x-footer />

    </div>
</x-guest-layout>
