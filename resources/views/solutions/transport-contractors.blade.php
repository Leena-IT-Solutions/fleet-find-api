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
                    <a href="/blog" class="text-slate-300 hover:text-lime-400 transition-colors">Blog</a>
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
                        💼 FOR ENTERPRISE TRANSPORT CONTRACTORS
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-none max-w-5xl mx-auto">
                        Transportation Software <br class="hidden sm:block">
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">For School Contractors.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Manage multiple school client portfolios, centralize vehicle tracking, optimize driver shifts, and automate billing invoicing.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4">
                        <a href="/book-demo" class="pulse-lime w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Request Demo
                        </a>
                        <a href="/contact" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-[#111625] hover:bg-[#161D30] text-slate-200 border border-slate-800 font-black text-sm uppercase tracking-wider transition-all-300 text-center">
                            Talk to Sales
                        </a>
                    </div>
                </div>
            </section>

            <!-- Key Capabilities Switch Grid -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-16">
                    <div class="text-center max-w-3xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Features Suite</span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Contractor Core Modules</h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            B2B enterprise transit operations tools custom-built to win school district contracts.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <!-- Module 1 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">🏫</span>
                            <h4 class="text-sm font-bold text-white">Multiple Schools</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Isolate schedules, rosters, and pricing structures per school client.</p>
                        </div>
                        <!-- Module 2 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">🚛</span>
                            <h4 class="text-sm font-bold text-white">Fleet Management</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Monitor large-scale multi-bus diagnostics and idling metrics.</p>
                        </div>
                        <!-- Module 3 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">👤</span>
                            <h4 class="text-sm font-bold text-white">Drivers Control</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Check timesheets rosters compliance and safety limits ratings.</p>
                        </div>
                        <!-- Module 4 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">📊</span>
                            <h4 class="text-sm font-bold text-white">Reports Panel</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Export weekly on-time completion timelines statistics.</p>
                        </div>
                        <!-- Module 5 -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-3 text-left">
                            <span class="text-2xl">🧾</span>
                            <h4 class="text-sm font-bold text-white">Invoices Billing</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Auto-calculate contract billing based on mileage registers.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 1: Multiple Schools -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">01 / Multiple Schools Portals</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Consolidated Multi-School Management</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Organize multiple school contracts under a single master profile. Isolate student databases, customize route parameters, and configure distinctive billing rates for each partner institution.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Individual dashboard views for each school client manager</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Separated safety metrics rules configuration parameters</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">Active School Contracts</h4>
                        <div class="space-y-2">
                            <div class="bg-[#1C273E] p-2.5 rounded flex justify-between text-[10px]">
                                <span>🏫 St. Jude's Academy</span>
                                <span class="text-emerald-400 font-bold">24 Buses Online</span>
                            </div>
                            <div class="bg-[#1C273E] p-2.5 rounded flex justify-between text-[10px]">
                                <span>🏫 Oakridge Heights Primary</span>
                                <span class="text-emerald-400 font-bold">12 Buses Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 2: Fleet Management -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 order-last lg:order-first shadow-xl">
                        <h4 class="text-xs font-bold text-white">Enterprise Fleet Status</h4>
                        <div class="space-y-2 text-[10px] text-slate-400">
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>Total Active Fleets:</span><span class="text-white font-bold">85 Vehicles</span></div>
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>Weekly Fuel Overhead:</span><span class="text-lime-400 font-bold">-18.2% Save</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">02 / Fleet Management</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Live Enterprise Fleet Controls</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Complete vehicle tracking parameters. Check active engine diagnostics, track vehicle idling parameters, schedule preventative bus maintenance dates, and trace ignition logs.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Trace vehicle service diagnostics reports</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Configurable idle warnings triggers to save diesel costs</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 3: Drivers -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">03 / Drivers Roster Control</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Monitor Driver Attendance & Safety Compliance</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Organize daily driver schedules, track shift start times, and monitor safe-driving compliance scores. Build a reliable driver network to secure district contracts.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Driver license expiration warnings databases</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Overspeeding and sudden braking alarms registers</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">Driver Roster Shift Checklist</h4>
                        <div class="space-y-2 text-[10px]">
                            <div class="flex justify-between bg-[#1C273E] p-2 rounded"><span>👤 Driver Keith (Shift A)</span><span class="text-emerald-400 font-bold">CHECKED IN (07:12 AM)</span></div>
                            <div class="flex justify-between bg-[#1C273E] p-2 rounded"><span>👤 Driver Marcus (Shift B)</span><span class="text-emerald-400 font-bold">CHECKED IN (07:15 AM)</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 4: Reports -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 order-last lg:order-first shadow-xl">
                        <h4 class="text-xs font-bold text-white">SLA Completion Stats</h4>
                        <div class="space-y-2 text-[10px]">
                            <div class="flex justify-between border-b border-slate-800 pb-1"><span>On-Time Arrival:</span><span class="text-emerald-400 font-bold">98.8%</span></div>
                            <div class="flex justify-between"><span>Unresolved Alerts:</span><span class="text-white font-bold">0 Alerts</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">04 / Reports</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Institutional Compliance Reports</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Generate detailed PDF/Excel transit reports to verify SLA compliance rules. Share route histories directly with school admin boards.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Complete time-stamped boarding databases exports</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Automated vehicle analytics diagnostics registers</span></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Module Section 5: Invoices -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">05 / Invoices & Billing</span>
                        <h3 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">Automated B2B Contract Billing</h3>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                            Ditch manual miles registers worksheets. WheelsTracker automatically tracks vehicle travel distances to generate invoices matching contract flat-rates per client school.
                        </p>
                        <div class="space-y-3.5 text-xs sm:text-sm text-slate-350">
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>Auto-calculated trip logs billing rates</span></div>
                            <div class="flex gap-3"><span class="text-lime-400 font-bold">✓</span><span>One-click PDF invoices download console</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 bg-[#121824] border border-slate-850 p-6 rounded-3xl text-left space-y-3 shadow-xl">
                        <h4 class="text-xs font-bold text-white">Invoice Summary Console</h4>
                        <div class="bg-[#1C273E] p-4 rounded-xl border border-slate-850">
                            <div class="flex justify-between text-[10px] text-slate-300"><span>School Contractor Invoice #1024</span><span class="text-lime-400 font-bold">GENERATED</span></div>
                            <p class="text-xs font-black text-white mt-2">Target School: Oakridge Heights Primary</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Scale Your Fleet Contracts Today</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        Schedule an engineering consultation to integrate WheelsTracker with your enterprise fleet workflows.
                    </p>
                    <div class="pt-4">
                        <a href="/book-demo" class="pulse-lime px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 inline-block">
                            Schedule B2B Demo
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
