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
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="lg:w-1/2">
                        <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Next-Gen
                            Automation</span>
                        <h2 class="text-4xl font-display font-bold text-gray-900 mb-6">Visual Flow Builder & <br> Smart
                            Chatbots</h2>
                        <p class="text-gray-500 text-lg leading-relaxed mb-8">
                            Create complex auto-reply flows without writing a single line of code. Drag and drop elements to
                            build interactive chatbots.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3"><i
                                    class="fas fa-check-circle text-brand-500 text-xl"></i><span
                                    class="font-bold text-gray-700">Drag & Drop Builder</span></li>
                            <li class="flex items-center gap-3"><i
                                    class="fas fa-check-circle text-brand-500 text-xl"></i><span
                                    class="font-bold text-gray-700">Keyword & Button Triggers</span></li>
                            <li class="flex items-center gap-3"><i
                                    class="fas fa-check-circle text-brand-500 text-xl"></i><span
                                    class="font-bold text-gray-700">Conditional Logic (If/Else)</span></li>
                        </ul>
                        <div class="mt-8">
                            <a href="{{ url('/features') }}" class="text-brand-600 font-bold hover:underline">See all
                                features &rarr;</a>
                        </div>
                    </div>
                    <div class="lg:w-1/2 relative">
                        <div class="bg-gray-50 border border-gray-200 rounded-3xl p-8 shadow-2xl relative z-10">
                            <div class="flex flex-col items-center gap-6">
                                <div class="bg-white p-4 rounded-xl shadow-md border border-brand-100 w-64 text-center">
                                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Trigger</p>
                                    <p class="font-bold text-gray-800">Keyword: "Price"</p>
                                </div>
                                <div class="h-8 w-0.5 bg-gray-300"></div>
                                <div class="bg-brand-50 p-4 rounded-xl shadow-md border border-brand-200 w-64 text-center">
                                    <p class="text-xs text-brand-600 uppercase font-bold mb-1">Bot Reply</p>
                                    <p class="font-bold text-gray-800">"Our plans start at $9..."</p>
                                </div>
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
                        @php $details = json_decode($plan->data ?? '{}'); @endphp
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