@extends('frontend.layouts.main2')
@section('content')
   <main class="overflow-hidden">
      <!-- Hero Section -->
      <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
         <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
            <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Choose Your Plan</span>
            <h1 class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
               Simple, Transparent <span
                  class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-600">Pricing.</span>
            </h1>
            <p class="text-gray-500 text-lg md:text-xl leading-relaxed mx-auto max-w-2xl">
               No hidden fees. No complicated setups. Pick a plan that fits your business stage and start automating in 5
               minutes.
            </p>
         </div>
      </section>

      <!-- Pricing Grid -->
      <section class="py-24 bg-white -mt-10 lg:-mt-20">
         <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
               @foreach($plans ?? [] as $plan)
                  @php
                     $details = is_string($plan->data) ? json_decode($plan->data ?? '{}') : (object) ($plan->data ?? []);
                     $isFeatured = $plan->is_recommended == 1;
                   @endphp
                  <div class="relative group">
                     @if($isFeatured)
                        <div
                           class="absolute -top-4 left-1/2 -translate-x-1/2 bg-brand-600 text-white px-6 py-1 rounded-full text-xs font-bold uppercase tracking-widest z-20 shadow-lg">
                           Recommended</div>
                     @endif

                     <div
                        class="h-full flex flex-col bg-white rounded-[2.5rem] p-10 shadow-card hover:shadow-card-hover transition-all duration-500 border {{ $isFeatured ? 'border-brand-500 ring-4 ring-brand-50/50' : 'border-gray-100' }}">
                        <div class="mb-8">
                           <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->title }}</h3>
                           <div class="flex items-baseline gap-1">
                              <span class="text-5xl font-extrabold text-gray-900">${{ $plan->price }}</span>
                              <span class="text-gray-400 font-medium">/
                                 {{ $plan->days == 365 ? 'Yearly' : ($plan->days == 30 ? 'Monthly' : $plan->days . ' Days') }}</span>
                           </div>
                        </div>

                        <div class="flex-1">
                           <ul class="space-y-4 mb-10">
                              <li class="flex items-center gap-3 text-gray-600">
                                 <div class="w-2 h-2 rounded-full bg-brand-500"></div>
                                 <span><strong>{{ $details->messages_limit == -1 ? 'Unlimited' : ($details->messages_limit ?? 0) }}</strong>
                                    Bulks / Month</span>
                              </li>
                              <li class="flex items-center gap-3 text-gray-600">
                                 <div class="w-2 h-2 rounded-full bg-brand-500"></div>
                                 <span><strong>{{ $details->device_limit == -1 ? 'Unlimited' : ($details->device_limit ?? 0) }}</strong>
                                    WhatsApp Accounts</span>
                              </li>
                              <li class="flex items-center gap-3 text-gray-600">
                                 <div class="w-2 h-2 rounded-full bg-brand-500"></div>
                                 <span><strong>{{ $details->contact_limit == -1 ? 'Unlimited' : ($details->contact_limit ?? 0) }}</strong>
                                    Contacts</span>
                              </li>
                              <li class="flex items-center gap-3 text-gray-600 opacity-60">
                                 <div class="w-2 h-2 rounded-full bg-brand-500"></div>
                                 <span>Visual Flow Builder</span>
                              </li>
                              <li class="flex items-center gap-3 text-gray-600">
                                 <div class="w-2 h-2 rounded-full bg-brand-500"></div>
                                 <span>Anti-Ban Technology</span>
                              </li>
                           </ul>
                        </div>

                        <a href="{{ url('/register', $plan->id) }}"
                           class="block w-full py-5 text-center font-bold text-lg rounded-2xl transition-all duration-300 {{ $isFeatured ? 'bg-brand-600 text-white hover:bg-brand-700 shadow-xl shadow-brand-500/30' : 'bg-gray-900 text-white hover:bg-brand-600' }}">
                           {{ $plan->is_trial == 1 ? 'Start Free Trial' : 'Get Started Now' }}
                        </a>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
      </section>

      <!-- Trusted Logos -->
      <section class="py-16 bg-gray-50 border-y border-gray-100">
         <div class="container mx-auto px-6">
            <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-10">Secured Payments &
               Trusted Gateways</p>
            <div class="flex flex-wrap justify-center gap-12 opacity-40 grayscale">
               <i class="fab fa-stripe-s text-4xl"></i>
               <i class="fab fa-cc-paypal text-4xl"></i>
               <i class="fab fa-cc-visa text-4xl"></i>
               <i class="fab fa-cc-mastercard text-4xl"></i>
               <i class="fab fa-cc-apple-pay text-4xl"></i>
            </div>
         </div>
      </section>

      <!-- FAQ Preview -->
      <section class="py-24 bg-white">
         <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-16">
               <h2 class="text-3xl font-display font-bold text-gray-900">Pricing FAQs</h2>
            </div>
            <div class="space-y-6">
               @foreach($faqs->take(4) as $faq)
                  <div class="border-b border-gray-100 pb-6">
                     <h4 class="font-bold text-gray-900 mb-2">{{ $faq->title }}</h4>
                     <p class="text-gray-500 leading-relaxed">{{ $faq->excerpt->value ?? '' }}</p>
                  </div>
               @endforeach
            </div>
            <div class="text-center mt-12">
               <a href="{{ url('/faq') }}" class="text-brand-600 font-bold hover:underline">View All Help Topics &rarr;</a>
            </div>
         </div>
      </section>
   </main>
@endsection