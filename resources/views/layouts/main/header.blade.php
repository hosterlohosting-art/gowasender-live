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

            <!-- Plan Name (Replaces Wallet) -->
            @if(Auth::check())
               <li class="nav-item d-none d-md-flex align-items-center mr-4">
                  <div class="plan-badge">
                     <i class="fas fa-crown"></i>
                     <span>{{ Auth::user()->plan->title ?? 'Free Plan' }}</span>
                  </div>
               </li>
            @endif

            <!-- Notifications -->
            @if(Request::is('user/*'))
               <audio id="notificationSound" src="{{ asset('assets/messagetone.mp3') }}"></audio>
               <li class="nav-item dropdown notifications-icon mr-4">
                  <a class="nav-link notification-toggle" href="#" role="button" data-toggle="dropdown"
                     aria-haspopup="true" aria-expanded="false">
                     <i class="far fa-bell" style="font-size: 1.4rem; color: #5e6c84;"></i>
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
                     <span class="profile-role-badge"
                        style="background-color: #e3fcf0; color: #0d885a; font-size: 11px; padding: 2px 8px; border-radius: 4px; font-weight: 600; display: inline-block; line-height: 1.5;">{{ Auth::user()->role == 'admin' ? __('Admin') : __('User') }}</span>
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

            <!-- Language Selector (Google Translate) -->
            <li class="nav-item ml-3 d-none d-md-flex align-items-center">
               <div id="google_translate_element"
                  style="border-radius: 20px; overflow: hidden; height: 36px; border: 1px solid #e9ecef;"></div>
               <style>
                  .goog-te-banner-frame.skiptranslate {
                     display: none !important;
                  }

                  body {
                     top: 0px !important;
                  }

                  .goog-te-gadget-simple {
                     background-color: #f0f2f5 !important;
                     border: none !important;
                     padding: 8px 12px !important;
                     border-radius: 20px !important;
                     font-size: 13px !important;
                  }

                  .goog-te-gadget-simple img {
                     display: none;
                  }

                  .goog-te-gadget-simple span {
                     color: #5e6c84 !important;
                     font-weight: 600;
                  }
               </style>
            </li>

            <!-- Help Icon (Beautiful Circle) -->
            <li class="nav-item ml-3 d-none d-md-block">
               <a href="#" class="nav-link pr-0">
                  <div
                     style="width: 36px; height: 36px; background: #6c757d; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                     <i class="fas fa-question" style="font-size: 14px;"></i>
                  </div>
               </a>
            </li>
         </ul>

         <!-- Google Translate Script -->
         <script type="text/javascript">
            function googleTranslateElementInit() {
               new google.translate.TranslateElement({ pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE }, 'google_translate_element');
            }
         </script>
         <script type="text/javascript"
            src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
      </div>
   </div>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
   @csrf
</form>