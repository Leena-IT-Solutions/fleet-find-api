<x-guest-layout :plain="true">
    <!-- Header -->
    <header class="relative w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" class="h-10 w-auto" alt="Wheels Tracker Logo">
            <span class="text-xl font-bold tracking-tight text-slate-900">Wheels Tracker</span>
        </a>
        <a href="/" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
            Back to Home &rarr;
        </a>
    </header>

    <!-- Main Content -->
    <main class="relative flex-grow px-6 py-12 z-10">
        <div class="max-w-4xl w-full mx-auto bg-white/80 backdrop-blur-xl border border-slate-200/80 shadow-2xl shadow-slate-200/50 rounded-2xl p-8 md:p-12">
            
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 mb-2">Privacy Policy</h1>
            <p class="text-sm text-slate-500 mb-8">Last Updated: July 14, 2026</p>

            <div class="prose prose-slate max-w-none space-y-6 text-slate-600 leading-relaxed">
                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-3">1. Introduction</h2>
                    <p>
                        Welcome to <strong>Wheels Tracker</strong> ("we," "our," "us"). We are committed to protecting your privacy and ensuring the security of your personal data. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our mobile application and web dashboard (collectively, the "Service").
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-3">2. Information We Collect</h2>
                    <p>To provide our real-time transit and fleet management services, we collect several categories of information:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>
                            <strong>Personal Information:</strong> When you register or update your profile, we collect your name, email address, mobile number, and password.
                        </li>
                        <li>
                            <strong>Child Profiles:</strong> Parents or organization administrators can add child profile records, including name, gender, and a profile photo.
                        </li>
                        <li>
                            <strong>Location Data:</strong> 
                            <ul class="list-circle pl-6 mt-1 space-y-1">
                                <li><strong>Real-Time Tracking:</strong> The Service tracks and transmits geographical coordinates (latitude and longitude) of transit vehicles and enrolled children to keep parents informed of live trips.</li>
                                <li><strong>Background Location:</strong> For driver and attendant accounts, we require background location access to broadcast transit tracking details to authorized parents even when the application is closed or not in use. Location sharing can be toggled on or off at any time.</li>
                            </ul>
                        </li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-3">3. How We Use Your Information</h2>
                    <p>We use the collected information for purposes including:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>Operating and maintaining the real-time school and institutional transit tracking systems.</li>
                        <li>Notifying parents and guardians about student departures, current locations, arrivals, or transit delays.</li>
                        <li>Allowing organization administrators to manage vehicles, routes, stops, and schedules.</li>
                        <li>Verifying user identities and managing secure access control credentials.</li>
                        <li>Fulfilling our subscription plan terms and billing processes.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-3">4. Information Sharing and Disclosure</h2>
                    <p>
                        We do not sell, trade, or rent your personal information to third parties. We share location coordinates and transit status updates only with authorized parent sharing groups, organization attendants, and school administrators linked directly to the respective child profile or route.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-3">5. Data Security</h2>
                    <p>
                        We implement strict security measures, including HTTPS encryption, secure database queries, and hashed passwords, to protect your data against unauthorized access, loss, or alteration. All profile photos uploaded via base64 encoding are stored securely on our hosts.
                    </p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-3">6. Your Rights and Choices</h2>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li><strong>Profile Updates:</strong> You can edit your name, email, and mobile number at any time on the profile settings page.</li>
                        <li><strong>Location Sharing Control:</strong> Users can toggle location sharing permissions on/off inside the app settings.</li>
                        <li><strong>Profile Deletion:</strong> Parents and organizations can delete child profiles, which removes all associated photo files from our storage disks immediately.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-slate-900 mb-3">7. Contact Us</h2>
                    <p>
                        If you have any questions or suggestions regarding this Privacy Policy, please contact us at:
                        <br>
                        <strong>Email:</strong> support@infoleena.com
                    </p>
                </section>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="relative w-full max-w-7xl mx-auto px-6 py-6 text-center text-slate-400 text-xs z-10 border-t border-slate-200">
        <p>&copy; {{ date('Y') }} Wheels Tracker. All rights reserved. &bull; <a href="{{ route('privacy-policy') }}" class="underline hover:text-slate-600">Privacy Policy</a></p>
    </footer>
</x-guest-layout>
