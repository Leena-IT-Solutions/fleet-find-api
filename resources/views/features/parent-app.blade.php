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
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Parent App Capabilities</h1>
                    
                    <!-- Horizontal Switches -->
                    <div class="flex justify-start md:justify-center gap-4 border-b border-slate-900/60 pt-8 text-xs sm:text-sm overflow-x-auto whitespace-nowrap scrollbar-none pb-1">
                        <a href="/features/parent-app" class="pb-3 text-lime-400 border-b-2 border-lime-400 font-bold px-2 flex-shrink-0">
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
                        <a href="/features/reports" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            📊 Reports
                        </a>
                    </div>
                </div>
            </section>

            <!-- Detailed Content Block -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Parent Tracking Portal</span>
                        <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">Child Transit Status In Real-Time</h2>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Provide parents with live self-service maps displaying vehicle coordinates directly in their smartphone web browsers or dedicated mobile app downloads.
                        </p>
                        <div class="space-y-3.5 text-xs text-slate-300">
                            <div class="flex gap-3"><span class="text-lime-400">✓</span><span>ETA updates recalculated every 2 seconds</span></div>
                            <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Push alerts when the vehicle is 1 km from pickup stops</span></div>
                            <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Instant RFID scan boarding confirmations</span></div>
                        </div>
                    </div>
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="w-[260px] h-[480px] rounded-[32px] bg-[#0A0D16] border-4 border-slate-800 shadow-2xl p-3 flex flex-col justify-between overflow-hidden">
                            <div class="flex-grow bg-[#111625] rounded-[24px] overflow-hidden p-3 flex flex-col justify-between relative mt-2">
                                <span class="text-[8px] text-slate-400">Parent Tracker View</span>
                                <div class="h-32 bg-[#1C273E] rounded-lg border border-slate-800 relative overflow-hidden flex items-center justify-center my-3">
                                    <svg class="absolute inset-0 w-full h-full p-2" viewBox="0 0 100 100">
                                        <path d="M 0 45 L 100 45 M 50 0 L 50 100" stroke="#253556" stroke-width="4"/>
                                        <circle cx="15" cy="45" r="3" fill="#ef4444"/>
                                        <g transform="translate(60, 41)">
                                            <circle cx="4" cy="4" r="5" fill="#a3e635" class="animate-ping"/>
                                            <rect width="8" height="5" rx="1" fill="#a3e635"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="bg-[#1C273E]/70 p-2.5 rounded-lg text-left text-[8.5px] border border-slate-850">
                                    <span class="text-slate-450 uppercase font-black block text-[7px]">ETA stopped</span>
                                    <p class="text-sm font-black text-lime-400 mt-0.5">08:12 AM (On Time)</p>
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
