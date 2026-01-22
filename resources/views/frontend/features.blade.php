@extends('frontend.layouts.main2')
@section('content')
   <main class="overflow-hidden">
      <!-- Hero Section -->
      <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
         <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
            <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Powerful Capabilities</span>
            <h1 class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
               Everything You Need to <span
                  class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-600">Automate.</span>
            </h1>
            <p class="text-gray-500 text-lg md:text-xl leading-relaxed mx-auto max-w-2xl">
               From simple bulk sending to complex visual automation, our tools are built for performance, safety, and ease
               of use.
            </p>
         </div>
      </section>

      <!-- Detailed Features Grid -->
      <section class="py-24 bg-white -mt-10 lg:-mt-20">
         <div class="container mx-auto px-6">
            <div class="space-y-32">
               <!-- Feature 1: Flow Builder -->
               <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">
                  <div class="lg:w-1/2">
                     <div class="p-3 inline-block bg-brand-50 rounded-2xl text-brand-600 text-2xl mb-6 shadow-sm">
                        <i class="fas fa-project-diagram"></i>
                     </div>
                     <h2 class="text-4xl font-display font-bold text-gray-900 mb-6">Visual Flow Builder</h2>
                     <p class="text-gray-500 text-lg leading-relaxed mb-8">
                        Drag and drop message nodes to create intelligent conversation flows. Automatically respond to
                        keywords, buttons, and user choices without touching a single line of code.
                     </p>
                     <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-brand-500"></i> Keyword Based Triggers
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-brand-500"></i> Conditional Logic (If/Else)
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-brand-500"></i> Interactive Button Menus
                        </li>
                     </ul>
                  </div>
                  <div class="lg:w-1/2 relative">
                     <div
                        class="bg-gray-50 rounded-[3rem] p-12 border border-gray-100 shadow-2xl relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-200 rounded-full blur-3xl opacity-20">
                        </div>
                        <img src="{{ asset('public/uploads/blog/whatsapp_marketing.png') }}" alt="Flow Builder"
                           class="rounded-2xl shadow-xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                     </div>
                  </div>
               </div>

               <!-- Feature 2: Bulk Sending -->
               <div class="flex flex-col lg:flex-row-reverse items-center gap-16 lg:gap-24">
                  <div class="lg:w-1/2">
                     <div class="p-3 inline-block bg-accent-50 rounded-2xl text-accent-600 text-2xl mb-6 shadow-sm">
                        <i class="fas fa-paper-plane"></i>
                     </div>
                     <h2 class="text-4xl font-display font-bold text-gray-900 mb-6">Intelligent Bulk Sending</h2>
                     <p class="text-gray-500 text-lg leading-relaxed mb-8">
                        Reach thousands of customers instantly. Our smart scheduler ensures your messages are delivered
                        gradually to mimic human behavior and maintain account safety.
                     </p>
                     <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-accent-500"></i> Variable Delay Intervals
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-accent-500"></i> Content Randomization (Spintax)
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-accent-500"></i> Detailed Delivery Logs
                        </li>
                     </ul>
                  </div>
                  <div class="lg:w-1/2 relative">
                     <div
                        class="bg-gray-50 rounded-[3rem] p-12 border border-gray-100 shadow-2xl relative overflow-hidden">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-accent-200 rounded-full blur-3xl opacity-20">
                        </div>
                        <img src="{{ asset('public/uploads/blog/ecommerce_automation.png') }}" alt="Bulk Send"
                           class="rounded-2xl shadow-xl transform -rotate-2 hover:rotate-0 transition-transform duration-500">
                     </div>
                  </div>
               </div>

               <!-- Feature 3: Multi-Session Support -->
               <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">
                  <div class="lg:w-1/2">
                     <div class="p-3 inline-block bg-purple-50 rounded-2xl text-purple-600 text-2xl mb-6 shadow-sm">
                        <i class="fas fa-layer-group"></i>
                     </div>
                     <h2 class="text-4xl font-display font-bold text-gray-900 mb-6">Multi-Session Load Balancing</h2>
                     <p class="text-gray-500 text-lg leading-relaxed mb-8">
                        Scale your volume by connecting multiple WhatsApp accounts. The system automatically rotates
                        between senders to distribute the workload and keep each SIM safe.
                     </p>
                     <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-purple-500"></i> Seamless Account Rotation
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-purple-500"></i> Centralized Inbox Management
                        </li>
                        <li class="flex items-center gap-3 text-gray-700 font-medium">
                           <i class="fas fa-check-circle text-purple-500"></i> Performance Analytics per Device
                        </li>
                     </ul>
                  </div>
                  <div class="lg:w-1/2 relative">
                     <div
                        class="bg-gray-50 rounded-[3rem] p-12 border border-gray-100 shadow-2xl relative overflow-hidden">
                        <div
                           class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-200 rounded-full blur-3xl opacity-20">
                        </div>
                        <img src="{{ asset('public/uploads/blog/api_comparison.png') }}" alt="Multi-Session"
                           class="rounded-2xl shadow-xl transform rotate-1 hover:rotate-0 transition-transform duration-500">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- Integration CTA -->
      <section class="py-24 bg-brand-dark text-white relative">
         <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-display font-bold mb-8">Ready to experience these features?</h2>
            <p class="text-gray-400 text-lg mb-12 max-w-2xl mx-auto opacity-80">Start with our free trial and see how our
               automation can change your business communication forever.</p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
               <a href="{{ url('/register') }}"
                  class="px-10 py-5 bg-brand-600 text-white font-bold text-lg rounded-2xl shadow-xl hover:-translate-y-1 transition duration-300">Start
                  Free Trial Now</a>
               <a href="{{ url('/pricing') }}"
                  class="px-10 py-5 bg-transparent border-2 border-white/20 text-white font-bold text-lg rounded-2xl hover:bg-white/5 transition duration-300">View
                  Pricing</a>
            </div>
         </div>
      </section>
   </main>
@endsection