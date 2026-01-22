<nav class="glass-header fixed w-full top-0 z-50 transition-all duration-300">
  <div class="container mx-auto px-6 py-4">
    <div class="flex justify-between items-center">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="flex items-center gap-2.5 group cursor-pointer">
        <img src="{{ asset('assets/img/brand/blue.png') }}" alt="WA Sender Logo" class="h-10 w-auto">
      </a>

      <!-- Desktop Menu -->
      <div class="hidden lg:flex items-center space-x-10 text-sm font-semibold text-gray-600">
        <a href="{{ url('/') }}"
          class="{{ Request::is('/') ? 'text-brand-600' : 'hover:text-brand-600' }} transition-colors">Home</a>
        <a href="{{ url('/features') }}"
          class="{{ Request::is('features*') ? 'text-brand-600' : 'hover:text-brand-600' }} transition-colors">Features</a>
        <a href="{{ url('/pricing') }}"
          class="{{ Request::is('pricing*') ? 'text-brand-600' : 'hover:text-brand-600' }} transition-colors">Pricing</a>
        <a href="{{ url('/about') }}"
          class="{{ Request::is('about*') ? 'text-brand-600' : 'hover:text-brand-600' }} transition-colors">About</a>
        <a href="{{ url('/blogs') }}"
          class="{{ Request::is('blog*') ? 'text-brand-600' : 'hover:text-brand-600' }} transition-colors">Blog</a>
        <a href="{{ url('/contact') }}"
          class="{{ Request::is('contact*') ? 'text-brand-600' : 'hover:text-brand-600' }} transition-colors">Contact</a>
      </div>

      <!-- Auth Buttons -->
      <div class="flex items-center gap-4">
        @if(!Auth::check())
          <a href="{{ url('/login') }}"
            class="hidden md:block text-sm font-bold text-gray-600 hover:text-brand-600 transition">Log In</a>
          <a href="{{ url('/register') }}"
            class="px-6 py-2.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-brand-600 hover:shadow-glow transition-all duration-300">
            Get Started
          </a>
        @else
          <a href="{{ url('/login') }}"
            class="px-6 py-2.5 text-sm font-bold text-white bg-brand-600 rounded-full hover:bg-brand-700 hover:shadow-glow transition-all duration-300">
            Dashboard
          </a>
        @endif

        <!-- Mobile Toggle -->
        <button class="lg:hidden text-gray-600 menu-toggle">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu (Hidden by default) -->
  <div class="mobile-menu hidden lg:hidden bg-white border-t border-gray-100 p-6 space-y-4 shadow-xl">
    <a href="{{ url('/') }}" class="block text-gray-600 font-bold">Home</a>
    <a href="{{ url('/features') }}" class="block text-gray-600 font-bold">Features</a>
    <a href="{{ url('/pricing') }}" class="block text-gray-600 font-bold">Pricing</a>
    <a href="{{ url('/about') }}" class="block text-gray-600 font-bold">About</a>
    <a href="{{ url('/blogs') }}" class="block text-gray-600 font-bold">Blog</a>
    <a href="{{ url('/contact') }}" class="block text-gray-600 font-bold">Contact</a>
    <hr>
    @if(!Auth::check())
      <a href="{{ url('/login') }}" class="block text-gray-600 font-bold">Login</a>
      <a href="{{ url('/register') }}" class="block text-brand-600 font-bold">Sign Up</a>
    @else
      <a href="{{ url('/login') }}" class="block text-brand-600 font-bold">Dashboard</a>
    @endif
  </div>
</nav>

<script>
  document.querySelector('.menu-toggle')?.addEventListener('click', function () {
    document.querySelector('.mobile-menu').classList.toggle('hidden');
  });
</script>