<x-guest-layout :plain="true">
    <style>
        .transition-all-300 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .pulse-lime { animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(163, 230, 53, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(163, 230, 53, 0); }
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
                    <a href="/features" class="text-slate-300 hover:text-lime-400 transition-colors">Features</a>
                    <a href="/solutions" class="text-slate-300 hover:text-lime-400 transition-colors">Solutions</a>
                    <a href="/pricing" class="font-semibold text-lime-400">Pricing</a>
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
            <!-- Hero -->
            <section class="py-20 bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 text-center">
                <div class="mx-auto max-w-4xl px-6 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        🏷️ Simple Pricing Tiers
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Predictable Plans for <br>
                        <span class="bg-gradient-to-r from-lime-450 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Schools of All Sizes.</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">
                        No hidden setup costs. Pay according to your active school vehicle count with flexible monthly or annual commitments.
                    </p>
                </div>
            </section>

            <!-- Pricing Grid -->
            <section class="py-20 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    <!-- Standard Plan -->
                    <div class="bg-[#121824] p-8 rounded-2xl border border-slate-850 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="text-[10px] text-slate-450 uppercase font-black tracking-widest block">Standard Tier</span>
                            <h3 class="text-xl font-bold text-white">Up to 5 Vehicles</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">Best for single school routes or private contractor cabs.</p>
                            <p class="text-3xl font-black text-white">$49<span class="text-sm text-slate-500 font-medium"> / month</span></p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow">
                            <div class="flex gap-2.5"><span>✓</span><span>Live GPS coordinates tracking</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Basic Parent Web Portal access</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Speeding alert notifications</span></div>
                        </div>
                        <a href="/book-demo" class="block text-center py-3 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#121824] hover:text-white text-slate-200 text-sm font-bold">
                            Select Standard
                        </a>
                    </div>

                    <!-- Professional Plan (Featured) -->
                    <div class="bg-[#121824] p-8 rounded-2xl border-2 border-lime-400 flex flex-col justify-between space-y-6 relative">
                        <span class="absolute -top-3.5 right-6 bg-lime-400 text-slate-950 text-[8px] font-black uppercase px-2 py-0.5 rounded-full">POPULAR</span>
                        <div class="space-y-4">
                            <span class="text-[10px] text-lime-450 uppercase font-black tracking-widest block">Professional Tier</span>
                            <h3 class="text-xl font-bold text-white">Up to 20 Vehicles</h3>
                            <p class="text-slate-455 text-xs leading-relaxed">Ideal for growing schools and standard operator networks.</p>
                            <p class="text-3xl font-black text-white">$149<span class="text-sm text-slate-500 font-medium"> / month</span></p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow">
                            <div class="flex gap-2.5"><span>✓</span><span>All features in Standard</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Full Student RFID integration</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Operations Manager desktop console</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Monthly fuel & fleet safety analytics</span></div>
                        </div>
                        <a href="/book-demo" class="block text-center py-3 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm">
                            Get Professional
                        </a>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="bg-[#121824] p-8 rounded-2xl border border-slate-850 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="text-[10px] text-slate-450 uppercase font-black tracking-widest block">Enterprise Tier</span>
                            <h3 class="text-xl font-bold text-white">Unlimited Vehicles</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">For large school boards, municipalities, and multi-fleet operators.</p>
                            <p class="text-3xl font-black text-white">Custom</p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow">
                            <div class="flex gap-2.5"><span>✓</span><span>All features in Professional</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Dedicated client success manager</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Custom API integrations & reports</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>SLA uptime availability guarantees</span></div>
                        </div>
                        <a href="/book-demo" class="block text-center py-3 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#121824] hover:text-white text-slate-200 text-sm font-bold">
                            Contact Sales
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
