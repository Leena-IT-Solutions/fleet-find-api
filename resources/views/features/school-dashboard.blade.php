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
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">School Dashboard</h1>
                    
                    <!-- Horizontal Switches -->
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

            <!-- Desktop UI Mockup Section -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider font-mono">B2B Console Panel</span>
                        <h2 class="text-3xl font-bold text-white">Interactive Desktop UI Mockup</h2>
                        <p class="text-slate-400 text-sm">
                            Inspect our admin software dashboard layout. This layout provides complete visibility of active trips, vehicle health, driver rosters, and system security controls.
                        </p>
                    </div>

                    <!-- Browser Frame wrapper -->
                    <div class="bg-[#121824] rounded-[24px] border border-slate-850 shadow-2xl overflow-hidden flex flex-col">
                        <!-- Browser Header bar -->
                        <div class="bg-[#0B0F17] px-4 py-3 border-b border-slate-900 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-red-500/20 border border-red-500/30"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-500/20 border border-yellow-500/30"></span>
                                <span class="w-3 h-3 rounded-full bg-green-500/20 border border-green-500/30"></span>
                            </div>
                            <div class="flex-grow max-w-lg bg-[#121824] rounded-lg px-4 py-1.5 border border-slate-850 text-slate-500 text-[10px] sm:text-xs font-mono text-center">
                                admin.wheelstracker.app/dashboard
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-lime-400 animate-pulse"></span>
                                <span class="text-[9px] text-lime-400 font-mono font-bold">ONLINE</span>
                            </div>
                        </div>

                        <!-- Native HTML/CSS High-Fidelity Dashboard Rendering -->
                        <div class="w-full flex flex-col md:flex-row bg-[#F4F6F9] text-slate-800 min-h-[600px] text-left">
                            
                            <!-- Sidebar -->
                            <div class="w-full md:w-64 bg-[#0A1128] text-slate-350 p-4 space-y-6 flex flex-col">
                                <div class="flex items-center gap-2.5 px-2">
                                    <div class="w-8 h-8 rounded bg-blue-600 flex items-center justify-center text-white font-bold">W</div>
                                    <span class="text-sm font-black text-white tracking-widest uppercase">WHEELS&zwj;TRACKER</span>
                                </div>
                                <div class="space-y-4 text-xs">
                                    <div class="px-2 py-1.5 bg-blue-600 text-white rounded-lg font-bold flex items-center gap-2.5">
                                        <span>📊</span><span>Dashboard</span>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[9px] text-slate-500 uppercase font-black px-2 tracking-wider">Management</span>
                                        <span class="flex items-center gap-2 px-2 py-1 hover:text-white transition-colors cursor-pointer">🚌 Vehicle Management</span>
                                        <span class="flex items-center gap-2 px-2 py-1 hover:text-white transition-colors cursor-pointer">👨‍✈️ Driver Management</span>
                                        <span class="flex items-center gap-2 px-2 py-1 hover:text-white transition-colors cursor-pointer">🗺️ Route Management</span>
                                        <span class="flex items-center gap-2 px-2 py-1 hover:text-white transition-colors cursor-pointer">🎒 Student Management</span>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[9px] text-slate-500 uppercase font-black px-2 tracking-wider">Operations</span>
                                        <span class="flex items-center gap-2 px-2 py-1 hover:text-white transition-colors cursor-pointer">📡 Live Vehicle Monitoring</span>
                                        <span class="flex items-center gap-2 px-2 py-1 hover:text-white transition-colors cursor-pointer">📅 Daily Trips</span>
                                        <span class="flex items-center gap-2 px-2 py-1 hover:text-white transition-colors cursor-pointer">📋 Transport Reports</span>
                                    </div>
                                </div>
                                <div class="mt-auto bg-[#131F3F] p-3 rounded-lg border border-slate-800 text-[10px] space-y-1">
                                    <span class="block font-bold text-white">Need Help?</span>
                                    <a href="/contact" class="text-blue-400 hover:underline">Contact Support &rarr;</a>
                                </div>
                            </div>

                            <!-- Main Workspace -->
                            <div class="flex-grow p-5 sm:p-6 space-y-6 overflow-y-auto">
                                
                                <!-- Top Bar controls -->
                                <div class="flex justify-between items-center pb-4 border-b border-slate-200">
                                    <div class="flex items-center gap-3">
                                        <span class="text-lg font-bold text-slate-900">Sunshine School</span>
                                        <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded-full">Active Term</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-xs">
                                        <span class="relative cursor-pointer text-base">🔔<span class="absolute -top-1 -right-1.5 w-4 h-4 bg-red-500 text-white rounded-full flex items-center justify-center text-[7px] font-bold">5</span></span>
                                        <div class="flex items-center gap-2">
                                            <span class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-700">A</span>
                                            <div class="hidden sm:block">
                                                <span class="block font-bold text-slate-900 leading-tight">Admin</span>
                                                <span class="text-[9px] text-slate-500 leading-none">Super Administrator</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats Row -->
                                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                        <span class="text-2xl bg-blue-50 p-2 rounded-lg">🚌</span>
                                        <div class="text-xs">
                                            <span class="text-slate-500 uppercase text-[8px] font-black">Total Vehicles</span>
                                            <p class="text-lg font-extrabold text-slate-900">32</p>
                                            <span class="text-[9px] text-emerald-600 font-bold">Active: 28</span>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                        <span class="text-2xl bg-emerald-50 p-2 rounded-lg">👨‍✈️</span>
                                        <div class="text-xs">
                                            <span class="text-slate-500 uppercase text-[8px] font-black">Total Drivers</span>
                                            <p class="text-lg font-extrabold text-slate-900">28</p>
                                            <span class="text-[9px] text-emerald-600 font-bold">Active: 26</span>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                        <span class="text-2xl bg-amber-50 p-2 rounded-lg">🗺️</span>
                                        <div class="text-xs">
                                            <span class="text-slate-500 uppercase text-[8px] font-black">Total Routes</span>
                                            <p class="text-lg font-extrabold text-slate-900">16</p>
                                            <span class="text-[9px] text-emerald-600 font-bold">Active: 16</span>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3">
                                        <span class="text-2xl bg-purple-50 p-2 rounded-lg">🎒</span>
                                        <div class="text-xs">
                                            <span class="text-slate-500 uppercase text-[8px] font-black">Total Students</span>
                                            <p class="text-lg font-extrabold text-slate-900">1,245</p>
                                            <span class="text-[9px] text-emerald-600 font-bold">Active: 1,198</span>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3 col-span-2 lg:col-span-1">
                                        <span class="text-2xl bg-indigo-50 p-2 rounded-lg">🔄</span>
                                        <div class="text-xs">
                                            <span class="text-slate-500 uppercase text-[8px] font-black">Today's Trips</span>
                                            <p class="text-lg font-extrabold text-slate-900">64</p>
                                            <span class="text-[9px] text-indigo-600 font-bold">Completed: 52</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Live Vehicles & Daily Trips -->
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                    
                                    <!-- Live Map Preview (lg:col-span-7) -->
                                    <div class="lg:col-span-7 bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-3">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-xs font-black uppercase text-slate-500 tracking-wider">Live Vehicle Monitoring</h3>
                                            <span class="text-[10px] text-blue-600 cursor-pointer font-bold">View All &rarr;</span>
                                        </div>
                                        <div class="h-64 bg-[#E8ECEF] rounded-lg relative overflow-hidden border border-slate-300 flex items-center justify-center">
                                            <!-- SVG Road Vector Grid Map Mock -->
                                            <svg class="absolute inset-0 w-full h-full p-4" viewBox="0 0 200 120" fill="none">
                                                <path d="M 0 30 H 200 M 0 80 H 200 M 60 0 V 120 M 140 0 V 120" stroke="#CBD5E1" stroke-width="2"/>
                                                
                                                <!-- Bus route lines -->
                                                <path d="M 60 30 L 140 30 L 140 80" stroke="#3B82F6" stroke-width="2" stroke-dasharray="3 3"/>
                                                
                                                <!-- Bus 1 -->
                                                <g transform="translate(90, 27)">
                                                    <circle cx="3" cy="3" r="4" fill="#EAB308"/>
                                                    <rect x="10" y="-8" width="60" height="18" rx="3" fill="white" stroke="#E2E8F0" stroke-width="1"/>
                                                    <text x="14" y="0" fill="#0F172A" font-size="5" font-weight="bold">MH12 AB 1234</text>
                                                    <text x="14" y="6" fill="#10B981" font-size="4.5" font-weight="bold">32 km/h</text>
                                                </g>

                                                <!-- Bus 2 -->
                                                <g transform="translate(137, 50)">
                                                    <circle cx="3" cy="3" r="4" fill="#EAB308"/>
                                                    <rect x="10" y="-8" width="60" height="18" rx="3" fill="white" stroke="#E2E8F0" stroke-width="1"/>
                                                    <text x="14" y="0" fill="#0F172A" font-size="5" font-weight="bold">MH12 CD 5678</text>
                                                    <text x="14" y="6" fill="#10B981" font-size="4.5" font-weight="bold">28 km/h</text>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex flex-wrap gap-4 text-[9px] font-bold text-slate-500">
                                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-500"></span>On Trip</span>
                                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span>In Progress</span>
                                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>At School</span>
                                        </div>
                                    </div>

                                    <!-- Daily Trips List (lg:col-span-5) -->
                                    <div class="lg:col-span-5 bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-4">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-xs font-black uppercase text-slate-500 tracking-wider">Daily Trips Log</h3>
                                            <span class="text-[10px] text-blue-600 cursor-pointer font-bold">View All &rarr;</span>
                                        </div>
                                        <div class="grid grid-cols-4 gap-2 text-center text-[10px] pb-2 border-b border-slate-100">
                                            <div class="bg-slate-50 p-2 rounded">
                                                <span class="text-slate-500 block text-[8px] uppercase">Total</span>
                                                <span class="font-extrabold text-slate-900">64</span>
                                            </div>
                                            <div class="bg-emerald-50 p-2 rounded">
                                                <span class="text-emerald-700 block text-[8px] uppercase">Done</span>
                                                <span class="font-extrabold text-emerald-800">52</span>
                                            </div>
                                            <div class="bg-blue-50 p-2 rounded">
                                                <span class="text-blue-700 block text-[8px] uppercase">Active</span>
                                                <span class="font-extrabold text-blue-800">10</span>
                                            </div>
                                            <div class="bg-amber-50 p-2 rounded">
                                                <span class="text-amber-700 block text-[8px] uppercase">Wait</span>
                                                <span class="font-extrabold text-amber-800">2</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2 text-xs">
                                            <div class="flex justify-between items-center p-2 hover:bg-slate-50 rounded-lg">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-900">Route - Morning 01</span>
                                                    <span class="text-[9px] text-slate-500">Sunshine School - 08:10 AM</span>
                                                </div>
                                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[8px]">COMPLETED</span>
                                            </div>
                                            <div class="flex justify-between items-center p-2 hover:bg-slate-50 rounded-lg">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-900">Route - Morning 02</span>
                                                    <span class="text-[9px] text-slate-500">Green Park Stop - 08:15 AM</span>
                                                </div>
                                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[8px]">COMPLETED</span>
                                            </div>
                                            <div class="flex justify-between items-center p-2 hover:bg-slate-50 rounded-lg">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-slate-900">Route - Morning 03</span>
                                                    <span class="text-[9px] text-slate-500">City Mall Stop - 08:20 AM</span>
                                                </div>
                                                <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded font-bold text-[8px] animate-pulse">IN PROGRESS</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Quick Access & Analytics -->
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                                    
                                    <!-- Quick Access (lg:col-span-6) -->
                                    <div class="lg:col-span-6 bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-4">
                                        <h3 class="text-xs font-black uppercase text-slate-500 tracking-wider">Quick Actions</h3>
                                        <div class="grid grid-cols-2 gap-3 text-xs">
                                            <div class="p-3 bg-slate-50 rounded-lg hover:bg-slate-100 cursor-pointer border border-slate-200 space-y-1">
                                                <span class="text-lg">🚌</span>
                                                <h4 class="font-bold text-slate-900">Vehicle Management</h4>
                                                <p class="text-[10px] text-slate-500">Rosters, diagnostics, mileage audit.</p>
                                            </div>
                                            <div class="p-3 bg-slate-50 rounded-lg hover:bg-slate-100 cursor-pointer border border-slate-200 space-y-1">
                                                <span class="text-lg">👨‍✈️</span>
                                                <h4 class="font-bold text-slate-900">Driver Assignment</h4>
                                                <p class="text-[10px] text-slate-500">Licensing, shifts, profile setup.</p>
                                            </div>
                                            <div class="p-3 bg-slate-50 rounded-lg hover:bg-slate-100 cursor-pointer border border-slate-200 space-y-1">
                                                <span class="text-lg">🗺️</span>
                                                <h4 class="font-bold text-slate-900">Route Builder</h4>
                                                <p class="text-[10px] text-slate-500">Map stops and geo checkpoints.</p>
                                            </div>
                                            <div class="p-3 bg-slate-50 rounded-lg hover:bg-slate-100 cursor-pointer border border-slate-200 space-y-1">
                                                <span class="text-lg">🎒</span>
                                                <h4 class="font-bold text-slate-900">Student Profiles</h4>
                                                <p class="text-[10px] text-slate-500">Parent accounts and RFID card keys.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transport Reports Analytics (lg:col-span-6) -->
                                    <div class="lg:col-span-6 bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-4">
                                        <h3 class="text-xs font-black uppercase text-slate-500 tracking-wider">Transport Reports</h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Circular Pie Chart Mock -->
                                            <div class="flex flex-col items-center justify-center space-y-2 border-r border-slate-100">
                                                <div class="relative w-24 h-24 flex items-center justify-center">
                                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                        <path class="text-slate-100" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                        <path class="text-emerald-500" stroke-width="4.5" stroke-dasharray="81.3, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                    </svg>
                                                    <div class="absolute text-center">
                                                        <span class="block text-sm font-extrabold text-slate-900 leading-none">81.3%</span>
                                                        <span class="text-[8px] text-slate-500 uppercase leading-none">Completed</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Gauge Circle Chart -->
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <div class="relative w-24 h-24 flex items-center justify-center">
                                                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                                        <path class="text-slate-100" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                        <path class="text-blue-500" stroke-width="4.5" stroke-dasharray="93, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                                    </svg>
                                                    <div class="absolute text-center">
                                                        <span class="block text-sm font-extrabold text-slate-900 leading-none">93%</span>
                                                        <span class="text-[8px] text-slate-500 uppercase leading-none">On-Time</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Recent Alerts -->
                                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-3">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-xs font-black uppercase text-slate-500 tracking-wider">Recent Operational Alerts</h3>
                                        <span class="text-[10px] text-blue-600 cursor-pointer font-bold">View All &rarr;</span>
                                    </div>
                                    <div class="divide-y divide-slate-100 text-xs">
                                        <div class="py-2.5 flex justify-between">
                                            <span class="text-slate-700">⚠️ Bus MH12 AB 1234 exceeded optimal speed limit zone</span>
                                            <span class="text-slate-500 font-mono text-[10px]">07:52 AM</span>
                                        </div>
                                        <div class="py-2.5 flex justify-between">
                                            <span class="text-slate-700">🎒 Aarav Sharma scanner checkout registration confirmed</span>
                                            <span class="text-slate-500 font-mono text-[10px]">07:48 AM</span>
                                        </div>
                                        <div class="py-2.5 flex justify-between">
                                            <span class="text-slate-700">🏫 Bus MH12 EF 9012 entered Sunshine School boundary line</span>
                                            <span class="text-slate-500 font-mono text-[10px]">08:05 AM</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </section>

            <!-- Detailed Explanation Grid of 11 Modules -->
            <section class="py-16 bg-[#0B0F17] border-y border-slate-900/60 text-left">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Features Matrix</span>
                        <h2 class="text-3xl font-bold text-white">School Dashboard Admin Modules</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        <!-- Dashboard Overview -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">🏢</span>
                            <h4 class="text-base font-bold text-white">Dashboard Overview</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Central diagnostic dashboard metrics mapping online vehicle coordinates logs, student boarding index, and active shift statuses.</p>
                        </div>

                        <!-- Vehicle Management -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">🚌</span>
                            <h4 class="text-base font-bold text-white">Vehicle Management</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Register school buses, vans, and rickshaws. Input fuel mileage stats, license schedules, and vehicle health check alerts.</p>
                        </div>

                        <!-- Student Management -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">🎒</span>
                            <h4 class="text-base font-bold text-white">Student Management</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Manage student records rosters. Assign unique parent account logins, RFID scan boarding cards, and route stop preferences.</p>
                        </div>

                        <!-- Driver Management -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">👨‍✈️</span>
                            <h4 class="text-base font-bold text-white">Driver Management</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Audit shift timings checklist records, active licensing validity states, and driving safety scores metrics logs.</p>
                        </div>

                        <!-- Route Management -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">🗺️</span>
                            <h4 class="text-base font-bold text-white">Route Management</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Create route vectors and stop locations networks using interactive map configurations to save dispatch mileage.</p>
                        </div>

                        <!-- Trip Monitoring -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">🔄</span>
                            <h4 class="text-base font-bold text-white">Trip Monitoring</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Observe live active trips paths, delay alert notifications, and geofence exit/entrance milestones logs.</p>
                        </div>

                        <!-- Reports -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">📋</span>
                            <h4 class="text-base font-bold text-white">Reports</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Generate detailed daily shift check summaries, student attendance sheets, and exportable PDF audit logs.</p>
                        </div>

                        <!-- Analytics -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">📊</span>
                            <h4 class="text-base font-bold text-white">Analytics</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Examine operational fuel savings index graphs, route delays parameters, and passenger timing optimization histories.</p>
                        </div>

                        <!-- Notifications -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">🔔</span>
                            <h4 class="text-base font-bold text-white">Notifications</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Configure automated SMS proximity warnings, WhatsApp scan confirmations, and B2B emergency delay alert streams.</p>
                        </div>

                        <!-- Permissions -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2">
                            <span class="text-xl">🔑</span>
                            <h4 class="text-base font-bold text-white">Permissions</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Define school role permissions. Restrict access parameters for transporters, attendants, dispatchers, and accounting teams.</p>
                        </div>

                        <!-- Admin Controls -->
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 space-y-2 col-span-1 md:col-span-2 lg:col-span-1">
                            <span class="text-xl">⚙️</span>
                            <h4 class="text-base font-bold text-white">Admin Controls</h4>
                            <p class="text-slate-400 text-xs leading-relaxed">Global configuration center for security settings updates, API diagnostics keys, and custom billing controls.</p>
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
                    <a href="/privacy-policy" class="hover:text-lime-400">Privacy Policy</a>
                    <a href="/terms-conditions" class="hover:text-lime-400">Terms & Conditions</a>
                    <a href="/contact" class="hover:text-lime-400">Contact</a>
                </div>
            </div>
        </footer>

    </div>
</x-guest-layout>
