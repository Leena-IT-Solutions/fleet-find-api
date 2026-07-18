<x-guest-layout :plain="true">
    <style>
        .transition-all-300 { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .pulse-lime { animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(163, 230, 53, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(163, 230, 53, 0); }
        }
        .pulse-green { animation: pulse-green-glow 2s infinite; }
        @keyframes pulse-green-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
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
                    <a href="/features" class="text-slate-300 hover:text-lime-400 transition-colors">Features</a>
                    <a href="/solutions" class="text-slate-300 hover:text-lime-400 transition-colors">Solutions</a>
                    <a href="/pricing" class="text-slate-300 hover:text-lime-400 transition-colors">Pricing</a>
                    <a href="/blog" class="text-slate-300 hover:text-lime-400 transition-colors">Blog</a>
                    <a href="/contact" class="font-semibold text-lime-400">Contact</a>
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
            <section class="py-24 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-4xl px-6 space-y-6 relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        📞 Get In Touch
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Connect with Our Team <br>
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">For Fleet Support.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Have operational questions or need technical support details? Send us a ticket and our representatives will respond.
                    </p>
                </div>
            </section>

            <!-- Form Split -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 space-y-12">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
                        
                        <!-- Left Card: Contact Channels -->
                        <div class="bg-[#121824] p-8 rounded-[32px] border border-slate-850 shadow-2xl flex flex-col justify-between space-y-8 text-left">
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <h3 class="text-2xl font-black text-white tracking-tight">Contact Channels</h3>
                                    <p class="text-slate-400 text-sm leading-relaxed">Reach out directly to avoid support queues.</p>
                                </div>
                                <div class="space-y-5 text-xs sm:text-sm">
                                    <div class="flex items-center gap-3">
                                        <span class="text-lime-400 text-lg">✉</span>
                                        <div>
                                            <span class="text-slate-500 block text-[9px] uppercase font-bold">Email Address</span>
                                            <span class="text-white font-semibold">leenaitsolutions@gmail.com</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-lime-400 text-lg">📞</span>
                                        <div>
                                            <span class="text-slate-500 block text-[9px] uppercase font-bold">Phone Number</span>
                                            <span class="text-white font-semibold">+91 90961 89183</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp Action Button -->
                            <div class="pt-6 border-t border-slate-800">
                                <a href="https://wa.me/919096189183" target="_blank" class="pulse-green w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm uppercase tracking-wider transition-all-300 shadow-lg shadow-emerald-650/20">
                                    <span>💬</span>
                                    <span>Chat on WhatsApp</span>
                                </a>
                            </div>
                        </div>

                        <!-- Right Card: Inquiry Form -->
                        <div class="bg-[#121824] p-8 rounded-[32px] border border-slate-850 shadow-2xl flex flex-col justify-between space-y-6 text-left">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-6">Inquiry Form</h3>
                                <form onsubmit="event.preventDefault(); alert('Message successfully sent! Our team will respond shortly.'); this.reset();" class="space-y-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs text-slate-400 font-bold uppercase mb-2">Your Name</label>
                                            <input type="text" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="Aarav Sharma">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-slate-400 font-bold uppercase mb-2">School Email</label>
                                            <input type="email" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="aarav@school.edu">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs text-slate-400 font-bold uppercase mb-2">School / Fleet Name</label>
                                            <input type="text" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="St. Jude's Academy">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-slate-400 font-bold uppercase mb-2">Phone Number</label>
                                            <input type="tel" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="+1 (555) 000-0000">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-slate-400 font-bold uppercase mb-2">Message</label>
                                        <textarea required rows="4" class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="Tell us about your fleet vehicles count..."></textarea>
                                    </div>
                                    <button type="submit" class="w-full py-3.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-colors shadow-lg shadow-lime-500/10 hover:scale-[1.01] duration-150">
                                        Send Message
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                    <!-- Book Demo Invitation Card -->
                    <div class="bg-gradient-to-r from-lime-950/20 to-emerald-950/20 p-8 rounded-[32px] border border-lime-500/20 flex flex-col md:flex-row items-center justify-between gap-6 text-left shadow-xl">
                        <div class="space-y-2">
                            <span class="text-[10px] text-lime-400 uppercase font-black tracking-widest font-mono">B2B Product Tour</span>
                            <h4 class="text-xl font-bold text-white">Looking for an Interactive Demo?</h4>
                            <p class="text-slate-400 text-sm leading-relaxed max-w-xl">
                                Schedule a live 15-minute screen share session with our engineers to configure your driver apps and operator dashboards.
                            </p>
                        </div>
                        <a href="/book-demo" class="pulse-lime px-6 py-3.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300 whitespace-nowrap">
                            Book Free Demo ➔
                        </a>
                    </div>

                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>
</x-guest-layout>
