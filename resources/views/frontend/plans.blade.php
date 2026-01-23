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
            <div class="flex flex-wrap justify-center gap-8">
               @foreach($plans ?? [] as $plan)
                  @php
                     $details = (object) (is_array($plan->data) ? $plan->data : json_decode($plan->data ?? '{}', true));
                     $isFeatured = $plan->is_recommended == 1;
                     $title = strtoupper($plan->title);
                  @endphp
                  <div class="relative group h-full w-full md:w-[calc(50%-1rem)] xl:w-[calc(25%-1.5rem)] max-w-sm">
                     @if($isFeatured)
                        <div
                           class="absolute -top-4 left-1/2 -translate-x-1/2 bg-brand-600 text-white px-6 py-1 rounded-full text-xs font-bold uppercase tracking-widest z-20 shadow-lg whitespace-nowrap">
                           BEST VALUE</div>
                     @endif

                     <div
                        class="h-full flex flex-col bg-white rounded-[2rem] p-8 shadow-card hover:shadow-card-hover transition-all duration-500 border {{ $isFeatured ? 'border-brand-500 ring-4 ring-brand-50/50' : 'border-gray-100' }}">
                        <div class="mb-6">
                           <h3 class="text-xl font-bold text-gray-900 mb-2 truncate" title="{{ $plan->title }}">
                              {{ $plan->title }}</h3>
                           <div class="flex items-baseline gap-1">
                              <span class="text-4xl font-extrabold text-gray-900">${{ $plan->price }}</span>
                              <span class="text-gray-400 text-sm font-medium">/
                                 {{ $plan->days >= 3650 ? 'Life Time' : ($plan->days == 730 ? '2 Years' : ($plan->days == 30 ? 'Monthly' : $plan->days . ' Days')) }}</span>
                           </div>
                        </div>

                        <div class="flex-1">
                           <ul class="space-y-3 mb-8">
                              @if(str_contains(strtolower($plan->title), 'free'))
                                 <li class="flex items-start gap-2 text-gray-500">
                                    <span class="text-red-500 text-xs">❌</span>
                                    <span class="text-xs">No Official Cloud API</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-red-600 font-bold bg-red-50 p-2 rounded-lg">
                                    <span class="text-xs">⚠️</span>
                                    <span class="text-[10px] leading-tight">DANGER: High Risk of Number Ban. Not recommended for
                                       business.</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-1.5"></div>
                                    <span class="text-xs"><strong>50</strong> Messages / day</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-1.5"></div>
                                    <span class="text-xs">1 WhatsApp Account</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-400 opacity-60">
                                    <div class="w-1.5 h-1.5 rounded-full bg-gray-300 mt-1.5"></div>
                                    <span class="text-xs">No Shared Team Access</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-400 opacity-60">
                                    <div class="w-1.5 h-1.5 rounded-full bg-gray-300 mt-1.5"></div>
                                    <span class="text-xs">Support: None</span>
                                 </li>
                              @elseif(str_contains(strtolower($plan->title), 'starter'))
                                 <li class="flex items-start gap-2 text-gray-700 font-semibold">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Official Cloud API Ready</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Unlimited Bulk Messaging</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Smart Anti-Ban Protection</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Visual Flow Builder</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Auto-Reply & Chatbots</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Contact Management</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-600">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Standard Support</span>
                                 </li>
                              @elseif(str_contains(strtolower($plan->title), 'pro'))
                                 <li class="flex items-start gap-2 text-brand-600 font-bold">
                                    <span class="text-brand-500 text-xs">✅</span>
                                    <span class="text-xs">ALL Features Included</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700">
                                    <span class="text-brand-500 text-xs">✅</span>
                                    <span class="text-xs">Valid for 24 Full Months</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700">
                                    <span class="text-brand-500 text-xs">✅</span>
                                    <span class="text-xs">Priority WhatsApp Support</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700">
                                    <span class="text-brand-500 text-xs">✅</span>
                                    <span class="text-xs">Advanced API Documentation</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700">
                                    <span class="text-brand-500 text-xs">✅</span>
                                    <span class="text-xs">Webhooks Integration</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700">
                                    <span class="text-brand-500 text-xs">✅</span>
                                    <span class="text-xs">Multiple Device Slots</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700">
                                    <span class="text-brand-500 text-xs">✅</span>
                                    <span class="text-xs">2-Year Price Guarantee</span>
                                 </li>
                              @elseif(str_contains(strtolower($plan->title), 'reseller'))
                                 <li class="flex items-start gap-2 text-gray-800 font-bold">
                                    <span class="text-blue-500 text-xs">✅</span>
                                    <span class="text-xs">Full Source Code (PHP/Laravel)</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-800 font-bold">
                                    <span class="text-blue-500 text-xs">✅</span>
                                    <span class="text-xs">White Label Branding</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-green-600 font-bold">
                                    <span class="text-green-500 text-xs">✅</span>
                                    <span class="text-xs">Keep 100% of Subscription Revenue</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700 font-medium">
                                    <span class="text-blue-500 text-xs">✅</span>
                                    <span class="text-xs">Professional Setup & Install</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700 font-medium">
                                    <span class="text-blue-500 text-xs">✅</span>
                                    <span class="text-xs">Multi-Tenant CMS Included</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700 font-medium">
                                    <span class="text-blue-500 text-xs">✅</span>
                                    <span class="text-xs">Admin Training Session</span>
                                 </li>
                                 <li class="flex items-start gap-2 text-gray-700 font-medium">
                                    <span class="text-blue-500 text-xs">✅</span>
                                    <span class="text-xs">Lifetime Core Updates</span>
                                 </li>
                              @endif
                           </ul>
                        </div>

                        <a href="{{ url('/register', $plan->id) }}"
                           class="block w-full py-4 text-center font-bold text-base rounded-xl transition-all duration-300 {{ $isFeatured ? 'bg-brand-600 text-white hover:bg-brand-700 shadow-lg shadow-brand-500/20' : 'bg-gray-900 text-white hover:bg-brand-600' }}">
                           {{ $plan->price == 0 ? 'Try for Free' : 'Get Started' }}
                        </a>
                     </div>
                  </div>
               @endforeach
            </div>
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
            <div class="space-y-6">
               @foreach($faqs->take(10) as $faq)
                  <div class="border-b border-gray-100 pb-6">
                     <h4 class="font-bold text-gray-900 mb-2">{{ $faq->title }}</h4>
                     <p class="text-gray-500 leading-relaxed">{{ $faq->excerpt->value ?? $faq->excerpt ?? '' }}</p>
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