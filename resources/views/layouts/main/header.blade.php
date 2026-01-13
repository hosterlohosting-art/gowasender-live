<nav class="navbar navbar-top navbar-expand navbar-light bg-secondary border-bottom">
   <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

         <!-- Mobile Toggler (only visible on small screens) -->
         <ul class="navbar-nav align-items-center d-xl-none mr-3">
            <li class="nav-item">
               <div class="pr-3 sidenav-toggler sidenav-toggler-light" data-action="sidenav-pin"
                  data-target="#sidenav-main">
                  <div class="sidenav-toggler-inner">
                     <i class="sidenav-toggler-line"></i>
                     <i class="sidenav-toggler-line"></i>
                     <i class="sidenav-toggler-line"></i>
                  </div>
               </div>
            </li>
         </ul>

         <!-- LEFT SIDE: Page Title -->
         <div class="d-none d-md-block">
            <h1 class="page-title-text">
               @if(View::hasSection('title'))
                  @yield('title')
               @else
                  {{ __('Dashboard') }}
               @endif
            </h1>
         </div>

         <!-- Auto-fill space -->
         <ul class="navbar-nav mr-auto"></ul>

         <!-- RIGHT SIDE: Support & Profile -->
         <ul class="navbar-nav align-items-center ml-auto ml-md-0 d-flex flex-row gap-3">

            <!-- Support Button -->
            <li class="nav-item mr-3">
               <a href="{{ Request::is('user/*') ? url('/user/support') : url('/admin/support') }}" class="support-btn">
                  <i class="ni ni-support-16"></i>
                  <span>{{ __('Support') }}</span>
               </a>
            </li>

            <!-- User Profile -->
            <li class="nav-item dropdown">
               <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  <div class="media align-items-center user-profile-media">
                     <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder"
                           src="{{ Auth::user()->avatar == null ? 'https://ui-avatars.com/api/?name=' . Auth::user()->name : asset(Auth::user()->avatar) }}">
                     </span>
                     <div class="media-body ml-2 d-none d-lg-block">
                        <span class="mb-0 text-sm arm font-weight-bold">{{ Auth::user()->name }}</span>
                     </div>
                  </div>
               </a>
               <div class="dropdown-menu dropdown-menu-right">
                  <div class="dropdown-header noti-title">
                     <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                  </div>
                  <a href="{{ Request::is('user/*') ? url('/user/profile') : url('/admin/profile') }}"
                     class="dropdown-item">
                     <i class="ni ni-single-02"></i>
                     <span>{{ __('My profile') }}</span>
                  </a>
                  @if(Request::is('user/*'))
                     <a href="{{ url('/user/subscription') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Subscription') }}</span>
                     </a>
                     <a href="{{ url('/user/auth-key') }}" class="dropdown-item">
                        <i class="fas fa-code"></i>
                        <span>{{ __('Auth Key') }}</span>
                     </a>
                  @endif
                  <a href="{{ Request::is('user/*') ? url('/user/support') : url('/admin/support') }}"
                     class="dropdown-item">
                     <i class="ni ni-support-16"></i>
                     <span>{{ __('Support') }}</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#!" class="dropdown-item logout-button">
                     <i class="ni ni-user-run"></i>
                     <span>{{ __('Logout') }}</span>
                  </a>
               </div>
            </li>
         </ul>
      </div>
   </div>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
   @csrf
</form>