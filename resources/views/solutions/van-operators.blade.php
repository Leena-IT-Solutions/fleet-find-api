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
                        🚐 FOR VAN OPERATORS & DAYCARES
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        Compact Route GPS <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">For Van Operators.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Coordinate small school routes, manage multiple vans, offer easy tracking maps to parents, and access flexible pricing plans.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Schedule A Demo
                        </a>
                        <a href="/pricing" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            View Pricing
                        </a>
                    </div>
                </div>
            </section>

            <!-- Key Capabilities Switch Grid -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="text-center max-w-3xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Features Suite</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Van Fleet Core Modules</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Cost-efficient coordinates trackers and easy status dashboards custom-tailored for small transit budgets.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Module 1 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">🚐</span>
                            <h4 class="text-sm font-bold text-white">Multiple Vans</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Trace up to 25 shuttle vans under a single unified dashboard view.</p>
                        </div>
                        <!-- Module 2 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">🏫</span>
                            <h4 class="text-sm font-bold text-white">Small Schools</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Perfect layout matches for private playschools and local daycares.</p>
                        </div>
                        <!-- Module 3 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">📍</span>
                            <h4 class="text-sm font-bold text-white">Easy Tracking</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Interactive maps links requiring zero technical learning curves.</p>
                        </div>
                        <!-- Module 4 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">🏷️</span>
                            <h4 class="text-sm font-bold text-white">Affordable Plans</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Highly flexible pricing matches starting at minimal rates.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 1: Multiple Vans -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Multiple Vans</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Coordinate Multiple Vans Simpler</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            No complex setups. Track multiple driver routes, see speed compliance profiles, and ensure safe passenger onboarding timings across all vans from one simplified manager dashboard.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Multi-vehicle coordinate status indicators</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Speed limits tracing logs across all van operators</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">Van Roster Grid</h4>
                        <div class="space-y-2">
                            <div class="bg-[#1C273E] p-2.5 rounded flex justify-between text-[10px]">
                                <span>🚐 Van #02 (Daycare Route A)</span>
                                <span class="text-emerald-400 font-bold">ONLINE</span>
                            </div>
                            <div class="bg-[#1C273E] p-2.5 rounded flex justify-between text-[10px]">
                                <span>🚐 Van #09 (School Loop C)</span>
                                <span class="text-emerald-400 font-bold">ONLINE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 2: Small Schools -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 order-last lg:order-first shadow-xl">
                        <h4 class="text-xs font-bold text-white">Daycare Dashboard Setup</h4>
                        <div class="space-y-2 text-[10px] text-slate-400">
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>Setup Time:</span><span class="text-lime-400 font-bold">15 Mins</span></div>
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>Hardware Cost:</span><span class="text-white font-bold">Zero (Uses smartphones)</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">02 / Small Schools & Daycares</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Tailored for Daycares & Primary Schools</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Small scale, high security. Daycares and primary schools choose WheelsTracker to give parents real-time reassurance without complex hardware setups.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Plug-and-play setup needing zero vehicle installations</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Customized stopping sequences suited for narrow suburbs</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 3: Easy Tracking -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">03 / Easy Tracking</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Zero-Friction Live Tracing</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Drivers run our clean Driver App to share coordinate updates automatically. Parents load interactive web links directly from their mobile web browsers to verify active van positions.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>One-click links needing zero parent app downloads</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Low-battery usage coordinates optimization</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">Easy Mapping Interface</h4>
                        <div class="bg-[#1C273E] p-3.5 rounded-xl border border-slate-850 flex justify-between items-center text-[10px]">
                            <span>📍 Click Link to View Live Map</span>
                            <span class="text-lime-400 font-black">OPEN LINK</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 4: Affordable Plans -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 order-last lg:order-first shadow-xl">
                        <h4 class="text-xs font-bold text-white">Starter Pricing Tier</h4>
                        <div class="space-y-2 text-[10px] text-slate-400">
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>Rate per Vehicle:</span><span class="text-lime-400 font-black text-base">$9/mo</span></div>
                            <div class="flex justify-between"><span>Contract Terms:</span><span class="text-white font-bold">Cancel Anytime</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">04 / Affordable Plans</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Highly Cost-Effective Plans</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            No hidden setup fees or locked-in annual contracts. Pay a simple flat rate per active van and scale up or down based on your seasonal school schedules.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Simple billing scales dynamically with active fleet count</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Free updates and support tickets included in all plans</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-24 bg-[#0B0F17] border-t border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Get Started in Minutes</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        Start tracking your passenger shuttles today with our zero-hardware mobile setup.
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
