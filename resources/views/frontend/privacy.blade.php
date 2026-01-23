@extends('frontend.layouts.main')

@section('content')
    <section class="pt-32 pb-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden p-8 md:p-12">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-8 border-b pb-6">{{ __('Privacy Policy') }}</h1>

                <div class="prose prose-lg text-gray-600 space-y-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('1. Introduction') }}</h2>
                        <p>
                            Welcome to GOWASender, a product of <strong>Hosterlo</strong>. We are committed to protecting
                            your personal data and your privacy. This Privacy Policy explains how we collect, use, and
                            safeguard your information when you use our WhatsApp marketing platform.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('2. Information We Collect') }}</h2>
                        <p>
                            We collect information you provide directly to us when you create an account, such as your name,
                            email address, and payment information. Additionally, when you use our services through the
                            WhatsApp Business API, we may process metadata related to your messages as necessary to provide
                            our service.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('3. How We Use Your Information') }}</h2>
                        <p>
                            GOWASender, by Hosterlo, uses your information to:
                        </p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li>Provide and maintain our service.</li>
                            <li>Process transactions and send related information.</li>
                            <li>Communicate with you about products, services, and updates.</li>
                            <li>Monitor and analyze usage and trends to improve user experience.</li>
                        </ul>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('4. Data Security') }}</h2>
                        <p>
                            As a product of Hosterlo, we implement industry-standard security measures to protect your data.
                            However, no method of transmission over the Internet or electronic storage is 100% secure, and
                            we cannot guarantee absolute security.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('5. Third-Party Services') }}</h2>
                        <p>
                            We use third-party services like Meta (WhatsApp Business API) and various payment gateways.
                            These services have their own privacy policies, and we encourage you to review them.
                        </p>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('6. Changes to This Policy') }}</h2>
                        <p>
                            We may update our Privacy Policy from time to time. We will notify you of any changes by posting
                            the new Privacy Policy on this page.
                        </p>
                    </div>

                    <div class="bg-brand-50 rounded-2xl p-6 border border-brand-100 mt-12">
                        <h2 class="text-xl font-bold text-brand-900 mb-2">{{ __('Legal Association') }}</h2>
                        <p class="text-brand-800 text-sm italic">
                            GOWASender is an official product developed and maintained by Hosterlo. All legal matters, terms
                            of use, and data protection agreements are governed by Hosterlo's corporate standards.
                        </p>
                    </div>

                    <div class="text-sm text-gray-500 pt-8 border-t">
                        <p>{{ __('Last Updated: January 2026') }}</p>
                        <p>&copy; {{ date('Y') }} Hosterlo. {{ __('All rights reserved.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection