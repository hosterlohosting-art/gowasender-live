@extends('frontend.layouts.main2')

@section('content')
    <main>
        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-brand-50/50">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-hero"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-4xl mx-auto text-center">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-brand-200 shadow-sm mb-6">
                        <span
                            class="text-xs font-bold text-brand-900 tracking-wide uppercase">{{ __('Legal Document') }}</span>
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-display font-extrabold text-gray-900 mb-6 tracking-tight">
                        {{ __('Privacy') }} <span class="text-brand-600">{{ __('Policy') }}</span>
                    </h1>
                    <p class="text-gray-500 text-lg leading-relaxed max-w-2xl mx-auto">
                        {{ __('At GOWASender, your privacy is our priority. This document outlines how we protect and manage your data.') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-24 bg-white relative">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-card p-8 md:p-12 space-y-12">

                        <div class="prose prose-lg max-w-none text-gray-600">
                            <div class="mb-12">
                                <h2 class="text-2xl font-display font-bold text-gray-900 mb-4 flex items-center gap-3">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-600 font-bold">1</span>
                                    {{ __('Introduction') }}
                                </h2>
                                <p class="pl-12">
                                    Welcome to GOWASender, a product of <strong class="text-brand-600">Hosterlo</strong>. We
                                    are committed to protecting
                                    your personal data and your privacy. This Privacy Policy explains how we collect, use,
                                    and
                                    safeguard your information when you use our WhatsApp marketing platform.
                                </p>
                            </div>

                            <div class="mb-12">
                                <h2 class="text-2xl font-display font-bold text-gray-900 mb-4 flex items-center gap-3">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-600 font-bold">2</span>
                                    {{ __('Information We Collect') }}
                                </h2>
                                <p class="pl-12">
                                    We collect information you provide directly to us when you create an account, such as
                                    your name,
                                    email address, and payment information. Additionally, when you use our services through
                                    the
                                    WhatsApp Business API, we process metadata related to your messages as necessary to
                                    provide
                                    our service securely.
                                </p>
                            </div>

                            <div class="mb-12">
                                <h2 class="text-2xl font-display font-bold text-gray-900 mb-4 flex items-center gap-3">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-600 font-bold">3</span>
                                    {{ __('How We Use Data') }}
                                </h2>
                                <div class="pl-12">
                                    <p class="mb-4">GOWASender, by Hosterlo, uses your information to:</p>
                                    <ul class="space-y-3">
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-brand-500 mt-1"></i>
                                            <span>Provide and maintain our core messaging services.</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-brand-500 mt-1"></i>
                                            <span>Process transactions and manage renewals via Hosterlo billing.</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-brand-500 mt-1"></i>
                                            <span>Communicate essential security updates and product changes.</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <i class="fas fa-check-circle text-brand-500 mt-1"></i>
                                            <span>Analyze usage patterns to improve the Visual Flow Builder
                                                experience.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-12">
                                <h2 class="text-2xl font-display font-bold text-gray-900 mb-4 flex items-center gap-3">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-600 font-bold">4</span>
                                    {{ __('Data Security') }}
                                </h2>
                                <p class="pl-12">
                                    As a premier product of Hosterlo, we implement enterprise-grade security protocols.
                                    All data transmitted between our servers and Meta's WhatsApp API is encrypted via
                                    SSL/TLS.
                                    We perform regular security audits to ensure your business data remains private.
                                </p>
                            </div>

                            <div class="mb-12">
                                <h2 class="text-2xl font-display font-bold text-gray-900 mb-4 flex items-center gap-3">
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-600 font-bold">5</span>
                                    {{ __('Compliance & Legal') }}
                                </h2>
                                <div class="pl-12 bg-gray-50 rounded-2xl p-6 border border-gray-100 text-sm italic">
                                    GOWASender is an official product developed and maintained by Hosterlo. All legal
                                    matters, terms
                                    of use, and data protection agreements are governed by Hosterlo's corporate standards
                                    and the
                                    laws applicable to our registered entities.
                                </div>
                            </div>
                        </div>

                        <div
                            class="pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-400">
                            <p>{{ __('Last Updated: January 2026') }}</p>
                            <p>&copy; {{ date('Y') }} Hosterlo. {{ __('All rights reserved.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        .bg-gradient-hero {
            background: radial-gradient(circle at top right, rgba(22, 163, 74, 0.05), transparent 40%),
                radial-gradient(circle at bottom left, rgba(34, 197, 94, 0.05), transparent 40%);
        }
    </style>
@endsection