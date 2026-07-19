<x-guest-layout :plain="true">
    <!-- Custom Styles matching Cyber Obsidian -->
    <style>
        .transition-all-300 {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .pulse-lime {
            animation: pulse-glow 2s infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(163, 230, 53, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(163, 230, 53, 0); }
        }
    </style>

    <div class="min-h-screen bg-[#080B11] text-slate-100 flex flex-col justify-between">
        
        <!-- Header Navigation -->
        <header class="sticky top-0 z-40 w-full border-b border-slate-900/60 bg-[#080B11]/85 backdrop-blur-xl transition-all-300 text-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <!-- Brand Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-lime-400 shadow-md shadow-lime-500/20 group-hover:scale-105 transition-all-300">
                        <img src="{{ asset('logo.png') }}" class="h-6 w-auto" alt="WheelsTracker Logo">
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-200">WheelsTracker</span>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="/#features" class="text-sm font-medium text-slate-300 hover:text-lime-400 transition-colors">Features</a>
                    <a href="/parent-app" class="text-sm font-medium text-slate-300 hover:text-lime-400 transition-colors">Parent App</a>
                    <a href="/driver-app" class="text-sm font-semibold text-lime-400 transition-colors">Driver App</a>
                    <a href="/#simulator" class="text-sm font-medium text-slate-300 hover:text-lime-400 transition-colors">Live Demo</a>
                    <a href="/#roi" class="text-sm font-medium text-slate-300 hover:text-lime-400 transition-colors">School ROI</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-semibold text-slate-300 hover:text-lime-400 transition-colors">
                        Sign In
                    </a>
                    <a href="/" class="pulse-lime px-5 py-2.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm font-semibold shadow-lg shadow-lime-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all-300">
                        Get WheelsTracker
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="flex-grow">
            <!-- Hero -->
            <section class="py-20 bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 relative overflow-hidden">
                <div class="mx-auto max-w-7xl px-6 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Text Pitch -->
                    <div class="lg:col-span-7 space-y-6 text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                            👨‍✈️ Driver App Simplicity
                        </div>
                        <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                            Designed for Drivers. <br>
                            <span class="bg-gradient-to-r from-lime-450 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Built for Absolute Simplicity.</span>
                        </h1>
                        <p class="text-slate-400 text-base sm:text-lg leading-relaxed">
                            We designed the driver experience around the driver. Oversized touch targets, automated checklists, hands-free GPS sharing, and zero typing.
                        </p>

                        <!-- Quote box about simplicity -->
                        <div class="bg-slate-900/50 border border-slate-800 p-5 rounded-2xl max-w-xl text-sm leading-relaxed border-l-4 border-l-lime-400">
                            <span class="text-lime-400 font-extrabold uppercase text-[10px] tracking-wider block mb-1">No Technical Training Required</span>
                            "If your drivers know how to send a WhatsApp message, they can master WheelsTracker in 60 seconds."
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4 pt-2">
                            <button onclick="alert('Download from App Store simulated!')" class="px-6 py-3.5 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#121824] hover:text-white text-slate-200 text-sm font-bold flex items-center justify-center gap-2">
                                🍏 Download on App Store
                            </button>
                            <button onclick="alert('Download from Play Store simulated!')" class="px-6 py-3.5 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#121824] hover:text-white text-slate-200 text-sm font-bold flex items-center justify-center gap-2">
                                🤖 Download on Google Play
                            </button>
                        </div>
                    </div>

                    <!-- App Mockup Chassis -->
                    <div class="lg:col-span-5 flex justify-center">
                        <div class="relative w-[285px] h-[550px] rounded-[36px] bg-[#0A0D16] border-4 border-slate-800 shadow-2xl p-3 flex flex-col justify-between overflow-hidden">
                            <!-- Mobile Speaker & Notch -->
                            <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-28 h-4 rounded-full bg-slate-850 z-20 flex justify-center items-center">
                                <span class="w-8 h-1 rounded bg-slate-800"></span>
                            </div>

                            <!-- Screen Body -->
                            <div class="flex-grow bg-[#111625] rounded-[28px] overflow-hidden p-4 flex flex-col justify-between relative mt-4">
                                <!-- Top Bar -->
                                <div class="flex justify-between items-center text-[9px] text-slate-400 font-mono">
                                    <span>WheelsTracker Driver</span>
                                    <span class="text-amber-400 font-bold">READY TO START</span>
                                </div>

                                <!-- Dynamic Body View -->
                                <div class="my-4 flex-grow flex flex-col justify-between">
                                    <!-- Status Message -->
                                    <div class="text-left space-y-2 mt-4">
                                        <h4 class="text-sm font-black text-white">Morning Route #04</h4>
                                        <p class="text-[9px] text-slate-400">Scheduled: 07:30 AM • 6 Stops configured</p>
                                    </div>

                                    <!-- Safety check list -->
                                    <div class="bg-slate-900/60 p-3 rounded-xl border border-slate-850 space-y-1 text-[8.5px]">
                                        <div class="flex justify-between"><span>⚙️ Engine Check:</span><span class="text-emerald-400 font-bold">✓ OK</span></div>
                                        <div class="flex justify-between"><span>⛽ Fuel Status:</span><span class="text-emerald-400 font-bold">✓ 92%</span></div>
                                    </div>

                                    <!-- Huge CTA Button -->
                                    <button onclick="alert('Trip started!')" class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/20 active:scale-[0.98] duration-150 mt-6">
                                        🛫 Start Trip
                                    </button>
                                </div>

                                <!-- Bottom Status Bar -->
                                <div class="bg-[#1C273E] p-2.5 rounded-lg text-[9px] text-slate-400 text-center">
                                    Automatic live location share begins on dispatch
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Driver App Features Grid -->
            <section class="py-20 bg-[#080B11] border-b border-slate-900/60">
                <div class="mx-auto max-w-7xl px-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-[#121824] p-8 rounded-2xl border border-slate-850 space-y-4">
                            <span class="text-3xl">🎯</span>
                            <h3 class="text-xl font-bold text-white">One-Tap Dispatch</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Drivers simply open the app and tap "Start Trip." The system automatically registers the route path and notifies parents of the dispatch.
                            </p>
                        </div>
                        
                        <!-- Card 2 -->
                        <div class="bg-[#121824] p-8 rounded-2xl border border-slate-850 space-y-4">
                            <span class="text-3xl">📳</span>
                            <h3 class="text-xl font-bold text-white">Hands-Free GPS</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Background location sharing streams coordinates seamlessly. The phone can be mounted or pocketed; no manual map navigation interactions needed.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-[#121824] p-8 rounded-2xl border border-slate-850 space-y-4">
                            <span class="text-3xl">🚦</span>
                            <h3 class="text-xl font-bold text-white">Smart Safe-Drive Alerts</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Audio-alert mechanisms warn drivers if they cross speed limits or deviate from mapped routes, promoting absolute road safety.
                            </p>
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
                    <a href="/parent-app" class="hover:text-lime-400">Parent App</a>
                    <a href="/driver-app" class="hover:text-lime-400">Driver App</a>
                    <a href="/#features" class="hover:text-lime-400">Features</a>
                </div>
            </div>
        </footer>

    </div>
</x-guest-layout>
