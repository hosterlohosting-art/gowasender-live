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

// Filter plans
$monthlyPlans = $plans->filter(function ($plan) {
    return ($plan->days ?? 30) == 30;
});

$yearlyPlans = $plans->filter(function ($plan) {
    return ($plan->days ?? 30) == 365;
});

// Helpers
function formatLimit($value)
{
    return $value == -1 ? 'Unlimited' : $value;
}

function formatFeatureKey($key)
{
    return ucwords(str_replace('_', ' ', $key));
}

function getPlanColor($labelColor)
{
    return match ($labelColor) {
        'price-color-1' => 'pink',
        'price-color-2' => 'brand', // Green
        default => 'accent', // Blue
    };
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans - WA Sender by Hosterlo | Bulk WhatsApp Marketing Tools</title>
    <meta name="description"
        content="Affordable Bulk WhatsApp Marketing plans. Compare our Monthly vs Yearly pricing. Features include Chatbots, Auto-responders, and Anti-Ban technology. Start for free.">
    <meta name="keywords"
        content="whatsapp marketing pricing, bulk sender cost, whatsapp api pricing, anti-ban whatsapp tool, hosterlo pricing">

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
                        'grid-pattern': "url(\"data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2316A34A' fill-opacity='0.03' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E\")",
                    },
                    boxShadow: {
                        'glow': '0 0 40px -10px rgba(34, 197, 94, 0.4)',
                        'card': '0 20px 40px -15px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 30px 60px -15px rgba(34, 197, 94, 0.1)',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .tab-btn.active {
            background-color: #16A34A;
            color: white;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }

        .tab-btn {
            color: #4B5563;
        }

        .tab-btn:hover:not(.active) {
            background-color: #F3F4F6;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="glass-header fixed w-full top-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2.5 group cursor-pointer">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg shadow-brand-500/20">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-display font-bold text-gray-900 tracking-tight block leading-none">WA
                            Sender</span>
                        <span class="text-[10px] font-bold text-brand-600 tracking-widest uppercase">by Hosterlo</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-10 text-sm font-semibold text-gray-600">
                    <a href="/" class="hover:text-brand-600 transition-colors">Home</a>
                    <a href="/#features" class="hover:text-brand-600 transition-colors">Features</a>
                    <a href="/pricing" class="text-brand-600 transition-colors">Pricing</a>
                    <a href="#" class="hover:text-brand-600 transition-colors">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-4">
                    <a href="/login"
                        class="hidden md:block text-sm font-bold text-gray-600 hover:text-brand-600 transition">Log
                        In</a>
                    <a href="/register"
                        class="px-6 py-2.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-brand-600 hover:shadow-glow transition-all duration-300">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Pricing Header -->
    <section class="pt-40 pb-16 bg-white relative overflow-hidden bg-grid-pattern">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-50/80"></div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-display font-bold text-gray-900 mb-6">
                Pricing that scales <br class="hidden md:block" /> with your ambition.
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10">
                Transparent pricing with no hidden fees. Start for free and upgrade as you grow your WhatsApp marketing
                campaigns.
            </p>

            <!-- Toggle Switch -->
            <div class="inline-flex bg-white p-2 rounded-2xl border border-gray-200 shadow-sm relative z-20">
                <button id="toggle-monthly" onclick="switchBilling('monthly')"
                    class="tab-btn active px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300">
                    Monthly
                </button>
                <button id="toggle-yearly" onclick="switchBilling('yearly')"
                    class="tab-btn px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2">
                    Annual
                    <span
                        class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wide border border-yellow-200">
                        -20% OFF
                    </span>
                </button>
            </div>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="py-16 bg-gray-50 flex-grow">
        <div class="container mx-auto px-6">

            <!-- Monthly Plans -->
            <div id="plans-monthly"
                class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto items-start transition-all duration-500 ease-out">
                <?php if ($monthlyPlans->count() > 0): ?>
                <?php    foreach ($monthlyPlans as $plan):
        $data = json_decode($plan->data ?? '{}', true);
        $color = getPlanColor($plan->labelcolor ?? 'default');
        $isRecommended = $plan->is_recommended ?? false;
                    ?>
                <div
                    class="group relative bg-white rounded-[2rem] p-8 flex flex-col transition-all duration-300 <?= $isRecommended ? 'shadow-xl border-2 border-' . $color . '-500 ring-4 ring-' . $color . '-500/10 scale-105 z-10' : 'shadow-card border border-gray-100 hover:border-' . $color . '-300 hover:shadow-lg' ?>">

                    <?php        if ($isRecommended): ?>
                    <div
                        class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-<?= $color ?>-600 to-<?= $color ?>-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg tracking-wide uppercase">
                        Most Popular
                    </div>
                    <?php        endif; ?>

                    <div class="mb-6">
                        <h3
                            class="text-2xl font-display font-bold text-gray-900 group-hover:text-<?= $color ?>-600 transition-colors">
                            <?= htmlspecialchars($plan->title) ?></h3>
                        <p class="text-sm text-gray-500 mt-2">Best for growing businesses.</p>
                    </div>

                    <div class="mb-8 flex items-baseline gap-1">
                        <span
                            class="text-5xl font-extrabold text-gray-900 tracking-tight">$<?= htmlspecialchars($plan->price) ?></span>
                        <span class="text-gray-500 font-medium">/month</span>
                    </div>

                    <a href="<?= url('/register', $plan->id) ?>"
                        class="block w-full py-4 text-center font-bold rounded-xl transition-all duration-300 <?= $isRecommended ? 'bg-' . $color . '-600 text-white hover:bg-' . $color . '-700 shadow-lg shadow-' . $color . '-500/30' : 'bg-gray-50 text-gray-900 hover:bg-' . $color . '-600 hover:text-white border border-gray-200 hover:border-transparent' ?>">
                        <?= ($plan->is_trial == 1) ? 'Start Free Trial' : 'Choose Plan' ?>
                    </a>

                    <div class="my-8 border-t border-gray-100"></div>

                    <ul class="space-y-4 mb-2 flex-1">
                        <?php        foreach ($data as $key => $value): ?>
                        <li
                            class="flex items-start gap-3 text-sm <?= ($value == 'true' || is_numeric($value)) ? 'text-gray-700' : 'text-gray-400 decoration-line-through' ?>">
                            <?php            if ($value == 'true' || is_numeric($value)): ?>
                            <div
                                class="mt-0.5 w-5 h-5 rounded-full bg-<?= $color ?>-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-<?= $color ?>-600 text-[10px]"></i>
                            </div>
                            <?php            else: ?>
                            <div
                                class="mt-0.5 w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-times text-gray-400 text-[10px]"></i>
                            </div>
                            <?php            endif; ?>
                            <span class="leading-tight">
                                <?= is_numeric($value) ? '<strong>' . formatLimit($value) . '</strong>' : '' ?>
                                <?= formatFeatureKey($key) ?>
                            </span>
                        </li>
                        <?php        endforeach; ?>
                    </ul>
                </div>
                <?php    endforeach; ?>
                <?php else: ?>
                <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-dashed border-gray-300">
                    <div class="text-gray-400 mb-2"><i class="fas fa-inbox text-4xl"></i></div>
                    <p class="text-gray-500 text-lg">No monthly plans available right now.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Yearly Plans (Hidden) -->
            <div id="plans-yearly"
                class="hidden grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto items-start transition-all duration-500 ease-out">
                <?php if ($yearlyPlans->count() > 0): ?>
                <?php    foreach ($yearlyPlans as $plan):
        $data = json_decode($plan->data ?? '{}', true);
        $color = getPlanColor($plan->labelcolor ?? 'default');
        $isRecommended = $plan->is_recommended ?? false;
                    ?>
                <div
                    class="group relative bg-white rounded-[2rem] p-8 flex flex-col transition-all duration-300 <?= $isRecommended ? 'shadow-xl border-2 border-' . $color . '-500 ring-4 ring-' . $color . '-500/10 scale-105 z-10' : 'shadow-card border border-gray-100 hover:border-' . $color . '-300 hover:shadow-lg' ?>">

                    <?php        if ($isRecommended): ?>
                    <div
                        class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-<?= $color ?>-600 to-<?= $color ?>-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg tracking-wide uppercase">
                        Most Popular
                    </div>
                    <?php        endif; ?>

                    <div class="mb-6">
                        <h3
                            class="text-2xl font-display font-bold text-gray-900 group-hover:text-<?= $color ?>-600 transition-colors">
                            <?= htmlspecialchars($plan->title) ?></h3>
                        <p class="text-sm text-gray-500 mt-2">Best value for long term.</p>
                    </div>

                    <div class="mb-8 flex items-baseline gap-1">
                        <span
                            class="text-5xl font-extrabold text-gray-900 tracking-tight">$<?= htmlspecialchars($plan->price) ?></span>
                        <span class="text-gray-500 font-medium">/year</span>
                    </div>

                    <a href="<?= url('/register', $plan->id) ?>"
                        class="block w-full py-4 text-center font-bold rounded-xl transition-all duration-300 <?= $isRecommended ? 'bg-' . $color . '-600 text-white hover:bg-' . $color . '-700 shadow-lg shadow-' . $color . '-500/30' : 'bg-gray-50 text-gray-900 hover:bg-' . $color . '-600 hover:text-white border border-gray-200 hover:border-transparent' ?>">
                        <?= ($plan->is_trial == 1) ? 'Start Free Trial' : 'Choose Plan' ?>
                    </a>

                    <div class="my-8 border-t border-gray-100"></div>

                    <ul class="space-y-4 mb-2 flex-1">
                        <?php        foreach ($data as $key => $value): ?>
                        <li
                            class="flex items-start gap-3 text-sm <?= ($value == 'true' || is_numeric($value)) ? 'text-gray-700' : 'text-gray-400 decoration-line-through' ?>">
                            <?php            if ($value == 'true' || is_numeric($value)): ?>
                            <div
                                class="mt-0.5 w-5 h-5 rounded-full bg-<?= $color ?>-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-check text-<?= $color ?>-600 text-[10px]"></i>
                            </div>
                            <?php            else: ?>
                            <div
                                class="mt-0.5 w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                <i class="fas fa-times text-gray-400 text-[10px]"></i>
                            </div>
                            <?php            endif; ?>
                            <span class="leading-tight">
                                <?= is_numeric($value) ? '<strong>' . formatLimit($value) . '</strong>' : '' ?>
                                <?= formatFeatureKey($key) ?>
                            </span>
                        </li>
                        <?php        endforeach; ?>
                    </ul>
                </div>
                <?php    endforeach; ?>
                <?php else: ?>
                <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-dashed border-gray-300">
                    <div class="text-gray-400 mb-2"><i class="fas fa-inbox text-4xl"></i></div>
                    <p class="text-gray-500 text-lg">No yearly plans available right now.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Trust Badge Strip -->
            <div class="mt-20 pt-10 border-t border-gray-200 text-center">
                <p class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-6">Secure Payments & Trusted
                    Technology</p>
                <div class="flex justify-center items-center gap-8 md:gap-12 opacity-40 grayscale">
                    <i class="fab fa-stripe text-5xl"></i>
                    <i class="fab fa-paypal text-3xl"></i>
                    <i class="fab fa-cc-visa text-4xl"></i>
                    <i class="fab fa-cc-mastercard text-4xl"></i>
                    <div class="flex items-center gap-1 font-bold text-xl"><i class="fas fa-lock"></i> SSL Secure</div>
                </div>
            </div>

        </div>
    </section>

    <!-- NEW SECTION: Detailed Comparison Table (SEO Boost) -->
    <section class="py-20 bg-white">
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
                            <th class="p-6 text-sm font-bold text-brand-600 uppercase bg-brand-50">WA Sender by Hosterlo</th>
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
                        <tr>
                            <td class="p-6 font-medium text-gray-900">Support</td>
                            <td class="p-6 text-gray-500">Email Only</td>
                            <td class="p-6 font-bold text-brand-600 bg-brand-50/30"><i
                                    class="fas fa-check-circle mr-2"></i>24/7 Live Chat</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- NEW SECTION: Use Cases (SEO Keywords) -->
    <section class="py-20 bg-gray-50 border-t border-gray-200">
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
                        <i class="fas fa-shopping-bag"></i></div>
                    <h3 class="font-bold text-lg mb-2">E-Commerce Stores</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Recover abandoned carts, send order updates, and
                        blast seasonal offers with 98% open rates.</p>
                </div>
                <!-- Real Estate -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xl mb-4">
                        <i class="fas fa-home"></i></div>
                    <h3 class="font-bold text-lg mb-2">Real Estate Agents</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Send property listings, schedule viewings
                        automatically, and follow up with leads instantly.</p>
                </div>
                <!-- Education -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 text-xl mb-4">
                        <i class="fas fa-graduation-cap"></i></div>
                    <h3 class="font-bold text-lg mb-2">EdTech & Coaching</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Send class reminders, fee alerts, and course
                        materials directly to student WhatsApp numbers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row gap-16">
                <div class="md:w-1/3">
                    <h2 class="text-3xl font-display font-bold text-gray-900 mb-4">Common Questions</h2>
                    <p class="text-gray-500 mb-6">Can't find the answer you're looking for? Reach out to our customer
                        support team.</p>
                    <a href="#" class="text-brand-600 font-bold hover:underline">Contact Support &rarr;</a>
                </div>

                <div class="md:w-2/3 space-y-6">
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Can I switch plans later?</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">Yes, you can upgrade or downgrade your plan at
                            any time. If you upgrade, the prorated difference will be charged. If you downgrade, credit
                            will be applied to your next billing cycle.</p>
                    </div>
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-2">Is there a refund policy?</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">We offer a 7-day money-back guarantee for all
                            new subscriptions. If you're not satisfied with our service, simply contact us within the
                            first week for a full refund.</p>
                    </div>
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="font-bold text-lg text-gray-900 mb-2">What payment methods do you accept?</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">We accept all major credit cards (Visa,
                            Mastercard, American Express), PayPal, and Stripe. For Enterprise plans, we also support
                            bank transfers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-dark text-white pt-20 pb-10 mt-auto">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 bg-brand-600 rounded-lg flex items-center justify-center text-white text-xl">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <span class="text-2xl font-display font-bold tracking-tight">WA Sender</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Hosterlo Inc.<br>
                        Making WhatsApp marketing safe, scalable, and simple for everyone.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Company</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-brand-400 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">Terms</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">Privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Resources</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-brand-400 transition">Blog</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition">API Docs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Get in touch</h4>
                    <p class="text-gray-400 text-sm mb-4">support@hosterlo.com</p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-8 h-8 rounded bg-white/10 flex items-center justify-center hover:bg-brand-600 transition"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#"
                            class="w-8 h-8 rounded bg-white/10 flex items-center justify-center hover:bg-brand-600 transition"><i
                                class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 pt-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Hosterlo Inc. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        function switchBilling(type) {
            const monthlyContainer = document.getElementById('plans-monthly');
            const yearlyContainer = document.getElementById('plans-yearly');
            const monthlyBtn = document.getElementById('toggle-monthly');
            const yearlyBtn = document.getElementById('toggle-yearly');

            if (type === 'monthly') {
                monthlyContainer.classList.remove('hidden', 'opacity-0');
                yearlyContainer.classList.add('hidden', 'opacity-0');

                monthlyBtn.classList.add('active');
                yearlyBtn.classList.remove('active');
            } else {
                monthlyContainer.classList.add('hidden', 'opacity-0');
                yearlyContainer.classList.remove('hidden', 'opacity-0');

                monthlyBtn.classList.remove('active');
                yearlyBtn.classList.add('active');
            }
        }
    </script>
</body>

</html>