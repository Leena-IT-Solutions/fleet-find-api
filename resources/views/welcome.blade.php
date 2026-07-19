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
                box-shadow: 0 0 0 0 rgba(163, 230, 53, 0.4);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(163, 230, 53, 0);
            }
        }
        .pulse-lime {
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

        /* Timeline path marching ants animation */
        @keyframes march {
            to {
                stroke-dashoffset: -20;
            }
        }
        .marching-path {
            stroke-dasharray: 6, 4;
            animation: march 1s linear infinite;
        }

        /* Tab highlights for app showcase cycler */
        .showcase-tab-active {
            background-color: rgb(163, 230, 53);
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(163, 230, 53, 0.3);
        }

        /* Transition delays */
        .showcase-screen, .story-screen {
            opacity: 0;
            transform: scale(0.98);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .showcase-screen.active, .story-screen.active {
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-900/60 bg-[#080B11]/85 backdrop-blur-xl transition-all-300 text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-lime-400 shadow-md shadow-lime-500/20 group-hover:scale-105 transition-all-300">
                    <img src="{{ asset('logo.png') }}" class="h-6 w-auto logo-spin" alt="WheelsTracker Logo">
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-200">WheelsTracker</span>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="/features" class="text-slate-300 hover:text-lime-400 transition-colors">Features</a>
                <a href="/solutions" class="text-slate-300 hover:text-lime-400 transition-colors">Solutions</a>
                <a href="/pricing" class="text-slate-300 hover:text-lime-400 transition-colors">Pricing</a>
                <a href="/contact" class="text-slate-300 hover:text-lime-400 transition-colors">Contact</a>
            </nav>

            <!-- Nav Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ auth()->user()->hasRole('Admin') ? route('administrator') : route('organization.dashboard') }}" class="hidden sm:inline-flex text-sm font-semibold text-slate-300 hover:text-lime-400 transition-colors">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-semibold text-slate-300 hover:text-lime-400 transition-colors">
                        Sign In
                    </a>
                @endauth
                
                <a href="/book-demo" class="pulse-lime px-5 py-2.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm font-semibold shadow-lg shadow-lime-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all-300">
                    Book Demo
                </a>

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
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-900/80 bg-[#080B11] px-6 py-4 shadow-xl space-y-4 text-white">
            <a href="#features" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-lime-400">Features</a>
            <a href="#simulator" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-lime-400">Live Demo</a>
            <a href="#roi" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-lime-400">School ROI</a>
            <a href="#testimonials" onclick="toggleMobileMenu()" class="block text-base font-medium text-slate-600 hover:text-lime-400">Success Stories</a>
            <div class="h-px bg-[#111724] my-2"></div>
            @auth
                <a href="{{ auth()->user()->hasRole('Admin') ? route('administrator') : route('organization.dashboard') }}" class="block text-base font-semibold text-slate-700 hover:text-lime-400">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="block text-base font-semibold text-slate-700 hover:text-lime-400">
                    Sign In
                </a>
            @endauth
        </div>
    </header>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative overflow-hidden py-16 lg:py-24 bg-gradient-to-b from-[#0B0F17] via-[#080B11] to-[#0A0D16] border-b border-slate-900/60 text-slate-100">
            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:items-center">
                    
                    <!-- Text Content & Animated Timeline (Left Column) -->
                    <div class="lg:col-span-7 text-center lg:text-left space-y-6">
                        <!-- Upper Badge -->
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-lime-950/20 animate-pulse"></span>
                            Safety & Operations Platform
                        </div>

                        <!-- Main B2B Heading -->
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-200 leading-tight">
                            Transform Your School Transport <br class="hidden sm:inline">
                            <span class="bg-gradient-to-r from-lime-450 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">into a Smart, Trackable & Safer System</span>
                        </h1>

                        <!-- Detailed Subtitle -->
                        <p class="text-slate-400 text-lg sm:text-xl max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                            Real-time GPS tracking for School Buses, Vans & Auto Rickshaws that keeps parents informed and schools in control.
                        </p>

                        <!-- CTA Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                            <button onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black font-bold shadow-xl shadow-lime-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all-300 text-center">
                                Book Free Demo
                            </button>
                            <button onclick="openVideoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-transparent hover:bg-[#121824] text-slate-300 font-bold border border-slate-800 shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-lime-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                                Watch Live Demo
                            </button>
                        </div>

                        <!-- Animated Pathway Flow Background representation -->
                        <div class="relative w-full py-6 mt-10 bg-[#121824] border border-slate-900/80 rounded-2xl p-4 overflow-hidden shadow-sm">
                            <div class="absolute top-[38px] left-[10%] right-[10%] h-0.5 pointer-events-none">
                                <svg class="w-full h-1" fill="none">
                                    <line x1="0" y1="0" x2="100%" y2="0" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"/>
                                    <line id="hero-timeline-flow" x1="0" y1="0" x2="0%" y2="0" stroke="#4f46e5" stroke-width="2.5" class="marching-path transition-all duration-1000" stroke-linecap="round"/>
                                </svg>
                            </div>
                            
                            <!-- Bus icon moving along path -->
                            <div id="hero-timeline-bus" class="absolute top-[22px] h-8 w-8 text-yellow-500 transition-all duration-1000 ease-in-out pointer-events-none" style="left: 12.5%; margin-left: -16px;">
                                <svg class="w-8 h-8 filter drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 11H6V6h12v5zm3 1v5c0 .55-.45 1-1 1h-1c-.55 0-1-.45-1-1v-1H6v1c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1v-5c0-1.66 1.34-3 3-3V5c0-1.1.9-2 2-2h8c1.1 0 2 .9 2 2v1c1.66 0 3 1.34 3 3v3h-1zM6.5 16c.83 0 1.5-.67 1.5-1.5S7.33 13 6.5 13 5 13.67 5 14.5 5.67 16 6.5 16zm11 0c.83 0 1.5-.67 1.5-1.5S18.33 13 17.5 13 16 13.67 16 14.5s.67 1.5 1.5 1.5z"/>
                                </svg>
                            </div>

                            <!-- 4 Pathway Nodes -->
                            <div class="relative grid grid-cols-4 gap-2 text-center z-10">
                                <!-- Node 1 -->
                                <div class="flex flex-col items-center">
                                    <div id="hero-node-0" class="w-9 h-9 rounded-full bg-[#121824] border-2 border-lime-400 text-lime-400 flex items-center justify-center shadow-md transition-all duration-500">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    </div>
                                    <span id="hero-text-0" class="text-[9px] sm:text-xxs font-extrabold text-lime-400 uppercase tracking-wider mt-2.5">1. Driver starts trip</span>
                                </div>
                                <!-- Node 2 -->
                                <div class="flex flex-col items-center">
                                    <div id="hero-node-1" class="w-9 h-9 rounded-full bg-[#121824] border border-slate-800 text-slate-400 flex items-center justify-center shadow transition-all duration-500">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    </div>
                                    <span id="hero-text-1" class="text-[9px] sm:text-xxs font-extrabold text-slate-450 uppercase tracking-wider mt-2.5">2. School Bus moving</span>
                                </div>
                                <!-- Node 3 -->
                                <div class="flex flex-col items-center">
                                    <div id="hero-node-2" class="w-9 h-9 rounded-full bg-[#121824] border border-slate-800 text-slate-400 flex items-center justify-center shadow transition-all duration-500">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span id="hero-text-2" class="text-[9px] sm:text-xxs font-extrabold text-slate-450 uppercase tracking-wider mt-2.5">3. Parent tracks live</span>
                                </div>
                                <!-- Node 4 -->
                                <div class="flex flex-col items-center">
                                    <div id="hero-node-3" class="w-9 h-9 rounded-full bg-[#121824] border border-slate-800 text-slate-400 flex items-center justify-center shadow transition-all duration-500">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                    <span id="hero-text-3" class="text-[9px] sm:text-xxs font-extrabold text-slate-450 uppercase tracking-wider mt-2.5">4. Safe Arrival</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cycling App Showcase (Right Column) -->
                    <div class="lg:col-span-5 relative flex flex-col items-center w-full">
                        <!-- Navigation Tabs for Showcase -->
                        <div class="flex rounded-xl bg-[#111724] p-1 mb-6 border border-slate-900/80/50 w-full max-w-sm z-10 shadow-sm">
                            <button onclick="setTabShowcase('parent')" id="btn-showcase-parent" class="flex-grow py-2 rounded-lg text-xs font-bold text-slate-600 hover:text-slate-300 transition-all-300 showcase-tab-active">
                                Parent App
                            </button>
                            <button onclick="setTabShowcase('driver')" id="btn-showcase-driver" class="flex-grow py-2 rounded-lg text-xs font-bold text-slate-400 hover:text-slate-300 transition-all-300">
                                Driver App
                            </button>
                            <button onclick="setTabShowcase('admin')" id="btn-showcase-admin" class="flex-grow py-2 rounded-lg text-xs font-bold text-slate-400 hover:text-slate-300 transition-all-300">
                                Dashboard
                            </button>
                        </div>

                        <!-- Showcase Viewport -->
                        <div class="relative w-full max-w-md h-[460px] flex items-center justify-center">
                            <!-- 1. Screen Parent App -->
                            <div id="showcase-screen-parent" class="showcase-screen active absolute inset-0 flex items-center justify-center">
                                <div class="w-[210px] h-[430px] relative flex flex-col items-center justify-center overflow-hidden">
                                    <img src="{{ asset('images/parent_app_preview.png') }}" class="h-full w-auto object-contain filter drop-shadow-2xl animate-fade-in" alt="WheelsTracker Parent App Console Screen">
                                </div>
                            </div>

                            <!-- 2. Screen Driver App -->
                            <div id="showcase-screen-driver" class="showcase-screen absolute inset-0 flex items-center justify-center">
                                <div class="w-[210px] h-[430px] relative flex flex-col items-center justify-center overflow-hidden">
                                    <img src="{{ asset('images/driver_app_preview.png') }}" class="h-full w-auto object-contain filter drop-shadow-2xl animate-fade-in" alt="WheelsTracker Driver App Console Screen">
                                </div>
                            </div>

                            <!-- 3. Screen Admin Dashboard -->
                            <div id="showcase-screen-admin" class="showcase-screen absolute inset-0 flex items-center justify-center">
                                <div class="w-[380px] h-[240px] rounded-xl bg-slate-950/40 p-1 border border-slate-850 shadow-2xl relative flex flex-col overflow-hidden">
                                    <!-- Window Header mock -->
                                    <div class="flex items-center justify-between pb-1 border-b border-slate-900/60 text-left px-2 pt-1">
                                        <div class="flex gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500/80"></span>
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500/80"></span>
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500/80"></span>
                                        </div>
                                        <span class="text-[7px] text-slate-500 font-mono">admin.wheelstracker.com</span>
                                        <span class="text-[7px] bg-lime-950/20 text-lime-400 font-extrabold px-1.5 py-0.2 rounded-full scale-90 border border-lime-500/20">LIVE MAP</span>
                                    </div>
                                    <!-- Dashboard screenshot inside -->
                                    <div class="flex-grow rounded-lg overflow-hidden relative mt-1 bg-slate-900">
                                        <img src="{{ asset('images/school_dashboard_preview.png') }}" class="w-full h-full object-cover filter brightness-95" alt="WheelsTracker Admin School Transport Management Dashboard View">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Trust Bar Section -->
        <section class="border-b border-slate-900/60 bg-[#0B0F17] py-8 text-slate-400">
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                    <!-- Text Label -->
                    <div class="flex-shrink-0 text-center lg:text-left">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-slate-450">Trusted Partner for:</span>
                    </div>
                    <!-- Logos Group -->
                    <div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-6 opacity-75 hover:opacity-100 transition-opacity duration-300">
                        <!-- Schools Group Logo -->
                        <div class="flex items-center gap-2 text-slate-400 hover:text-lime-400 transition-colors cursor-default">
                            <svg class="w-6 h-6 text-slate-400 hover:text-lime-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479L12 21l-4.825-3.943a12.083 12.083 0 01.665-6.479L12 14z" />
                            </svg>
                            <span class="text-sm font-bold tracking-tight uppercase">Schools & Academies</span>
                        </div>
                        <!-- Transport Operators Logo -->
                        <div class="flex items-center gap-2 text-slate-400 hover:text-lime-400 transition-colors cursor-default">
                            <svg class="w-6 h-6 text-slate-400 hover:text-lime-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="text-sm font-bold tracking-tight uppercase">Transport Operators</span>
                        </div>
                        <!-- School Vans Logo -->
                        <div class="flex items-center gap-2 text-slate-400 hover:text-lime-400 transition-colors cursor-default">
                            <svg class="w-6 h-6 text-slate-400 hover:text-lime-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <span class="text-sm font-bold tracking-tight uppercase">School Vans</span>
                        </div>
                        <!-- Auto Rickshaw Networks Logo -->
                        <div class="flex items-center gap-2 text-slate-400 hover:text-lime-400 transition-colors cursor-default">
                            <svg class="w-6 h-6 text-slate-400 hover:text-lime-300 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-sm font-bold tracking-tight uppercase">Rickshaw Networks</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- The Problem Section -->
        <section class="py-20 bg-[#080B11] text-slate-200 border-t border-slate-900/60">
            <div class="mx-auto max-w-7xl px-6">
                <!-- Title Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-semibold uppercase tracking-wider border border-red-100">
                        Operational Friction
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-200 tracking-tight">Every School Faces These Daily Transport Challenges</h2>
                    <p class="text-slate-500 text-sm sm:text-base">
                        Daily coordination without automation introduces friction, wastes staff time, and creates avoidable tension with parents.
                    </p>
                </div>

                <!-- 6 Challenges Card Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Card 1: 📞 Parents constantly calling drivers -->
                    <div class="bg-[#121824] border border-slate-900/80 rounded-2xl p-6 hover:shadow-lg hover:border-red-500/20 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-[#121824] border border-slate-800 flex items-center justify-center text-lime-400 text-xl mb-5 shadow-sm">
                            📞
                        </div>
                        <h3 class="text-lg font-bold text-slate-300 mb-2">Parents constantly calling drivers</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Anxious parents flood driver phone lines during trips. This creates high stress, navigation delays, and severe road safety distractions.
                        </p>
                    </div>

                    <!-- Card 2: 🚌 Students waiting outside -->
                    <div class="bg-[#121824] border border-slate-900/80 rounded-2xl p-6 hover:shadow-lg hover:border-red-500/20 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-[#121824] border border-slate-800 flex items-center justify-center text-lime-400 text-xl mb-5 shadow-sm">
                            🚌
                        </div>
                        <h3 class="text-lg font-bold text-slate-300 mb-2">Students waiting outside</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Without reliable ETAs, children stand at pickup spots in pouring rain or extreme afternoon heat guessing arrival schedules.
                        </p>
                    </div>

                    <!-- Card 3: ⏰ Late buses causing complaints -->
                    <div class="bg-[#121824] border border-slate-900/80 rounded-2xl p-6 hover:shadow-lg hover:border-red-500/20 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-[#121824] border border-slate-800 flex items-center justify-center text-lime-400 text-xl mb-5 shadow-sm">
                            ⏰
                        </div>
                        <h3 class="text-lg font-bold text-slate-300 mb-2">Late buses causing complaints</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Unpredicted traffic delays spark high call volumes to school receptionists, overwhelming administrative desks with routine queries.
                        </p>
                    </div>

                    <!-- Card 4: 📍 No visibility of vehicle location -->
                    <div class="bg-[#121824] border border-slate-900/80 rounded-2xl p-6 hover:shadow-lg hover:border-red-500/20 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-[#121824] border border-slate-800 flex items-center justify-center text-lime-400 text-xl mb-5 shadow-sm">
                            📍
                        </div>
                        <h3 class="text-lg font-bold text-slate-300 mb-2">No visibility of vehicle location</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Neither the front desk nor the driver fleet manager knows the active coordinates of buses, leading to blind spots and guesswork.
                        </p>
                    </div>

                    <!-- Card 5: 👨💼 Schools unable to monitor drivers -->
                    <div class="bg-[#121824] border border-slate-900/80 rounded-2xl p-6 hover:shadow-lg hover:border-red-500/20 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-[#121824] border border-slate-800 flex items-center justify-center text-lime-400 text-xl mb-5 shadow-sm">
                            👨‍💼
                        </div>
                        <h3 class="text-lg font-bold text-slate-300 mb-2">Schools unable to monitor drivers</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            No logs for vehicle speeding, detour alerts, fuel wasting idles, or unauthorized vehicle runs, exposing the school to huge liabilities.
                        </p>
                    </div>

                    <!-- Card 6: 📢 Manual communication -->
                    <div class="bg-[#121824] border border-slate-900/80 rounded-2xl p-6 hover:shadow-lg hover:border-red-500/20 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-[#121824] border border-slate-800 flex items-center justify-center text-lime-400 text-xl mb-5 shadow-sm">
                            📢
                        </div>
                        <h3 class="text-lg font-bold text-slate-300 mb-2">Manual communication</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Staff must compile delay details and send frantic manual text alerts or coordinate chaotic parent WhatsApp groups for schedule updates.
                        </p>
                    </div>

                </div>

                <!-- Ending Callout: Sound familiar? -->
                <div class="mt-16 text-center max-w-2xl mx-auto space-y-4 pt-8 border-t border-slate-900/80">
                    <p class="text-2xl font-extrabold text-slate-200 tracking-tight">Sound familiar?</p>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                        Managing school transport doesn't have to be a daily operational crisis. WheelsTracker is built specifically to automate driver dispatch, silence parent phone lines, and keep safety first.
                    </p>
                    <div class="pt-2">
                        <button onclick="openDemoModal()" class="inline-flex items-center gap-2 text-sm font-bold text-lime-400 hover:text-lime-300 transition-colors">
                            See how WheelsTracker solves these challenges ➔
                        </button>
                    </div>
                </div>

            </div>
        </section>

        <!-- Key Features Section (Redesigned: Meet Wheels Tracker Story flow) -->
        <section id="features" class="py-20 bg-[#121824] border-t border-slate-900/80">
            <div class="mx-auto max-w-7xl px-6">
                <!-- Title Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 text-blue-650 text-xs font-semibold uppercase tracking-wider border border-lime-500/20 animate-pulse">
                        Operational Flow
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-200 tracking-tight">Meet Wheels Tracker</h2>
                    <p class="text-slate-500 text-sm sm:text-base">
                        Follow the connected story of a school transit journey, built on three devices working in perfect synchronization.
                    </p>
                </div>

                <!-- Split Layout Wrapper -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left: Story Timeline Steps (col-span-5) -->
                    <div class="lg:col-span-5 relative pl-12 py-2 text-left">
                        
                        <!-- Vertical Track Line -->
                        <div class="absolute left-4 top-8 bottom-8 w-0.5 bg-slate-200">
                            <!-- Active fill track that animates height -->
                            <div id="story-track-fill" class="w-full bg-gradient-to-b from-lime-400 to-emerald-500 rounded-full transition-all duration-500" style="height: 0%;"></div>
                        </div>

                        <!-- Step 1 Panel -->
                        <div onclick="setStoryStep(0)" id="story-step-0" class="relative p-6 rounded-2xl border border-slate-900/80 bg-[#121824] border border-slate-800 shadow-xl shadow-black/20 cursor-pointer transition-all duration-300 transform -translate-y-0.5 border-l-4 border-l-lime-400">
                            <!-- Node Marker -->
                            <div id="story-node-0" class="absolute -left-[42px] top-6 w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-xs ring-4 ring-amber-500/20 shadow-md shadow-amber-600/30 scale-110 border-2 border-amber-500 transition-all duration-300 z-10">
                                1
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-extrabold tracking-widest text-lime-400">Step 1: Driver Dispatch</span>
                                <h3 class="text-lg font-extrabold text-slate-200 mt-1">Starts Trip → GPS Starts</h3>
                                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                    Ramesh climbs into the bus, runs a quick vehicle pre-check checklist, and taps "Start Trip". Cloud tracking launches instantly.
                                </p>
                            </div>
                        </div>

                        <!-- Step 2 Panel -->
                        <div onclick="setStoryStep(1)" id="story-step-1" class="relative p-6 rounded-2xl border border-transparent bg-transparent cursor-pointer transition-all duration-300 opacity-60 hover:opacity-90">
                            <!-- Node Marker -->
                            <div id="story-node-1" class="absolute -left-[42px] top-6 w-8 h-8 rounded-full bg-white text-slate-400 flex items-center justify-center font-bold text-xs border-2 border-slate-900/80 transition-all duration-300 z-10">
                                2
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-extrabold tracking-widest text-lime-400">Step 2: Control Room</span>
                                <h3 class="text-lg font-extrabold text-slate-300/80 mt-1">Monitors Every Vehicle</h3>
                                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                    The St. Jude's central admin panel coordinates maps, speeds, stops, and driver behavior to ensure 100% route adherence.
                                </p>
                            </div>
                        </div>

                        <!-- Step 3 Panel -->
                        <div onclick="setStoryStep(2)" id="story-step-2" class="relative p-6 rounded-2xl border border-transparent bg-transparent cursor-pointer transition-all duration-300 opacity-60 hover:opacity-90">
                            <!-- Node Marker -->
                            <div id="story-node-2" class="absolute -left-[42px] top-6 w-8 h-8 rounded-full bg-white text-slate-400 flex items-center justify-center font-bold text-xs border-2 border-slate-900/80 transition-all duration-300 z-10">
                                3
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-extrabold tracking-widest text-lime-400">Step 3: Family Alerts</span>
                                <h3 class="text-lg font-extrabold text-slate-300/80 mt-1">Parents Track Live</h3>
                                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                    Aarav's parents get a proximity notification: "Bus is 3 mins away." They step out of the house exactly as the bus pulls up.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4 Panel -->
                        <div onclick="setStoryStep(3)" id="story-step-3" class="relative p-6 rounded-2xl border border-transparent bg-transparent cursor-pointer transition-all duration-300 opacity-60 hover:opacity-90">
                            <!-- Node Marker -->
                            <div id="story-node-3" class="absolute -left-[42px] top-6 w-8 h-8 rounded-full bg-white text-slate-400 flex items-center justify-center font-bold text-xs border-2 border-slate-900/80 transition-all duration-300 z-10">
                                4
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-extrabold tracking-widest text-lime-400">Step 4: Operations Completed</span>
                                <h3 class="text-lg font-extrabold text-slate-300/80 mt-1">Peace of Mind</h3>
                                <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                    Safe arrival check-ins confirm child presence. Admin phone inquiries drop to zero while trust rating rises.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Right: Large Device Showcase Viewport (col-span-7) -->
                    <div class="lg:col-span-7 flex items-center justify-center bg-[#090D1A] rounded-[32px] border border-slate-800 shadow-2xl p-6 md:p-8 min-h-[520px] relative overflow-hidden">
                        
                        <!-- Grid background pattern -->
                        <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:20px_20px] opacity-40 pointer-events-none"></div>

                        <!-- Floating Glow effects -->
                        <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-lime-950/20/10 blur-[100px] pointer-events-none"></div>
                        <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full bg-violet-500/10 blur-[100px] pointer-events-none"></div>
                        
                        <!-- Viewport Screen 1: Driver App (Phone Mockup) -->
                        <div id="story-screen-0" class="story-screen active flex items-center justify-center transition-all duration-500 w-full">
                            <!-- Beautiful phone mockup -->
                            <div class="w-[280px] h-[460px] rounded-[42px] bg-slate-950 p-3 border-[6px] border-slate-800 shadow-2xl relative flex flex-col overflow-hidden">
                                <!-- Phone Notch -->
                                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-28 h-4.5 bg-slate-850 rounded-full z-20 flex items-center justify-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-900"></span>
                                    <span class="w-8 h-1 bg-slate-900 rounded-full"></span>
                                </div>
                                <div class="flex-grow rounded-[32px] bg-slate-900 p-4 text-left flex flex-col justify-between relative overflow-hidden text-white pt-6">
                                    <div class="flex justify-between items-center text-[10px] text-slate-400">
                                        <span class="font-mono">07:30 AM</span>
                                        <span class="font-mono">LTE 🔋</span>
                                    </div>
                                    <div class="text-center border-b border-slate-800/80 pb-2">
                                        <h4 class="text-xs font-extrabold tracking-wide">Driver Console</h4>
                                        <p class="text-[8px] text-emerald-400 font-bold uppercase tracking-widest mt-0.5">Route 04 Active</p>
                                    </div>
                                    
                                    <div class="my-4 bg-slate-850/80 rounded-xl p-3 border border-slate-800 text-left space-y-2">
                                        <div class="flex justify-between items-center text-[9px] border-b border-slate-800 pb-1.5">
                                            <span class="text-slate-400">Assigned Route</span>
                                            <span class="font-bold text-white">Route 04 (Sector-B)</span>
                                        </div>
                                        <div class="space-y-1 text-[8px] text-slate-400">
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-emerald-500">✓</span>
                                                <span>Pre-Trip Checklist Completed</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-emerald-500">✓</span>
                                                <span>GPS Beacon Connected</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-950/40 border border-blue-500/20 p-2.5 rounded-xl text-center space-y-1 my-2">
                                        <p class="text-[8px] text-slate-400">Currently Streaming Location</p>
                                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 mx-auto animate-ping"></div>
                                    </div>
                                    
                                    <button class="w-full py-2.5 rounded-lg bg-lime-400 hover:bg-lime-300 text-slate-950 font-black font-extrabold text-[11px] shadow-lg shadow-lime-500/10 text-center tracking-wide">
                                        🟢 Live Broadcasting
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Viewport Screen 2: School Console (Browser Dashboard Mockup) -->
                        <div id="story-screen-1" class="story-screen hidden flex items-center justify-center transition-all duration-500 w-full">
                            <!-- Beautiful browser window mockup -->
                            <div class="w-full max-w-[480px] rounded-xl bg-[#111625] border border-slate-800 shadow-2xl relative flex flex-col overflow-hidden text-white">
                                <!-- Window controls -->
                                <div class="flex items-center justify-between pb-2 border-b border-slate-900 px-3 pt-2">
                                    <div class="flex gap-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full bg-red-500/80"></span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-green-500/80"></span>
                                    </div>
                                    <span class="text-[8px] text-slate-400 font-mono">dashboard.wheelstracker.app/transit</span>
                                    <span class="text-[8px] bg-blue-600/20 text-blue-400 px-2 py-0.5 rounded font-extrabold tracking-wide border border-blue-500/30 scale-90">12 ONLINE</span>
                                </div>
                                <div class="bg-[#151D30] rounded-b-xl p-3.5 text-left space-y-3.5">
                                    <div class="flex justify-between items-center pb-2 border-b border-slate-800">
                                        <div>
                                            <h4 class="text-xs font-bold">St. Jude's Operations Control</h4>
                                            <p class="text-[8px] text-slate-400">Real-time status check for active routes</p>
                                        </div>
                                    </div>
                                    <!-- Vehicles list -->
                                    <div class="space-y-2 text-[9px]">
                                        <div class="bg-[#1C273E] p-2.5 rounded-lg border border-blue-500/20 flex justify-between items-center shadow-sm">
                                            <div>
                                                <p class="font-bold text-white">Route 04 (Ramesh Kumar)</p>
                                                <p class="text-[7.5px] text-blue-300">Speed: 42 km/h | stops: normal</p>
                                            </div>
                                            <span class="text-[8px] text-emerald-400 bg-emerald-950/80 px-2 py-0.5 rounded font-extrabold border border-emerald-500/20">ON-TIME</span>
                                        </div>
                                        <div class="bg-[#1C273E] p-2.5 rounded-lg border border-slate-800/80 flex justify-between items-center opacity-85">
                                            <div>
                                                <p class="font-bold text-slate-300">Route 11 (Amit Sen)</p>
                                                <p class="text-[7.5px] text-slate-500">Speed: 0 km/h | Delay detected at Stop 2</p>
                                            </div>
                                            <span class="text-[8px] text-amber-400 bg-amber-950/80 px-2 py-0.5 rounded font-extrabold border border-amber-500/20 text-center">3m WAIT</span>
                                        </div>
                                    </div>
                                    <div class="bg-[#0B0F19] p-2.5 rounded text-[8px] text-slate-400 border border-slate-850 flex justify-between">
                                        <span>⚠️ Alert log: Vehicle 11 idle for 4 minutes at Stop #2</span>
                                        <span class="text-blue-400 font-bold hover:underline cursor-pointer">Notify Driver</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Viewport Screen 3: Parent App (Phone Mockup Map) -->
                        <div id="story-screen-2" class="story-screen hidden flex items-center justify-center transition-all duration-500 w-full">
                            <!-- Phone mockup -->
                            <div class="w-[280px] h-[460px] rounded-[42px] bg-slate-950 p-3 border-[6px] border-slate-800 shadow-2xl relative flex flex-col overflow-hidden">
                                <!-- Phone Notch -->
                                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-28 h-4.5 bg-slate-850 rounded-full z-20 flex items-center justify-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-900"></span>
                                    <span class="w-8 h-1 bg-slate-900 rounded-full"></span>
                                </div>
                                <div class="flex-grow rounded-[32px] bg-slate-900 p-4 text-left flex flex-col justify-between relative overflow-hidden text-white pt-6">
                                    
                                    <!-- Dynamic Push notification drop-down simulator -->
                                    <div class="absolute top-2 left-2 right-2 z-30 bg-white/95 backdrop-blur-md rounded-xl p-2.5 shadow-lg border border-slate-900/80 flex items-center gap-2 transform translate-y-1 animate-bounce">
                                        <div class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs">
                                            🔔
                                        </div>
                                        <div class="text-slate-300 flex-grow leading-none">
                                            <p class="text-[9px] font-bold text-slate-200">WheelsTracker Alert</p>
                                            <p class="text-[7.5px] text-slate-500 mt-0.5">Bus is 3 Mins away from Stop #3</p>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center text-[10px] text-slate-400 pt-6">
                                        <span class="font-mono">07:55 AM</span>
                                        <span class="font-mono">LTE</span>
                                    </div>
                                    
                                    <!-- GPS Map Preview -->
                                    <div class="h-32 bg-slate-950 rounded-xl relative border border-slate-800 overflow-hidden my-2 flex items-center justify-center">
                                        <svg class="absolute inset-0 w-full h-full p-2" viewBox="0 0 200 100" fill="none">
                                            <path d="M 20 50 L 180 50" stroke="#334155" stroke-width="8" stroke-linecap="round"/>
                                            <circle cx="30" cy="50" r="5" fill="#ef4444"/>
                                            <circle cx="170" cy="50" r="5" fill="#06b6d4"/>
                                            <g transform="translate(130, 42)">
                                                <rect width="18" height="10" rx="2" fill="#fbbf24"/>
                                                <circle cx="4" cy="10" r="1.5" fill="#1e293b"/>
                                                <circle cx="14" cy="10" r="1.5" fill="#1e293b"/>
                                            </g>
                                        </svg>
                                        <span class="absolute bottom-1 right-2 text-[7.5px] bg-slate-900/90 text-blue-400 font-bold px-1.5 py-0.5 rounded border border-slate-800">Live GPS Active</span>
                                    </div>
                                    
                                    <div class="bg-slate-850/80 border border-slate-800 rounded-xl p-2.5 space-y-1">
                                        <p class="text-[9px] font-bold text-slate-300">Live Status</p>
                                        <p class="text-[7.5px] text-slate-400">Child Stop: Stop #3 (Near Park). Please proceed to pick up stop.</p>
                                    </div>
                                    
                                    <a href="tel:123456" class="block w-full text-center bg-slate-800 hover:bg-slate-750 text-white text-[9px] font-bold py-2 rounded-lg transition-colors border border-slate-700 mt-2">
                                        📞 Call Driver Attendant
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Viewport Screen 4: Peace of Mind (Checklist confirmation) -->
                        <div id="story-screen-3" class="story-screen hidden flex items-center justify-center transition-all duration-500 w-full">
                            <!-- Beautiful card with success summary -->
                            <div class="w-full max-w-sm rounded-2xl bg-[#121824] border border-slate-800 shadow-2xl text-slate-200 text-left space-y-6">
                                <div class="flex items-center gap-4 border-b border-slate-800 pb-4">
                                    <div class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xl shadow-lg shadow-emerald-500/20">
                                        ✓
                                    </div>
                                    <div>
                                        <h4 class="text-base font-extrabold text-white">Journey Verified</h4>
                                        <p class="text-xs text-slate-400">Route 04 Sector-B Log Complete</p>
                                    </div>
                                </div>
                                <div class="space-y-3.5">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-400">On-Time Performance Rate</span>
                                        <span class="font-black text-emerald-400 bg-emerald-950/20 px-2 py-0.5 rounded border border-emerald-500/20">98.4%</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-400">Parent Telephone Inquiries</span>
                                        <span class="font-black text-emerald-400 bg-emerald-950/20 px-2 py-0.5 rounded border border-emerald-500/20">0 Calls Received</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-400">Fuel Consumption Reduction</span>
                                        <span class="font-black text-lime-400 bg-lime-950/20 px-2 py-0.5 rounded border border-lime-500/30">15% Saved</span>
                                    </div>
                                </div>
                                <div class="bg-lime-950/20 rounded-xl p-3.5 border border-lime-500/20 text-center text-xs text-lime-400">
                                    <p class="font-bold">✨ B2B Efficiency Impact</p>
                                    <p class="text-[11px] text-slate-400 mt-1">Parents track bus proactively on their phones, taking all transport query load off school admins.</p>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
        </section>

        <!-- Interactive Product Demo Section -->
        <section id="interactive-demo" class="py-24 bg-[#080B11] border-t border-slate-900/60 text-white">
            <div class="mx-auto max-w-7xl px-6">
                <!-- Title Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-12">
                    <h2 class="text-xs uppercase font-extrabold tracking-wider text-lime-400">Product Sandbox</h2>
                    <p class="text-3xl sm:text-4xl font-extrabold text-slate-200 tracking-tight">Interactive Product Demo</p>
                    <p class="text-slate-500 text-sm sm:text-base">
                        Toggle between tabs and click the features to preview real-time screens across all user apps.
                    </p>

                    <!-- Horizontal Primary Tabs Selector -->
                    <div class="inline-flex rounded-2xl bg-[#111724] p-1.5 mt-8 border border-slate-900/80">
                        <button onclick="switchDemoTab('parent')" id="demo-tab-parent" class="px-6 py-3 rounded-xl text-sm font-bold text-lime-400 bg-[#121824] text-lime-400 shadow-md border border-lime-500/20 transition-all duration-300">
                            📱 Parent App
                        </button>
                        <button onclick="switchDemoTab('driver')" id="demo-tab-driver" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-200 transition-all duration-300">
                            👨‍✈️ Driver App
                        </button>
                        <button onclick="switchDemoTab('school')" id="demo-tab-school" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-200 transition-all duration-300">
                            💻 School Dashboard
                        </button>
                    </div>
                </div>

                <!-- Main Layout Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mt-12">
                    
                    <!-- Left: Sub-Tabs Menu Panel (col-span-4) -->
                    <div class="lg:col-span-4 text-left">
                        
                        <!-- Parent App Sub-Menu -->
                        <div id="demo-menu-parent" class="space-y-2">
                            <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest px-3 mb-3">Parent App Screen list</h4>
                            <button onclick="switchDemoSubTab('parent-live-map')" id="link-parent-live-map" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-lime-950/20 text-lime-400 border-l-4 border-l-lime-400 font-bold transition-all duration-300 text-left">
                                🗺️ Live Map Tracking
                            </button>
                            <button onclick="switchDemoSubTab('parent-vehicle-details')" id="link-parent-vehicle-details" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                📦 Vehicle Specifications
                            </button>
                            <button onclick="switchDemoSubTab('parent-driver-info')" id="link-parent-driver-info" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                👤 Assigned Driver Details
                            </button>
                            <button onclick="switchDemoSubTab('parent-eta')" id="link-parent-eta" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                ⏱️ Proximity ETA Countdown
                            </button>
                            <button onclick="switchDemoSubTab('parent-notifications')" id="link-parent-notifications" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🔔 Push Notifications Log
                            </button>
                            <button onclick="switchDemoSubTab('parent-trip-history')" id="link-parent-trip-history" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                📜 School Trip History
                            </button>
                        </div>

                        <!-- Driver App Sub-Menu (Hidden by default) -->
                        <div id="demo-menu-driver" class="space-y-2 hidden">
                            <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest px-3 mb-3">Driver App Actions</h4>
                            <button onclick="switchDemoSubTab('driver-start-trip')" id="link-driver-start-trip" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🛫 Start Trip Pre-check
                            </button>
                            <button onclick="switchDemoSubTab('driver-share-location')" id="link-driver-share-location" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                📡 Share Live GPS Beacon
                            </button>
                            <button onclick="switchDemoSubTab('driver-student-pickup')" id="link-driver-student-pickup" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🚶 Student Pickup Check-in
                            </button>
                            <button onclick="switchDemoSubTab('driver-student-drop')" id="link-driver-student-drop" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🚪 Student Drop Confirmation
                            </button>
                            <button onclick="switchDemoSubTab('driver-stop-trip')" id="link-driver-stop-trip" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🏁 Stop Trip Report
                            </button>
                        </div>

                        <!-- School Dashboard Sub-Menu (Hidden by default) -->
                        <div id="demo-menu-school" class="space-y-2 hidden">
                            <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest px-3 mb-3">School Dashboard tabs</h4>
                            <button onclick="switchDemoSubTab('school-vehicle-list')" id="link-school-vehicle-list" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🚌 Vehicle Fleet Status
                            </button>
                            <button onclick="switchDemoSubTab('school-drivers')" id="link-school-drivers" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                👨‍✈️ Driver Roster list
                            </button>
                            <button onclick="switchDemoSubTab('school-students')" id="link-school-students" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🎓 Student Database Roster
                            </button>
                            <button onclick="switchDemoSubTab('school-routes')" id="link-school-routes" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                🛣️ Route Management Control
                            </button>
                            <button onclick="switchDemoSubTab('school-trips')" id="link-school-trips" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                📈 Live Transit Streams
                            </button>
                            <button onclick="switchDemoSubTab('school-reports')" id="link-school-reports" class="relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left">
                                📊 Operational Reports & ROI
                            </button>
                        </div>

                    </div>

                    <!-- Right: Dynamic Device Mockup Viewport (col-span-8) -->
                    <div class="lg:col-span-8 flex items-center justify-center bg-[#090D1A] rounded-[32px] border border-slate-800 shadow-2xl p-6 md:p-8 min-h-[560px] relative overflow-hidden">
                        
                        <!-- Grid background pattern -->
                        <div class="absolute inset-0 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:20px_20px] opacity-40 pointer-events-none"></div>

                        <!-- Floating Glow effects -->
                        <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-lime-950/20/10 blur-[100px] pointer-events-none"></div>
                        <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full bg-violet-500/10 blur-[100px] pointer-events-none"></div>
                        
                        <!-- DEVICE 1: Phone Shell (For Parent & Driver Apps) -->
                        <div id="demo-phone-shell" class="relative z-10 flex items-center justify-center">
                            <div class="w-[285px] h-[480px] rounded-[44px] bg-slate-950 p-3 border-[6px] border-slate-850 shadow-2xl relative flex flex-col overflow-hidden">
                                <!-- Phone Notch -->
                                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 w-28 h-4.5 bg-slate-850 rounded-full z-20 flex items-center justify-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-900"></span>
                                    <span class="w-8 h-1 bg-slate-900 rounded-full"></span>
                                </div>
                                <div class="flex-grow rounded-[32px] bg-slate-900 p-4 text-left flex flex-col justify-between relative overflow-hidden text-white pt-6">
                                    
                                    <!-- ==================== PARENT SCREENS ==================== -->
                                    
                                    <!-- Parent: Live Map -->
                                    <div id="screen-parent-live-map" class="story-screen active flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Live Route Map</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Bus 04: sector-B</p>
                                        </div>
                                        <div class="h-44 bg-slate-950 rounded-xl relative border border-slate-800 overflow-hidden my-2 flex items-center justify-center">
                                            <svg class="absolute inset-0 w-full h-full p-2" viewBox="0 0 200 100" fill="none">
                                                <path d="M 20 50 L 180 50 M 80 10 L 80 90" stroke="#334155" stroke-width="8" stroke-linecap="round"/>
                                                <circle cx="30" cy="50" r="5" fill="#ef4444"/>
                                                <circle cx="170" cy="50" r="5" fill="#06b6d4"/>
                                                <g transform="translate(110, 42)">
                                                    <rect width="18" height="10" rx="2" fill="#fbbf24" class="animate-pulse"/>
                                                    <circle cx="4" cy="10" r="1.5" fill="#1e293b"/>
                                                    <circle cx="14" cy="10" r="1.5" fill="#1e293b"/>
                                                </g>
                                            </svg>
                                            <span class="absolute bottom-1 right-2 text-[7px] bg-slate-900/90 text-blue-400 font-bold px-1.5 py-0.5 rounded border border-slate-800">Route 04 Moving</span>
                                        </div>
                                        <div class="bg-blue-950/40 border border-blue-500/20 rounded-xl p-2.5 text-center mt-auto">
                                            <p class="text-[9px] font-bold text-white">Status: En Route</p>
                                            <p class="text-[7.5px] text-slate-400 mt-0.5">Approaching Stop #3 (School Gate next)</p>
                                        </div>
                                    </div>

                                    <!-- Parent: Vehicle Details -->
                                    <div id="screen-parent-vehicle-details" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Vehicle Specifications</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Route 04 Transport Details</p>
                                        </div>
                                        <div class="my-4 space-y-2 flex-grow justify-center flex flex-col">
                                            <div class="bg-slate-850 p-2.5 rounded-xl border border-slate-800 text-[10px] space-y-1.5">
                                                <div class="flex justify-between border-b border-slate-800 pb-1"><span class="text-slate-400">Model:</span><span class="font-bold">Force Traveller 26-Seater</span></div>
                                                <div class="flex justify-between border-b border-slate-800 pb-1"><span class="text-slate-400">License Plate:</span><span class="font-bold text-blue-400">DL-1P-C-9872</span></div>
                                                <div class="flex justify-between border-b border-slate-800 pb-1"><span class="text-slate-400">Insurance Expiry:</span><span class="font-bold text-emerald-400">Dec 2026</span></div>
                                                <div class="flex justify-between"><span class="text-slate-400">Pollution Certificate:</span><span class="font-bold text-emerald-400">Active (Checked)</span></div>
                                            </div>
                                        </div>
                                        <div class="p-2 bg-emerald-950/20 border border-emerald-500/20 text-emerald-400 text-center rounded-xl text-[8.5px] mt-auto">
                                            🛡️ School Certified & Fully Insured Transit vehicle
                                        </div>
                                    </div>

                                    <!-- Parent: Driver Information -->
                                    <div id="screen-parent-driver-info" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Assigned Driver</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Safety Profile</p>
                                        </div>
                                        <div class="my-4 text-center space-y-3 flex-grow flex flex-col justify-center">
                                            <div class="w-14 h-14 bg-blue-950/40 rounded-full mx-auto border border-blue-500/20 flex items-center justify-center text-xl">
                                                👨‍✈️
                                            </div>
                                            <div>
                                                <h5 class="text-xs font-bold">Ramesh Kumar</h5>
                                                <p class="text-[8.5px] text-slate-400">8 Years experience in School Transport</p>
                                            </div>
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-slate-800 rounded-full text-[8.5px] text-yellow-400 mx-auto">
                                                ⭐ 4.9 Rating (204 parents)
                                            </div>
                                        </div>
                                        <div class="p-2 bg-blue-950/30 border border-blue-500/20 text-blue-300 text-center rounded-xl text-[8.5px] mt-auto">
                                            ✓ Police background verification completed
                                        </div>
                                    </div>

                                    <!-- Parent: ETA -->
                                    <div id="screen-parent-eta" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Live ETA Countdown</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Stop #3 Pickup stop</p>
                                        </div>
                                        <div class="my-6 text-center space-y-4 flex-grow flex flex-col justify-center">
                                            <div class="text-3xl font-black text-white animate-pulse">03 Mins</div>
                                            <p class="text-[9px] text-slate-400 px-4 leading-relaxed">Driver Ramesh Kumar is approaching your stop. Please prepare to pick up child.</p>
                                        </div>
                                        <button class="w-full py-2 bg-slate-800 text-[9px] rounded-lg text-slate-350 font-bold text-center border border-slate-700 mt-auto">
                                            🔔 Enable Extra Loud Alert
                                        </button>
                                    </div>

                                    <!-- Parent: Notifications -->
                                    <div id="screen-parent-notifications" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Notifications Feed</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Live Alert updates</p>
                                        </div>
                                        <div class="my-3 space-y-1.5 flex-grow overflow-y-auto max-h-[220px]">
                                            <div class="bg-slate-850 p-2 rounded-lg border border-slate-800 text-[8px] flex justify-between">
                                                <span>🚦 Route 04 completed</span><span class="text-slate-400">08:12 AM</span>
                                            </div>
                                            <div class="bg-slate-850 p-2 rounded-lg border border-slate-800 text-[8px] flex justify-between">
                                                <span>🏫 Aarav reached school</span><span class="text-slate-400">08:11 AM</span>
                                            </div>
                                            <div class="bg-slate-850 p-2 rounded-lg border border-slate-800 text-[8px] flex justify-between">
                                                <span>✓ Aarav boarded bus</span><span class="text-slate-400">07:42 AM</span>
                                            </div>
                                            <div class="bg-slate-850 p-2 rounded-lg border border-slate-800 text-[8px] flex justify-between">
                                                <span>🛫 Route 04 started trip</span><span class="text-slate-400">07:30 AM</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Parent: Trip History -->
                                    <div id="screen-parent-trip-history" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Trip Logs</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Past Transit Archives</p>
                                        </div>
                                        <div class="my-3 space-y-1.5 flex-grow overflow-y-auto max-h-[220px]">
                                            <div class="bg-slate-850 p-2 rounded-lg border border-slate-800 text-[8.5px] flex justify-between">
                                                <div><span class="font-bold text-white">Jul 15 (PM Trip)</span><p class="text-[7px] text-slate-400">Duration: 42 mins</p></div>
                                                <span class="text-emerald-400 font-bold">COMPLETED</span>
                                            </div>
                                            <div class="bg-slate-850 p-2 rounded-lg border border-slate-800 text-[8.5px] flex justify-between">
                                                <div><span class="font-bold text-white">Jul 15 (AM Trip)</span><p class="text-[7px] text-slate-400">Duration: 38 mins</p></div>
                                                <span class="text-emerald-400 font-bold">COMPLETED</span>
                                            </div>
                                            <div class="bg-slate-850 p-2 rounded-lg border border-slate-800 text-[8.5px] flex justify-between">
                                                <div><span class="font-bold text-white">Jul 14 (PM Trip)</span><p class="text-[7px] text-slate-400">Duration: 45 mins</p></div>
                                                <span class="text-emerald-400 font-bold">COMPLETED</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ==================== DRIVER SCREENS ==================== -->

                                    <!-- Driver: Start Trip -->
                                    <div id="screen-driver-start-trip" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Pre-Route Verification</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Checklist</p>
                                        </div>
                                        <div class="my-3 space-y-1.5 flex-grow flex flex-col justify-center">
                                            <div class="space-y-1 text-[9px] bg-slate-850 p-3 rounded-xl border border-slate-800">
                                                <div class="flex items-center justify-between"><span>⚙️ Engine Oil check:</span><span class="text-emerald-400 font-bold">OK</span></div>
                                                <div class="flex items-center justify-between"><span>⛽ Fuel level checked:</span><span class="text-emerald-400 font-bold">92%</span></div>
                                                <div class="flex items-center justify-between"><span>🛞 Tire pressure status:</span><span class="text-emerald-400 font-bold">Normal</span></div>
                                            </div>
                                        </div>
                                        <button onclick="alert('Trip broadcasting started!')" class="w-full py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-[10px] text-center shadow-lg shadow-emerald-600/20 mt-auto">
                                            🛫 Start Active Trip
                                        </button>
                                    </div>

                                    <!-- Driver: Share Live Location -->
                                    <div id="screen-driver-share-location" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Live GPS Broadcasting</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Route 04</p>
                                        </div>
                                        <div class="my-6 text-center space-y-4 flex-grow flex flex-col justify-center items-center">
                                            <div class="w-20 h-20 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center relative">
                                                <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold animate-ping">📡</div>
                                            </div>
                                            <p class="text-[10px] text-slate-350">Streaming live coordinates to school and parent portals every 2 seconds.</p>
                                        </div>
                                        <div class="p-2 bg-emerald-950/20 border border-emerald-500/20 text-emerald-400 text-center rounded-xl text-[8.5px] mt-auto">
                                            🟢 GPS Signal Status: Excellent
                                        </div>
                                    </div>

                                    <!-- Driver: Student Pickup -->
                                    <div id="screen-driver-student-pickup" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Student Boarding</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Stop #3 Checklist</p>
                                        </div>
                                        <div class="my-3 space-y-2 flex-grow overflow-y-auto max-h-[220px]">
                                            <div class="bg-slate-850 p-2.5 rounded-lg border border-slate-800 flex justify-between items-center text-[9px]">
                                                <div><p class="font-bold text-white">Aarav Gupta</p><p class="text-[7.5px] text-slate-400">Seat 12</p></div>
                                                <span class="text-[8.5px] text-emerald-400 font-extrabold">BOARDED</span>
                                            </div>
                                            <div class="bg-slate-850 p-2.5 rounded-lg border border-slate-800 flex justify-between items-center text-[9px] opacity-80">
                                                <div><p class="font-bold text-slate-300">Ananya Sen</p><p class="text-[7.5px] text-slate-500">Seat 05</p></div>
                                                <button onclick="this.innerHTML='BOARDED'; this.className='text-[8.5px] text-emerald-400 font-extrabold'" class="text-[8.5px] bg-blue-600 px-2 py-0.5 rounded text-white font-bold">Tap Board</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver: Student Drop -->
                                    <div id="screen-driver-student-drop" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">Student Drop-off</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Safe Arrival Confirmation</p>
                                        </div>
                                        <div class="my-6 text-center space-y-4 flex-grow flex flex-col justify-center items-center">
                                            <div class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xl shadow-lg">✓</div>
                                            <div>
                                                <h5 class="text-xs font-bold text-white">All Students Dropped</h5>
                                                <p class="text-[8.5px] text-slate-400 mt-1">St. Jude's school gate dropoff completed. 28/28 verified checklist.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Driver: Stop Trip -->
                                    <div id="screen-driver-stop-trip" class="story-screen hidden flex flex-col justify-between h-full">
                                        <div class="text-center border-b border-slate-800/80 pb-2">
                                            <h4 class="text-xs font-extrabold tracking-wide">End Route Report</h4>
                                            <p class="text-[8px] text-blue-400 font-bold uppercase mt-0.5">Route 04 Summary</p>
                                        </div>
                                        <div class="my-3 space-y-2 flex-grow flex flex-col justify-center">
                                            <div class="bg-slate-850 p-2.5 rounded-xl border border-slate-800 text-[8.5px] space-y-1.5">
                                                <div class="flex justify-between"><span>Total distance:</span><span class="font-bold">18.2 km</span></div>
                                                <div class="flex justify-between"><span>Duration:</span><span class="font-bold">42 Mins</span></div>
                                                <div class="flex justify-between"><span>Avg Speed limit adherence:</span><span class="text-emerald-400 font-bold">100%</span></div>
                                            </div>
                                        </div>
                                        <button onclick="alert('Trip ended and archived.')" class="w-full py-2 rounded-lg bg-red-650 hover:bg-red-600 text-white font-extrabold text-[10px] text-center mt-auto">
                                            🛑 Close active route
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- DEVICE 2: Browser Mockup Shell (For School Dashboard View) -->
                        <div id="demo-browser-shell" class="relative z-10 hidden w-full max-w-[500px]">
                            <div class="w-full rounded-2xl bg-[#111625] border-[4px] border-slate-800 shadow-2xl relative flex flex-col overflow-hidden text-white">
                                <!-- Window Title Bar -->
                                <div class="flex items-center justify-between pb-2 border-b border-slate-900 px-3 pt-2">
                                    <div class="flex gap-1.5">
                                        <span class="w-2.5 h-2.5 rounded-full bg-red-500/80"></span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></span>
                                        <span class="w-2.5 h-2.5 rounded-full bg-green-500/80"></span>
                                    </div>
                                    <span class="text-[8px] text-slate-500 font-mono">admin.wheelstracker.app/transit-hub</span>
                                    <span class="text-[8px] bg-blue-600/20 text-blue-400 px-2 py-0.5 rounded font-extrabold scale-90 border border-blue-500/30">12 ONLINE</span>
                                </div>
                                <div class="bg-[#151D30] rounded-b-xl p-4 text-left space-y-4 min-h-[320px] flex flex-col justify-between">
                                    
                                    <!-- ==================== SCHOOL SCREENS ==================== -->

                                    <!-- School: Vehicle List -->
                                    <div id="screen-school-vehicle-list" class="story-screen hidden flex-grow flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-xs font-bold text-white border-b border-slate-800 pb-1.5">Active Fleet Registry</h4>
                                            <div class="space-y-1.5 text-[8.5px] mt-2">
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Bus #04 (Force Traveller)</span><span class="text-emerald-400 font-bold">ONLINE</span>
                                                </div>
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Bus #11 (Tata Starbus)</span><span class="text-emerald-400 font-bold">ONLINE</span>
                                                </div>
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Van #02 (Maruti Eeco)</span><span class="text-slate-500 font-bold">OFFLINE</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- School: Drivers -->
                                    <div id="screen-school-drivers" class="story-screen hidden flex-grow flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-xs font-bold text-white border-b border-slate-800 pb-1.5">Assigned Drivers list</h4>
                                            <div class="space-y-1.5 text-[8.5px] mt-2">
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Ramesh Kumar (Route 04)</span><span class="text-yellow-400">⭐ 4.9</span>
                                                </div>
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Amit Sen (Route 11)</span><span class="text-yellow-400">⭐ 4.7</span>
                                                </div>
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>K. Prasad (Route 02)</span><span class="text-yellow-400">⭐ 4.8</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- School: Students -->
                                    <div id="screen-school-students" class="story-screen hidden flex-grow flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-xs font-bold text-white border-b border-slate-800 pb-1.5">Student Directory</h4>
                                            <div class="space-y-1.5 text-[8px] mt-2">
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Aarav Gupta (Grade 4)</span><span class="text-slate-350">Route 04 - Stop 3</span>
                                                </div>
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Ananya Sen (Grade 2)</span><span class="text-slate-350">Route 11 - Stop 5</span>
                                                </div>
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Kabir Dev (Grade 6)</span><span class="text-slate-350">Route 04 - Stop 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- School: Routes -->
                                    <div id="screen-school-routes" class="story-screen hidden flex-grow flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-xs font-bold text-white border-b border-slate-800 pb-1.5">Route Configuration</h4>
                                            <div class="space-y-1.5 text-[8.5px] mt-2">
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded border border-blue-500/20">
                                                    <span>Route 04 - Sector-B Path</span><span class="font-bold">6 stops</span>
                                                </div>
                                                <div class="flex justify-between items-center bg-[#1C273E] p-2 rounded">
                                                    <span>Route 11 - South-End Path</span><span class="font-bold">8 stops</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- School: Trips -->
                                    <div id="screen-school-trips" class="story-screen hidden flex-grow flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-xs font-bold text-white border-b border-slate-800 pb-1.5">Live Operational Feed</h4>
                                            <div class="space-y-1.5 text-[8px] mt-2">
                                                <div class="bg-blue-950/40 p-2 rounded border border-blue-500/20 text-blue-350 flex justify-between">
                                                    <span>• Route 04 Started Trip</span><span>07:30 AM</span>
                                                </div>
                                                <div class="bg-emerald-950/40 p-2 rounded border border-emerald-500/20 text-emerald-400 flex justify-between">
                                                    <span>• Route 04 completed passenger pickup at Stop #3</span><span>07:42 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- School: Reports -->
                                    <div id="screen-school-reports" class="story-screen hidden flex-grow flex flex-col justify-between">
                                        <div>
                                            <h4 class="text-xs font-bold text-white border-b border-slate-800 pb-1.5">Monthly Reports Summary</h4>
                                            <div class="grid grid-cols-2 gap-2 mt-2">
                                                <div class="bg-[#1C273E] p-2 rounded text-center">
                                                    <span class="text-[7px] text-slate-400 uppercase font-bold">Speed Adherence</span>
                                                    <p class="text-xs font-black text-emerald-400">99.2%</p>
                                                </div>
                                                <div class="bg-[#1C273E] p-2 rounded text-center">
                                                    <span class="text-[7px] text-slate-400 uppercase font-bold">Fuel costs reduced</span>
                                                    <p class="text-xs font-black text-blue-400">15.4%</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Parent Experience Section -->
        <section id="parent-experience" class="py-24 bg-[#080B11] border-y border-slate-900/60 overflow-hidden relative">
            <!-- Background floating ambient bubbles -->
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-rose-500/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-lime-950/20 blur-[120px] pointer-events-none"></div>
            
            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <!-- Title Header -->
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-20">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/25 text-lime-400 text-xs font-semibold uppercase tracking-wider border border-lime-500/20">
                        Parent Experience
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Parents Always Know</h2>
                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                        No guesswork, no curb-side waiting in the rain, no frantic phone calls. Walk through the morning journey of absolute peace of mind.
                    </p>
                </div>

                <!-- 5-Step Connected Timeline Layout -->
                <div class="relative">
                    
                    <!-- SVG Connecting Flow Line (Visible on Desktop) -->
                    <div class="absolute top-1/2 left-0 w-full h-1 transform -translate-y-1/2 hidden md:block z-0 opacity-20">
                        <svg class="w-full h-4" fill="none" viewBox="0 0 1200 16" preserveAspectRatio="none">
                            <path d="M 0 8 Q 150 0, 300 8 T 600 8 T 900 8 T 1200 8" stroke="#10b981" stroke-width="2" stroke-dasharray="8 6" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-8 relative z-10">
                        
                        <!-- Step 1: Child leaves home -->
                        <div class="bg-[#121824] border border-slate-850 rounded-3xl p-6 shadow-xl shadow-black/40 text-slate-200 hover:-translate-y-1.5 duration-300 relative overflow-hidden flex flex-col justify-between items-center text-center group">
                            <span class="absolute top-3 right-3 text-[9px] font-black px-2 py-0.5 rounded-full bg-lime-950/40 text-lime-400">STEP 1</span>
                            
                            <!-- Custom visual graphic -->
                            <div class="w-20 h-20 rounded-2xl bg-lime-950/30 border border-lime-500/20 flex items-center justify-center text-4xl mb-6 relative group-hover:scale-105 duration-300">
                                <span class="relative z-10">🏡</span>
                                <div class="absolute inset-0 bg-lime-500/5 rounded-2xl blur group-hover:scale-110 duration-300"></div>
                            </div>
                            
                            <div class="space-y-2 flex-grow flex flex-col justify-center">
                                <h3 class="text-base font-extrabold text-white group-hover:text-lime-400 duration-350">Child Leaves Home</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Your child steps out the door with backpack ready. You wave goodbye knowing transport is perfectly synced.
                                </p>
                            </div>
                        </div>

                        <!-- Step 2: Vehicle Approaching -->
                        <div class="bg-[#121824] border border-slate-850 rounded-3xl p-6 shadow-xl shadow-black/40 text-slate-200 hover:-translate-y-1.5 duration-300 relative overflow-hidden flex flex-col justify-between items-center text-center group">
                            <span class="absolute top-3 right-3 text-[9px] font-black px-2 py-0.5 rounded-full bg-rose-950/40 text-rose-400">STEP 2</span>
                            
                            <!-- Custom visual graphic -->
                            <div class="w-20 h-20 rounded-2xl bg-rose-950/30 border border-rose-500/20 flex items-center justify-center text-4xl mb-6 relative group-hover:scale-105 duration-300">
                                <span class="relative z-10">📲</span>
                                <div class="absolute -top-1 -right-1 w-4.5 h-4.5 bg-rose-500 rounded-full text-white text-[8px] font-black flex items-center justify-center animate-bounce">1</div>
                                <div class="absolute inset-0 bg-rose-500/5 rounded-2xl blur group-hover:scale-110 duration-300"></div>
                            </div>
                            
                            <div class="space-y-2 flex-grow flex flex-col justify-center">
                                <h3 class="text-base font-extrabold text-white group-hover:text-rose-400 duration-350">Vehicle Approaching</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    App alerts you when the bus is exactly 5 minutes away. No waiting outside in scorching heat or cold rain.
                                </p>
                            </div>
                        </div>

                        <!-- Step 3: Pickup Alert -->
                        <div class="bg-[#121824] border border-slate-850 rounded-3xl p-6 shadow-xl shadow-black/40 text-slate-200 hover:-translate-y-1.5 duration-300 relative overflow-hidden flex flex-col justify-between items-center text-center group">
                            <span class="absolute top-3 right-3 text-[9px] font-black px-2 py-0.5 rounded-full bg-amber-950/40 text-amber-400">STEP 3</span>
                            
                            <!-- Custom visual graphic -->
                            <div class="w-20 h-20 rounded-2xl bg-amber-950/30 border border-amber-500/20 flex items-center justify-center text-4xl mb-6 relative group-hover:scale-105 duration-300">
                                <span class="relative z-10">🚌</span>
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full text-white text-xs font-black flex items-center justify-center">✓</div>
                                <div class="absolute inset-0 bg-amber-500/5 rounded-2xl blur group-hover:scale-110 duration-300"></div>
                            </div>
                            
                            <div class="space-y-2 flex-grow flex flex-col justify-center">
                                <h3 class="text-base font-extrabold text-white group-hover:text-amber-400 duration-350">Pickup Confirmation</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Get an instant push notification the split-second your child boards and the vehicle starts rolling.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4: Live Tracking -->
                        <div class="bg-[#121824] border border-slate-850 rounded-3xl p-6 shadow-xl shadow-black/40 text-slate-200 hover:-translate-y-1.5 duration-300 relative overflow-hidden flex flex-col justify-between items-center text-center group">
                            <span class="absolute top-3 right-3 text-[9px] font-black px-2 py-0.5 rounded-full bg-violet-950/40 text-violet-400">STEP 4</span>
                            
                            <!-- Custom visual graphic -->
                            <div class="w-20 h-20 rounded-2xl bg-violet-950/30 border border-violet-500/20 flex items-center justify-center text-4xl mb-6 relative group-hover:scale-105 duration-300">
                                <span class="relative z-10">📍</span>
                                <div class="absolute inset-0 bg-violet-500/5 rounded-2xl blur group-hover:scale-110 duration-300"></div>
                            </div>
                            
                            <div class="space-y-2 flex-grow flex flex-col justify-center">
                                <h3 class="text-base font-extrabold text-white group-hover:text-violet-400 duration-350">Live Path Tracking</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    Watch the bus progress dynamically on the map. Know speed, location, and delay updates instantly.
                                </p>
                            </div>
                        </div>

                        <!-- Step 5: Reached School Notification -->
                        <div class="bg-[#121824] border border-slate-850 rounded-3xl p-6 shadow-xl shadow-black/40 text-slate-200 hover:-translate-y-1.5 duration-300 relative overflow-hidden flex flex-col justify-between items-center text-center group">
                            <span class="absolute top-3 right-3 text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-950/40 text-emerald-400">STEP 5</span>
                            
                            <!-- Custom visual graphic -->
                            <div class="w-20 h-20 rounded-2xl bg-emerald-950/30 border border-emerald-500/20 flex items-center justify-center text-4xl mb-6 relative group-hover:scale-105 duration-300">
                                <span class="relative z-10">🏫</span>
                                <div class="absolute inset-0 bg-emerald-500/5 rounded-2xl blur group-hover:scale-110 duration-300"></div>
                            </div>
                            
                            <div class="space-y-2 flex-grow flex flex-col justify-center">
                                <h3 class="text-base font-extrabold text-white group-hover:text-emerald-400 duration-350">Classroom Arrival</h3>
                                <p class="text-xs text-slate-400 leading-relaxed">
                                    "Aarav reached St. Jude's School." Sit back and start your day knowing they have arrived safely.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Emotional Footer Banner -->
                <div class="mt-16 bg-gradient-to-r from-blue-950 to-slate-900 rounded-3xl p-8 text-center text-white relative overflow-hidden shadow-2xl border border-blue-500/20">
                    <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
                    <div class="relative z-10 max-w-2xl mx-auto space-y-4">
                        <p class="text-xs uppercase font-extrabold tracking-widest text-blue-300">Peace of mind for families</p>
                        <h4 class="text-xl sm:text-2xl font-extrabold">Because nothing matters more than a safe arrival.</h4>
                        <p class="text-slate-350 text-xs sm:text-sm">
                            Schools using WheelsTracker report a 98% parent satisfaction rate in the first month. Give your families the security they deserve.
                        </p>
                    </div>
                </div>
            </div>
        </section>



        <!-- ROI & Trust Statistics Section -->
        <section id="roi" class="py-20 bg-blue-950 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:32px_32px] opacity-5 pointer-events-none"></div>
            
            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Text ROI pitch -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-blue-200 text-xs font-semibold uppercase tracking-wider">
                            Measurable Impact
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">The Financial & Administrative Return on Investment</h2>
                        <p class="text-blue-200 text-base sm:text-lg leading-relaxed">
                            Implementing WheelsTracker is not just about tracking; it pays for itself by optimizing your fleet operations, decreasing driver fuel waste, and relieving administrative staff from repetitive inquiries.
                        </p>
                        
                        <div class="space-y-4 pt-4">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm text-blue-100"><strong>90% fewer incoming transport inquiries</strong>, giving administrative staff hours back daily to focus on admissions and school tasks.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm text-blue-100"><strong>15-20% fuel cost savings</strong> by utilizing route optimizations and stopping driver vehicle misuse.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm text-blue-100"><strong>Boost school enrollment appeal</strong>. Safety and real-time visibility are powerful marketing points for prospective parents.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics grid -->
                    <div class="lg:col-span-6 grid grid-cols-2 gap-6">
                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-cyan-400">90%</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-blue-200 mt-2">Query Reduction</p>
                            <p class="text-[11px] text-blue-300 mt-1">Parents track independently</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-emerald-400">20%</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-blue-200 mt-2">Fuel Cost Savings</p>
                            <p class="text-[11px] text-blue-300 mt-1">Due to AI optimized paths</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-yellow-400">100%</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-blue-200 mt-2">Parent Adoption</p>
                            <p class="text-[11px] text-blue-300 mt-1">Instant, code-based access</p>
                        </div>

                        <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 text-center">
                            <p class="text-4xl sm:text-5xl font-black text-blue-300">15m</p>
                            <p class="text-xs uppercase tracking-wider font-extrabold text-blue-200 mt-2">Saved Per Trip</p>
                            <p class="text-[11px] text-blue-300 mt-1">By avoiding traffic bottlenecks</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Final Call to Action -->
        <section class="py-20 bg-[#080B11] border-t border-slate-900/60">
            <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Ready to build a smarter, safer school transport network?
                </h2>
                <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                    Set up your routes, map your stops, and invite parents. Start tracking with WheelsTracker in less than 24 hours. No hardware obligations.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                    <button onclick="openDemoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black font-bold shadow-xl shadow-lime-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all-300">
                        Schedule a Free Demo
                    </button>
                    <button onclick="openVideoModal()" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-transparent hover:bg-slate-800 text-slate-300 font-bold border border-slate-800 shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all-300">
                        Explore Platform
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Interactive "Book a Demo" Modal Overlay -->
    <div id="demo-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDemoModal()"></div>

        <!-- Modal Content Container -->
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-[#0C101A] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-850 text-slate-200">
                <!-- Close Button -->
                <button onclick="closeDemoModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- 1. Form View -->
                <div id="demo-form-view" class="px-6 py-8 sm:p-8 space-y-6">
                    <div class="space-y-2">
                        <h3 class="text-xl font-extrabold text-white" id="modal-title">Book a Free 15-Min Demo</h3>
                        <p class="text-xs text-slate-400">
                            See how WheelsTracker solves parent queries and driver management for your specific fleet size.
                        </p>
                    </div>

                    <form id="demo-request-form" onsubmit="submitDemoForm(event)" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1.5">Your Name *</label>
                                <input type="text" required class="w-full rounded-lg border border-slate-800 bg-[#121824] px-3.5 py-2 text-sm text-white focus:border-lime-400 focus:outline-none focus:ring-1 focus:ring-lime-400">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1.5">School/Company Name *</label>
                                <input type="text" required class="w-full rounded-lg border border-slate-800 bg-[#121824] px-3.5 py-2 text-sm text-white focus:border-lime-400 focus:outline-none focus:ring-1 focus:ring-lime-400">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Work Email *</label>
                            <input type="email" required class="w-full rounded-lg border border-slate-800 bg-[#121824] px-3.5 py-2 text-sm text-white focus:border-lime-400 focus:outline-none focus:ring-1 focus:ring-lime-400">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Contact Number *</label>
                            <input type="tel" required class="w-full rounded-lg border border-slate-800 bg-[#121824] px-3.5 py-2 text-sm text-white focus:border-lime-400 focus:outline-none focus:ring-1 focus:ring-lime-400">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Approximate Fleet Size *</label>
                            <select required class="w-full rounded-lg border border-slate-800 bg-[#121824] px-3.5 py-2 text-sm text-white focus:border-lime-400 focus:outline-none focus:ring-1 focus:ring-lime-400">
                                <option value="" class="bg-[#121824] text-slate-400">Select Option</option>
                                <option value="1-5" class="bg-[#121824] text-white">1 - 5 vehicles (Buses/Vans/Rickshaws)</option>
                                <option value="6-20" class="bg-[#121824] text-white">6 - 20 vehicles</option>
                                <option value="21-50" class="bg-[#121824] text-white">21 - 50 vehicles</option>
                                <option value="50+" class="bg-[#121824] text-white">More than 50 vehicles</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-lime-400 hover:bg-lime-300 text-slate-950 font-black font-bold py-3 rounded-lg text-sm shadow-md transition-all-300">
                            Confirm Demo Request
                        </button>
                    </form>
                </div>

                <!-- 2. Success View -->
                <div id="demo-success-view" class="hidden px-6 py-12 text-center space-y-6">
                    <div class="w-16 h-16 rounded-full bg-emerald-950/20 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto shadow-md">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xl font-extrabold text-white">Thank you, Request Submitted!</h3>
                        <p class="text-sm text-slate-400 max-w-sm mx-auto">
                            We have received your demo request details. Our school logistics expert will contact you shortly at your provided email.
                        </p>
                    </div>
                    <button onclick="closeDemoModal()" class="w-32 bg-[#111724] hover:bg-slate-800 text-slate-300 font-bold py-2 rounded-lg text-sm transition-all-300 mx-auto">
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
                <button onclick="closeVideoModal()" class="absolute -top-10 right-0 md:-top-3 md:-right-8 text-white hover:text-blue-400 focus:outline-none text-2xl font-bold">
                    &times;
                </button>

                <!-- YouTube Video Interface -->
                <div class="aspect-video w-full rounded-xl bg-slate-900 overflow-hidden relative">
                    <iframe id="demo-youtube-iframe" class="w-full h-full" src="" title="WheelsTracker Live Demo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
            const iframe = document.getElementById('demo-youtube-iframe');
            iframe.src = "https://www.youtube.com/embed/gnXug6MZODc?autoplay=1";
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('demo-youtube-iframe');
            iframe.src = "";
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Cycling App Showcase (Hero Right Column)
        let activeShowcaseTab = 'parent';
        let showcaseInterval;
        const tabs = ['parent', 'driver', 'admin'];

        function setTabShowcase(tabName) {
            clearInterval(showcaseInterval);
            
            tabs.forEach(t => {
                const btn = document.getElementById(`btn-showcase-${t}`);
                const screen = document.getElementById(`showcase-screen-${t}`);
                if (btn) btn.className = 'flex-grow py-2 rounded-lg text-xs font-bold text-slate-400 hover:text-slate-300 transition-all-300';
                if (screen) screen.classList.remove('active');
            });

            const activeBtn = document.getElementById(`btn-showcase-${tabName}`);
            const activeScreen = document.getElementById(`showcase-screen-${tabName}`);
            if (activeBtn) activeBtn.className = 'flex-grow py-2 rounded-lg text-xs font-bold text-slate-400 hover:text-slate-300 transition-all-300 showcase-tab-active';
            if (activeScreen) activeScreen.classList.add('active');
            
            activeShowcaseTab = tabName;
            startShowcaseAutoplay();
        }

        function startShowcaseAutoplay() {
            showcaseInterval = setInterval(() => {
                let currentIndex = tabs.indexOf(activeShowcaseTab);
                let nextIndex = (currentIndex + 1) % tabs.length;
                
                let currentTab = tabs[currentIndex];
                let nextTab = tabs[nextIndex];
                
                const curBtn = document.getElementById(`btn-showcase-${currentTab}`);
                const curScreen = document.getElementById(`showcase-screen-${currentTab}`);
                if (curBtn) {
                    curBtn.classList.remove('showcase-tab-active');
                    curBtn.className = 'flex-grow py-2 rounded-lg text-xs font-bold text-slate-400 hover:text-slate-300 transition-all-300';
                }
                if (curScreen) curScreen.classList.remove('active');

                const nextBtn = document.getElementById(`btn-showcase-${nextTab}`);
                const nextScreen = document.getElementById(`showcase-screen-${nextTab}`);
                if (nextBtn) nextBtn.className = 'flex-grow py-2 rounded-lg text-xs font-bold text-slate-400 hover:text-slate-300 transition-all-300 showcase-tab-active';
                if (nextScreen) nextScreen.classList.add('active');

                activeShowcaseTab = nextTab;
            }, 4000);
        }

        // Timeline Flow Animation (Hero Left Column)
        let timelineState = 0;
        const timelineBus = document.getElementById('hero-timeline-bus');
        const timelineFlow = document.getElementById('hero-timeline-flow');

        function startTimelineAnimation() {
            setInterval(() => {
                timelineState = (timelineState + 1) % 4;
                updateTimelineUI(timelineState);
            }, 4000);
        }

        function updateTimelineUI(state) {
            const positions = ['12.5%', '37.5%', '62.5%', '87.5%'];
            const flowWidths = ['0%', '33.3%', '66.6%', '100%'];
            
            if (timelineBus) {
                timelineBus.style.left = positions[state];
            }
            if (timelineFlow) {
                timelineFlow.setAttribute('x2', flowWidths[state]);
            }

            for (let i = 0; i < 4; i++) {
                const node = document.getElementById(`hero-node-${i}`);
                const text = document.getElementById(`hero-text-${i}`);
                
                if (i <= state) {
                    if (node) {
                        node.className = 'w-9 h-9 rounded-full bg-[#121824] border-2 border-lime-400 text-lime-400 flex items-center justify-center shadow-md transition-all duration-500';
                    }
                    if (text) {
                        text.className = 'text-[9px] sm:text-xxs font-extrabold text-lime-400 uppercase tracking-wider mt-2.5';
                    }
                } else {
                    if (node) {
                        node.className = 'w-9 h-9 rounded-full bg-[#121824] border border-slate-800 text-slate-400 flex items-center justify-center shadow transition-all duration-500';
                    }
                    if (text) {
                        text.className = 'text-[9px] sm:text-xxs font-extrabold text-slate-450 uppercase tracking-wider mt-2.5';
                    }
                }
            }
        }

        // Story Timeline Redesign (Meet Wheels Tracker)
        let activeStoryStep = 0;
        let storyInterval;
        const totalStorySteps = 4;

        function setStoryStep(stepIdx) {
            clearInterval(storyInterval);
            
            // Toggle active classes on left side steps
            for (let i = 0; i < totalStorySteps; i++) {
                const stepPanel = document.getElementById(`story-step-${i}`);
                const screenViewport = document.getElementById(`story-screen-${i}`);
                const nodeMarker = document.getElementById(`story-node-${i}`);
                
                if (i === stepIdx) {
                    if (stepPanel) {
                        stepPanel.className = 'relative p-6 rounded-2xl border border-slate-900/80 bg-[#121824] border border-slate-800 shadow-xl shadow-black/20 cursor-pointer transition-all duration-300 transform -translate-y-0.5 border-l-4 border-l-lime-400';
                        stepPanel.querySelector('h3').className = 'text-lg font-extrabold text-slate-200 mt-1';
                    }
                    if (nodeMarker) {
                        nodeMarker.className = 'absolute -left-[42px] top-6 w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-xs ring-4 ring-amber-500/20 shadow-md shadow-amber-600/30 scale-110 border-2 border-amber-500 transition-all duration-300 z-10';
                    }
                    if (screenViewport) {
                        screenViewport.classList.remove('hidden');
                        screenViewport.classList.add('active');
                    }
                } else {
                    if (stepPanel) {
                        stepPanel.className = 'relative p-6 rounded-2xl border border-transparent bg-transparent cursor-pointer transition-all duration-300 opacity-60 hover:opacity-90';
                        stepPanel.querySelector('h3').className = 'text-lg font-extrabold text-slate-300/80 mt-1';
                    }
                    if (nodeMarker) {
                        nodeMarker.className = 'absolute -left-[42px] top-6 w-8 h-8 rounded-full bg-white text-slate-400 flex items-center justify-center font-bold text-xs border-2 border-slate-900/80 transition-all duration-300 z-10';
                    }
                    if (screenViewport) {
                        screenViewport.classList.add('hidden');
                        screenViewport.classList.remove('active');
                    }
                }
            }

            // Update vertical tracking height
            const fillTrack = document.getElementById('story-track-fill');
            if (fillTrack) {
                const percentages = ['0%', '33.3%', '66.6%', '100%'];
                fillTrack.style.height = percentages[stepIdx];
            }

            activeStoryStep = stepIdx;
            startStoryAutoplay();
        }

        function startStoryAutoplay() {
            storyInterval = setInterval(() => {
                let nextStep = (activeStoryStep + 1) % totalStorySteps;
                setStoryStep(nextStep);
            }, 5000);
        }

        // Interactive Product Demo Controller
        let activeDemoTab = 'parent';
        let activeDemoSubTab = {
            parent: 'parent-live-map',
            driver: 'driver-start-trip',
            school: 'school-vehicle-list'
        };

        function switchDemoTab(tabName) {
            activeDemoTab = tabName;
            
            const tabs = ['parent', 'driver', 'school'];
            tabs.forEach(t => {
                const btn = document.getElementById(`demo-tab-${t}`);
                if (btn) {
                    if (t === tabName) {
                        btn.className = 'px-6 py-3 rounded-xl text-sm font-bold text-lime-400 bg-[#121824] text-lime-400 shadow-md border border-lime-500/20 transition-all duration-300';
                    } else {
                        btn.className = 'px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-200 transition-all duration-300';
                    }
                }
                
                const menu = document.getElementById(`demo-menu-${t}`);
                if (menu) {
                    if (t === tabName) {
                        menu.classList.remove('hidden');
                    } else {
                        menu.classList.add('hidden');
                    }
                }
            });

            // Toggle device mockups
            const phoneShell = document.getElementById('demo-phone-shell');
            const browserShell = document.getElementById('demo-browser-shell');
            if (tabName === 'school') {
                if (phoneShell) phoneShell.classList.add('hidden');
                if (browserShell) browserShell.classList.remove('hidden');
            } else {
                if (phoneShell) phoneShell.classList.remove('hidden');
                if (browserShell) browserShell.classList.add('hidden');
            }

            switchDemoSubTab(activeDemoSubTab[tabName]);
        }

        function switchDemoSubTab(subTabId) {
            const primary = activeDemoTab;
            activeDemoSubTab[primary] = subTabId;

            let menuItems = [];
            if (primary === 'parent') {
                menuItems = ['parent-live-map', 'parent-vehicle-details', 'parent-driver-info', 'parent-eta', 'parent-notifications', 'parent-trip-history'];
            } else if (primary === 'driver') {
                menuItems = ['driver-start-trip', 'driver-share-location', 'driver-student-pickup', 'driver-student-drop', 'driver-stop-trip'];
            } else if (primary === 'school') {
                menuItems = ['school-vehicle-list', 'school-drivers', 'school-students', 'school-routes', 'school-trips', 'school-reports'];
            }

            menuItems.forEach(item => {
                const link = document.getElementById(`link-${item}`);
                const screen = document.getElementById(`screen-${item}`);
                
                if (link) {
                    if (item === subTabId) {
                        link.className = 'relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-lime-950/20 text-lime-400 border-l-4 border-l-lime-400 font-bold transition-all duration-300 text-left';
                    } else {
                        link.className = 'relative flex items-center gap-3 p-3.5 w-full rounded-xl bg-transparent text-slate-400 hover:bg-[#111724] hover:text-slate-200 border-l-4 border-l-transparent transition-all duration-300 text-left';
                    }
                }

                if (screen) {
                    if (item === subTabId) {
                        screen.classList.remove('hidden');
                        screen.classList.add('active');
                    } else {
                        screen.classList.add('hidden');
                        screen.classList.remove('active');
                    }
                }
            });
        }

        window.addEventListener('DOMContentLoaded', () => {
            startShowcaseAutoplay();
            startTimelineAnimation();
            startStoryAutoplay();
            // Initialize sub-tabs switcher states
            switchDemoTab('parent');
        });
    </script>
</x-guest-layout>
