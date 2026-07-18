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
        
        /* Bar chart animation */
        @keyframes grow-bar {
            0% { transform: scaleY(0.1); }
            100% { transform: scaleY(1); }
        }
        .chart-grow-effect { transform-origin: bottom; animation: grow-bar 1.5s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
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
                        📈 Enterprise Fleet Telematics & Analytics
                    </div>
                    
                    <!-- Exact Primary Keyword in H1 -->
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        Optimized <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">School Fleet Management</span>
                    </h1>
                    
                    <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                        Improve operational efficiency, minimize fuel expenditure, automate vehicle servicing alerts, and manage drivers safety compliance scores under a unified cloud management platform.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Request Live Demo
                        </a>
                        <a href="https://wa.me/919096189183?text=Hi%20WheelsTracker,%20I%20am%20interested%20in%20School%20Fleet%20Management." target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-bold text-sm uppercase tracking-wider transition-all-300 text-center flex items-center justify-center gap-2">
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
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Four Pillars of Efficiency</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Institutional Fleet Operations</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Upgrade from fragmented sheets to a powerful diagnostic suite. WheelsTracker maps fuel trends, safety flags, and maintenance schedules under one hub.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Pillar 1 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-4 hover:-translate-y-1 duration-300 text-left">
                            <span class="text-2xl">📍</span>
                            <h3 class="text-sm font-bold text-white">Route Optimization</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">
                                AI routing modules reduce overlapping trips and idle wait times, helping operators cut monthly diesel costs.
                            </p>
                        </div>
                        <!-- Pillar 2 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-4 hover:-translate-y-1 duration-300 text-left">
                            <span class="text-2xl">🔧</span>
                            <h3 class="text-sm font-bold text-white">Preventative Servicing</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">
                                Get automatic alerts based on distance travelled. Schedule oil changes, fitness checks, and engine diagnostics.
                            </p>
                        </div>
                        <!-- Pillar 3 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-4 hover:-translate-y-1 duration-300 text-left">
                            <span class="text-2xl">🚨</span>
                            <h3 class="text-sm font-bold text-white">Driver Behavior Audit</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">
                                Monitor overspeed counts, hard cornering, and route deviation logs to calculate safety compliance scores.
                            </p>
                        </div>
                        <!-- Pillar 4 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-4 hover:-translate-y-1 duration-300 text-left">
                            <span class="text-2xl">📊</span>
                            <h3 class="text-sm font-bold text-white">Automated Reports</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">
                                Export detailed Excel rosters and PDF logs showing vehicle mileage, active hours, and trip counts.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Section: Custom Telemetry Graph Animation -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Text Info Column -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Fleet Diagnostics</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Live Fleet Diagnostics</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Understand exactly how your fleet is performing. Monitor fuel utilization curves, trace distance logs, and configure geofence zones to prevent unauthorized detours or personal vehicle usage.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Complete diagnostics overview for buses, vans, and rickshaws</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Odometer tracking with automatic service notifications</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Fuel consumption trend charts and compliance audits</span></div>
                        </div>
                    </div>

                    <!-- Visual Animation Column -->
                    <div class="lg:col-span-6 flex items-center justify-center">
                        <div class="w-full max-w-lg bg-[#121824] border border-slate-850 p-6 rounded-3xl shadow-2xl relative overflow-hidden text-left space-y-6">
                            
                            <!-- Header Info Panel -->
                            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-white">Monthly Fuel Optimization</h4>
                                    <p class="text-[10px] text-slate-400">Total Fleet Cost Trends</p>
                                </div>
                                <span class="text-[10px] bg-lime-450/20 text-lime-400 border border-lime-500/30 px-2 py-0.5 rounded font-black">-15.4% Saved</span>
                            </div>

                            <!-- Diagnostic Bar Chart -->
                            <div class="h-40 flex items-end justify-between gap-4 border-b border-slate-800 pb-2 relative z-10 px-2">
                                <div class="w-full space-y-2 text-center">
                                    <div class="w-full bg-[#1C273E] h-16 rounded-t-lg relative overflow-hidden">
                                        <div class="absolute bottom-0 w-full bg-slate-500 h-full scale-y-[0.9] chart-grow-effect"></div>
                                    </div>
                                    <span class="text-[8px] text-slate-400 uppercase">May</span>
                                </div>
                                <div class="w-full space-y-2 text-center">
                                    <div class="w-full bg-[#1C273E] h-24 rounded-t-lg relative overflow-hidden">
                                        <div class="absolute bottom-0 w-full bg-slate-500 h-full scale-y-[0.8] chart-grow-effect"></div>
                                    </div>
                                    <span class="text-[8px] text-slate-400 uppercase">Jun</span>
                                </div>
                                <div class="w-full space-y-2 text-center">
                                    <div class="w-full bg-[#1C273E] h-32 rounded-t-lg relative overflow-hidden">
                                        <div class="absolute bottom-0 w-full bg-lime-400 h-full scale-y-[0.6] chart-grow-effect"></div>
                                    </div>
                                    <span class="text-[8px] text-lime-450 uppercase font-bold">Jul (AI Active)</span>
                                </div>
                            </div>

                            <!-- Live Telemetry Stats -->
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Active Fleet</span>
                                    <p class="text-xs font-bold text-white mt-0.5">28 Vehicles</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Maintenance Alert</span>
                                    <p class="text-xs font-bold text-white mt-0.5">0 Active Flags</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Speed Violations</span>
                                    <p class="text-xs font-bold text-white mt-0.5">0 logs Today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Multi-Vehicle Platform Versatility -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Unified Dashboard Control</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Support for Any Vehicle Type</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Indian school districts run diverse fleets. WheelsTracker maps all vehicle classifications under a single dashboard organization.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Bus -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                            <span class="text-3xl">🚌</span>
                            <h3 class="text-lg font-bold text-white">Large School Buses</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Ideal for heavy transport networks. Integrates with hardwired GPS/AIS-140 devices, checks route compliance, and syncs passenger tallies.
                            </p>
                        </div>
                        <!-- Van -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                            <span class="text-3xl">🚐</span>
                            <h3 class="text-lg font-bold text-white">School Vans & SUVs</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Best for suburban routing. Simple OBD plug installation options, narrow-lane path optimization, and real-time geofence alerts.
                            </p>
                        </div>
                        <!-- Rickshaw -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                            <span class="text-3xl">🛺</span>
                            <h3 class="text-lg font-bold text-white">Auto Rickshaw Pools</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                100% app-based setup on driver smartphones. Low-cost solution for hyper-local parent transit pools.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 text-left">
                    <div class="text-center space-y-4 mb-16">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Platform Resources</span>
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Fleet Management FAQ</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">How does route optimization lower fuel budgets?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Our AI system processes student stop registries, groups them into compact routes, and generates directions that eliminate overlaps and empty miles.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Can we schedule preventative maintenance alerts?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. The dashboard logs vehicle mileage automatically. You can configure distance parameters (e.g. every 5,000 km) to alert servicing, engine inspections, or RTO renewals.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Does the software support multiple user roles and permissions?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. The system features hierarchical access control tags (Super Admins, Transport Managers, Operators, Drivers, and Parents) to secure sensitive fleet logs.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Banner -->
            <section class="py-24 bg-gradient-to-r from-blue-950 to-slate-900 text-white relative overflow-hidden border-t border-slate-900/60">
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
                <div class="relative z-10 max-w-4xl mx-auto text-center space-y-8 px-6">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-blue-300">Boost Operational Efficiency</span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                        Optimize Your District's Commute Operations.
                    </h2>
                    <p class="text-slate-350 text-sm sm:text-base max-w-2xl mx-auto">
                        Speak with our enterprise engineers to schedule a live system walk-through and build custom route configurations.
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
