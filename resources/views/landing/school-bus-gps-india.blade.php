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
        
        /* Map dot animation */
        @keyframes pulse-dot {
            0% { transform: scale(0.9); opacity: 0.9; }
            50% { transform: scale(1.3); opacity: 0.4; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        .pulse-dot-effect { animation: pulse-dot 2s infinite ease-out; }
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
                        🇮🇳 AIS-140 & RTO Compliant Solutions
                    </div>
                    
                    <!-- Exact Primary Keyword in H1 -->
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        Best-in-Class <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">School Bus GPS India</span>
                    </h1>
                    
                    <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                        The ultimate vehicle tracking software designed for Indian schools, transport contractors, and RTO rules. Keep fleets compliant with AIS-140 GPS standards, limit overspeeding hazards, and send automated WhatsApp alerts to parents.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Request Live Demo
                        </a>
                        <a href="https://wa.me/919096189183?text=Hi%20WheelsTracker,%20I%20am%20interested%20in%20School%20Bus%20GPS%20India." target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-bold text-sm uppercase tracking-wider transition-all-300 text-center flex items-center justify-center gap-2">
                            <span>Connect on WhatsApp</span>
                            <span class="text-emerald-400 text-xs">• Online</span>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Value Proposition -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Features Custom-Built for India</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">RTO Guidelines & Safe Transit</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            RTO regulations mandate certified tracking and speed limits check. WheelsTracker helps your school maintain compliance seamlessly.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/30 border border-lime-500/20 flex items-center justify-center text-2xl">
                                📜
                            </div>
                            <h3 class="text-lg font-bold text-white">AIS-140 GPS Compliant</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Seamlessly integrate your existing RTO-approved AIS-140 tracking hardware. Pull data from government server networks and secure vehicle fitness certificate approvals.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-emerald-950/30 border border-emerald-500/20 flex items-center justify-center text-2xl">
                                💬
                            </div>
                            <h3 class="text-lg font-bold text-white">WhatsApp & SMS Integration</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Deliver real-time delay notifications, route check-in statuses, and proximity alerts directly to parents via SMS or automated WhatsApp APIs.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-cyan-950/30 border border-cyan-500/20 flex items-center justify-center text-2xl">
                                🚨
                            </div>
                            <h3 class="text-lg font-bold text-white">Speed Governor Auditing</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Prevent rash driving. Set up custom overspeed alert thresholds (e.g. 40 km/h) and log instant overspeed triggers to institutional panels.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Section: Custom India Map Animation -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Text Info Column -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / India-Centric Telemetry</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Optimized for Indian Routes</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Indian streets present high traffic variables and network dead-zones. Our platform features lightweight network modes to continue recording coordinates logs locally even under low-connectivity routes.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Offline data logging matching active routes</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Speed limits validation maps (RTO rules)</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Multi-vehicle contractor dispatch logs</span></div>
                        </div>
                    </div>

                    <!-- Visual Animation Column -->
                    <div class="lg:col-span-6 flex items-center justify-center">
                        <div class="w-full max-w-lg bg-[#121824] border border-slate-850 p-6 rounded-3xl shadow-2xl relative overflow-hidden text-left space-y-6">
                            
                            <!-- Header Info Panel -->
                            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-white">Route 04 Transit Hub</h4>
                                    <p class="text-[10px] text-slate-400">Delhi-NCR School Commute</p>
                                </div>
                                <span class="text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded font-black">ACTIVE</span>
                            </div>

                            <!-- Map Mockup Panel -->
                            <div class="h-48 bg-[#090D1A] rounded-2xl relative overflow-hidden border border-slate-800">
                                <!-- Grid lines pattern -->
                                <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>

                                <!-- Road Network Paths -->
                                <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 300 150" fill="none">
                                    <path d="M 20 75 Q 75 120, 150 75 T 280 75" stroke="#334155" stroke-width="4" stroke-linecap="round"/>
                                    <path d="M 150 10 L 150 140" stroke="#334155" stroke-width="4" stroke-linecap="round"/>
                                    
                                    <!-- Stops -->
                                    <circle cx="20" cy="75" r="4.5" fill="#f59e0b"/>
                                    <circle cx="150" cy="75" r="4.5" fill="#ef4444"/>
                                    <circle cx="280" cy="75" r="4.5" fill="#10b981"/>

                                    <!-- Animated vehicle moving along path -->
                                    <g id="animated-india-bus" transform="translate(20, 75)">
                                        <animateMotion dur="7s" repeatCount="indefinite" path="M 20 75 Q 75 120, 150 75 T 280 75" />
                                        <circle cx="0" cy="0" r="10" fill="#a3e635" class="pulse-dot-effect opacity-50"/>
                                        <circle cx="0" cy="0" r="5" fill="#a3e635"/>
                                    </g>
                                </svg>
                                
                                <span class="absolute top-2 left-2 text-[8px] bg-slate-900/90 text-slate-400 px-1.5 py-0.5 rounded">Check point 1</span>
                                <span class="absolute bottom-2 right-2 text-[8px] bg-slate-900/90 text-lime-400 px-1.5 py-0.5 rounded">RTO Checkpoint Passed</span>
                            </div>

                            <!-- Live Telemetry Stats -->
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">AIS-140 Signal</span>
                                    <p class="text-xs font-bold text-emerald-400 mt-0.5">Connected</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Average Speed</span>
                                    <p class="text-xs font-bold text-white mt-0.5">32 km/h</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Attendant SOS</span>
                                    <p class="text-xs font-bold text-white mt-0.5">Idle</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Hardware Versatility -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Device Integration options</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Flexible Hardware Ecosystem</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            No hard software lock-ins. WheelsTracker integrates natively with local Indian AIS-140 GPS suppliers or standard Android/iOS smartphones.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- AIS-140 Device Option -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 flex flex-col justify-between text-left">
                            <div class="space-y-4">
                                <span class="text-3xl">📜</span>
                                <h3 class="text-xl font-bold text-white">AIS-140 Hardware Integration</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Perfect for large schools and transport contractors requiring government Fitness Certificates. We sync coordinates logs, ignition telemetry, and panic alarms from certified Indian GPS brands.
                                </p>
                            </div>
                            <div class="pt-6 border-t border-slate-800/80 mt-6 text-xs text-lime-400 flex gap-2 font-bold">
                                <span>✔ RTO Approved Protocols</span><span>•</span><span>✔ Government server sync</span>
                            </div>
                        </div>

                        <!-- App-Based Option -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 flex flex-col justify-between text-left">
                            <div class="space-y-4">
                                <span class="text-3xl">📱</span>
                                <h3 class="text-xl font-bold text-white">App-Based Smartphone Tracking</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Best for private school vans, auto-rickshaw pools, or budget transit setups. Drivers run the WheelsTracker Driver App to map transit locations without buying extra trackers.
                                </p>
                            </div>
                            <div class="pt-6 border-t border-slate-800/80 mt-6 text-xs text-lime-400 flex gap-2 font-bold">
                                <span>✔ Zero Hardware Cost</span><span>•</span><span>✔ Android & iOS Apps</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 text-left">
                    <div class="text-center space-y-4 mb-16">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Help Desk</span>
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">GPS System FAQ</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Do you supply AIS-140 certified GPS trackers?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                WheelsTracker is a software platform. We integrate with your existing AIS-140 certified devices. If you do not have hardware, our engineering team can connect you with certified Indian hardware manufacturers.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Does the software support regional RTO speed limits?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. Admins can configure custom speed limits matching regional RTO rules (such as 40 km/h for school vehicles) and log real-time speed violation reports.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">What are the pricing options in Indian Rupees (INR)?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                We offer customized, cost-effective pricing in INR for Indian schools and operators. Please contact our local team to receive a tailored commercial proposal.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Banner -->
            <section class="py-24 bg-gradient-to-r from-blue-950 to-slate-900 text-white relative overflow-hidden border-t border-slate-900/60">
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
                <div class="relative z-10 max-w-4xl mx-auto text-center space-y-8 px-6">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-blue-300">Boost Institutional Safety Standards</span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                        Deploy WheelsTracker in Your School Today.
                    </h2>
                    <p class="text-slate-350 text-sm sm:text-base max-w-2xl mx-auto">
                        Connect with our India sales engineers to draft integration plans, configure AIS-140 tracking devices, and request pricing structures.
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
