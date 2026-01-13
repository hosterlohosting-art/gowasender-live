<?php
$plans = collect([]);
try {
    // Ensure database connection exists before query
    if (class_exists('\Illuminate\Support\Facades\DB')) {
        $plans = \Illuminate\Support\Facades\DB::table('plans')->where('status', 1)->get();
    }
} catch (\Exception $e) {
    $plans = collect([]);
}

// Filter plans to show specific ones on home page (e.g., Recommended or Monthly)
$featuredPlans = $plans->filter(function ($plan) {
    return ($plan->is_recommended == 1) || ($plan->days == 30);
})->take(3);

// Helpers
function formatLimit($value)
{
    return $value == -1 ? 'Unlimited' : $value;
}

function formatFeatureKey($key)
{
    return ucwords(str_replace('_', ' ', $key));
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WA Sender by Hosterlo - #1 Safe Bulk WhatsApp Automation Tool</title>
    <meta name="description"
        content="Automate your WhatsApp marketing with Visual Flow Builder, Chatbots, and Anti-Ban technology. Send bulk messages safely with WA Sender by Hosterlo.">
    <meta name="keywords"
        content="whatsapp automation, bulk sender, visual flow builder, chatbot builder, anti-ban whatsapp, hosterlo wa sender">

    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#F0FDF4',
                            100: '#DCFCE7',
                            200: '#BBF7D0',
                            400: '#4ADE80',
                            500: '#22C55E', // WhatsApp Green
                            600: '#16A34A',
                            700: '#15803D',
                            900: '#14532D',
                            dark: '#022C22',
                        },
                        accent: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            500: '#3B82F6', // Trust Blue
                            600: '#2563EB',
                            700: '#1D4ED8',
                            900: '#1E3A8A',
                        },
                        pink: {
                            50: '#FDF2F8',
                            100: '#FCE7F3',
                            500: '#EC4899',
                            600: '#DB2777',
                            700: '#BE185D',
                        }
                    },
                    backgroundImage: {
                        'hero-pattern': "url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2316A34A' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")",
                    },
                    boxShadow: {
                        'glow': '0 0 40px -10px rgba(34, 197, 94, 0.4)',
                        'card': '0 20px 40px -15px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 30px 60px -15px rgba(34, 197, 94, 0.15)',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        .text-gradient {
            background: linear-gradient(135deg, #16A34A 0%, #2563EB 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-hero {
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.1), transparent 40%),
                radial-gradient(circle at bottom left, rgba(22, 163, 74, 0.1), transparent 40%);
        }

        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
        }

        .tab-btn.active {
            background-color: #16A34A;
            color: white;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }

        .tab-btn {
            color: #4B5563;
        }
    </style>
</head>

