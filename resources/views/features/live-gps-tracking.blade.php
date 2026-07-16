<x-guest-layout :plain="true">
    <head>
        <title>Real-Time Live GPS Tracking Systems for Schools & Fleets | WheelsTracker</title>
        <meta name="description" content="Inspect high-accuracy real-time vehicle movement, geolocation telemetry streams, route tracking matching, and animated vector maps on WheelsTracker.">
    </head>
    <style>
        .transition-all-300 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .pulse-lime { animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(163, 230, 53, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(163, 230, 53, 0); }
        }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }

        /* Animated Map Trail */
        .animated-trail {
            stroke-dasharray: 8;
            animation: dash-animation 20s linear infinite;
        }
        @keyframes dash-animation {
            to {
                stroke-dashoffset: -100;
            }
        }
        .ping-glow {
            animation: ping-glow-anim 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        @keyframes ping-glow-anim {
            75%, 100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }
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
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Live GPS Tracking</h1>
                    
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
                        <a href="/features/live-gps-tracking" class="pb-3 text-lime-400 border-b-2 border-lime-400 font-bold px-2 flex-shrink-0">
                            📡 Live GPS Tracking
                        </a>
                        <a href="/features/notifications" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            🔔 Notifications
                        </a>
                        <a href="/features/reports" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            📊 Reports
                        </a>
                    </div>
                </div>
            </section>

            <!-- Detailed Content Block -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Text support details -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider font-mono">Live Telemetry Pipeline</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white leading-tight">High-Frequency Coordinates Streaming.</h2>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Our live tracking engine parses coordinates parameters every 2 seconds to generate fluid paths. Inspect delays, speeding flags, and geofence events with zero delays.
                        </p>
                        <div class="grid grid-cols-2 gap-6 pt-4 border-t border-slate-900">
                            <div>
                                <span class="text-[9px] text-slate-500 uppercase block font-bold">Location Accuracy</span>
                                <span class="text-base font-bold text-white">±3 Meters Deviation</span>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-500 uppercase block font-bold">GPS Updates Interval</span>
                                <span class="text-base font-bold text-white">Every 2 Seconds</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Interactive Animated Map Mockup -->
                    <div class="lg:col-span-6 flex justify-center">
                        <div class="w-full max-w-md bg-[#121824] rounded-[32px] border border-slate-850 p-5 shadow-2xl space-y-4 text-left">
                            <div class="flex justify-between items-center pb-2 border-b border-slate-850">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-lime-400 animate-pulse"></span>
                                    <span class="text-[9px] font-mono text-slate-350">Active Vehicle: Bus #04</span>
                                </div>
                                <span class="text-[8px] bg-lime-950/20 text-lime-400 border border-lime-500/20 px-2 py-0.5 rounded font-mono font-bold">STREAMING LIVE</span>
                            </div>

                            <!-- Animated Vector Map Widget -->
                            <div class="h-48 bg-[#0B0F17] rounded-2xl border border-slate-850 relative overflow-hidden flex items-center justify-center">
                                <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 200 120" fill="none">
                                    <!-- Map Roads Layout -->
                                    <path d="M10 20 H190 M10 60 H190 M10 100 H190 M50 10 V110 M150 10 V110" stroke="#162235" stroke-width="2"/>
                                    
                                    <!-- Animated Route Trail -->
                                    <path d="M50 20 H150 V100 H190" stroke="#3b82f6" stroke-dasharray="4 4" stroke-width="2" class="animated-trail"/>
                                    
                                    <!-- Geofence Circle -->
                                    <circle cx="150" cy="100" r="16" fill="rgba(163, 230, 53, 0.08)" stroke="rgba(163, 230, 53, 0.2)" stroke-width="1" stroke-dasharray="2 2"/>
                                    <text x="142" y="80" fill="#a3e635" font-size="6" font-family="monospace">Stop #3 Zone</text>

                                    <!-- Blinking Vehicle Marker -->
                                    <g transform="translate(110, 20)">
                                        <circle cx="0" cy="0" r="6" fill="#a3e635" opacity="0.3" class="ping-glow"/>
                                        <circle cx="0" cy="0" r="3.5" fill="#a3e635"/>
                                    </g>
                                </svg>
                            </div>

                            <div class="grid grid-cols-3 gap-2 text-[9px] sm:text-xs">
                                <div class="bg-[#0B0F17] p-2 rounded-xl border border-slate-850">
                                    <span class="text-slate-500 block text-[7px] uppercase font-bold">Active Speed</span>
                                    <span class="text-white font-bold">42 km/h</span>
                                </div>
                                <div class="bg-[#0B0F17] p-2 rounded-xl border border-slate-850">
                                    <span class="text-slate-500 block text-[7px] uppercase font-bold">Route Deviation</span>
                                    <span class="text-emerald-400 font-bold">0% Match</span>
                                </div>
                                <div class="bg-[#0B0F17] p-2 rounded-xl border border-slate-850">
                                    <span class="text-slate-500 block text-[7px] uppercase font-bold">Next STOP ETA</span>
                                    <span class="text-lime-400 font-bold">2.5 Mins</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- SEO Informational Section Grid -->
            <section class="py-16 bg-[#0B0F17] border-y border-slate-900/60 text-left">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="text-center max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Technical Specifications</span>
                        <h2 class="text-3xl font-bold text-white">How Our Tracking Engine Works</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                        
                        <!-- Real-time GPS -->
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-lg">📡</div>
                            <h3 class="text-lg font-bold text-white">Real-Time GPS</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Our low-latency telemetry pipelines capture vehicle location points with sub-second transmission delays, converting raw strings to coordinates maps instantly.
                            </p>
                        </div>

                        <!-- Location Accuracy -->
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-lg">🎯</div>
                            <h3 class="text-lg font-bold text-white">Location Accuracy</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                By mapping multi-satellite constellation signals, the driver app records exact coordinate positions with accuracy margins under ±3 meters.
                            </p>
                        </div>

                        <!-- Live Vehicle Movement -->
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-lg">🚗</div>
                            <h3 class="text-lg font-bold text-white">Live Vehicle Movement</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Visual movement indicators show smooth directional vectors, reducing map stutter and providing fluid vehicle updates for parents tracking.
                            </p>
                        </div>

                        <!-- Route Tracking -->
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-lg">🗺️</div>
                            <h3 class="text-lg font-bold text-white">Route Tracking</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Compares live coordinates traces against school assigned path vectors. Any unauthorized deviations trigger flags in the operator console.
                            </p>
                        </div>

                        <!-- Geo Location -->
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-lg">📍</div>
                            <h3 class="text-lg font-bold text-white">Geo Location</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Dynamic geofence calculations trigger SMS and WhatsApp proximity updates as the bus crosses virtual boundaries.
                            </p>
                        </div>

                        <!-- GPS Updates -->
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-lg">⏰</div>
                            <h3 class="text-lg font-bold text-white">GPS Updates</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Steady 2-second coordinate sync intervals balance server throughput and display precision, preventing location data drops.
                            </p>
                        </div>

                        <!-- Animated Maps -->
                        <div class="space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-lg">🎥</div>
                            <h3 class="text-lg font-bold text-white">Animated Maps</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Browser and app dashboards feature smooth transitions on path overlays, showing stop statuses in high contrast.
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
