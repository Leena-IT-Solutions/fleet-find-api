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
                    <a href="/features" class="font-semibold text-lime-400">Features</a>
                    <a href="/solutions" class="text-slate-300 hover:text-lime-400 transition-colors">Solutions</a>
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
            <!-- Sub Navigation Header -->
            <section class="bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 pt-12 pb-4 text-center">
                <div class="mx-auto max-w-4xl px-6 space-y-4">
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Reports & Diagnostics</h1>
                    
                    <!-- Horizontal Switches -->
                    <div class="flex justify-start md:justify-center gap-4 border-b border-slate-900/60 pt-8 text-xs sm:text-sm overflow-x-auto whitespace-nowrap scrollbar-none pb-1">
                        <a href="/features/parent-app" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            👶 Parent App
                        </a>
                        <a href="/features/driver-app" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            👨&zwj;✈️ Driver App
                        </a>
                        <a href="/features/school-dashboard" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            🏫 School Dashboard
                        </a>
                        <a href="/features/live-gps-tracking" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            📡 Live GPS Tracking
                        </a>
                        <a href="/features/notifications" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            🔔 Notifications
                        </a>
                        <a href="/features/reports" class="pb-3 text-lime-400 border-b-2 border-lime-400 font-bold px-2 flex-shrink-0">
                            📊 Reports
                        </a>
                    </div>
                </div>
            </section>

            <!-- Detailed Content Block -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">B2B Analytics Panel</span>
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">Actionable Operational Reports</h2>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Review detailed driver checklists, compliance grades, speed violations records, and generate fuel optimization plans.
                        </p>
                        <div class="space-y-3.5 text-xs text-slate-300">
                            <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Fuel consumption savings analytics graphs</span></div>
                            <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Driver attendance & check-in compliance logs</span></div>
                            <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Exportable CSV safety audit sheets</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="w-full max-w-sm bg-[#121824] border border-slate-850 p-6 rounded-3xl space-y-6 text-left">
                            <span class="text-[9px] text-slate-450 uppercase font-black font-mono">Weekly Diagnostics</span>
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[9px] text-slate-300"><span>Fuel Cost Savings</span><span class="text-lime-400 font-bold">+15.4%</span></div>
                                    <div class="h-2 w-full bg-slate-900 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-lime-400 to-emerald-400 rounded-full" style="width: 78%"></div>
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[9px] text-slate-300"><span>Idle Time Reduction</span><span class="text-lime-400 font-bold">-32 mins</span></div>
                                    <div class="h-2 w-full bg-slate-900 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-lime-400 to-emerald-400 rounded-full" style="width: 62%"></div>
                                    </div>
                                </div>
                            </div>
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
