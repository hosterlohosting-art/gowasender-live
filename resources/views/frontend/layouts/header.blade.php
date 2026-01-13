<header>
  <!-- container start -->
  <div class="container">
    <!-- navigation bar -->
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets/img/brand/blue.png') }}" alt="image">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
          <!-- <i class="icofont-navigation-menu ico_menu"></i> -->
          <div class="toggle-wrap">
            <span class="toggle-bar"></span>
          </div>
        </span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/features') }}">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/pricing') }}">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/about') }}">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
          </li>
          @if(!Auth::check())
            <li class="nav-item">
              <a class="nav-link dark_btn" href="{{ url('/login') }}">Login</a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link dark_btn" href="{{ url('/login') }}">Dashboard</a>
            </li>
          @endif
        </ul>
      </div>
    </nav>
    <!-- navigation end -->
  </div>
  <!-- container end -->
</header>