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
                    <a href="/pricing" class="text-slate-300 hover:text-lime-400 transition-colors">Pricing</a>
                    <a href="/case-studies" class="text-slate-300 hover:text-lime-400 transition-colors">Case Studies</a>
                    <a href="/blog" class="text-slate-300 hover:text-lime-400 transition-colors">Blog</a>
                    <a href="/about" class="font-semibold text-lime-400">About</a>
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
            <section class="relative py-24 sm:py-32 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-4xl px-6 space-y-6 relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        🚀 MEET WHEELSTRACKER
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Modernizing Transit Safety <br>
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">For The Next Generation.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        The story behind WheelsTracker, our core values, and the team engineering absolute safety for student commutes.
                    </p>
                </div>
            </section>

            <!-- Mission & Vision Section -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mission Card -->
                    <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl">🎯</div>
                        <h3 class="text-xl font-bold text-white">Our Mission</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            To eliminate parent transit anxiety globally. We empower school managers and fleet operators with low-latency coordinates tracking systems that build guardian confidence.
                        </p>
                    </div>
                    <!-- Vision Card -->
                    <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 space-y-4 text-left">
                        <div class="w-12 h-12 rounded-2xl bg-lime-950/20 border border-lime-500/20 flex items-center justify-center text-2xl">👁️</div>
                        <h3 class="text-xl font-bold text-white">Our Vision</h3>
                        <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                            To establish the global gold standard for school transit routing automation, replacing outdated paper roster timelines with simple background smartphone telemetry logs.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Company Story -->
            <section class="py-16 bg-[#0B0F17] border-y border-slate-900/60 text-left">
                <div class="mx-auto max-w-4xl px-6 space-y-6">
                    <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Company Story</span>
                    <h2 class="text-3xl font-black text-white tracking-tight">How It All Started</h2>
                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                        WheelsTracker was founded after identifying a massive communication delay in local school operations. When school buses ran late due to traffic or weather conditions, front offices faced hundreds of incoming calls from anxious parents checking coordinates. 
                    </p>
                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                        We realized that tracking coordinates wasn't just a technical challenge—it was an empathy challenge. By introducing automated geofenced proximity updates and self-service passenger portals, we replaced administrative chaos with clean operational visibility. Today, we scale telemetry tools for daycares, bus fleet contractors, and large-scale school boards.
                    </p>
                </div>
            </section>

            <!-- Why WheelsTracker -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Core Strengths</span>
                        <h2 class="text-3xl font-bold text-white">Why WheelsTracker?</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2 text-left">
                            <span class="text-lime-400 font-bold text-lg font-mono block">01.</span>
                            <h4 class="text-sm font-bold text-white">2s Latency GPS</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">Low-latency tracking updates streams coordinate routes accurately.</p>
                        </div>
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2 text-left">
                            <span class="text-lime-400 font-bold text-lg font-mono block">02.</span>
                            <h4 class="text-sm font-bold text-white">Zero Hardware Required</h4>
                            <p class="text-slate-455 text-[11px] leading-relaxed">Runs directly on standard drivers mobile devices, saving setup costs.</p>
                        </div>
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2 text-left">
                            <span class="text-lime-400 font-bold text-lg font-mono block">03.</span>
                            <h4 class="text-sm font-bold text-white">White-label Tools</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">B2B contractors customize client interfaces under private domains.</p>
                        </div>
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2 text-left">
                            <span class="text-lime-400 font-bold text-lg font-mono block">04.</span>
                            <h4 class="text-sm font-bold text-white">Route Optimization</h4>
                            <p class="text-slate-450 text-[11px] leading-relaxed">AI route layouts save diesel consumption and dispatch overheads.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Our Team -->
            <section class="py-16 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Leadership</span>
                        <h2 class="text-3xl font-bold text-white">Meet Our Team</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Member 1 -->
                        <div class="bg-[#121824] p-6 rounded-3xl border border-slate-850 text-center space-y-4 shadow-lg">
                            <div class="w-20 h-20 bg-[#1C273E] rounded-full mx-auto flex items-center justify-center text-3xl">👩‍💼</div>
                            <div>
                                <h4 class="text-base font-bold text-white">Dr. Amanda K. Ross</h4>
                                <span class="text-[10px] text-lime-400 uppercase tracking-widest font-mono">Co-Founder & CEO</span>
                            </div>
                            <p class="text-slate-400 text-xs leading-relaxed">Logistics research specialist with 12+ years optimizing institutional fleet channels.</p>
                        </div>
                        <!-- Member 2 -->
                        <div class="bg-[#121824] p-6 rounded-3xl border border-slate-850 text-center space-y-4 shadow-lg">
                            <div class="w-20 h-20 bg-[#1C273E] rounded-full mx-auto flex items-center justify-center text-3xl">👨‍💻</div>
                            <div>
                                <h4 class="text-base font-bold text-white">Keith Bennett</h4>
                                <span class="text-[10px] text-lime-400 uppercase tracking-widest font-mono">Lead Telemetry Engineer</span>
                            </div>
                            <p class="text-slate-400 text-xs leading-relaxed">Core developer of the 2s low-latency GPS streaming pipelines.</p>
                        </div>
                        <!-- Member 3 -->
                        <div class="bg-[#121824] p-6 rounded-3xl border border-slate-850 text-center space-y-4 shadow-lg">
                            <div class="w-20 h-20 bg-[#1C273E] rounded-full mx-auto flex items-center justify-center text-3xl">👩‍💻</div>
                            <div>
                                <h4 class="text-base font-bold text-white">Elena Rostova</h4>
                                <span class="text-[10px] text-lime-400 uppercase tracking-widest font-mono">Customer Success Lead</span>
                            </div>
                            <p class="text-slate-400 text-xs leading-relaxed">Dedicated manager coordinates district support and billing SLA audits.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact / CTA -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Ready to Connect?</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        Have questions about our technology or team? Reach out and we will respond within 24 hours.
                    </p>
                    <div class="pt-4">
                        <a href="/contact" class="pulse-lime px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 inline-block">
                            Contact Us
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
