<nav class="navbar navbar-top navbar-expand navbar-light bg-white border-bottom"
   style="height: 70px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
   <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <!-- LEFT: Logo & Mobile Toggler -->
         <div class="d-flex align-items-center">
            <div class="sidenav-toggler sidenav-toggler-dark d-xl-none mr-3" data-action="sidenav-pin"
               data-target="#sidenav-main">
               <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-dark"></i>
                  <i class="sidenav-toggler-line bg-dark"></i>
                  <i class="sidenav-toggler-line bg-dark"></i>
               </div>
            </div>

            <a class="navbar-brand d-xl-none" href="{{ url('/') }}">
               <img src="{{ asset('assets/img/brand/blue.png') }}" class="navbar-brand-img" alt="Logo"
                  style="height: 35px;">
            </a>
         </div>

         <!-- RIGHT: User Tools -->
         <ul class="navbar-nav align-items-center ml-auto">

            <!-- Plan Name (Replaces Wallet) -->
            @if(Auth::check())
               <li class="nav-item d-none d-md-flex align-items-center mr-4">
                  <div class="plan-badge">
                     @if(Auth::user()->plan_id && Auth::user()->subscription)
                        <i class="fas fa-crown text-gold"></i>
                        <span>{{ Auth::user()->subscription->title }}</span>
                     @else
                        <span>{{ __('Free Plan') }}</span>
                     @endif
                  </div>
               </li>
            @endif

            <!-- Notifications -->
            @if(Request::is('user/*'))
               <audio id="notificationSound" src="{{ asset('assets/messagetone.mp3') }}"></audio>
               <li class="nav-item dropdown notifications-icon mr-4">
                  <a class="nav-link notification-toggle" href="#" role="button" data-toggle="dropdown"
                     aria-haspopup="true" aria-expanded="false">
                     <i class="fas fa-bell"></i>
                     <span class="notification-badge notification-count">0</span>
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
               <a class="nav-link pr-0 dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" style="display: flex; align-items: center;">
                  <span class="avatar avatar-sm rounded-circle mr-3">
                     <img alt="User"
                        src="{{ Auth::user()->avatar == null ? 'https://ui-avatars.com/api/?name=' . Auth::user()->name : asset(Auth::user()->avatar) }}">
                  </span>
                  <div class="profile-section d-none d-lg-block mr-2" style="text-align: left;">
                     <div class="d-flex align-items-center">
                        <span class="profile-name"
                           style="color: #333; font-weight: 600; font-size: 14px;">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ml-2" style="font-size: 10px; color: #8898aa;"></i>
                     </div>
                     <span
                        class="profile-role-badge">{{ Auth::user()->role == 'admin' ? __('Admin') : __('User') }}</span>
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

            <!-- Help Icon (Gradient Circle) -->
            <li class="nav-item ml-3 d-none d-md-block">
               <a href="#" class="nav-link pr-0">
                  <div class="help-icon-circle">
                     <i class="fas fa-question" style="font-size: 14px;"></i>
                  </div>
               </a>
            </li>

         </ul>

         <!-- Google Translate Script removed per request -->
      </div>
   </div>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
   @csrf
</form>