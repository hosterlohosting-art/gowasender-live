<nav class="navbar navbar-top navbar-expand navbar-light bg-white border-bottom"
   style="height: 70px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
   <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

         <!-- LEFT: Logo & Mobile Toggler -->
         <div class="d-flex align-items-center">
            <!-- Mobile Toggler (Only visible on mobile) -->
            <div class="sidenav-toggler sidenav-toggler-dark d-xl-none mr-3" data-action="sidenav-pin"
               data-target="#sidenav-main">
               <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-dark"></i>
                  <i class="sidenav-toggler-line bg-dark"></i>
                  <i class="sidenav-toggler-line bg-dark"></i>
               </div>
            </div>

            <!-- Brand Logo -->
            <a class="navbar-brand mr-lg-5" href="{{ url('/') }}">
               <img src="{{ asset('assets/img/brand/blue.png') }}" class="navbar-brand-img" alt="Logo"
                  style="height: 40px;">
            </a>
         </div>

         <!-- RIGHT: User Tools -->
         <ul class="navbar-nav align-items-center ml-auto">

            <!-- Wallet Balance -->
            @if(Auth::check())
               <li class="nav-item d-none d-md-flex align-items-center mr-4">
                  <div class="d-flex align-items-center px-3 py-2 bg-secondary rounded-pill">
                     <i class="ni ni-credit-card text-primary mr-2"></i>
                     <span class="text-sm font-weight-bold text-dark">{{ Auth::user()->wallet ?? '0.00' }}
                        {{ get_option('currency_code', 'USD') }}</span>
                  </div>
               </li>
            @endif

            <!-- Notifications -->
            @if(Request::is('user/*'))
               <audio id="notificationSound" src="{{ asset('assets/messagetone.mp3') }}"></audio>
               <li class="nav-item dropdown notifications-icon notifications-area mr-3">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                     <i class="ni ni-bell-55 text-dark" style="font-size: 1.2rem;"></i>
                     <span class="badge badge-circle badge-primary notification-count"
                        style="position: absolute; top: 0; right: -5px; width: 15px; height: 15px; font-size: 10px;">0</span>
                  </a>
                  <button id="install-button" style="display: none;">Install</button>
                  <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                     <div class="px-3 py-3">
                        <h6 class="text-sm text-muted m-0">{{ __('You have') }} <strong
                              class="text-primary notification-count">0</strong> {{ __('notifications.') }}</h6>
                     </div>
                     <div class="list-group list-group-flush notifications-list"></div>
                  </div>
               </li>
            @endif

            <!-- User Profile -->
            <li class="nav-item dropdown">
               <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  <div class="media align-items-center">
                     <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder"
                           src="{{ Auth::user()->avatar == null ? 'https://ui-avatars.com/api/?name=' . Auth::user()->name : asset(Auth::user()->avatar) }}">
                     </span>
                     <div class="media-body ml-2 d-none d-lg-block">
                        <span class="mb-0 text-sm font-weight-bold text-dark">{{ Auth::user()->name }}</span>
                        <div class="text-xs text-muted" style="line-height: 1;">
                           {{ Auth::user()->role == 'admin' ? 'Administrator' : 'User' }}
                        </div>
                     </div>
                     <i class="ni ni-bold-down ml-2 text-dark"></i>
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