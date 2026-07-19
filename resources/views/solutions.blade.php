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
                    <a href="/solutions" class="font-semibold text-lime-400">Solutions</a>
                    <a href="/pricing" class="text-slate-300 hover:text-lime-400 transition-colors">Pricing</a>
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
                        💼 Stakeholder Solutions
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Optimized Transport for <br>
                        <span class="bg-gradient-to-r from-lime-450 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Every Transit Challenge.</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">
                        WheelsTracker connects school owners, fleet managers, drivers, and parents in a unified tracking matrix built to address specific transport needs.
                    </p>
                </div>
            </section>

            <!-- Solutions Grid -->
            <section class="py-20 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Schools Card -->
                        <a href="/solutions/schools" class="block bg-[#121824] p-8 rounded-2xl border border-slate-850 hover:border-lime-400 transition-all duration-300 transform hover:-translate-y-1 space-y-4 group">
                            <div class="flex justify-between items-start">
                                <span class="text-3xl">🏫</span>
                                <span class="text-[10px] text-lime-400 font-bold tracking-widest uppercase bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/20">Active</span>
                            </div>
                            <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Schools</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Complete tracking portals for individual schools, trace ETA updates, handle driver logs, and share live location maps with parents.
                            </p>
                        </a>

                        <!-- School Groups Card -->
                        <a href="/solutions/schools" class="block bg-[#121824] p-8 rounded-2xl border border-slate-850 hover:border-lime-400 transition-all duration-300 transform hover:-translate-y-1 space-y-4 group">
                            <div class="flex justify-between items-start">
                                <span class="text-3xl">🏢</span>
                                <span class="text-[10px] text-lime-400 font-bold tracking-widest uppercase bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/20">Group SKU</span>
                            </div>
                            <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">School Groups</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Consolidated panels designed for multi-branch school networks. Manage all campuses, fleets, and administrative roles under a single dashboard.
                            </p>
                        </a>

                        <!-- Bus Operators Card -->
                        <a href="/solutions/school-bus-operators" class="block bg-[#121824] p-8 rounded-2xl border border-slate-850 hover:border-lime-400 transition-all duration-300 transform hover:-translate-y-1 space-y-4 group">
                            <div class="flex justify-between items-start">
                                <span class="text-3xl">🚌</span>
                                <span class="text-[10px] text-lime-400 font-bold tracking-widest uppercase bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/20">Operator</span>
                            </div>
                            <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Bus Operators</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Robust scheduling tools, trace fuel logs, prevent idle overheads, and streamline driver shifts for school bus fleet operators.
                            </p>
                        </a>

                        <!-- Van Operators Card -->
                        <a href="/solutions/van-operators" class="block bg-[#121824] p-8 rounded-2xl border border-slate-850 hover:border-lime-400 transition-all duration-300 transform hover:-translate-y-1 space-y-4 group">
                            <div class="flex justify-between items-start">
                                <span class="text-3xl">🚐</span>
                                <span class="text-[10px] text-lime-400 font-bold tracking-widest uppercase bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/20">Micro Fleet</span>
                            </div>
                            <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Van Operators</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Compact fleet tracker systems built for private school vans. Satisfy parent demands with automated boarding notification triggers.
                            </p>
                        </a>

                        <!-- Rickshaw Operators Card -->
                        <a href="/solutions/auto-rickshaw-operators" class="block bg-[#121824] p-8 rounded-2xl border border-slate-850 hover:border-lime-400 transition-all duration-300 transform hover:-translate-y-1 space-y-4 group">
                            <div class="flex justify-between items-start">
                                <span class="text-3xl">🛺</span>
                                <span class="text-[10px] text-lime-400 font-bold tracking-widest uppercase bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/20">Local Pool</span>
                            </div>
                            <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Rickshaw Operators</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Lightweight B2C tracking interfaces for local rickshaw pools. Reassure parents with simple location broadcasts and check-ins.
                            </p>
                        </a>

                        <!-- Transport Agencies Card -->
                        <a href="/solutions/transport-contractors" class="block bg-[#121824] p-8 rounded-2xl border border-slate-850 hover:border-lime-400 transition-all duration-300 transform hover:-translate-y-1 space-y-4 group">
                            <div class="flex justify-between items-start">
                                <span class="text-3xl">💼</span>
                                <span class="text-[10px] text-lime-400 font-bold tracking-widest uppercase bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/20">Enterprise</span>
                            </div>
                            <h3 class="text-xl font-bold text-white group-hover:text-lime-400 transition-colors">Transport Agencies</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Enterprise-grade tracking APIs, automated safety audits checklists, and contractor compliance registries for large transport agencies.
                            </p>
                        </a>

                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>
</x-guest-layout>
