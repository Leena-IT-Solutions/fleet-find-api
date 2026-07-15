<x-guest-layout :plain="true">
    <style>
        .transition-all-300 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .pulse-lime { animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(163, 230, 53, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(163, 230, 53, 0); }
        }
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
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
            <!-- Hero -->
            <section class="py-16 bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 text-center">
                <div class="mx-auto max-w-4xl px-6 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        🛠️ Capabilities Playground
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Complete Features Walkthrough
                    </h1>
                    <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                        Explore specific modules, custom interfaces, and B2B configurations for school administration panels, parents, and drivers.
                    </p>

                    <!-- Horizontal Primary Switches -->
                    <div class="flex justify-start md:justify-center gap-4 border-b border-slate-900/60 pt-8 text-xs sm:text-sm overflow-x-auto whitespace-nowrap scrollbar-none pb-1">
                        <a href="/features/parent-app" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            👶 Parent App
                        </a>
                        <a href="/features/driver-app" class="pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0">
                            👨‍✈️ Driver App
                        </a>
                        <a href="/features/school-dashboard" class="pb-3 text-lime-400 border-b-2 border-lime-400 font-bold px-2 flex-shrink-0">
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

            <!-- Playgrounds -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6">
                    
                    <!-- Parent Playground Block -->
                    <div id="features-block-parent" class="features-block hidden grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
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

                    <!-- Driver Playground Block -->
                    <div id="features-block-driver" class="features-block hidden grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-6 text-left">
                            <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Driver Checklist Portal</span>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">Simplicity for On-Road Operations</h2>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                A simple dashboard that requires no technical knowledge. Oversized touch controls, automated safety checks, and zero typing.
                            </p>
                            <div class="space-y-3.5 text-xs text-slate-300">
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Single tap dispatch start/stop triggers</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Automated background location streaming</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Oversized driver checklist controls</span></div>
                            </div>
                        </div>
                        <div class="lg:col-span-5 flex justify-center">
                            <div class="w-[260px] h-[480px] rounded-[32px] bg-[#0A0D16] border-4 border-slate-800 shadow-2xl p-3 flex flex-col justify-between overflow-hidden">
                                <div class="flex-grow bg-[#111625] rounded-[24px] overflow-hidden p-3 flex flex-col justify-between relative mt-2">
                                    <span class="text-[8px] text-slate-400">Driver Active Route</span>
                                    <div class="my-auto space-y-3">
                                        <div class="bg-slate-900/60 p-2.5 rounded-lg border border-slate-850 space-y-1 text-[8px]">
                                            <div class="flex justify-between"><span>⚙️ Engine Check:</span><span class="text-emerald-400 font-bold">✓ OK</span></div>
                                            <div class="flex justify-between"><span>⛽ Fuel Status:</span><span class="text-emerald-400 font-bold">✓ 92%</span></div>
                                        </div>
                                        <button onclick="alert('Trip started!')" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/20 active:scale-[0.98] duration-150">
                                            🛫 Start Trip
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- School Playground Block -->
                    <div id="features-block-school" class="features-block hidden grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-6 text-left">
                            <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Central Administration Console</span>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">One Dashboard. Total Operational Control.</h2>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Monitor routes, dispatch drivers, manage student rosters, and audit fleet analytics from a single desktop dashboard built for school administration teams.
                            </p>
                            <div class="space-y-3.5 text-xs text-slate-300">
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Complete fleet & driver diagnostics rosters</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Interactive route mapping stop networks</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Detailed fuel statistics & safety KPIs reports</span></div>
                            </div>
                        </div>
                        <div class="lg:col-span-5 flex justify-center bg-[#090D1A] rounded-[24px] border border-slate-800 shadow-2xl p-4 min-h-[300px]">
                            <div class="w-full rounded-xl bg-[#111625] border border-slate-800 shadow-xl flex flex-col overflow-hidden text-white">
                                <div class="flex items-center justify-between pb-1.5 border-b border-slate-900 px-3 pt-2">
                                    <div class="flex gap-1.5"><span class="w-2 h-2 rounded-full bg-red-500/80"></span><span class="w-2 h-2 rounded-full bg-yellow-500/80"></span><span class="w-2 h-2 rounded-full bg-green-500/80"></span></div>
                                    <span class="text-[7px] text-slate-500 font-mono">admin.wheelstracker.app</span>
                                </div>
                                <div class="bg-[#151D30] p-4 text-left min-h-[200px] flex flex-col justify-between text-[8px]">
                                    <div class="flex justify-between items-center border-b border-slate-800 pb-1.5">
                                        <h4 class="text-[10px] font-black">Vehicle Registry Fleet</h4>
                                    </div>
                                    <div class="space-y-1 mt-2">
                                        <div class="flex justify-between bg-[#1C273E] p-2 rounded"><span>🚌 Bus #04 (Force Traveller)</span><span class="text-emerald-400 font-bold">ONLINE</span></div>
                                        <div class="flex justify-between bg-[#1C273E] p-2 rounded"><span>🚌 Bus #11 (Tata Starbus)</span><span class="text-emerald-400 font-bold">ONLINE</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GPS Playground Block -->
                    <div id="features-block-gps" class="features-block hidden grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-6 text-left">
                            <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Telemetry Engine</span>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">Live GPS Coordinate Streams</h2>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Our backend captures vehicle location parameters every 2 seconds. The coordinates feed direct live maps to audit paths, speeds, and idle logs.
                            </p>
                            <div class="space-y-3.5 text-xs text-slate-300">
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>2-second latency GPS beacons streaming</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Automatic geofencing entrance / exit registry</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Interactive route deviations warning triggers</span></div>
                            </div>
                        </div>
                        <div class="lg:col-span-5 flex justify-center">
                            <!-- Beautiful Active GPS Telemetry Box -->
                            <div class="w-full max-w-sm bg-[#121824] border border-slate-850 p-6 rounded-3xl space-y-4 text-left">
                                <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                                    <span class="text-[9px] text-lime-400 uppercase font-black">GPS Sensor Node #102</span>
                                    <span class="text-[8px] bg-emerald-950/20 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded">CONNECTED</span>
                                </div>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between"><span>Latitude:</span><span class="text-slate-400 font-mono">28.6139° N</span></div>
                                    <div class="flex justify-between"><span>Longitude:</span><span class="text-slate-400 font-mono">77.2090° E</span></div>
                                    <div class="flex justify-between"><span>Active Speed:</span><span class="text-lime-400 font-bold">42 km/h</span></div>
                                    <div class="flex justify-between"><span>Current Stop:</span><span class="text-slate-400">Stop #4 (Sector 12)</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Playground Block -->
                    <div id="features-block-notifications" class="features-block hidden grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-6 text-left">
                            <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Automated Alerts Hub</span>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight">Instant Pickup & Arrival Alerts</h2>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Silence parent phone lines completely. The system auto-calculates distance thresholds and triggers notifications straight to parent mobile screens.
                            </p>
                            <div class="space-y-3.5 text-xs text-slate-300">
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Geofence pickup trigger alerts</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>School reached success notifications</span></div>
                                <div class="flex gap-3"><span class="text-lime-400">✓</span><span>Emergency delays announcement broadcasts</span></div>
                            </div>
                        </div>
                        <div class="lg:col-span-5 flex justify-center">
                            <!-- Smartphone Notification Bar Mockups -->
                            <div class="w-full max-w-sm space-y-3">
                                <div class="bg-[#1C273E] p-4 rounded-xl border border-slate-800 text-left relative overflow-hidden flex items-center gap-3">
                                    <span class="text-2xl">🔔</span>
                                    <div>
                                        <h5 class="text-[10px] font-bold text-white">WheelsTracker Alert</h5>
                                        <p class="text-[9px] text-slate-400">Bus #04 is 800m away. Please proceed to Stop #3.</p>
                                    </div>
                                </div>
                                <div class="bg-[#1C273E] p-4 rounded-xl border border-slate-800 text-left relative overflow-hidden flex items-center gap-3">
                                    <span class="text-2xl">🎓</span>
                                    <div>
                                        <h5 class="text-[10px] font-bold text-white">WheelsTracker School Arrival</h5>
                                        <p class="text-[9px] text-slate-400">Aarav has checked in at St. Jude's Academy.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Playground Block -->
                    <div id="features-block-reports" class="features-block hidden grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
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
                            <!-- Premium Graph Mockup -->
                            <div class="w-full max-w-sm bg-[#121824] border border-slate-850 p-6 rounded-3xl space-y-6 text-left">
                                <span class="text-[9px] text-slate-450 uppercase font-black block">Weekly Analytics Diagnostic</span>
                                <div class="space-y-4">
                                    <!-- Bar 1 -->
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-[9px] text-slate-300"><span>Fuel Cost Savings</span><span class="text-lime-400 font-bold">+15.4%</span></div>
                                        <div class="h-2 w-full bg-slate-900 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-lime-400 to-emerald-400 rounded-full" style="width: 78%"></div>
                                        </div>
                                    </div>
                                    <!-- Bar 2 -->
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

    <!-- JS Tabs Swapper -->
    <script>
        function setMainFeaturesTab(tabName) {
            const tabs = ['parent', 'driver', 'school', 'gps', 'notifications', 'reports'];
            tabs.forEach(t => {
                const btn = document.getElementById(`main-features-tab-${t}`);
                const block = document.getElementById(`features-block-${t}`);
                if (btn) {
                    if (t === tabName) {
                        btn.className = 'pb-3 text-lime-400 border-b-2 border-lime-400 transition-colors font-bold px-2 flex-shrink-0';
                    } else {
                        btn.className = 'pb-3 text-slate-400 hover:text-white transition-colors font-bold px-2 flex-shrink-0';
                    }
                }
                if (block) {
                    if (t === tabName) {
                        block.classList.remove('hidden');
                    } else {
                        block.classList.add('hidden');
                    }
                }
            });
        }

        window.addEventListener('DOMContentLoaded', () => {
            const initialTab = "{{ $activeTab ?? 'school' }}";
            setMainFeaturesTab(initialTab);
        });
    </script>
</x-guest-layout>
