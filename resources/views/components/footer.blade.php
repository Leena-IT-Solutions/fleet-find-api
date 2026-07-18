<footer class="w-full border-t border-slate-900/60 bg-[#05070A] py-16 text-slate-400 text-xs">
    <div class="mx-auto max-w-7xl px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">
        <!-- Logo & Brand Description -->
        <div class="space-y-4">
            <a href="/" class="flex items-center gap-3 group">
                <div class="relative flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 shadow-md shadow-blue-600/10 group-hover:scale-105 transition-all-300">
                    <img src="{{ asset('logo.png') }}" class="h-5 w-auto" alt="WheelsTracker Logo">
                </div>
                <span class="text-lg font-bold tracking-tight text-slate-200">WheelsTracker</span>
            </a>
            <p class="text-slate-400 text-xs leading-relaxed">
                A clean, professional real-time GPS tracking and logistics solution designed specifically for schools, parents, and transport management authorities.
            </p>
        </div>
        <!-- Features -->
        <div>
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-200 mb-4">Features</h4>
            <ul class="space-y-2.5">
                <li><a href="/features/parent-app" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">📱 Parent App</a></li>
                <li><a href="/features/driver-app" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">👨‍✈️ Driver App</a></li>
                <li><a href="/features/school-dashboard" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">🏫 School Dashboard</a></li>
                <li><a href="/features/live-gps-tracking" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">📡 Live GPS Tracking</a></li>
                <li><a href="/features/notifications" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">🔔 Proximity Alerts</a></li>
                <li><a href="/features/reports" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">📊 Route Analytics</a></li>
            </ul>
        </div>
        <!-- Solutions -->
        <div>
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-200 mb-4">Solutions</h4>
            <ul class="space-y-2.5">
                <li><a href="/solutions/schools" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">School Management</a></li>
                <li><a href="/solutions/school-bus-operators" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Bus Fleet Operators</a></li>
                <li><a href="/solutions/van-operators" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Van Fleet Operators</a></li>
                <li><a href="/solutions/auto-rickshaw-operators" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Shared Rickshaws</a></li>
                <li><a href="/solutions/transport-contractors" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Transport Contractors</a></li>
            </ul>
        </div>
        <!-- Company & Legal -->
        <div>
            <h4 class="text-xs uppercase font-extrabold tracking-wider text-slate-200 mb-4">Company</h4>
            <ul class="space-y-2.5">
                <li><a href="/about" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">About Us</a></li>
                <li><a href="/pricing" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Pricing Plans</a></li>
                <li><a href="/case-studies" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Case Studies</a></li>
                <li><a href="/blog" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Read Blog</a></li>
                <li><a href="/contact" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Contact Support</a></li>
                <li><a href="/privacy-policy" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Privacy Policy</a></li>
                <li><a href="/terms-conditions" class="hover:text-lime-400 text-slate-500 hover:underline transition-colors">Terms & Conditions</a></li>
            </ul>
        </div>
    </div>
    <!-- Footer Bottom -->
    <div class="mx-auto max-w-7xl px-6 mt-12 pt-8 border-t border-slate-900/60 flex flex-col sm:flex-row justify-between items-center text-slate-500 gap-4">
        <p>&copy; {{ date('Y') }} WheelsTracker. All rights reserved.</p>
        <p class="text-center sm:text-right">
            Designed for school transit safety. 
            <span class="block sm:inline sm:ml-1">(Designed & developed by <a href="https://leenaitsolutions.in/" target="_blank" rel="noopener" class="text-blue-500 hover:text-lime-400 font-semibold underline transition-colors">Leena IT Solutions</a>)</span>
        </p>
    </div>
</footer>
