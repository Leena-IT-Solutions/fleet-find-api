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
                    <a href="/about" class="text-slate-300 hover:text-lime-400 transition-colors">About</a>
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
            <section class="py-20 bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 text-center">
                <div class="mx-auto max-w-4xl px-6 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        📞 Get In Touch
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Connect with Our Team <br>
                        <span class="bg-gradient-to-r from-lime-450 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">For Fleet Support.</span>
                    </h1>
                    <p class="text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">
                        Have operational questions or need technical support details? Send us a ticket and our fleet representatives will respond in 2 hours.
                    </p>
                </div>
            </section>

            <!-- Form Split -->
            <section class="py-20 bg-[#080B11]">
                <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <!-- Text support details -->
                    <div class="lg:col-span-5 space-y-8 text-left">
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-white">Direct Support Channels</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">Reach out directly to avoid queue wait times.</p>
                        </div>
                        <div class="space-y-4 text-sm">
                            <div class="flex items-center gap-3">
                                <span class="text-lime-400 text-lg">✉</span>
                                <span>support@wheelstracker.com</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-lime-400 text-lg">📞</span>
                                <span>+1 (555) 231-9988</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-lime-400 text-lg">🏢</span>
                                <span class="text-slate-400">Leena IT Solutions Center, Suite 404</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="lg:col-span-7 bg-[#121824] p-8 rounded-3xl border border-slate-850">
                        <form onsubmit="event.preventDefault(); alert('Message successfully sent! Our team will respond shortly.'); this.reset();" class="space-y-6 text-left">
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
                            <div>
                                <label class="block text-xs text-slate-400 font-bold uppercase mb-2">School / Fleet Name</label>
                                <input type="text" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="St. Jude's Academy">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 font-bold uppercase mb-2">Message</label>
                                <textarea required rows="4" class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="Tell us about your fleet vehicles count..."></textarea>
                            </div>
                            <button type="submit" class="w-full py-3.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-colors shadow-lg shadow-lime-500/10">
                                Send Message
                            </button>
                        </form>
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
