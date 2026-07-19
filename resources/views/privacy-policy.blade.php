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
                        🇮🇳 DPDP Act, 2023 & IT Act Compliant
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Privacy Policy
                    </h1>
                    <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
                        Last updated: July 19, 2026. Aligned with the Digital Personal Data Protection Act, 2023 (DPDP Act) and Information Technology (IT) Rules, 2011.
                    </p>
                </div>
            </section>

            <!-- Content -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-left space-y-12 leading-relaxed text-slate-355 text-sm sm:text-base">
                    
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">01.</span> Regulatory Framework & Role Clarification
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            This Privacy Policy is compiled in compliance with the **Digital Personal Data Protection Act, 2023 (DPDP Act)** and **Section 43A of the Information Technology Act, 2000** of India. Under these regulations, WheelsTracker (owned and operated by Leena IT Solutions) acts as a **Data Fiduciary** for the personal data provided by educational institutions (schools, universities) and parent guardians (**Data Principals**). We process location coordinates and passenger logs solely on behalf of the registered institutional client.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">02.</span> Consent Mechanism & Purpose Limitation
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            In accordance with Section 6 of the DPDP Act, 2023, personal data is collected only after obtaining free, specific, informed, unconditional, and unambiguous consent from the Data Principal. Parents or legal guardians provide consent during account registration on the WheelsTracker application. 
                        </p>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            **Consent Withdrawal:** You have the right to withdraw your consent to data processing at any time. Upon withdrawal of consent, we will cease processing location telemetry for your account within 48 hours, which will disable live stop updates.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">03.</span> Sensitive Personal Data & Information (SPDI)
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            We collect specific categories of data necessary for routing operations, categorised as SPDI under the IT Rules, 2011:
                        </p>
                        <ul class="list-disc pl-6 space-y-2 text-slate-400 text-sm">
                            <li><strong>Real-time Location Coordinates:</strong> GPS latitude, longitude, velocity, and timestamp signals collected from drivers during routing operations.</li>
                            <li><strong>Account Credentials:</strong> Password hashes, login tokens, school district association parameters, and registered mobile numbers.</li>
                            <li><strong>Parent-Student Mappings:</strong> Internal stop reference tags matching parent accounts to the school van or bus stop for proximity alerts.</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">04.</span> Rights of Data Principals
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            As a Data Principal under the DPDP Act, you have the following legal rights regarding your personal data:
                        </p>
                        <ul class="list-disc pl-6 space-y-2 text-slate-400 text-sm">
                            <li><strong>Right of Access:</strong> Obtain a summary of the personal data currently being processed and the processing activities.</li>
                            <li><strong>Right to Correction & Erasure:</strong> Correct incomplete, inaccurate, or outdated data, or request absolute deletion of location records.</li>
                            <li><strong>Right to Grievance Redressal:</strong> File a direct complaint with our Grievance Officer regarding any data breach or unauthorized processing.</li>
                            <li><strong>Right to Nominate:</strong> Nominate any individual to exercise your rights under the DPDP Act in the event of death or incapacity.</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">05.</span> Processing of Children's Personal Data
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            Under Section 9 of the DPDP Act, 2023, processing data of a child (under 18 years of age) requires verifiable consent from the parent or lawful guardian. 
                        </p>
                        <ul class="list-disc pl-6 space-y-2 text-slate-400 text-sm">
                            <li>We do not process children's personal data in any manner that is likely to cause a detrimental effect on the well-being of the child.</li>
                            <li>We do not track, profile, monitor, or direct targeted advertisements to children based on their transit logs, route metrics, or geofence crossings.</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">06.</span> Reasonable Security Practices & Breach Protocol
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            We implement strict security practices conforming to **ISO/IEC 27001** standards and IT Act Section 43A requirements. Telemetry pipelines are secured via TLS 1.3 encryption, and data-at-rest is encrypted with AES-256 protocols.
                        </p>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            **Breach Reporting:** In the event of a personal data breach, we are legally mandated to report the incident to the **Indian Computer Emergency Response Team (CERT-In)** and notify affected Data Principals and the Data Protection Board of India in the prescribed format.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">07.</span> Data Retention & Cross-Border Transfer
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            All location logs and GPS history tracking datasets are kept for a maximum of 30 days to generate fuel idling and route compliance reports. Once this retention window lapses, logs are permanently purged from active servers. In accordance with DPDP Act guidelines, personal data collected from Indian citizens is processed and stored on secure servers located within the territory of India.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white border-b border-slate-900 pb-3 flex items-center gap-3">
                            <span class="text-lime-400">08.</span> Appointment of Grievance Redressal Officer
                        </h2>
                        <p class="leading-relaxed text-slate-400 text-sm">
                            In accordance with Section 5 of the IT Rules, 2011 and DPDP Act provisions, we have appointed a Grievance Redressal Officer. Any concerns, data access requests, or complaints should be directed to:
                        </p>
                        <div class="bg-[#121824] p-6 rounded-2xl border border-slate-850 text-xs sm:text-sm space-y-2">
                            <p class="text-white"><strong class="text-slate-400 block text-[9px] uppercase font-bold tracking-wider">Grievance Officer:</strong> Sandeep Rathod</p>
                            <p class="text-white"><strong class="text-slate-400 block text-[9px] uppercase font-bold tracking-wider">Designated Email:</strong> <a href="mailto:leenaitsolutions@gmail.com" class="text-lime-400 hover:underline">leenaitsolutions@gmail.com</a></p>
                            <p class="text-white"><strong class="text-slate-400 block text-[9px] uppercase font-bold tracking-wider">Contact Number:</strong> <a href="tel:9096189183" class="text-lime-400 hover:underline">9096189183</a></p>
                        </div>
                    </div>

                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>
</x-guest-layout>
