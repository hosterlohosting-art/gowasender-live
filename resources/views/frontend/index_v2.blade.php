<?php
$plans = collect([]);
try {
    if (class_exists('\Illuminate\Support\Facades\DB')) {
        $plans = \Illuminate\Support\Facades\DB::table('plans')->where('status', 1)->get();
    }
} catch (\Exception $e) {
    $plans = collect([]);
}

$featuredPlans = $plans->filter(function ($plan) {
    return ($plan->is_recommended == 1) || ($plan->days == 30);
})->take(3);

function formatLimit($value)
{
    return $value == -1 ? 'Unlimited' : $value;
}
?>

@extends('frontend.layouts.main2')
@section('content')
    <main>
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
                        <strong>Spintax Rotation</strong>. Automate your entire marketing funnel safely.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-5 justify-center w-full md:w-auto">
                        <a href="{{ url('/register') }}"
                            class="px-8 py-4 bg-gradient-to-r from-brand-600 to-brand-500 text-white font-bold text-lg rounded-xl shadow-xl shadow-brand-500/30 hover:shadow-2xl hover:shadow-brand-500/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                            <i class="fab fa-whatsapp text-2xl"></i> Start Sending Now
                        </a>
                        <a href="{{ url('/pricing') }}"
                            class="px-8 py-4 bg-white text-gray-800 border border-gray-200 font-bold text-lg rounded-xl hover:border-brand-500 hover:text-brand-600 transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
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

        <!-- Features Showcase -->
        <section class="py-24 bg-white relative">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Next-Gen
                        Automation</span>
                    <h2 class="text-4xl font-display font-bold text-gray-900">Everything You Need to <br> Dominate WhatsApp
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1: Large Card (Spans 2 cols) -->
                    <div class="md:col-span-2 bg-gradient-to-br from-brand-900 to-brand-800 rounded-3xl p-10 text-white relative overflow-hidden group"
                        data-tilt data-aos="fade-right">
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -translate-y-1/2 translate-x-1/2">
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-3xl font-bold mb-4">Visual Flow Builder</h3>
                            <p class="text-brand-100 text-lg mb-8 max-w-md">Create complex chatbot flows with a
                                drag-and-drop interface. No coding required.</p>
                            <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20 inline-block">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-brand-500 flex items-center justify-center">1
                                    </div>
                                    <div class="h-0.5 w-10 bg-white/30"></div>
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">2</div>
                                    <div class="h-0.5 w-10 bg-white/30"></div>
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">3</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2: Tall Card (Right) -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all group relative overflow-hidden"
                        data-tilt data-aos="fade-left" data-aos-delay="100">
                        <div
                            class="absolute -bottom-10 -right-10 w-40 h-40 bg-accent-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50">
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl bg-accent-100 text-accent-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Smart Chatbots</h3>
                        <p class="text-gray-500 leading-relaxed">Auto-reply with keywords, buttons, and list messages 24/7.
                        </p>
                    </div>

                    <!-- Feature 3: Standard Card -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all group"
                        data-tilt data-aos="fade-up" data-aos-delay="200">
                        <div
                            class="w-14 h-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Bulk Broadcasting</h3>
                        <p class="text-gray-500 leading-relaxed">Send unlimited messages to thousands of contacts in one
                            click.</p>
                    </div>

                    <!-- Feature 4: Standard Card -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all group"
                        data-tilt data-aos="fade-up" data-aos-delay="300">
                        <div
                            class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Schedule Messages</h3>
                        <p class="text-gray-500 leading-relaxed">Plan your campaigns ahead of time. Set it and forget it.
                        </p>
                    </div>

                    <!-- Feature 5: Wide Card -->
                    <div class="md:col-span-1 bg-gray-50 rounded-3xl p-8 border border-gray-200" data-aos="fade-up"
                        data-aos-delay="400">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Live Reports</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-brand-500 w-3/4"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">Delivered</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 w-1/2"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600">Read</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Preview -->
        <section class="py-24 bg-brand-50/50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-display font-bold text-gray-900">Featured Plans</h2>
                    <p class="text-gray-500 mt-4 text-lg">Transparent pricing for every business size.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    @foreach($featuredPlans as $plan)
                        @php $details = (object) (is_array($plan->data) ? $plan->data : json_decode($plan->data ?? '{}', true)); @endphp
                        <div
                            class="bg-white rounded-3xl p-8 shadow-card hover:shadow-card-hover transition-all border border-transparent hover:border-brand-200 flex flex-col">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->title }}</h3>
                            <div class="text-4xl font-bold text-brand-600 mb-6">${{ $plan->price }} <span
                                    class="text-lg text-gray-400 font-normal">/ {{ $plan->days == 365 ? 'yr' : 'mo' }}</span>
                            </div>
                            <a href="{{ url('/register', $plan->id) }}"
                                class="block w-full py-3 text-center bg-gray-900 text-white font-bold rounded-xl hover:bg-brand-600 transition mb-6">Get
                                Started</a>
                            <ul class="space-y-3 flex-1">
                                <li class="flex gap-3 text-sm text-gray-600"><i class="fas fa-check text-brand-500"></i>
                                    {{ formatLimit($details->messages_limit ?? 0) }} Messages</li>
                                <li class="flex gap-3 text-sm text-gray-600"><i class="fas fa-check text-brand-500"></i>
                                    Anti-Ban Protection</li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <style>
        .bg-hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2316A34A' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .bg-gradient-hero {
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.1), transparent 40%),
                radial-gradient(circle at bottom left, rgba(22, 163, 74, 0.1), transparent 40%);
        }
    </style>
@endsection