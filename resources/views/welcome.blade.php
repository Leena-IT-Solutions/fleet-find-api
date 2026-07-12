<x-guest-layout :plain="true">
    <!-- Custom Styles for Premium Experience -->
    <style>
        /* Smooth transitions */
        .transition-all-300 {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Glassmorphism utility */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .dark-glass-panel {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Pulse glow animation for CTA buttons and pins */
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
            }
        }
        .pulse-indigo {
            animation: pulse-glow 2s infinite;
        }

        @keyframes float-slow {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }
        .float-animation {
            animation: float-slow 4s ease-in-out infinite;
        }

        /* Custom Scrollbar for simulator map log */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 2px;
        }
    </style>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-200/80 bg-white/70 backdrop-blur-xl transition-all-300">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 shadow-md shadow-indigo-600/10 group-hover:scale-105 transition-all-300">
                    <img src="{{ asset('logo.png') }}" class="h-6 w-auto logo-spin" alt="FleetFind Logo">
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">FleetFind</span>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Features</a>
                <a href="#simulator" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Live Demo</a>
                <a href="#roi" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">School ROI</a>
                <a href="#testimonials" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Success Stories</a>
            </nav>

            <!-- Nav Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ auth()->user()->hasRole('Admin') ? route('administrator') : route('organization.dashboard') }}" class="hidden sm:inline-flex text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-semibold text-slate-700 hover:text-indigo-600 transition-colors">
                        Sign In
                    </a>
                @endauth
                
                <button onclick="openDemoModal()" class="pulse-indigo px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold shadow-lg shadow-indigo-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all-300">
                    Book Free Demo
                </button>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="block md:hidden text-slate-600 focus:outline-none" aria-label="Toggle Navigation">
                    <svg id="menu-icon-open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                    <svg id="menu-icon-close" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-6 py-4 shadow-xl space-y-4">
            <a href="#features" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-indigo-600">Features</a>
            <a href="#simulator" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-indigo-600">Live Demo</a>
            <a href="#roi" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-indigo-600">School ROI</a>
            <a href="#testimonials" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-indigo-600">Success Stories</a>
            <div class="h-px bg-slate-100 my-2"></div>
            @auth
                <a href="{{ auth()->user()->hasRole('Admin') ? route('administrator') : route('organization.dashboard') }}" class="block text-base font-semibold text-slate-700 hover:text-indigo-600">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block text-base font-semibold text-slate-700 hover:text-indigo-600">
                    Sign In
                </a>
            @endauth
        </div>
    </header>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative overflow-hidden py-16 lg:py-24 bg-gradient-to-b from-indigo-50/40 via-white to-white">
            <div class="mx-auto max-w-7xl px-6">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:items-center">
                    
                    <!-- Text Content (Left Column) -->
                    <div class="lg:col-span-7 text-center lg:text-left space-y-6">
                        <!-- Upper Badge -->
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-semibold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                            Safety & Operations Platform
                        </div>

                        <!-- Emotional/Action Headline -->
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight">
                            Give Parents Complete <br class="hidden sm:inline">
                            <span class="bg-gradient-to-r from-indigo-600 via-violet-600 to-cyan-600 bg-clip-text text-transparent">Visibility of Child's Journey</span>
                        </h1>

                        <!-- Detailed Subtitle targeting School Owners -->
                        <p class="text-slate-600 text-lg sm:text-xl max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                            Live GPS tracking for school buses, vans, and auto rickshaws. Improve parent trust, reduce transport queries by 90%, and build a smarter, safer school.
                        </p>

                        <!-- CTA Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                            <button onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold shadow-xl shadow-indigo-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all-300 text-center">
                                Book Free Demo
                            </button>
                            <button onclick="openVideoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white hover:bg-slate-50 text-slate-800 font-bold border border-slate-200/80 shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                                Watch Demo Video
                            </button>
                        </div>

                        <!-- B2B Trust Badging -->
                        <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center justify-center lg:justify-start gap-x-6 gap-y-3">
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Setup in Under 24 Hours
                            </div>
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                No Costly Tracker Hardware Needed
                            </div>
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Dedicated Driver App
                            </div>
                        </div>
                    </div>

                    <!-- Visual Mockup (Right Column) -->
                    <div class="lg:col-span-5 relative flex justify-center">
                        <div class="relative w-full max-w-md lg:max-w-none float-animation">
                            <!-- Background glow decorative circles -->
                            <div class="absolute -top-12 -left-12 h-64 w-64 rounded-full bg-cyan-400/20 blur-3xl pointer-events-none"></div>
                            <div class="absolute -bottom-12 -right-12 h-64 w-64 rounded-full bg-violet-400/20 blur-3xl pointer-events-none"></div>
                            
                            <!-- Main Image Card Frame -->
                            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-3 shadow-2xl">
                                <img src="{{ asset('images/fleetfind_hero.png') }}" class="w-full h-auto object-cover rounded-xl" alt="School Fleet Tracking Concept">
                            </div>

                            <!-- Overlaid Floating Stat Badge 1 -->
                            <div class="absolute top-8 -left-6 md:-left-8 glass-panel rounded-2xl p-4 shadow-xl border border-white flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Student Status</p>
                                    <p class="text-sm font-extrabold text-slate-800">Aarav Arrived Safely</p>
                                </div>
                            </div>

                            <!-- Overlaid Floating Stat Badge 2 -->
                            <div class="absolute bottom-10 -right-4 glass-panel rounded-2xl p-4 shadow-xl border border-white flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-600">
                                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Bus 04 ETA</p>
                                    <p class="text-sm font-extrabold text-slate-800">3 Mins Away (On-Time)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Problem / Pain Points comparison (B2B focused) -->
        <section class="py-20 bg-slate-50 border-y border-slate-100">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                    <h2 class="text-xs uppercase font-extrabold tracking-wider text-indigo-600">The Operations Headache</h2>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Why Traditional School Transport Fails</p>
                    <p class="text-slate-500 text-base sm:text-lg">
                        Managing school transport manually is stressful, expensive, and leads to angry parents. Here is how FleetFind transforms your administration.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl p-8 border border-slate-200/60 shadow-sm flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-500 font-bold text-lg mb-2">01</div>
                            <h3 class="text-lg font-bold text-slate-800">Endless Anxious Phone Calls</h3>
                            <div class="space-y-3.5 pt-2">
                                <div class="flex gap-2.5 text-sm text-slate-400 line-through">
                                    <svg class="w-5 h-5 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Parents calling the office asking "Where is the bus?" and "Why is it late?" during your busiest morning hours.
                                </div>
                                <div class="flex gap-2.5 text-sm text-slate-600 font-medium">
                                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>The FleetFind Way:</strong> Live link and push notifications alert parents automatically as the bus nears their home.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl p-8 border border-slate-200/60 shadow-sm flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-500 font-bold text-lg mb-2">02</div>
                            <h3 class="text-lg font-bold text-slate-800">Zero Driver Accountability</h3>
                            <div class="space-y-3.5 pt-2">
                                <div class="flex gap-2.5 text-sm text-slate-400 line-through">
                                    <svg class="w-5 h-5 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    No way to monitor speeding, unauthorized driver detours, long stops, or rough driving.
                                </div>
                                <div class="flex gap-2.5 text-sm text-slate-600 font-medium">
                                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>The FleetFind Way:</strong> Automated speed alert logs, path deviations, and real-time mapping keep drivers responsible.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl p-8 border border-slate-200/60 shadow-sm flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-500 font-bold text-lg mb-2">03</div>
                            <h3 class="text-lg font-bold text-slate-800">Unknown Student Boarding</h3>
                            <div class="space-y-3.5 pt-2">
                                <div class="flex gap-2.5 text-sm text-slate-400 line-through">
                                    <svg class="w-5 h-5 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Manually tracking attendance or guessing if a child boarded the correct vehicle or reached the school.
                                </div>
                                <div class="flex gap-2.5 text-sm text-slate-600 font-medium">
                                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>The FleetFind Way:</strong> Optional QR/RFID card scans verify who is on board. Parents receive confirmation immediately.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive Product Simulator (B2B Showcase) -->
        <section id="simulator" class="py-20 bg-white">
            <div class="mx-auto max-w-7xl px-6">
                
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-12">
                    <h2 class="text-xs uppercase font-extrabold tracking-wider text-indigo-600">Product Interactive Tour</h2>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">One App. Two Distinct Interfaces.</p>
                    <p class="text-slate-500">
                        See how FleetFind solves administrative tracking headaches for you, while providing complete transparency and ease to parents.
                    </p>

                    <!-- Simulator Tabs -->
                    <div class="inline-flex rounded-xl bg-slate-100 p-1 mt-6">
                        <button onclick="switchTab('admin-panel')" id="tab-admin-panel" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-800 bg-white shadow-sm transition-all-300">
                            🔑 School Administrator View
                        </button>
                        <button onclick="switchTab('parent-app')" id="tab-parent-app" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-500 hover:text-slate-900 transition-all-300">
                            📱 Parent Mobile App View
                        </button>
                    </div>
                </div>

                <!-- Simulator Screens Container -->
                <div class="max-w-5xl mx-auto bg-slate-900 rounded-3xl p-4 md:p-6 shadow-2xl border border-slate-800">
                    
                    <!-- 1. School Admin Simulator Screen -->
                    <div id="sim-admin-panel" class="block space-y-6">
                        <!-- Simulated Admin Header -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-4 border-b border-slate-850 gap-3">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-white font-semibold text-sm">FleetFind Central Control Dashboard</span>
                                <span class="bg-indigo-900 text-indigo-300 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">St. Jude's Academy</span>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="alert('Simulation: Broadcast sent!')" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold px-3.5 py-1.5 rounded-lg transition-all-300">
                                    Broadcast Alert to Parents
                                </button>
                                <span class="bg-slate-850 text-slate-300 text-xs font-semibold px-3.5 py-1.5 rounded-lg border border-slate-800">
                                    Live Routes: 12/12 Active
                                </span>
                            </div>
                        </div>

                        <!-- Simulated Dashboard Workspace -->
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                            <!-- Left: Route List (col-span-4) -->
                            <div class="lg:col-span-4 space-y-3 max-h-[360px] overflow-y-auto pr-1 custom-scrollbar">
                                <p class="text-xs uppercase font-extrabold tracking-wider text-slate-500 px-1">Active Vehicles</p>
                                
                                <div class="bg-slate-850/80 rounded-xl p-3 border border-indigo-500/30 shadow-md">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-sm font-bold text-white">Route 04 - Sector-B Bus</h4>
                                            <p class="text-[11px] text-indigo-400 font-semibold">Driver: Ramesh Kumar</p>
                                        </div>
                                        <span class="text-[10px] bg-emerald-500/10 text-emerald-400 font-extrabold px-2 py-0.5 rounded border border-emerald-500/20">ON-TIME</span>
                                    </div>
                                    <div class="mt-2.5 flex items-center justify-between text-xs text-slate-400">
                                        <span>Speed: 42 km/h</span>
                                        <span>Attendance: 24/28</span>
                                    </div>
                                </div>

                                <div class="bg-slate-850/30 hover:bg-slate-850/50 rounded-xl p-3 border border-slate-800 transition-all-300 cursor-pointer">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-300">Route 11 - South-End Van</h4>
                                            <p class="text-[11px] text-slate-500 font-semibold">Driver: Amit Sen</p>
                                        </div>
                                        <span class="text-[10px] bg-amber-500/10 text-amber-400 font-extrabold px-2 py-0.5 rounded border border-amber-500/20">5M DELAY</span>
                                    </div>
                                    <div class="mt-2.5 flex items-center justify-between text-xs text-slate-400">
                                        <span>Speed: 38 km/h</span>
                                        <span>Attendance: 8/8</span>
                                    </div>
                                </div>

                                <div class="bg-slate-850/30 hover:bg-slate-850/50 rounded-xl p-3 border border-slate-800 transition-all-300 cursor-pointer">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-300">Route 02 - East Auto Rickshaw</h4>
                                            <p class="text-[11px] text-slate-500 font-semibold">Driver: K. Prasad</p>
                                        </div>
                                        <span class="text-[10px] bg-emerald-500/10 text-emerald-400 font-extrabold px-2 py-0.5 rounded border border-emerald-500/20">ON-TIME</span>
                                    </div>
                                    <div class="mt-2.5 flex items-center justify-between text-xs text-slate-400">
                                        <span>Speed: 25 km/h</span>
                                        <span>Attendance: 4/4</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Simulated Live Map (col-span-8) -->
                            <div class="lg:col-span-8 bg-slate-950 rounded-2xl relative min-h-[300px] border border-slate-800 overflow-hidden flex flex-col justify-between">
                                <!-- Map Graphic Background (Stylized dark vector map path) -->
                                <div class="absolute inset-0 opacity-25 bg-[radial-gradient(#1e293b_1.5px,transparent_1.5px)] [background-size:24px_24px] pointer-events-none"></div>
                                
                                <!-- Map Road Lines and Bus path -->
                                <svg class="absolute inset-0 w-full h-full p-4 pointer-events-none" viewBox="0 0 600 300" fill="none">
                                    <!-- Streets -->
                                    <path d="M 50 150 L 550 150 M 150 50 L 150 250 M 450 50 L 450 250 M 300 150 L 300 250" stroke="#334155" stroke-width="12" stroke-linecap="round"/>
                                    <!-- Bus Path -->
                                    <path d="M 150 220 L 150 150 L 410 150" stroke="#6366f1" stroke-width="3" stroke-dasharray="6,6" stroke-linecap="round"/>
                                    
                                    <!-- School Pin -->
                                    <circle cx="450" cy="150" r="10" fill="#06b6d4" class="animate-pulse"/>
                                    <text x="470" y="155" fill="#06b6d4" class="text-[11px] font-bold">ST. JUDE'S SCHOOL</text>
                                    
                                    <!-- Bus Moving -->
                                    <g transform="translate(320, 142)">
                                        <rect width="32" height="16" rx="4" fill="#fbbf24"/>
                                        <circle cx="8" cy="16" r="3" fill="#1e293b"/>
                                        <circle cx="24" cy="16" r="3" fill="#1e293b"/>
                                        <polygon points="26,4 32,8 26,12" fill="#d97706"/>
                                        <text x="6" y="-6" fill="#fbbf24" class="text-[9px] font-black">BUS 04</text>
                                    </g>
                                    
                                    <!-- Student Boarding point -->
                                    <circle cx="150" cy="220" r="6" fill="#10b981"/>
                                    <text x="165" y="223" fill="#10b981" class="text-[9px] font-semibold">Stop #3 (Aarav Boarded)</text>
                                </svg>

                                <!-- Top Overlay Bar: Info Box -->
                                <div class="relative z-10 glass-panel dark-glass-panel m-3 p-3.5 rounded-xl border border-slate-800 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-bold">Route 04: Active Tracking</p>
                                            <p class="text-slate-400 text-[10px]">Speed: 42 km/h | Limit: 60 km/h</p>
                                        </div>
                                    </div>
                                    <span class="text-slate-400 text-[10px] font-mono">Location: 28.6139° N, 77.2090° E</span>
                                </div>

                                <!-- Bottom Status Bar -->
                                <div class="relative z-10 p-3 bg-slate-900 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400 mt-auto">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                        Real-time feed active
                                    </span>
                                    <span>Last updated: Just now</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- 2. Parent App Simulator Screen -->
                    <div id="sim-parent-app" class="hidden space-y-6">
                        <!-- Two-Column Simulator inside container -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                            
                            <!-- Left Description Block -->
                            <div class="md:col-span-6 space-y-4">
                                <h3 class="text-xl font-bold text-white">How Parents Benefit (Saves Your Office Time)</h3>
                                <p class="text-slate-300 text-sm leading-relaxed">
                                    Parents receive a secure, encrypted link specific to their child's route. No App downloads are strictly required to start, ensuring 100% parent adoption.
                                </p>
                                <ul class="space-y-3 pt-2 text-sm text-slate-400">
                                    <li class="flex items-start gap-2.5">
                                        <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span><strong>Geo-Fence Proximity Alerts:</strong> Parents receive a push/SMS notification when the bus is exactly 10 minutes away, ending wait times in sun or rain.</span>
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span><strong>Boarding Validation:</strong> Parents know instantly when their kid boards the bus and reaches the school gate safely.</span>
                                    </li>
                                    <li class="flex items-start gap-2.5">
                                        <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span><strong>One-Tap Contact:</strong> Easily connect with the assigned driver or the school attendant with one click.</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Right Phone Mockup Block -->
                            <div class="md:col-span-6 flex justify-center">
                                <div class="w-64 h-[440px] rounded-[36px] bg-slate-950 p-2.5 border-[4px] border-slate-800 shadow-2xl relative flex flex-col overflow-hidden">
                                    <!-- Speaker/Camera Notch -->
                                    <div class="absolute top-2.5 left-1/2 transform -translate-x-1/2 w-20 h-4 bg-slate-850 rounded-full z-20 flex items-center justify-center">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-900"></span>
                                    </div>
                                    
                                    <!-- Mobile Screen Workspace -->
                                    <div class="flex-grow rounded-[28px] bg-slate-900 p-3 overflow-hidden flex flex-col justify-between relative">
                                        
                                        <!-- Top Status bar -->
                                        <div class="flex justify-between items-center text-[10px] text-slate-400 pt-1 px-2 z-10">
                                            <span>08:02 AM</span>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A1.002 1.002 0 013 10V5a2 2 0 012-2h5a1 1 0 01.707.293l7 7zM10 11a2 2 0 110-4 2 2 0 010 4z" clip-rule="evenodd"/></svg>
                                                <span>LTE</span>
                                            </div>
                                        </div>

                                        <!-- Phone App Header -->
                                        <div class="text-center pt-2 pb-2 border-b border-slate-800/80">
                                            <h4 class="text-xs font-bold text-white">FleetFind Parents</h4>
                                            <p class="text-[8px] text-indigo-400">Child: Aarav Gupta</p>
                                        </div>

                                        <!-- Mini Live Map mockup -->
                                        <div class="h-28 bg-slate-950 rounded-xl relative border border-slate-800 overflow-hidden my-2 flex items-center justify-center">
                                            <!-- Road Path SVG -->
                                            <svg class="absolute inset-0 w-full h-full p-2" viewBox="0 0 200 100" fill="none">
                                                <path d="M 20 50 L 180 50" stroke="#334155" stroke-width="8" stroke-linecap="round"/>
                                                <!-- Home Stop -->
                                                <circle cx="30" cy="50" r="4" fill="#ef4444"/>
                                                <text x="25" y="40" fill="#ef4444" class="text-[7px] font-bold">STOP</text>
                                                
                                                <!-- School Stop -->
                                                <circle cx="170" cy="50" r="4" fill="#06b6d4"/>
                                                
                                                <!-- Bus Avatar Moving -->
                                                <g id="animated-bus" transform="translate(60, 42)">
                                                    <rect width="18" height="10" rx="2" fill="#fbbf24"/>
                                                    <circle cx="4" cy="10" r="1.5" fill="#1e293b"/>
                                                    <circle cx="14" cy="10" r="1.5" fill="#1e293b"/>
                                                    <polygon points="15,2 18,5 15,8" fill="#d97706"/>
                                                </g>
                                            </svg>
                                            <span class="absolute bottom-1 right-2 text-[8px] bg-slate-900/90 text-indigo-400 font-extrabold px-1.5 py-0.5 rounded">Live GPS</span>
                                        </div>

                                        <!-- Live ETA Status Notification -->
                                        <div class="bg-indigo-950/80 border border-indigo-500/20 rounded-xl p-2.5 flex items-start gap-2">
                                            <div class="w-6 h-6 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 flex-shrink-0">
                                                <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div class="text-left leading-tight">
                                                <p class="text-[10px] font-bold text-white">Bus is 3 mins away</p>
                                                <p class="text-[8px] text-indigo-300">Approaching Stop #3 (Near Park)</p>
                                            </div>
                                        </div>

                                        <!-- Log Feed -->
                                        <div class="space-y-1.5 my-2 max-h-[100px] overflow-y-auto pr-0.5 custom-scrollbar text-[9px]">
                                            <div class="bg-slate-850/50 p-1.5 rounded-lg border border-slate-800 flex justify-between items-center">
                                                <span class="text-slate-300">👋 Route started</span>
                                                <span class="text-slate-500">07:30 AM</span>
                                            </div>
                                            <div id="sim-parent-board-log" class="bg-emerald-950/20 border border-emerald-500/10 p-1.5 rounded-lg flex justify-between items-center text-emerald-400">
                                                <span>✅ Aarav Boarded Bus</span>
                                                <span class="text-slate-500">07:42 AM</span>
                                            </div>
                                            <div class="bg-slate-850/20 p-1.5 rounded-lg flex justify-between items-center text-slate-500">
                                                <span>🏫 Safe arrival at School</span>
                                                <span>Pending</span>
                                            </div>
                                        </div>

                                        <!-- Contact Footer actions -->
                                        <a href="tel:123456" class="mt-auto block w-full text-center bg-slate-800 hover:bg-slate-750 text-white text-[9px] font-bold py-1.5 rounded-lg transition-all-300">
                                            📞 Call Attendant (Kamlesh)
                                        </a>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- Key Features Section (Grid Layout) -->
        <section id="features" class="py-20 bg-slate-50 border-t border-slate-100">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                    <h2 class="text-xs uppercase font-extrabold tracking-wider text-indigo-600">Enterprise Capabilities</h2>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Built to Modernize School Transport</p>
                    <p class="text-slate-500">
                        FleetFind packs all the tracking, billing, safety, and driver analytics tools into one unified, sleek management platform.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-500/20 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Live Route Mapping</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                See all active vehicles on an interactive dashboard. Monitor stops, live speeds, delays, and current route adherence in real-time.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-500/20 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Smart Proximity Alerts</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Automatically alerts parents via push notifications or SMS as the bus approaches their pickup or drop-off zone. Zero parent coordination needed.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-500/20 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Driver Safety Audits</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Get instant safety updates for speeding, harsh braking, and route violations. Generate detailed safety reports to ensure passenger security.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-500/20 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Secure Attendance Scans</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Integrate with lightweight RFID cards or QR code scanner apps. Log student boarding timestamps automatically and confirm child presence.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-500/20 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Smart Route Optimizer</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Automatically calculate the most fuel-efficient routes, bypassing traffic congestion. Optimize vehicles to reduce fuel expenses by 15% to 20%.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 hover:border-indigo-500/20 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all-300 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-2">Fee & Subscription Manager</h3>
                            <p class="text-slate-500 text-sm leading-relaxed">
                                Manage school transportation fees and digital tracking subscriptions from the central hub. Send automated reminders for pending dues.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ROI & Trust Statistics Section -->
        <section id="roi" class="py-20 bg-indigo-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:32px_32px] opacity-5 pointer-events-none"></div>
            
            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Text ROI pitch -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-indigo-200 text-xs font-semibold uppercase tracking-wider">
                            Measurable Impact
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">The Financial & Administrative Return on Investment</h2>
                        <p class="text-indigo-200 text-base sm:text-lg leading-relaxed">
                            Implementing FleetFind is not just about tracking; it pays for itself by optimizing your fleet operations, decreasing driver fuel waste, and relieving administrative staff from repetitive inquiries.
                        </p>
                        
                        <div class="space-y-4 pt-4">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm text-indigo-100"><strong>90% fewer incoming transport inquiries</strong>, giving administrative staff hours back daily to focus on admissions and school tasks.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm text-indigo-100"><strong>15-20% fuel cost savings</strong> by utilizing route optimizations and stopping driver vehicle misuse.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm text-indigo-100"><strong>Boost school enrollment appeal</strong>. Safety and real-time visibility are powerful marketing points for prospective parents.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics grid -->
                    <div class="lg:col-span-6 grid grid-cols-2 gap-6">
                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-cyan-400">90%</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-indigo-200 mt-2">Query Reduction</p>
                            <p class="text-[11px] text-indigo-300 mt-1">Parents track independently</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-emerald-400">20%</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-indigo-200 mt-2">Fuel Cost Savings</p>
                            <p class="text-[11px] text-indigo-300 mt-1">Due to AI optimized paths</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-yellow-400">100%</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-indigo-200 mt-2">Parent Adoption</p>
                            <p class="text-[11px] text-indigo-300 mt-1">Instant, code-based access</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-indigo-300">15m</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-indigo-200 mt-2">Saved Per Trip</p>
                            <p class="text-[11px] text-indigo-300 mt-1">By avoiding traffic bottlenecks</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Testimonial Slider Section -->
        <section id="testimonials" class="py-20 bg-white">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                    <h2 class="text-xs uppercase font-extrabold tracking-wider text-indigo-600">Client Reviews</h2>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Trusted by School Administrators</p>
                    <p class="text-slate-500">
                        Here is how schools and transport operations have streamlined their daily student tracking and communication using FleetFind.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <!-- Testimonial 1 -->
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-6">
                        <p class="text-slate-600 text-sm leading-relaxed italic">
                            "Before FleetFind, our reception area was pure chaos between 7:30 AM and 8:30 AM, with dozens of parents calling to ask why buses were running late. Now, our staff can focus on actual administrative duties because parents check the bus ETA directly on their phones. Our parents are happier, and our office is peaceful."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-600/10 flex items-center justify-center font-bold text-indigo-600">SM</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Sister Mary D'Souza</h4>
                                <p class="text-[11px] text-slate-500">Principal, St. Jude's Secondary School</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-6">
                        <p class="text-slate-600 text-sm leading-relaxed italic">
                            "We operate a fleet of 25 vans and buses across the city. Monitoring routes and driver behaviors was near impossible. FleetFind gave us route-deviation history and speeding logs in 24 hours. We reduced our monthly fuel invoice by 18% and improved student safety on day one."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-cyan-600/10 flex items-center justify-center font-bold text-cyan-600">VK</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Vikram Khanna</h4>
                                <p class="text-[11px] text-slate-500">Director, Khanna Kids Transport Services</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final Call to Action -->
        <section class="py-20 bg-gradient-to-t from-indigo-50/50 to-white border-t border-slate-100">
            <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Ready to build a smarter, safer school transport network?
                </h2>
                <p class="text-slate-500 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                    Set up your routes, map your stops, and invite parents. Start tracking with FleetFind in less than 24 hours. No hardware obligations.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                    <button onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold shadow-xl shadow-indigo-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all-300">
                        Schedule a Free Demo
                    </button>
                    <button onclick="openVideoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white hover:bg-slate-50 text-slate-800 font-bold border border-slate-200/80 shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all-300">
                        Explore Platform
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-200 bg-white py-12">
        <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="relative flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 shadow-md shadow-indigo-600/10">
                        <img src="{{ asset('logo.png') }}" class="h-5 w-auto" alt="FleetFind Logo">
                    </div>
                    <span class="text-lg font-bold tracking-tight text-slate-900">FleetFind</span>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed">
                    A clean, professional real-time GPS tracking and logistics solution designed specifically for schools and transport operators.
                </p>
            </div>
            <div>
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-900 mb-4">Product</h4>
                <ul class="space-y-2 text-xs text-slate-500">
                    <li><a href="#features" class="hover:text-indigo-600">Features</a></li>
                    <li><a href="#simulator" class="hover:text-indigo-600">Live Simulator</a></li>
                    <li><a href="#roi" class="hover:text-indigo-600">Administrative ROI</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-900 mb-4">Company</h4>
                <ul class="space-y-2 text-xs text-slate-500">
                    <li><a href="#" class="hover:text-indigo-600">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-indigo-600">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-indigo-600">Contact Sales</a></li>
                </ul>
            </div>
            <div class="space-y-3">
                <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-900 mb-4">Receive Updates</h4>
                <form onsubmit="event.preventDefault(); alert('Subscribed!')" class="flex gap-2">
                    <input type="email" placeholder="Work email" required class="min-w-0 flex-grow rounded-lg border border-slate-200 px-3 py-2 text-xs focus:border-indigo-500 focus:outline-none">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs px-4 py-2 rounded-lg transition-colors">
                        Join
                    </button>
                </form>
            </div>
        </div>
        <div class="mx-auto max-w-7xl px-6 mt-12 pt-6 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center text-slate-400 text-xs gap-4">
            <p>&copy; {{ date('Y') }} FleetFind. All rights reserved.</p>
            <p>Designed for schools and transport management authorities. <span class="block sm:inline sm:ml-1">(Designed & developed by <a href="https://leenaitsolutions.in/" target="_blank" rel="noopener" class="text-indigo-500 hover:text-indigo-600 font-semibold underline transition-colors">Leena IT Solutions</a>)</span></p>
        </div>
    </footer>

    <!-- Interactive "Book a Demo" Modal Overlay -->
    <div id="demo-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDemoModal()"></div>

        <!-- Modal Content Container -->
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">
                <!-- Close Button -->
                <button onclick="closeDemoModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- 1. Form View -->
                <div id="demo-form-view" class="px-6 py-8 sm:p-8 space-y-6">
                    <div class="space-y-2">
                        <h3 class="text-xl font-extrabold text-slate-950" id="modal-title">Book a Free 15-Min Demo</h3>
                        <p class="text-xs text-slate-500">
                            See how FleetFind solves parent queries and driver management for your specific fleet size.
                        </p>
                    </div>

                    <form id="demo-request-form" onsubmit="submitDemoForm(event)" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Your Name *</label>
                                <input type="text" required class="w-full rounded-lg border border-slate-200 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">School/Company Name *</label>
                                <input type="text" required class="w-full rounded-lg border border-slate-200 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Work Email *</label>
                            <input type="email" required class="w-full rounded-lg border border-slate-200 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Contact Number *</label>
                            <input type="tel" required class="w-full rounded-lg border border-slate-200 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Approximate Fleet Size *</label>
                            <select required class="w-full rounded-lg border border-slate-200 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                <option value="">Select Option</option>
                                <option value="1-5">1 - 5 vehicles (Buses/Vans/Rickshaws)</option>
                                <option value="6-20">6 - 20 vehicles</option>
                                <option value="21-50">21 - 50 vehicles</option>
                                <option value="50+">More than 50 vehicles</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-lg text-sm shadow-md transition-all-300">
                            Confirm Demo Request
                        </button>
                    </form>
                </div>

                <!-- 2. Success View -->
                <div id="demo-success-view" class="hidden px-6 py-12 text-center space-y-6">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto shadow-md">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xl font-extrabold text-slate-950">Thank you, Request Submitted!</h3>
                        <p class="text-sm text-slate-500 max-w-sm mx-auto">
                            We have received your demo request details. Our school logistics expert will contact you shortly at your provided email.
                        </p>
                    </div>
                    <button onclick="closeDemoModal()" class="w-32 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2 rounded-lg text-sm transition-all-300 mx-auto">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Interactive "Watch Demo" Modal Overlay -->
    <div id="video-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeVideoModal()"></div>

        <!-- Modal Content Container -->
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-slate-950 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-slate-800 p-1">
                <!-- Close Button -->
                <button onclick="closeVideoModal()" class="absolute -top-10 right-0 md:-top-3 md:-right-8 text-white hover:text-indigo-400 focus:outline-none text-2xl font-bold">
                    &times;
                </button>

                <!-- Mockup Video Interface -->
                <div class="aspect-video w-full rounded-xl bg-slate-900 overflow-hidden relative flex flex-col justify-between">
                    <!-- Top header -->
                    <div class="p-3 bg-gradient-to-b from-slate-950/80 to-transparent flex justify-between items-center text-xs text-white z-10">
                        <span>FleetFind - System Walkthrough</span>
                        <span class="bg-indigo-600 px-2 py-0.5 rounded font-bold">B2B DEMO</span>
                    </div>

                    <!-- Center Play button mockup -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-20 h-20 rounded-full bg-indigo-600 hover:bg-indigo-500 text-white flex items-center justify-center shadow-2xl cursor-pointer hover:scale-105 active:scale-95 transition-all-300 pulse-indigo" onclick="alert('Simulation: Playing walk-through video...')">
                            <svg class="w-10 h-10 ml-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Bottom Controls mockup -->
                    <div class="p-4 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent flex flex-col gap-2.5 z-10 text-white">
                        <!-- Progress bar -->
                        <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                            <div class="w-1/3 h-full bg-indigo-500 rounded-full"></div>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <div class="flex items-center gap-3">
                                <span>02:14 / 06:40</span>
                                <span>|</span>
                                <span>Volume: 80%</span>
                            </div>
                            <span class="text-indigo-400 font-bold">Dashboard & Driver App Overview</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Vanilla Javascript Logic -->
    <script>
        // Toggle mobile nav menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-icon-open');
            const closeIcon = document.getElementById('menu-icon-close');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        }

        // Tab switcher for Simulator
        function switchTab(tabName) {
            const adminTab = document.getElementById('tab-admin-panel');
            const parentTab = document.getElementById('tab-parent-app');
            const adminSim = document.getElementById('sim-admin-panel');
            const parentSim = document.getElementById('sim-parent-app');

            if (tabName === 'admin-panel') {
                adminTab.className = 'px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-800 bg-white shadow-sm transition-all-300';
                parentTab.className = 'px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-500 hover:text-slate-900 transition-all-300';
                adminSim.style.display = 'block';
                parentSim.style.display = 'none';
            } else {
                parentTab.className = 'px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-800 bg-white shadow-sm transition-all-300';
                adminTab.className = 'px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-500 hover:text-slate-900 transition-all-300';
                adminSim.style.display = 'none';
                parentSim.style.display = 'block';
                startParentAppAnimation();
            }
        }

        // Live interactive mobile animation inside simulator
        let animationInterval;
        function startParentAppAnimation() {
            // Reset state
            const bus = document.getElementById('animated-bus');
            const boardingLog = document.getElementById('sim-parent-board-log');
            if (!bus) return;

            bus.setAttribute('transform', 'translate(60, 42)');
            boardingLog.classList.add('hidden');

            if (animationInterval) clearInterval(animationInterval);

            let pos = 60;
            let boarded = false;

            animationInterval = setInterval(() => {
                pos += 2;
                if (pos > 160) {
                    pos = 60;
                    boarded = false;
                    boardingLog.classList.add('hidden');
                }
                
                // Show boarding log half way
                if (pos >= 110 && !boarded) {
                    boarded = true;
                    boardingLog.classList.remove('hidden');
                }

                bus.setAttribute('transform', `translate(${pos}, 42)`);
            }, 100);
        }

        // Modal Open/Close handlers
        function openDemoModal() {
            const modal = document.getElementById('demo-modal');
            const formView = document.getElementById('demo-form-view');
            const successView = document.getElementById('demo-success-view');

            formView.style.display = 'block';
            successView.style.display = 'none';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Lock background scroll
        }

        function closeDemoModal() {
            const modal = document.getElementById('demo-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function submitDemoForm(event) {
            event.preventDefault();
            const formView = document.getElementById('demo-form-view');
            const successView = document.getElementById('demo-success-view');

            formView.style.display = 'none';
            successView.style.display = 'block';
        }

        function openVideoModal() {
            const modal = document.getElementById('video-modal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('video-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    </script>
</x-guest-layout>
