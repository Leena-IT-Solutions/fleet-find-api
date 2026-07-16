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
            
            <!-- Hero Header -->
            <section class="relative py-24 sm:py-32 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-7xl px-6 relative z-10 text-center space-y-8">
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-lime-950/20 border border-lime-500/30 text-lime-400 text-xs font-bold uppercase tracking-widest">
                        🛺 A HUGE MICRO-TRANSIT OPPORTUNITY
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        GPS Tracking For <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Auto Rickshaw Operators.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Modernize local school pools, share live locations with parents, build a premium profile, and decrease administrative call logs.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Start Free Trial
                        </a>
                    </div>
                </div>
            </section>

            <!-- Target Audience Grid -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="text-center max-w-3xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Target Scope</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Who We Serve</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Serving micro-transit operators, vehicle contractors, and driver groups across cities.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Target 1 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left">
                            <span class="text-3xl">🏫</span>
                            <h3 class="text-lg font-bold text-white">School Rickshaw Drivers</h3>
                            <p class="text-slate-450 text-xs sm:text-sm leading-relaxed">
                                Coordinate shared neighborhood school pool lists. Share routes statuses instantly with parents.
                            </p>
                        </div>
                        <!-- Target 2 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left">
                            <span class="text-3xl">🛺</span>
                            <h3 class="text-lg font-bold text-white">Fleet Owners</h3>
                            <p class="text-slate-450 text-xs sm:text-sm leading-relaxed">
                                Monitor coordinates and idle parameters across a group of up to 50 local auto rickshaws.
                            </p>
                        </div>
                        <!-- Target 3 -->
                        <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/20 transition-all-300 space-y-4 text-left">
                            <span class="text-3xl">👤</span>
                            <h3 class="text-lg font-bold text-white">Individual Drivers</h3>
                            <p class="text-slate-450 text-xs sm:text-sm leading-relaxed">
                                Modernize your daily passenger routes. Run our simple driver tracking software directly from any smartphone.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Benefits Overview (4 Cards) -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="text-center max-w-3xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Operational Benefits</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Driver & Fleet Benefits</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Benefit 1 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <div class="text-lime-400 text-xl font-bold">📍</div>
                            <h4 class="text-sm font-bold text-white">Share Live Location</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Parents trace active rickshaw coordinate locations via simple mobile web links.</p>
                        </div>
                        <!-- Benefit 2 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <div class="text-lime-400 text-xl font-bold">⭐</div>
                            <h4 class="text-sm font-bold text-white">Professional Image</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Differentiate yourself from basic transit options by offering tracking technology amenities.</p>
                        </div>
                        <!-- Benefit 3 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <div class="text-lime-400 text-xl font-bold">📞</div>
                            <h4 class="text-sm font-bold text-white">Reduce Calls</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Geofence alerts broadcast automatically to parents, ending constant support call checkups.</p>
                        </div>
                        <!-- Benefit 4 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <div class="text-lime-400 text-xl font-bold">🛡️</div>
                            <h4 class="text-sm font-bold text-white">Gain Parent Trust</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Prove ride safety logs and on-time drop-off schedules to secure long-term parent loyalty.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Sections (Alternating) -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-20">
                    
                    <!-- Section: Share Live Location -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-5 text-left">
                            <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Live Coordinates Sharing</span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-white">Share Live Coordinates on Simple Maps</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Give parents complete reassurance. Share live links that open real-time coordinates, showing driver headings and dropping stop locations.
                            </p>
                        </div>
                        <div class="lg:col-span-5 bg-slate-900/40 p-6 rounded-2xl border border-slate-850 text-left space-y-3">
                            <div class="flex gap-3 text-xs"><span class="text-lime-400 font-bold">✓</span><span>Requires no parent mobile app installation</span></div>
                            <div class="flex gap-3 text-xs"><span class="text-lime-400 font-bold">✓</span><span>Automatic maps redirection for simple use</span></div>
                        </div>
                    </div>

                    <!-- Section: Professional Image -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-5 bg-slate-900/40 p-6 rounded-2xl border border-slate-850 text-left space-y-3 order-last lg:order-first">
                            <div class="flex gap-3 text-xs"><span class="text-lime-400 font-bold">✓</span><span>Stand out from local competitors</span></div>
                            <div class="flex gap-3 text-xs"><span class="text-lime-400 font-bold">✓</span><span>Build a reputable, high-end driver rating profile</span></div>
                        </div>
                        <div class="lg:col-span-7 space-y-5 text-left">
                            <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Brand Elevation</span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-white">Build a Trusted, Tech-Savvy Profile</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Showcase modern coordinates tracking technology to target school clients, building a professional reputation that commands premium rates.
                            </p>
                        </div>
                    </div>

                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-24 bg-[#0B0F17] border-t border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Tap Into a Massive Opportunity</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        Join modern school rickshaw drivers using WheelsTracker to secure new clients and build lasting parent trust.
                    </p>
                    <div class="pt-4">
                        <a href="/book-demo" class="pulse-lime px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 inline-block">
                            Start Free Trial
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
