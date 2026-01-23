@extends('frontend.layouts.main2')
@section('content')
   <main class="overflow-hidden">
      <!-- Hero Section -->
      <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
         <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
               <div class="lg:w-1/2">
                  <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Our Mission</span>
                  <h1
                     class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
                     Powering the <br>
                     <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-600">Conversation
                        Economy.</span>
                  </h1>
                  <p class="text-gray-500 text-lg md:text-xl mb-10 leading-relaxed max-w-2xl">
                     At Hosterlo, we believe that business is about relationships. Our platform helps thousands of
                     companies scale their customer connections through intelligent, safe, and human-like WhatsApp
                     automation.
                  </p>
                  <div class="flex gap-4">
                     <div class="flex -space-x-3">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                           src="https://ui-avatars.com/api/?name=John+Doe" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                           src="https://ui-avatars.com/api/?name=Jane+Smith" alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                           src="https://ui-avatars.com/api/?name=Alex+Johnson" alt="">
                     </div>
                     <div class="text-sm">
                        <p class="font-bold text-gray-900">10,000+ Users</p>
                        <p class="text-gray-500">Trusting us worldwide</p>
                     </div>
                  </div>
               </div>
               <div class="lg:w-1/2">
                  <div class="relative">
                     <img src="{{ asset('public/uploads/about_3d.png') }}" alt="Global Connections"
                        class="w-full h-auto rounded-3xl shadow-2xl relative z-10 animate-float">
                     <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-200 rounded-full blur-3xl opacity-40"></div>
                     <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-accent-200 rounded-full blur-3xl opacity-40">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- Core Values -->
      <section class="py-24 bg-white">
         <div class="container mx-auto px-6">
            <div class="text-center mb-16">
               <h2 class="text-4xl font-display font-bold text-gray-900">What Drives Us</h2>
               <p class="text-gray-500 mt-4 text-lg">Leading the industry with innovation and ethics.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
               <div class="p-8 rounded-3xl bg-gray-50 border border-gray-100 hover:shadow-xl transition duration-500">
                  <div
                     class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-600 text-2xl mb-6">
                     <i class="fas fa-shield-alt"></i>
                  </div>
                  <h3 class="text-xl font-bold mb-4">Safety First</h3>
                  <p class="text-gray-500 leading-relaxed">We invest heavily in Anti-Ban technology to ensure your business
                     reputation remains spotless and your account remains safe.</p>
               </div>
               <div class="p-8 rounded-3xl bg-gray-50 border border-gray-100 hover:shadow-xl transition duration-500">
                  <div
                     class="w-14 h-14 bg-accent-100 rounded-2xl flex items-center justify-center text-accent-600 text-2xl mb-6">
                     <i class="fas fa-bolt"></i>
                  </div>
                  <h3 class="text-xl font-bold mb-4">Hyper Automation</h3>
                  <p class="text-gray-500 leading-relaxed">Our Visual Flow Builder and Chatbots are designed to handle 80%
                     of routine queries, giving you time to focus on growth.</p>
               </div>
               <div class="p-8 rounded-3xl bg-gray-50 border border-gray-100 hover:shadow-xl transition duration-500">
                  <div
                     class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 text-2xl mb-6">
                     <i class="fas fa-users"></i>
                  </div>
                  <h3 class="text-xl font-bold mb-4">User Centric</h3>
                  <p class="text-gray-500 leading-relaxed">Every feature we build is inspired by our community. We listen,
                     we build, and we help you succeed.</p>
               </div>
            </div>
         </div>
      </section>

      <!-- Stats Section -->
      <section class="py-20 bg-brand-900 text-white">
         <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
               <div>
                  <h4 class="text-5xl font-display font-bold mb-2">350M</h4>
                  <p class="text-brand-400 font-semibold uppercase tracking-widest text-xs">Total Broadcasts</p>
               </div>
               <div>
                  <h4 class="text-5xl font-display font-bold mb-2">12K+</h4>
                  <p class="text-brand-400 font-semibold uppercase tracking-widest text-xs">Happy Businesses</p>
               </div>
               <div>
                  <h4 class="text-5xl font-display font-bold mb-2">99.9%</h4>
                  <p class="text-brand-400 font-semibold uppercase tracking-widest text-xs">Uptime Guaranteed</p>
               </div>
               <div>
                  <h4 class="text-5xl font-display font-bold mb-2">24/7</h4>
                  <p class="text-brand-400 font-semibold uppercase tracking-widest text-xs">Expert Support</p>
               </div>
            </div>
         </div>
      </section>

      <!-- Join Us CTA -->
      <section class="py-24 bg-white relative">
         <div class="container mx-auto px-6">
            <div
               class="bg-gradient-to-r from-brand-600 to-brand-500 rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
               <div class="relative z-10 max-w-3xl mx-auto">
                  <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6">Ready to scale your business?
                  </h2>
                  <p class="text-brand-100 text-lg mb-10 opacity-90">Join thousands of entrepreneurs who are already
                     automating their sales funnel with GOWASender — a proud product of Hosterlo.</p>
                  <a href="{{ url('/register') }}"
                     class="inline-block px-10 py-5 bg-white text-brand-600 font-bold text-xl rounded-2xl shadow-xl hover:-translate-y-1 transition duration-300">Start
                     Your Journey Now</a>
               </div>
               <!-- Decor -->
               <div class="absolute -top-10 -right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
               <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            </div>
         </div>
      </section>
   </main>

   <style>
      @keyframes float {
         0% {
            transform: translateY(0px);
         }

         50% {
            transform: translateY(-20px);
         }

         100% {
            transform: translateY(0px);
         }
      }

      .animate-float {
         animation: float 6s ease-in-out infinite;
      }
   </style>
@endsection