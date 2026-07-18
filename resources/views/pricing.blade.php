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
            <section class="py-24 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-4xl px-6 space-y-6 relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        🏷️ Transparent Billing Tiers
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Simple Pricing For <br>
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Every Size Fleet.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Scale billing dynamically based on active vehicle counts. No setup fees, cancel anytime.
                    </p>
                </div>
            </section>

            <!-- Pricing Grid -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- Starter Plan -->
                    <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/10 transition-all-300 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="text-[10px] text-slate-450 uppercase font-black tracking-widest block">Starter Tier</span>
                            <h3 class="text-xl font-bold text-white">Starter</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">Best for individual shuttle drivers or tiny school daycare routes.</p>
                            <p class="text-3xl font-black text-white">$9<span class="text-xs text-slate-500 font-medium"> / vehicle / month</span></p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow">
                            <div class="flex gap-2.5"><span>✓</span><span>Live GPS location streaming</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Web map tracker links</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Basic speed limit audits</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Driver app access</span></div>
                        </div>
                        <a href="/book-demo" class="block text-center py-3 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#121824] hover:text-white text-slate-200 text-sm font-bold transition-all-300">
                            Select Starter
                        </a>
                    </div>

                    <!-- Professional Plan (Featured) -->
                    <div class="bg-[#121824] p-8 rounded-3xl border-2 border-lime-400 flex flex-col justify-between space-y-6 relative shadow-xl">
                        <span class="absolute -top-3.5 right-6 bg-lime-400 text-slate-950 text-[8px] font-black uppercase px-2.5 py-1 rounded-full font-bold">POPULAR</span>
                        <div class="space-y-4">
                            <span class="text-[10px] text-lime-400 uppercase font-black tracking-widest block font-bold">Professional Tier</span>
                            <h3 class="text-xl font-bold text-white">Professional</h3>
                            <p class="text-slate-400 text-xs leading-relaxed">Perfect for standard school fleets and contractor transport pools.</p>
                            <p class="text-3xl font-black text-white">$19<span class="text-xs text-slate-500 font-medium"> / vehicle / month</span></p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow">
                            <div class="flex gap-2.5"><span>✓</span><span>All features in Starter</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Automated ETA update push notifications</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>RFID passenger scan checks boarding logs</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Central administration console panel</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Weekly fuel idling optimization reports</span></div>
                        </div>
                        <a href="/book-demo" class="pulse-lime block text-center py-3 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm transition-all-300">
                            Get Professional
                        </a>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/10 transition-all-300 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="text-[10px] text-slate-450 uppercase font-black tracking-widest block">Enterprise Tier</span>
                            <h3 class="text-xl font-bold text-white">Enterprise</h3>
                            <p class="text-slate-450 text-xs leading-relaxed">For large school districts, cities, and national transit providers.</p>
                            <p class="text-3xl font-black text-white">Custom</p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow">
                            <div class="flex gap-2.5"><span>✓</span><span>All features in Professional</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Multi-school contractor portal access</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>White-labeled mobile applications</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Custom API diagnostics integration</span></div>
                            <div class="flex gap-2.5"><span>✓</span><span>Dedicated customer success manager</span></div>
                        </div>
                        <a href="/book-demo" class="block text-center py-3 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#121824] hover:text-white text-slate-200 text-sm font-bold transition-all-300">
                            Contact Enterprise
                        </a>
                    </div>
                </div>
            </section>

            <!-- Compare Features Table Section -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-5xl px-6 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">In-Depth Matrix</span>
                        <h2 class="text-3xl font-bold text-white">Compare Features</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-slate-800">
                                    <th class="py-4 text-slate-400 font-bold uppercase">Features</th>
                                    <th class="py-4 px-4 text-white font-bold">Starter</th>
                                    <th class="py-4 px-4 text-white font-bold">Professional</th>
                                    <th class="py-4 px-4 text-white font-bold">Enterprise</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-900">
                                <tr>
                                    <td class="py-4 font-semibold text-slate-350">Live Coordinates Updates</td>
                                    <td class="py-4 px-4 text-lime-400">✓ (5s interval)</td>
                                    <td class="py-4 px-4 text-lime-400">✓ (2s interval)</td>
                                    <td class="py-4 px-4 text-lime-400">✓ (Sub-second)</td>
                                </tr>
                                <tr>
                                    <td class="py-4 font-semibold text-slate-350">RFID Boarding Checkins</td>
                                    <td class="py-4 px-4 text-slate-600">—</td>
                                    <td class="py-4 px-4 text-lime-400">✓</td>
                                    <td class="py-4 px-4 text-lime-400">✓</td>
                                </tr>
                                <tr>
                                    <td class="py-4 font-semibold text-slate-350">Overspeeding Warnings Registry</td>
                                    <td class="py-4 px-4 text-slate-400">Basic</td>
                                    <td class="py-4 px-4 text-lime-400">✓ Advanced</td>
                                    <td class="py-4 px-4 text-lime-400">✓ Custom Alerts</td>
                                </tr>
                                <tr>
                                    <td class="py-4 font-semibold text-slate-350">Monthly Idle Fuel Reports</td>
                                    <td class="py-4 px-4 text-slate-600">—</td>
                                    <td class="py-4 px-4 text-lime-400">✓</td>
                                    <td class="py-4 px-4 text-lime-400">✓</td>
                                </tr>
                                <tr>
                                    <td class="py-4 font-semibold text-slate-350">White-label Parent Interfaces</td>
                                    <td class="py-4 px-4 text-slate-600">—</td>
                                    <td class="py-4 px-4 text-slate-600">—</td>
                                    <td class="py-4 px-4 text-lime-400">✓</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- CTA / Book Demo Section -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Ready to Optimize Your Fleet?</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        Book a free 15-minute diagnostic call with our engineers to configure your setup.
                    </p>
                    <div class="pt-4 flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Book Free Demo Now
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>
</x-guest-layout>
