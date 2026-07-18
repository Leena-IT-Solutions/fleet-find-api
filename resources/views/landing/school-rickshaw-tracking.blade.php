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
        
        /* Rickshaw pulse node animation */
        @keyframes rickshaw-pulse {
            0% { transform: scale(0.9); opacity: 0.9; }
            50% { transform: scale(1.35); opacity: 0.45; }
            100% { transform: scale(1.7); opacity: 0; }
        }
        .rickshaw-pulse-effect { animation: rickshaw-pulse 2s infinite ease-out; }
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
                    <a href="/case-studies" class="text-slate-350 hover:text-lime-400 transition-colors">Case Studies</a>
                    <a href="/blog" class="text-slate-350 hover:text-lime-400 transition-colors">Blog</a>
                    <a href="/about" class="text-slate-350 hover:text-lime-400 transition-colors">About</a>
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
                        🛺 Hyper-Local Mobile GPS Tracking
                    </div>
                    
                    <!-- Exact Primary Keyword in H1 -->
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        Affordable <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Auto Rickshaw Tracking for Schools</span>
                    </h1>
                    
                    <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                        Secure shared auto-rickshaw pools, private commutes, and neighborhood school transits. Run 100% app-based tracking on drivers' smartphones, send automated WhatsApp updates to parents, and assure student security.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Request Demo
                        </a>
                        <a href="https://wa.me/919096189183?text=Hi%20WheelsTracker,%20I%20am%20interested%20in%20Auto%20Rickshaw%20Tracking%20for%20Schools." target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-bold text-sm uppercase tracking-wider transition-all-300 text-center flex items-center justify-center gap-2">
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
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Designed for Local Operators</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Zero-Hardware Tracking</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Rickshaws are privately operated and don't need complex fleet electronics. Our platform operates entirely through basic smartphone apps.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/30 border border-lime-500/20 flex items-center justify-center text-2xl">
                                📱
                            </div>
                            <h3 class="text-lg font-bold text-white">App-Based (No GPS Hardware)</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Drivers only require a budget Android smartphone. No wiring changes, no batteries, and zero installation headaches. Download and start tracking instantly.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-emerald-950/30 border border-emerald-500/20 flex items-center justify-center text-2xl">
                                💬
                            </div>
                            <h3 class="text-lg font-bold text-white">Direct WhatsApp Alerts</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Share live web tracking links with parents via WhatsApp. Parents track their children directly in their mobile browser without needing app installations.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-cyan-950/30 border border-cyan-500/20 flex items-center justify-center text-2xl">
                                🛺
                            </div>
                            <h3 class="text-lg font-bold text-white">Shared Pool Syncing</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Easily aggregate student pickups across parent groups. One rickshaw route feeds tracking logs to all participating family accounts simultaneously.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Section: Rickshaw SVG Map Animation -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Text Info Column -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Local Transit Grid</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Hyper-Local Route Monitoring</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Auto rickshaws navigate small streets and short routes. WheelsTracker registers path adherence thresholds, tracks stops duration, checks battery status, and updates ETAs dynamically.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Low-battery consumption phone logging modes</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Instant stop notifications (no waiting outside)</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Secure web links for parental tracking access</span></div>
                        </div>
                    </div>

                    <!-- Visual Animation Column -->
                    <div class="lg:col-span-6 flex items-center justify-center">
                        <div class="w-full max-w-lg bg-[#121824] border border-slate-850 p-6 rounded-3xl shadow-2xl relative overflow-hidden text-left space-y-6">
                            
                            <!-- Header Info Panel -->
                            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-white">Rickshaw Pool #09</h4>
                                    <p class="text-[10px] text-slate-400">Sector-C Shared Ride</p>
                                </div>
                                <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded font-black">LIVE</span>
                            </div>

                            <!-- Map Mockup Panel -->
                            <div class="h-48 bg-[#090D1A] rounded-2xl relative overflow-hidden border border-slate-800">
                                <!-- Grid lines pattern -->
                                <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>

                                <!-- Road Network Paths -->
                                <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 300 150" fill="none">
                                    <path d="M 30 30 C 100 100, 150 10, 270 75" stroke="#334155" stroke-width="4" stroke-linecap="round"/>
                                    
                                    <!-- Stop points -->
                                    <circle cx="30" cy="30" r="4.5" fill="#f59e0b"/>
                                    <circle cx="110" cy="65" r="4.5" fill="#ef4444"/>
                                    <circle cx="270" cy="75" r="4.5" fill="#10b981"/>

                                    <!-- Animated vehicle node -->
                                    <g id="animated-rickshaw" transform="translate(30, 30)">
                                        <animateMotion dur="6s" repeatCount="indefinite" path="M 30 30 C 100 100, 150 10, 270 75" />
                                        <circle cx="0" cy="0" r="10" fill="#a3e635" class="rickshaw-pulse-effect opacity-50"/>
                                        <circle cx="0" cy="0" r="4.5" fill="#a3e635"/>
                                    </g>
                                </svg>
                                
                                <span class="absolute top-2 left-2 text-[8px] bg-slate-900/90 text-slate-400 px-1.5 py-0.5 rounded">Stop 1</span>
                                <span class="absolute bottom-2 right-2 text-[8px] bg-slate-900/90 text-lime-400 px-1.5 py-0.5 rounded">ETA: 2 Mins</span>
                            </div>

                            <!-- Live Telemetry Stats -->
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Driver Signal</span>
                                    <p class="text-xs font-bold text-white mt-0.5">🟢 GPS Active</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Current Speed</span>
                                    <p class="text-xs font-bold text-white mt-0.5">26 km/h</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Driver battery</span>
                                    <p class="text-xs font-bold text-lime-400 mt-0.5">82% Charged</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Simplicity and Onboarding Steps -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Fast Deployment</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Setup in 3 Simple Steps</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Get your neighborhood rickshaw pool mapped and active in minutes.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                        <!-- Step 1 -->
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/20 text-lime-400 border border-lime-500/20 flex items-center justify-center font-bold">01</div>
                            <h4 class="text-lg font-bold text-white">Create Rickshaw Route</h4>
                            <p class="text-slate-450 text-xs sm:text-sm leading-relaxed">
                                Enter pickup stops and add parent mobile contacts to the dashboard pool.
                            </p>
                        </div>
                        <!-- Step 2 -->
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/20 text-lime-400 border border-lime-500/20 flex items-center justify-center font-bold">02</div>
                            <h4 class="text-lg font-bold text-white">Driver Installs App</h4>
                            <p class="text-slate-450 text-xs sm:text-sm leading-relaxed">
                                The rickshaw driver downloads the WheelsTracker Driver App and enters the unique route code.
                            </p>
                        </div>
                        <!-- Step 3 -->
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/20 text-lime-400 border border-lime-500/20 flex items-center justify-center font-bold">03</div>
                            <h4 class="text-lg font-bold text-white">Start Sharing Location</h4>
                            <p class="text-slate-450 text-xs sm:text-sm leading-relaxed">
                                As the driver starts the transit trip, location alerts map directly to parent accounts.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 text-left">
                    <div class="text-center space-y-4 mb-16">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">FAQ</span>
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Rickshaw Tracking FAQ</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Do we need to buy any physical tracking device?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                No, you do not. Auto rickshaw drivers only require a basic Android phone. Location signals are computed and broadcasted directly from the driver app.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">What if the driver does not have a smartphone?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                If a driver does not possess a smartphone, you can install a compact, battery-powered GPS tracker inside the rickshaw's glove compartment or utility box. Contact us to find device options.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Can multiple families track the same rickshaw?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. The organizer can register all parent contacts to the same rickshaw route, allowing every parent to track the active ride simultaneously.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Banner -->
            <section class="py-24 bg-gradient-to-r from-blue-950 to-slate-900 text-white relative overflow-hidden border-t border-slate-900/60">
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
                <div class="relative z-10 max-w-4xl mx-auto text-center space-y-8 px-6">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-blue-300">Set Up Shared Commute Safely</span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                        Map Your Neighborhood Rickshaw Pools.
                    </h2>
                    <p class="text-slate-350 text-sm sm:text-base max-w-2xl mx-auto">
                        Speak with our product coordinators to set up your account, register driver contacts, and secure affordable pricing models.
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
