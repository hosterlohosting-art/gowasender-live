<footer class="bg-brand-dark text-white pt-24 pb-12">
  <div class="container mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">

      <div class="col-span-1 md:col-span-1">
        <div class="flex items-center gap-3 mb-6">
          <img src="{{ asset('assets/img/brand/white.png') }}" alt="WA Sender Logo" class="h-10 w-auto">
        </div>
        <p class="text-gray-400 text-sm leading-relaxed mb-8">
          The world's most trusted WhatsApp marketing platform. <strong>A product of Hosterlo</strong>. Built for
          safety, speed, and scale.
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
          <li><a href="{{ url('/features') }}" class="hover:text-brand-400 transition">Features</a></li>
          <li><a href="{{ url('/pricing') }}" class="hover:text-brand-400 transition">Pricing</a></li>
          <li><a href="{{ url('/blogs') }}" class="hover:text-brand-400 transition">Resources</a></li>
          <li><a href="{{ url('/faq') }}" class="hover:text-brand-400 transition">FAQ</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-lg mb-6 text-white">Company</h4>
        <ul class="space-y-4 text-gray-400 text-sm">
          <li><a href="{{ url('/about') }}" class="hover:text-brand-400 transition">About Us</a></li>
          <li><a href="{{ url('/contact') }}" class="hover:text-brand-400 transition">Contact</a></li>
          <li><a href="{{ url('/privacy-policy') }}" class="hover:text-brand-400 transition">Privacy Policy</a></li>
          <li><a href="{{ url('/terms-condition') }}" class="hover:text-brand-400 transition">Terms of Service</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold text-lg mb-6 text-white">Newsletter</h4>
        <p class="text-gray-400 text-sm mb-4">Get the latest marketing insights.</p>
        <form class="flex flex-col gap-3">
          <input type="email" placeholder="Email address"
            class="bg-white/5 border border-white/10 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-brand-500 transition">
          <button type="button"
            class="bg-brand-600 text-white font-bold px-4 py-3 rounded-xl hover:bg-brand-500 transition">Subscribe</button>
        </form>
      </div>
    </div>

    <div class="border-t border-white/10 pt-8 text-center text-gray-500 text-sm">
      <p>&copy; {{ date('Y') }} Hosterlo Inc. All rights reserved.</p>
    </div>
  </div>
</footer>