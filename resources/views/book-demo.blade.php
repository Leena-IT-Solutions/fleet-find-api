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
                    <a href="/contact" class="text-slate-300 hover:text-lime-400 transition-colors">Contact</a>
                </nav>
                <div class="flex items-center gap-4">
                    <a href="/login" class="hidden sm:inline-flex text-sm font-semibold text-slate-300 hover:text-lime-400 transition-colors">Sign In</a>
                    <a href="/book-demo" class="pulse-lime px-5 py-2.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm font-semibold shadow-lg shadow-lime-500/10 hover:scale-[1.02] active:scale-[0.98] transition-all-300">Book Demo</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center py-20 relative overflow-hidden">
            <div class="mx-auto max-w-xl w-full px-6 relative z-10 space-y-8">
                
                <div class="text-center space-y-3">
                    <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">🗓️ Personalized Walkthrough</span>
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">Book a Free Demo</h1>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm mx-auto">
                        See how WheelsTracker solves parent queries and automates route logs. Set a time that suits you.
                    </p>
                </div>

                <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850">
                    <form onsubmit="event.preventDefault(); alert('Demo request submitted! We will send calendar invitations shortly.'); this.reset();" class="space-y-6 text-left">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs text-slate-400 font-bold uppercase mb-2">First Name</label>
                                <input type="text" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="Aarav">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 font-bold uppercase mb-2">School Email</label>
                                <input type="email" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors" placeholder="aarav@school.edu">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs text-slate-400 font-bold uppercase mb-2">Fleet Size (Buses/Vans)</label>
                                <select required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-slate-300 text-sm focus:outline-none focus:border-lime-400 transition-colors">
                                    <option value="1-5">1 - 5 vehicles</option>
                                    <option value="6-20">6 - 20 vehicles</option>
                                    <option value="21-50">21 - 50 vehicles</option>
                                    <option value="50+">50+ vehicles</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 font-bold uppercase mb-2">Preferred Date</label>
                                <input type="date" required class="w-full bg-[#1A2333] border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-lime-400 transition-colors">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3.5 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-colors shadow-lg shadow-lime-500/10">
                            Confirm Demo Booking
                        </button>
                    </form>
                </div>
            </div>
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
