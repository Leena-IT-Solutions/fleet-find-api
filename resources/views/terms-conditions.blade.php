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
                    <a href="/features" class="text-slate-300 hover:text-lime-400 transition-colors">Features</a>
                    <a href="/solutions" class="text-slate-300 hover:text-lime-400 transition-colors">Solutions</a>
                    <a href="/pricing" class="text-slate-300 hover:text-lime-400 transition-colors">Pricing</a>
                    <a href="/blog" class="text-slate-300 hover:text-lime-400 transition-colors">Blog</a>
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
            <section class="py-20 bg-gradient-to-b from-[#0B0F17] to-[#080B11] border-b border-slate-900/60 text-center">
                <div class="mx-auto max-w-4xl px-6 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        ⚖️ Legal Framework
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Terms & Conditions
                    </h1>
                    <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                        Last updated: July 16, 2026. Review rules, SLAs, and usage limitations of our tracking platform.
                    </p>
                </div>
            </sectio            <!-- Content -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-left space-y-12 leading-relaxed text-slate-355 text-sm sm:text-base">
                    
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">01.</span> Acceptance of Terms
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            By subscribing to, installing, or accessing the WheelsTracker web dashboard, administrator console, or mobile applications, you agree to be bound by these Terms & Conditions. If you are registering on behalf of a school district, educational institution, bus contractor, or van transport company, you represent that you possess the legal authority to bind such entity to this framework.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">02.</span> Scope of Service & GPS Compliance
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            WheelsTracker provides real-time geolocation tracking software-as-a-service (SaaS) to monitor school vehicles during transit. Subscribing organizations are responsible for ensuring that:
                        </p>
                        <ul class="list-disc pl-6 space-y-2 text-slate-400 text-sm">
                            <li>All active vehicle operators (drivers and attendants) have consented to the transmission of location parameters and telemetry during shift hours.</li>
                            <li>No tracking devices or active driver applications remain enabled outside of verified school transit hours.</li>
                            <li>The GPS hardware or smartphones running our telemetry service meet the minimum cellular signal bandwidth requirements.</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">03.</span> Account Credentials & Access Control
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            Schools and transport contractors must maintain strict confidentiality of administrative, operator, and parent-guardian login credentials. WheelsTracker is not responsible for unauthorized system modifications, student route alterations, or data leaks resulting from weak password security or compromised credentials.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">04.</span> Subscription Billing, Tiers, & Cancellations
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            WheelsTracker services are billed in advance on a recurring monthly or annual schedule based on the active vehicle fleet size.
                        </p>
                        <ul class="list-disc pl-6 space-y-2 text-slate-400 text-sm">
                            <li><strong>Billing Unit:</strong> Fees are calculated based on the count of active vehicles registered within your portal.</li>
                            <li><strong>Upgrades/Downgrades:</strong> Adding vehicles triggers a prorated invoice for the remainder of the billing cycle. Vehicle count reductions apply to the subsequent billing cycle.</li>
                            <li><strong>Cancellations:</strong> Subscribers can cancel their plans through their portal. Payments made are non-refundable, and no partial credits will be issued.</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">05.</span> Limitations of Liability & Routing
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            While WheelsTracker maintains advanced telemetry processing nodes to provide exact ETAs, we hold no liability for routing delays, missed drop-offs, or traffic deviations caused by GPS signal drops, local cellular outages, street closure blocks, or operator scheduling errors. Geolocation accuracy is subject to device limitations and environmental parameters.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">06.</span> Service Level Agreements & Maintenance
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            We aim to maintain a 99.9% server uptime rating for active tracking feeds. Scheduled maintenance is conducted during low-usage windows (weekends/midnight lines) and will be announced via system dashboards 48 hours in advance. Emergency hotfixes resolving data transmission or security alerts are deployed immediately without prior notice.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">07.</span> Governing Law & Disputes
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            These Terms & Conditions are governed by the laws of the jurisdiction where the primary educational institution holds its licensing. Any formal disputes or billing claims arising from service usage must be submitted to our administrative compliance board before legal resolution is sought.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">08.</span> Contact Legal Department
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            If you have questions regarding SLA limits, billing agreements, enterprise terms, or liability limits, please reach out to our team at <a href="mailto:leenaitsolutions@gmail.com" class="text-lime-400 hover:underline">leenaitsolutions@gmail.com</a>.
                        </p>
                    </div>

                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>
</x-guest-layout>