<body class="bg-white text-gray-800 antialiased font-sans overflow-x-hidden">

    <!-- Navigation -->
    <nav class="glass-header fixed w-full top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2.5 group cursor-pointer">
                    <img src="{{ asset('assets/img/brand/blue.png') }}" alt="WA Sender Logo" class="h-10 w-auto">
                    <div>
                        <span class="text-2xl font-display font-bold text-gray-900 tracking-tight block leading-none">WA
                            Sender</span>
                        <span class="text-[10px] font-bold text-brand-600 tracking-widest uppercase">by Hosterlo</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-10 text-sm font-semibold text-gray-600">
                    <a href="/" class="text-brand-600 transition-colors">Home</a>
                    <a href="#automation" class="hover:text-brand-600 transition-colors">Automation</a>
                    <a href="#anti-ban" class="hover:text-brand-600 transition-colors">Safety</a>
                    <a href="pricing.php" class="hover:text-brand-600 transition-colors">Pricing</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-4">
                    <a href="/login"
                        class="hidden md:block text-sm font-bold text-gray-600 hover:text-brand-600 transition">Log
                        In</a>
                    <a href="/register"
                        class="px-6 py-2.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-brand-600 hover:shadow-glow transition-all duration-300">
                        Start Free Trial
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-brand-50/50 bg-hero-pattern">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-hero"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col items-center text-center max-w-5xl mx-auto">

                <div
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-brand-200 shadow-sm mb-8 animate-fade-in-up">
                    <span class="flex h-2 w-2 relative">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                    </span>
                    <span class="text-xs font-bold text-brand-900 tracking-wide uppercase">Safe-Send Protocol v3.0
                        Active</span>
                </div>

                <h1
                    class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
                    Scale Your WhatsApp <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-600">Without
                        Getting Banned.</span>
                </h1>

                <p class="text-gray-500 text-lg md:text-xl mb-10 leading-relaxed max-w-2xl mx-auto">
                    The only platform with <strong>Visual Flow Builder</strong>, <strong>Auto-Warmup</strong>, and
                    <strong>Spintax Rotation</strong>. Automate your entire marketing funnel safely with 99.9% delivery
                    rates.
                </p>

                <div class="flex flex-col sm:flex-row gap-5 justify-center w-full md:w-auto">
                    <a href="/register"
                        class="px-8 py-4 bg-brand-600 text-white font-bold text-lg rounded-xl shadow-xl shadow-brand-500/30 hover:shadow-2xl hover:bg-brand-700 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                        <i class="fab fa-whatsapp text-2xl"></i> Start Sending Now
                    </a>
                    <a href="pricing.php"
                        class="px-8 py-4 bg-white text-gray-800 border border-gray-200 font-bold text-lg rounded-xl hover:border-brand-500 hover:text-brand-600 transition-all duration-300 flex items-center justify-center gap-2 shadow-sm">
                        See Pricing
                    </a>
                </div>

                <!-- Stats Strip -->
                <div
                    class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-16 pt-8 border-t border-gray-200/60 w-full max-w-4xl">
                    <div class="text-center">
                        <p class="text-3xl font-display font-bold text-gray-900">10M+</p>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Messages Sent</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-display font-bold text-gray-900">99.9%</p>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Uptime SLA</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-display font-bold text-gray-900">24/7</p>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Auto-Bot Support
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-display font-bold text-brand-600">0%</p>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mt-1">Ban Risk *</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logo Cloud -->
    <div class="border-y border-gray-100 bg-white py-10 overflow-hidden">
        <div class="container mx-auto px-6">
            <p class="text-center text-sm font-semibold text-gray-400 uppercase tracking-widest mb-8">Trusted by
                marketing teams at</p>
            <div
                class="flex flex-wrap justify-center gap-12 md:gap-20 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
                <i class="fab fa-amazon text-4xl hover:text-gray-900 transition"></i>
                <i class="fab fa-google text-4xl hover:text-gray-900 transition"></i>
                <i class="fab fa-spotify text-4xl hover:text-gray-900 transition"></i>
                <i class="fab fa-airbnb text-4xl hover:text-gray-900 transition"></i>
                <i class="fab fa-stripe text-4xl hover:text-gray-900 transition"></i>
            </div>
        </div>
    </div>

    <!-- NEW SECTION: Visual Automation (Meta-style features) -->
    <section id="automation" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Next-Gen
                        Automation</span>
                    <h2 class="text-4xl font-display font-bold text-gray-900 mb-6">Visual Flow Builder & <br> Smart
                        Chatbots</h2>
                    <p class="text-gray-500 text-lg leading-relaxed mb-8">
                        Create complex auto-reply flows without writing a single line of code. Drag and drop elements to
                        build interactive chatbots that handle sales, support, and lead qualification automatically.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-brand-500 text-xl"></i>
                            <span class="font-bold text-gray-700">Drag & Drop Builder</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-brand-500 text-xl"></i>
                            <span class="font-bold text-gray-700">Keyword & Button Triggers</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-brand-500 text-xl"></i>
                            <span class="font-bold text-gray-700">Conditional Logic (If/Else)</span>
                        </li>
                    </ul>
                </div>

                <!-- Visual Representation of Flow -->
                <div class="lg:w-1/2 relative">
                    <div class="bg-gray-50 border border-gray-200 rounded-3xl p-8 shadow-2xl relative z-10">
                        <div class="flex flex-col items-center gap-6">
                            <!-- Step 1 -->
                            <div class="bg-white p-4 rounded-xl shadow-md border border-brand-100 w-64 text-center">
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Trigger</p>
                                <p class="font-bold text-gray-800">Keyword: "Price"</p>
                            </div>
                            <!-- Arrow -->
                            <div class="h-8 w-0.5 bg-gray-300"></div>
                            <!-- Step 2 -->
                            <div class="bg-brand-50 p-4 rounded-xl shadow-md border border-brand-200 w-64 text-center">
                                <p class="text-xs text-brand-600 uppercase font-bold mb-1">Bot Reply</p>
                                <p class="font-bold text-gray-800">"Our plans start at $9..."</p>
                                <div class="mt-2 flex gap-2 justify-center">
                                    <span class="bg-white px-2 py-1 rounded text-xs border shadow-sm">Monthly</span>
                                    <span class="bg-white px-2 py-1 rounded text-xs border shadow-sm">Yearly</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Background Decor -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-brand-100 rounded-full blur-3xl opacity-50">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Anti-Ban Technology Section -->
    <section id="anti-ban" class="py-24 bg-gray-900 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-brand-900/20 blur-3xl rounded-full pointer-events-none">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row gap-16 items-center">
                <div class="md:w-1/2">
                    <span class="text-brand-400 font-bold tracking-wider uppercase text-sm mb-2 block">Safety First
                        Architecture</span>
                    <h2 class="text-3xl md:text-5xl font-display font-bold mb-6 leading-tight">
                        Why You Won't Get <span class="text-brand-400">Blocked</span>.
                    </h2>
                    <p class="text-gray-400 text-lg leading-relaxed mb-8">
                        WhatsApp blocks numbers that behave like robots. WA Sender mimics human behavior perfectly using
                        advanced algorithms to protect your business reputation.
                    </p>

                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center text-brand-400 text-xl shrink-0">
                                <i class="fas fa-random"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Spintax (Spin Syntax)</h4>
                                <p class="text-gray-400 text-sm">"Hello", "Hi", "Hey" - We randomize words so no two
                                    messages are identical hash signatures.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center text-brand-400 text-xl shrink-0">
                                <i class="fas fa-stopwatch"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Human-Like Delays</h4>
                                <p class="text-gray-400 text-sm">Random variable delays (e.g., 10-25 seconds) between
                                    messages to simulate real typing.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-gray-800 border border-gray-700 flex items-center justify-center text-brand-400 text-xl shrink-0">
                                <i class="fas fa-sync"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Account Rotation</h4>
                                <p class="text-gray-400 text-sm">Connect multiple numbers. The system automatically
                                    switches senders to keep volume low per SIM.</p>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a href="#"
                            class="text-brand-400 hover:text-white underline decoration-brand-400 underline-offset-4 transition">Read
                            our full Anti-Ban Guide &rarr;</a>
                    </div>
                </div>

                <div class="md:w-1/2">
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-8 shadow-2xl">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2"><i
                                class="fas fa-shield-alt text-brand-400"></i> Safety Report</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-400">Content Uniqueness</span>
                                    <span class="text-brand-400 font-bold">100%</span>
                                </div>
                                <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-brand-500 w-full"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-400">Delay Variance</span>
                                    <span class="text-brand-400 font-bold">Optimal (15-45s)</span>
                                </div>
                                <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-brand-500 w-[90%]"></div>
                                </div>
                            </div>
                            <div class="p-4 bg-brand-900/30 border border-brand-500/30 rounded-lg mt-4">
                                <p class="text-sm text-brand-200"><i class="fas fa-info-circle mr-2"></i> Your campaign
                                    is configured with <strong>Safe Mode</strong> enabled.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Preview Section -->
    <section id="pricing" class="py-24 bg-brand-50/50 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-display font-bold text-gray-900">Featured Plans</h2>
                <p class="text-gray-500 mt-4 text-lg">Transparent pricing for every business size.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <?php if ($featuredPlans->count() > 0): ?>
                <?php    foreach ($featuredPlans as $plan):
        $features = json_decode($plan->data ?? '{}');
                    ?>
                <div
                    class="bg-white rounded-3xl p-8 shadow-card hover:shadow-xl transition-all border border-transparent hover:border-brand-200 flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($plan->title) ?></h3>
                    <div class="text-4xl font-bold text-brand-600 mb-6">$<?= htmlspecialchars($plan->price) ?> <span
                            class="text-lg text-gray-400 font-normal">/ <?= ($plan->days == 365) ? 'yr' : 'mo' ?></span>
                    </div>

                    <a href="{{ url('/register', $plan->id) }}"
                        class="block w-full py-3 text-center bg-gray-900 text-white font-bold rounded-xl hover:bg-brand-600 transition mb-6 shadow-lg shadow-brand-500/10 hover:shadow-brand-500/30">Get
                        Started</a>

                    <ul class="space-y-3 flex-1">
                        <li class="flex gap-3 text-sm text-gray-600"><i class="fas fa-check text-brand-500"></i>
                            <?= formatLimit($features->messages_limit ?? 0) ?> Messages</li>
                        <li class="flex gap-3 text-sm text-gray-600"><i class="fas fa-check text-brand-500"></i>
                            <?= formatLimit($features->contact_limit ?? 0) ?> Contacts</li>
                        <li class="flex gap-3 text-sm text-gray-600"><i class="fas fa-check text-brand-500"></i>
                            Anti-Ban Protection</li>
                    </ul>
                </div>
                <?php    endforeach; ?>
                <?php else: ?>
                <!-- Fallback if DB empty -->
                <div class="bg-white rounded-3xl p-8 shadow-card col-span-3 text-center">
                    <h3 class="text-2xl font-bold text-gray-900">Flexible Pricing Available</h3>
                    <p class="text-gray-500 mt-2 mb-6">Check our full pricing page for detailed plans.</p>
                    <a href="pricing.php" class="px-6 py-3 bg-brand-600 text-white font-bold rounded-xl">View All
                        Plans</a>
                </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-12">
                <a href="pricing.php"
                    class="inline-flex items-center gap-2 text-brand-600 font-bold hover:text-brand-700 transition">
                    View Full Pricing & Feature Comparison <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- NEW SECTION: Comparison Table -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-display font-bold text-gray-900">Why Hosterlo outperforms the rest</h2>
                <p class="text-gray-500 mt-2">A breakdown of what makes our Anti-Ban technology superior.</p>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-gray-100 shadow-xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-6 text-sm font-bold text-gray-900 uppercase">Features</th>
                            <th class="p-6 text-sm font-bold text-gray-500 uppercase">Standard Senders</th>
                            <th class="p-6 text-sm font-bold text-brand-600 uppercase bg-brand-50">WA Sender by Hosterlo
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="p-6 font-medium text-gray-900">Anti-Ban Technology</td>
                            <td class="p-6 text-gray-500">Basic Delays Only</td>
                            <td class="p-6 font-bold text-brand-600 bg-brand-50/30"><i
                                    class="fas fa-check-circle mr-2"></i>AI Human Emulation</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-medium text-gray-900">Account Rotation</td>
                            <td class="p-6 text-gray-500">Manual Switching</td>
                            <td class="p-6 font-bold text-brand-600 bg-brand-50/30"><i
                                    class="fas fa-check-circle mr-2"></i>Auto-Load Balancing</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-medium text-gray-900">API Access</td>
                            <td class="p-6 text-gray-500">Limited / Paid Extra</td>
                            <td class="p-6 font-bold text-brand-600 bg-brand-50/30"><i
                                    class="fas fa-check-circle mr-2"></i>Full Cloud API Included</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- NEW SECTION: Use Cases -->
    <section class="py-24 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-display font-bold text-gray-900">Perfect for every industry</h2>
                <p class="text-gray-500 mt-2">Tailored solutions for high-growth sectors.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- E-commerce -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 text-xl mb-4">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">E-Commerce Stores</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Recover abandoned carts, send order updates, and
                        blast seasonal offers with 98% open rates.</p>
                </div>
                <!-- Real Estate -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xl mb-4">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Real Estate Agents</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Send property listings, schedule viewings
                        automatically, and follow up with leads instantly.</p>
                </div>
                <!-- Education -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 text-xl mb-4">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">EdTech & Coaching</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Send class reminders, fee alerts, and course
                        materials directly to student WhatsApp numbers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-display font-bold text-gray-900">Frequently Asked Questions</h2>
                <p class="text-gray-500 mt-2">Everything you need to know about safe WhatsApp marketing.</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-md transition cursor-pointer"
                    onclick="this.querySelector('p').classList.toggle('hidden'); this.querySelector('i').classList.toggle('rotate-180')">
                    <div class="flex justify-between items-center font-bold text-gray-900">
                        <span>Will my WhatsApp number get banned?</span>
                        <i class="fas fa-chevron-down text-brand-500 transition-transform"></i>
                    </div>
                    <p class="text-gray-600 mt-4 leading-relaxed text-sm hidden">
                        While no tool can guarantee 100% safety as it depends on WhatsApp's policies, WA Sender
                        significantly reduces risk using random delays, spintax, and account rotation. We recommend
                        using 'warm-up' numbers for best results.
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-md transition cursor-pointer"
                    onclick="this.querySelector('p').classList.toggle('hidden'); this.querySelector('i').classList.toggle('rotate-180')">
                    <div class="flex justify-between items-center font-bold text-gray-900">
                        <span>Do I need to keep my PC on?</span>
                        <i class="fas fa-chevron-down text-brand-500 transition-transform"></i>
                    </div>
                    <p class="text-gray-600 mt-4 leading-relaxed text-sm hidden">
                        No! WA Sender is 100% cloud-based. Once you schedule a campaign, our servers handle the sending
                        process. You can turn off your device and relax.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-dark text-white pt-24 pb-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">

                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 bg-brand-600 rounded-lg flex items-center justify-center text-white text-xl">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <span class="text-2xl font-display font-bold tracking-tight">WA Sender</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-8">
                        The world's most trusted WhatsApp marketing platform by Hosterlo. Built for safety, speed,
                        and scale.
                    </p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-600 transition-all"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-600 transition-all"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-600 transition-all"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Product</h4>
                    <ul class="space-y-4 text-gray-400 text-sm">
                        <li><a href="#features" class="hover:text-brand-400 transition">Features</a></li>
                        <li><a href="pricing.php" class="hover:text-brand-400 transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">API Docs</a></li>
                        <li><a href="#anti-ban" class="hover:text-brand-400 transition">Anti-Ban Guide</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Company</h4>
                    <ul class="space-y-4 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-brand-400 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">Contact</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">Privacy Policy</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Newsletter</h4>
                    <p class="text-gray-400 text-sm mb-4">Get the latest marketing tips.</p>
                    <div class="flex flex-col gap-3">
                        <input type="email" placeholder="Email address"
                            class="bg-white/5 border border-white/10 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-brand-500 transition">
                        <button
                            class="bg-brand-600 text-white font-bold px-4 py-3 rounded-xl hover:bg-brand-500 transition">Subscribe</button>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Hosterlo Inc. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>