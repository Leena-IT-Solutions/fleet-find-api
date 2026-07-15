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
            <section class="py-20 bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 text-center">
                <div class="mx-auto max-w-4xl px-6 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        🚀 Company Profile
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Our Mission is to Secure <br>
                        <span class="bg-gradient-to-r from-lime-450 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Every Student Transit.</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">
                        WheelsTracker was founded by logistics and safety professionals who realized school transport was lagging behind modern technological solutions.
                    </p>
                </div>
            </section>

            <!-- Company details -->
            <section class="py-20 bg-[#080B11]">
                <div class="mx-auto max-w-3xl px-6 space-y-8 text-left leading-relaxed text-slate-300">
                    <p>
                        We build high-reliability tracking software specifically targeted at schools, transporter fleet operators, and student caretakers. We believe that tracking is not merely about finding coordinates on a grid; it is about providing families with absolute peace of mind and administrative operations with financial return on investment.
                    </p>
                    <p>
                        Our platform integrates custom browser-based consoles, high-contrast driver coordination timelines, and real-time parent self-service maps to cover all aspects of school transport logistics.
                    </p>
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
