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
                    <a href="/pricing" class="font-semibold text-lime-400">Pricing</a>
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
            <section class="py-24 bg-gradient-to-b from-[#0F1420] via-[#080B11] to-[#080B11] border-b border-slate-900/60 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(163,230,53,0.08),rgba(0,0,0,0))]"></div>
                <div class="mx-auto max-w-4xl px-6 space-y-6 relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-lime-950/20 border border-lime-500/20 text-lime-400 text-xs font-semibold uppercase tracking-wider">
                        🏷️ Transparent Billing Tiers
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-white tracking-tight leading-tight">
                        Simple Pricing For <br>
                        <span class="bg-gradient-to-r from-lime-400 via-emerald-400 to-cyan-400 bg-clip-text text-transparent">Every Size Fleet.</span>
                    </h1>
                    <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Scale billing dynamically based on active vehicle counts. No setup fees, cancel anytime.
                    </p>
                </div>
            </section>

            <!-- Pricing Grid -->
            <section class="py-16 bg-[#080B11]">
                <div class="mx-auto max-w-5xl px-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
                    
                    <!-- Micro Fleet Plan (< 10 Vehicles) -->
                    <div class="bg-[#121824] p-8 rounded-3xl border border-slate-850 hover:border-lime-500/10 transition-all-300 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="text-[10px] text-slate-450 uppercase font-black tracking-widest block">For Small Fleets</span>
                            <h3 class="text-2xl font-black text-white">Micro Fleet Plan</h3>
                            <p class="text-slate-400 text-xs leading-relaxed">Perfect for schools with less than 10 active vehicles, vans, or auto rickshaws.</p>
                            <p class="text-4xl font-black text-white">₹229<span class="text-xs text-slate-500 font-medium"> / vehicle / month</span></p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow text-left">
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Live GPS coordinates tracking (2s updates)</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Parent tracking mobile app portal access</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Hands-free driver app checklists & checks</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Centralized school administrator monitoring console</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Unlimited instant push notifications</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Weekly fuel idling & speed compliance reports</span>
                            </div>
                        </div>
                        
                        <!-- Input block inside card -->
                        <div class="border-t border-slate-850 pt-4 space-y-2 text-left">
                            <label class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">Fleet Size (1 - 9 vehicles)</label>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="adjustMicroCount(-1)" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#1A2333] text-slate-400 hover:text-white flex items-center justify-center font-extrabold text-lg transition-all-300 select-none">-</button>
                                <div class="relative flex-grow">
                                    <input type="number" id="micro-vehicle-count" min="1" max="9" value="5" readonly class="w-full text-center bg-[#1A2333] border border-slate-800 focus:border-lime-400 rounded-xl py-2.5 pr-8 text-white text-xs focus:outline-none transition-colors">
                                    <span class="absolute right-3 top-3 text-[9px] text-slate-500 font-bold font-mono select-none">Qty</span>
                                </div>
                                <button type="button" onclick="adjustMicroCount(1)" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#1A2333] text-slate-400 hover:text-white flex items-center justify-center font-extrabold text-lg transition-all-300 select-none">+</button>
                            </div>
                            <div class="flex justify-between items-center text-[10px] text-slate-400 font-semibold px-1 pt-1">
                                <span>Total Price:</span>
                                <span id="micro-total-label" class="text-lime-400 font-bold font-mono">₹1,145/month</span>
                            </div>
                        </div>

                        <button onclick="deployMicroPlan()" class="w-full text-center py-4 rounded-xl bg-slate-900 border border-slate-800 hover:bg-[#1A2333] hover:text-white text-slate-200 text-sm font-black uppercase tracking-wider transition-all-300">
                            Deploy Micro Plan
                        </button>
                    </div>

                    <!-- Growth Fleet Plan (10+ Vehicles) -->
                    <div class="bg-[#121824] p-8 rounded-3xl border-2 border-lime-400 flex flex-col justify-between space-y-6 relative shadow-xl">
                        <span class="absolute -top-3.5 right-6 bg-lime-400 text-slate-950 text-[8px] font-black uppercase px-2.5 py-1 rounded-full font-bold">BEST VALUE</span>
                        <div class="space-y-4">
                            <span class="text-[10px] text-lime-400 uppercase font-black tracking-widest block font-bold">For Larger Fleets</span>
                            <h3 class="text-2xl font-black text-white">Growth Fleet Plan</h3>
                            <p class="text-slate-400 text-xs leading-relaxed">Custom built for larger school campuses, district contracts, and B2B operators.</p>
                            <p class="text-4xl font-black text-white">₹199<span class="text-xs text-slate-500 font-medium"> / vehicle / month</span></p>
                        </div>
                        <div class="space-y-3.5 text-xs border-t border-slate-850 pt-6 flex-grow text-left">
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>All features in Micro Fleet plan included</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Higher vehicle counts rate discount (₹199/mo)</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>RFID passenger scan integration support</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Dedicated customer success supervisor</span>
                            </div>
                            <div class="flex gap-2.5 items-center text-slate-300">
                                <span class="text-lime-400 font-bold">✓</span><span>Custom API integrations & multi-school views</span>
                            </div>
                        </div>

                        <!-- Input block inside card -->
                        <div class="border-t border-slate-850 pt-4 space-y-2 text-left">
                            <label class="text-[10px] text-lime-400/80 font-extrabold uppercase tracking-wider block">Fleet Size (10+ vehicles)</label>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="adjustGrowthCount(-1)" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-850 hover:bg-[#1A2333] text-slate-400 hover:text-white flex items-center justify-center font-extrabold text-lg transition-all-300 select-none">-</button>
                                <div class="relative flex-grow">
                                    <input type="number" id="growth-vehicle-count" min="10" value="15" readonly class="w-full text-center bg-[#1A2333] border border-lime-400/25 focus:border-lime-400 rounded-xl py-2.5 pr-8 text-white text-xs focus:outline-none transition-colors">
                                    <span class="absolute right-3 top-3 text-[9px] text-lime-400/40 font-bold font-mono select-none">Qty</span>
                                </div>
                                <button type="button" onclick="adjustGrowthCount(1)" class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-850 hover:bg-[#1A2333] text-slate-400 hover:text-white flex items-center justify-center font-extrabold text-lg transition-all-300 select-none">+</button>
                            </div>
                            <div class="flex justify-between items-center text-[10px] text-slate-350 font-semibold px-1 pt-1">
                                <span>Total Price:</span>
                                <span id="growth-total-label" class="text-lime-400 font-black font-mono">₹2,985/month</span>
                            </div>
                        </div>

                        <button onclick="deployGrowthPlan()" class="pulse-lime w-full text-center py-4 rounded-xl bg-lime-400 hover:bg-lime-300 text-slate-950 font-black text-sm uppercase tracking-wider transition-all-300">
                            Deploy Growth Plan
                        </button>
                    </div>

                </div>
            </section>

            <!-- Feature Checklist Section -->
            <section class="py-24 bg-[#0B0F17] border-y border-slate-900/60">
                <div class="mx-auto max-w-4xl px-6 space-y-12 text-center">
                    <div class="max-w-2xl mx-auto space-y-4">
                        <span class="text-lime-400 font-extrabold text-xs uppercase tracking-wider">Zero Compromises</span>
                        <h2 class="text-3xl font-black text-white">All Features Included In Both Plans</h2>
                        <p class="text-slate-400 text-sm">We believe child safety shouldn't be gated by paywalls. That's why every account gets access to our complete list of tracking modules.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left pt-6">
                        <div class="bg-[#121824] p-5 rounded-2xl border border-slate-850 flex gap-4">
                            <div class="text-lime-400 text-lg">📡</div>
                            <div>
                                <h4 class="text-sm font-extrabold text-white">Live Tracking Streams</h4>
                                <p class="text-xs text-slate-400 mt-1">High-frequency coordinate parameter refreshes every 2 seconds on dynamic route maps.</p>
                            </div>
                        </div>
                        <div class="bg-[#121824] p-5 rounded-2xl border border-slate-850 flex gap-4">
                            <div class="text-lime-400 text-lg">📱</div>
                            <div>
                                <h4 class="text-sm font-extrabold text-white">Dual-Interface Mobiles</h4>
                                <p class="text-xs text-slate-400 mt-1">Sleek parent portals for tracking, and hands-free big-indicator checklists for drivers.</p>
                            </div>
                        </div>
                        <div class="bg-[#121824] p-5 rounded-2xl border border-slate-850 flex gap-4">
                            <div class="text-lime-400 text-lg">🔔</div>
                            <div>
                                <h4 class="text-sm font-extrabold text-white">Instant Push Notifications</h4>
                                <p class="text-xs text-slate-400 mt-1">Instant, unlimited mobile app push alerts when a vehicle crosses geofence boundaries.</p>
                            </div>
                        </div>
                        <div class="bg-[#121824] p-5 rounded-2xl border border-slate-850 flex gap-4">
                            <div class="text-lime-400 text-lg">📊</div>
                            <div>
                                <h4 class="text-sm font-extrabold text-white">High-Fidelity PDF Reports</h4>
                                <p class="text-xs text-slate-400 mt-1">Export fleet mileage sheets, speed violations logs, and vehicle idling parameters.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Direct Verification Support -->
            <section class="py-24 bg-[#080B11]">
                <div class="mx-auto max-w-4xl px-6 text-center space-y-8">
                    <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">Need a Custom Institutional Setup?</h2>
                    <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                        If you represent a university or a city-wide public transport contract with 100+ vehicles, contact our pricing team.
                    </p>
                    <div class="pt-4">
                        <a href="/contact" class="w-full sm:w-auto px-8 py-4 rounded-xl border border-slate-800 bg-slate-900 hover:bg-slate-800 text-white font-black text-sm uppercase tracking-wider transition-all-300 inline-block">
                            Contact Pricing Desk
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer />

    </div>

    <!-- Razorpay Checkout Integration Scripts -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function adjustMicroCount(delta) {
            const input = document.getElementById('micro-vehicle-count');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > 9) {
                val = 9;
                alert("Micro Fleet Plan is capped at 9 vehicles. For 10 or more vehicles, please use the Growth Fleet Plan!");
            }
            input.value = val;
            updateMicroTotal();
        }

        function adjustGrowthCount(delta) {
            const input = document.getElementById('growth-vehicle-count');
            let val = parseInt(input.value) + delta;
            if (val < 10) {
                val = 10;
                alert("Growth Fleet Plan requires a minimum of 10 vehicles. For smaller fleets, please use the Micro Fleet Plan.");
            }
            input.value = val;
            updateGrowthTotal();
        }

        function updateMicroTotal() {
            const input = document.getElementById('micro-vehicle-count');
            let val = parseInt(input.value);
            if (isNaN(val) || val < 1) val = 1;
            if (val > 9) val = 9;
            const total = val * 229;
            document.getElementById('micro-total-label').innerText = '₹' + total.toLocaleString('en-IN') + '/month';
        }

        function updateGrowthTotal() {
            const input = document.getElementById('growth-vehicle-count');
            let val = parseInt(input.value);
            if (isNaN(val) || val < 10) val = 10;
            const total = val * 199;
            document.getElementById('growth-total-label').innerText = '₹' + total.toLocaleString('en-IN') + '/month';
        }

        function deployMicroPlan() {
            const val = parseInt(document.getElementById('micro-vehicle-count').value);
            if (isNaN(val) || val < 1 || val > 9) {
                alert("Please enter a valid fleet size between 1 and 9.");
                return;
            }
            openRazorpayCheckout('Micro Fleet Plan', 229, val);
        }

        function deployGrowthPlan() {
            const val = parseInt(document.getElementById('growth-vehicle-count').value);
            if (isNaN(val) || val < 10) {
                alert("Please enter a valid fleet size of 10 or more.");
                return;
            }
            openRazorpayCheckout('Growth Fleet Plan', 199, val);
        }

        function openRazorpayCheckout(packageName, pricePerVehicle, count) {
            // Calculate total subscription amount
            const totalAmount = count * pricePerVehicle;

            const options = {
                "key": "rzp_test_dummykey12345", // Dummy public test key
                "amount": totalAmount * 100, // Amount in paise
                "currency": "INR",
                "name": "WheelsTracker",
                "description": packageName + " Subscription (" + count + " Vehicles)",
                "image": "http://127.0.0.1:8000/logo.png",
                "handler": function (response) {
                    alert("Payment successful!\nPayment ID: " + response.razorpay_payment_id + "\nYour fleet dashboard is now active.");
                },
                "prefill": {
                    "name": "Leena IT Solutions",
                    "email": "leenaitsolutions@gmail.com",
                    "contact": "+919096189183"
                },
                "theme": {
                    "color": "#a3e635" // Premium custom lime green color theme matching the branding
                }
            };

            try {
                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response) {
                    alert("Payment failed: " + response.error.description);
                });
                rzp.open();
            } catch (error) {
                console.error("Razorpay error: ", error);
                alert("Unable to open Razorpay payment gateway checkout portal.");
            }
        }
    </script>
    </div>
</x-guest-layout>
