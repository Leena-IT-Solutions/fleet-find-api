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
        
        /* Pulse Animation for geofences and active nodes */
        @keyframes geofence-pulse {
            0% { transform: scale(0.9); opacity: 0.25; }
            50% { transform: scale(1.3); opacity: 0.1; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        .geofence-pulse-effect { animation: geofence-pulse 3s infinite ease-out; }
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
                        🛡️ Campus Security & Safety Audits
                    </div>
                    
                    <!-- Exact Primary Keyword in H1 -->
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        High-Performance <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">GPS Tracking System for Schools</span>
                    </h1>
                    
                    <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                        Secure student transit operations, enforce speed limit compliance, optimize routes, and manage parent communication. A unified fleet tracking solution built specifically to meet the high safety standards of modern educational institutions.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Request Demo
                        </a>
                        <a href="https://wa.me/919096189183?text=Hi%20WheelsTracker,%20I%20am%20interested%20in%20GPS%20Tracking%20System%20for%20Schools." target="_blank" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-bold text-sm uppercase tracking-wider transition-all-300 text-center flex items-center justify-center gap-2">
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
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Enterprise Safety Features</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Institutional Transit Security</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Upgrade your school district's transport logistics. Keep administrators, operators, and parents in sync with our robust platform.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-lime-950/30 border border-lime-500/20 flex items-center justify-center text-2xl">
                                🛡️
                            </div>
                            <h3 class="text-lg font-bold text-white">Geofenced Campus Safezones</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Establish virtual geofences around schools, bus bays, and checkpoints. Trigger automatic check-in logs and notifications as buses enter or exit.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-emerald-950/30 border border-emerald-500/20 flex items-center justify-center text-2xl">
                                🚨
                            </div>
                            <h3 class="text-lg font-bold text-white">Emergency SOS Monitoring</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Drivers can report traffic breakdowns or emergencies in one tap. Broadcasts instant alerts with exact coordinates to transport desks.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-6 hover:-translate-y-1.5 duration-300 transition-all-300">
                            <div class="w-12 h-12 rounded-xl bg-cyan-950/30 border border-cyan-500/20 flex items-center justify-center text-2xl">
                                📈
                            </div>
                            <h3 class="text-lg font-bold text-white">Operational Auditing</h3>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Archive up to 90 days of route histories, overspeed counts, idle logs, and driver compliance reports. Essential for school board audits.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Section: Geofence SVG Map Animation -->
            <section class="py-24 bg-[#0B0F17] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    
                    <!-- Text Info Column -->
                    <div class="lg:col-span-6 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Virtual Perimeters</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Dynamic Geofence Alerting</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Create custom circular or polygonal geofences around stops, campuses, and routes. As the vehicle crosses these perimeters, our backend server auto-logs ETAs and dispatches live notification pings to parents.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Infinite custom geofence zone configurations</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>SMS & Push Notifications geofence dispatching</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Check-in logs matching student RFID records</span></div>
                        </div>
                    </div>

                    <!-- Visual Animation Column -->
                    <div class="lg:col-span-6 flex items-center justify-center">
                        <div class="w-full max-w-lg bg-[#121824] border border-slate-850 p-6 rounded-3xl shadow-2xl relative overflow-hidden text-left space-y-6">
                            
                            <!-- Header Info Panel -->
                            <div class="flex justify-between items-center border-b border-slate-800 pb-3">
                                <div>
                                    <h4 class="text-sm font-bold text-white">Primary Geofence Control</h4>
                                    <p class="text-[10px] text-slate-400">Campus Perimeter Boundary</p>
                                </div>
                                <span class="text-[10px] bg-lime-450/20 text-lime-400 border border-lime-500/30 px-2 py-0.5 rounded font-black">ACTIVE</span>
                            </div>

                            <!-- Map Mockup Panel -->
                            <div class="h-48 bg-[#090D1A] rounded-2xl relative overflow-hidden border border-slate-800">
                                <!-- Grid lines pattern -->
                                <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px] opacity-40"></div>

                                <!-- Geofence Zone circle -->
                                <div class="absolute top-[48px] left-[138px] w-24 h-24 rounded-full bg-lime-500/10 border-2 border-lime-400/30 z-0">
                                    <div class="w-full h-full rounded-full bg-lime-500/10 scale-100 geofence-pulse-effect"></div>
                                </div>

                                <!-- Road Network Paths -->
                                <svg class="absolute inset-0 w-full h-full p-4 z-10" viewBox="0 0 300 150" fill="none">
                                    <path d="M 20 120 L 120 75 L 280 75" stroke="#334155" stroke-width="4" stroke-linecap="round"/>
                                    
                                    <!-- Stop nodes -->
                                    <circle cx="20" cy="120" r="4.5" fill="#f59e0b"/>
                                    <circle cx="280" cy="75" r="4.5" fill="#3b82f6"/>
                                    
                                    <!-- School building node -->
                                    <circle cx="150" cy="75" r="6" fill="#10b981"/>

                                    <!-- Animated node moving into geofence -->
                                    <g id="animated-bus">
                                        <animateMotion dur="8s" repeatCount="indefinite" path="M 20 120 L 120 75 L 280 75" />
                                        <circle cx="0" cy="0" r="4" fill="#a3e635"/>
                                    </g>
                                </svg>
                                
                                <span class="absolute top-2 left-2 text-[8px] bg-slate-900/90 text-slate-400 px-1.5 py-0.5 rounded">Geofence boundary: 500m</span>
                                <span class="absolute bottom-2 right-2 text-[8px] bg-slate-900/90 text-lime-400 px-1.5 py-0.5 rounded">Checkin Confirmed</span>
                            </div>

                            <!-- Live Telemetry Stats -->
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Active Geofences</span>
                                    <p class="text-xs font-bold text-white mt-0.5">14 Configured</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Alert Delay</span>
                                    <p class="text-xs font-bold text-lime-400 mt-0.5">&lt; 1 Second</p>
                                </div>
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-center">
                                    <span class="text-[8px] text-slate-400 uppercase font-semibold">Logs Created</span>
                                    <p class="text-xs font-bold text-white mt-0.5">1,402 Today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Institutional Grade Platform (School admin panel highlights) -->
            <section class="py-24 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Complete Controls</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Institutional Dashboard Suite</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Everything your district transport coordinators need under a unified web command center.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Feature Box 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 flex flex-col justify-between text-left">
                            <div class="space-y-4">
                                <span class="text-3xl">💻</span>
                                <h3 class="text-xl font-bold text-white">Centralized Dispatch Dashboard</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Monitor active bus networks, see live speed compliance metrics, override driver route assignments, verify delay alerts, and communicate with emergency contact nodes.
                                </p>
                            </div>
                            <div class="pt-6 border-t border-slate-800/80 mt-6 text-xs text-lime-400 flex gap-2 font-bold">
                                <span>✔ Live Vehicle Registry</span><span>•</span><span>✔ Attendant Rosters</span>
                            </div>
                        </div>

                        <!-- Feature Box 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 flex flex-col justify-between text-left">
                            <div class="space-y-4">
                                <span class="text-3xl">🛡️</span>
                                <h3 class="text-xl font-bold text-white">Security & Audit Compliance</h3>
                                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                    Generate detailed PDF charts showing route speed violations, stop counts, and vehicle mileage. Fully compliant with state safety boards and transport authority requirements.
                                </p>
                            </div>
                            <div class="pt-6 border-t border-slate-800/80 mt-6 text-xs text-lime-400 flex gap-2 font-bold">
                                <span>✔ Encrypted Data Backups</span><span>•</span><span>✔ 90-Day History Files</span>
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
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">System FAQ</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Can the system map multiple school buildings or campuses?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. You can establish polygonal geofence boundaries for multiple schools and track check-ins for each building individually under one school organization account.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">Is parent communication secure and private?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                Yes. Parents can only view the live tracking links and logs for the specific routes their children are assigned to. Transport rosters details are private and secure.
                            </p>
                        </div>

                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <h4 class="text-sm sm:text-base font-bold text-white">What data is stored in the 90-day history archives?</h4>
                            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                                We archive exact GPS coordinates, speed records, active time stamps, geofence enter/leave events, and emergency SOS event logs.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Banner -->
            <section class="py-24 bg-gradient-to-r from-blue-950 to-slate-900 text-white relative overflow-hidden border-t border-slate-900/60">
                <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
                <div class="relative z-10 max-w-4xl mx-auto text-center space-y-8 px-6">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-blue-300">Upgrade Your Institution's Safety</span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                        Deploy Next-Gen Tracking for Your School.
                    </h2>
                    <p class="text-slate-350 text-sm sm:text-base max-w-2xl mx-auto">
                        Speak with our system engineers to integrate WheelsTracker with your existing transport setup and map out security configurations.
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
