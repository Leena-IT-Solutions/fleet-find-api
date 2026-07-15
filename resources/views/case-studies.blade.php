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
                    <a href="/pricing" class="text-slate-300 hover:text-lime-400 transition-colors">Pricing</a>
                    <a href="/case-studies" class="font-semibold text-lime-400">Case Studies</a>
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
                        📈 B2B Success Stories
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Measurable Fleet Impact <br>
                        <span class="bg-gradient-to-r from-lime-450 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">From Leading Academies.</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">
                        Read how transport managers and administrators optimize their route checklists and decrease fuel waste.
                    </p>
                </div>
            </section>

            <!-- Case Studies List -->
            <section class="py-20 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <!-- Case Study 1 -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-[#121824] p-8 sm:p-12 rounded-3xl border border-slate-850">
                        <div class="lg:col-span-7 space-y-4">
                            <span class="text-xs text-lime-400 font-extrabold uppercase tracking-wider">St. Jude's Academy</span>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white">Reclaimed 2.5 Hours Daily in Administrative Inquiries</h2>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                St. Jude's fleet of 12 buses was overwhelmed with parent phone inquiries about transit arrival delays. WheelsTracker's parent self-service ETA maps resolved 85% of telephone tickets.
                            </p>
                        </div>
                        <div class="lg:col-span-5 text-center bg-slate-900/50 p-6 rounded-2xl border border-slate-800 space-y-2">
                            <p class="text-4xl font-black text-lime-400">85%</p>
                            <p class="text-xs uppercase font-extrabold text-slate-400">Fewer Parent Calls</p>
                        </div>
                    </div>

                    <!-- Case Study 2 -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-[#121824] p-8 sm:p-12 rounded-3xl border border-slate-850">
                        <div class="lg:col-span-7 space-y-4">
                            <span class="text-xs text-lime-400 font-extrabold uppercase tracking-wider">Little Flowers School</span>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white">Eliminating Boarding Disputes with RFID Logs</h2>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Little Flowers School integrated automated RFID boarding tags across their vans. The school gate checks now take 3 minutes instead of 18 minutes.
                            </p>
                        </div>
                        <div class="lg:col-span-5 text-center bg-slate-900/50 p-6 rounded-2xl border border-slate-800 space-y-2">
                            <p class="text-4xl font-black text-lime-400">3 Mins</p>
                            <p class="text-xs uppercase font-extrabold text-slate-400">Boarding Check Completion</p>
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
                    <a href="/contact" class="hover:text-lime-400">Contact</a>
                </div>
            </div>
        </footer>

    </div>
</x-guest-layout>
