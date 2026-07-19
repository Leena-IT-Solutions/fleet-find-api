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
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Driver App</h1>
                    
                    <!-- Horizontal Switches -->
                    <div class="flex justify-start md:justify-center gap-4 border-b border-slate-900/60 pt-8 text-xs sm:text-sm overflow-x-auto whitespace-nowrap scrollbar-none pb-1">
                        <a href="/features/parent-app" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            👶 Parent App
                        </a>
                        <a href="/features/driver-app" class="pb-3 text-lime-400 border-b-2 border-lime-400 font-bold px-2 flex-shrink-0">
                            👨‍✈️ Driver App
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

            <!-- Simplicity introduction section -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-6">
                    <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider font-mono">Zero Learning Curve</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Designed for Simplicity.</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        School bus and van drivers have enough to focus on. That's why our application features oversized touch panels, zero-typing requirements, and automatic background location streaming coordinates.
                    </p>
                </div>
            </section>
            <!-- Driver Experience Section -->
            <section id="driver-experience" class="py-24 bg-slate-900 text-white relative overflow-hidden">
                <!-- Glowing background accents -->
                <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-emerald-500/10 blur-[120px] pointer-events-none"></div>
                <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-lime-950/20 blur-[120px] pointer-events-none"></div>

                <div class="mx-auto max-w-7xl px-6 relative z-10">
                    <!-- Section Header -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-16">
                        <div class="lg:col-span-8 space-y-4 text-left">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-400 text-xs font-semibold uppercase tracking-wider border border-white/5">
                                Driver App Simplicity
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-black tracking-tight">Driver Experience</h2>
                            <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-2xl">
                                We know that school bus and auto drivers are not technology experts. That’s why we built a hands-free app with oversized indicators and zero typing requirements.
                            </p>
                        </div>
                    </div>

                    <!-- Split Interactive Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        
                        <!-- Left: Timeline Selector & Simplicity Callout (col-span-5) -->
                        <div class="lg:col-span-5 space-y-8 text-left">
                            
                            <!-- Timeline steps list -->
                            <div class="space-y-4 relative">
                                <!-- Vertical track line indicator -->
                                <div class="absolute left-6 top-6 bottom-6 w-0.5 bg-slate-800"></div>

                                <!-- Step 1: Start Trip -->
                                <div onclick="setDriverExpStep(0)" id="driver-exp-step-0" class="relative pl-14 py-2 cursor-pointer group transition-all duration-300 opacity-100">
                                    <div id="driver-exp-node-0" class="absolute left-2.5 top-2.5 w-7 h-7 rounded-full bg-emerald-500 text-slate-950 font-black text-xs flex items-center justify-center ring-4 ring-emerald-500/20 transition-all duration-300">1</div>
                                    <h3 class="text-sm font-extrabold text-white group-hover:text-emerald-400 duration-300">Start Trip</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                        Drivers open the app, view their route card, and tap a single large green button to begin.
                                    </p>
                                </div>

                                <!-- Step 2: Live GPS -->
                                <div onclick="setDriverExpStep(1)" id="driver-exp-step-1" class="relative pl-14 py-2 cursor-pointer group transition-all duration-300 opacity-60 hover:opacity-100">
                                    <div id="driver-exp-node-1" class="absolute left-2.5 top-2.5 w-7 h-7 rounded-full bg-slate-800 text-slate-400 font-bold text-xs flex items-center justify-center transition-all duration-300">2</div>
                                    <h3 class="text-sm font-extrabold text-white group-hover:text-emerald-400 duration-300">Live GPS Active</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                        Runs completely in the background. Hands-free tracking keeps drivers focused on the road.
                                    </p>
                                </div>

                                <!-- Step 3: Pickup Complete -->
                                <div onclick="setDriverExpStep(2)" id="driver-exp-step-2" class="relative pl-14 py-2 cursor-pointer group transition-all duration-300 opacity-60 hover:opacity-100">
                                    <div id="driver-exp-node-2" class="absolute left-2.5 top-2.5 w-7 h-7 rounded-full bg-slate-800 text-slate-400 font-bold text-xs flex items-center justify-center transition-all duration-300">3</div>
                                    <h3 class="text-sm font-extrabold text-white group-hover:text-emerald-400 duration-300">Pickup Checked</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                        A simple checklist displays students at each stop. Tap checkmarks to mark boarded kids.
                                    </p>
                                </div>

                                <!-- Step 4: Drop Complete -->
                                <div onclick="setDriverExpStep(3)" id="driver-exp-step-3" class="relative pl-14 py-2 cursor-pointer group transition-all duration-300 opacity-60 hover:opacity-100">
                                    <div id="driver-exp-node-3" class="absolute left-2.5 top-2.5 w-7 h-7 rounded-full bg-slate-800 text-slate-400 font-bold text-xs flex items-center justify-center transition-all duration-300">4</div>
                                    <h3 class="text-sm font-extrabold text-white group-hover:text-emerald-400 duration-300">Drop Confirmation</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                        Tap confirmation once the bus pulls into the school gate. Parents get notified instantly.
                                    </p>
                                </div>

                                <!-- Step 5: End Trip -->
                                <div onclick="setDriverExpStep(4)" id="driver-exp-step-4" class="relative pl-14 py-2 cursor-pointer group transition-all duration-300 opacity-60 hover:opacity-100">
                                    <div id="driver-exp-node-4" class="absolute left-2.5 top-2.5 w-7 h-7 rounded-full bg-slate-800 text-slate-400 font-bold text-xs flex items-center justify-center transition-all duration-300">5</div>
                                    <h3 class="text-sm font-extrabold text-white group-hover:text-emerald-400 duration-300">End Trip</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                        Tap to close route logs. The app prompts a visual seating check to ensure no children remain.
                                    </p>
                                </div>
                            </div>

                            <!-- Simplicity Callout -->
                            <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 space-y-3 shadow-lg">
                                <h4 class="text-sm font-extrabold text-emerald-400 flex items-center gap-2">
                                    ✨ No Technical Knowledge Required
                                </h4>
                                <p class="text-xs text-slate-300 leading-relaxed">
                                    If your drivers know how to send a WhatsApp message, they can master WheelsTracker in 60 seconds. Our UI features oversized buttons, visual checklists, and zero typing fields.
                                </p>
                            </div>

                        </div>

                        <!-- Right: High-Fidelity Smartphone Mockup -->
                        <div class="lg:col-span-7 flex justify-center items-center">
                            <div class="relative max-w-[340px] sm:max-w-[380px] w-full transform hover:scale-[1.02] transition duration-500">
                                <img src="{{ asset('images/driver_experience_preview.png') }}" class="w-full h-auto drop-shadow-[0_25px_50px_rgba(0,0,0,0.5)] animate-fade-in" alt="WheelsTracker Driver App Screen Interface Mockup">
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </main>

        <!-- Footer -->
        <x-footer />

    <!-- Vanilla Javascript Logic -->
    <script>
        // Driver Experience Interactive Controller
        let activeDriverExpStep = 0;
        const totalDriverExpSteps = 5;

        function setDriverExpStep(stepIdx) {
            for (let i = 0; i < totalDriverExpSteps; i++) {
                const stepPanel = document.getElementById(`driver-exp-step-${i}`);
                const screenViewport = document.getElementById(`driver-exp-screen-${i}`);
                const nodeMarker = document.getElementById(`driver-exp-node-${i}`);
                
                if (i === stepIdx) {
                    if (stepPanel) {
                        stepPanel.classList.remove('opacity-60');
                        stepPanel.classList.add('opacity-100');
                    }
                    if (nodeMarker) {
                        nodeMarker.className = 'absolute left-2.5 top-2.5 w-7 h-7 rounded-full bg-emerald-500 text-slate-950 font-black text-xs flex items-center justify-center ring-4 ring-emerald-500/20 transition-all duration-300';
                    }
                    if (screenViewport) {
                        screenViewport.classList.remove('hidden');
                        screenViewport.classList.add('active');
                    }
                } else {
                    if (stepPanel) {
                        stepPanel.classList.add('opacity-60');
                        stepPanel.classList.remove('opacity-100');
                    }
                    if (nodeMarker) {
                        nodeMarker.className = 'absolute left-2.5 top-2.5 w-7 h-7 rounded-full bg-slate-800 text-slate-400 font-bold text-xs flex items-center justify-center transition-all duration-300';
                    }
                    if (screenViewport) {
                        screenViewport.classList.add('hidden');
                        screenViewport.classList.remove('active');
                    }
                }
            }
            activeDriverExpStep = stepIdx;
        }

        window.addEventListener('DOMContentLoaded', () => {
            setDriverExpStep(0);
        });
    </script>
</x-guest-layout>
