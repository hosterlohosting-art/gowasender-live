<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @laravelPWA
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ env('APP_NAME') }}</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
    type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/uicons-regular-straight.css') }}">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  @stack('topcss')
  <link rel="stylesheet" href="{{ asset('assets/css/argon.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/toastify-js/src/toastify.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard_1.css?v=1.7') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pace/pace-theme-default.min.css') }}">
  @stack('css')
  @if(Request::is('user/cloudapi/chats/*'))
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chat.css?v=3') }}">
  @endif
</head>

<body class="{{ Request::is('admin/*') ? 'admin-layout' : 'user-layout' }}">

  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{ url('/login') }}">
          <img src="{{ asset('assets/img/brand/blue.png') }}" class="navbar-brand-img" alt="Logo"
            style="max-height: 50px;">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          @include('layouts.main.sidebar')
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('layouts.main.header')
    @yield('head')
    <!-- Page content -->
    <div class="container-fluid mt--6">

      @yield('content')

      <!-- Footer -->
      @include('layouts.main.footer')
    </div>
  </div>
  <form action="{{ route('logout') }}" method="post" id="logout-form">@csrf</form>

  <!-- Core -->

  <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  @stack('topjs')
  <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
  <!-- Plugins  -->
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/toastify-js/src/toastify.js') }}"></script>
  <script src="{{ asset('assets/plugins/form.js?v=2') }}"></script>
  @stack('js')
  @unless(Request::is('user/cloudapi/chats/*'))
    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
  @endunless
  <script src="{{ asset('assets/js/argon.js?v=1.1.1') }}"></script>
  @stack('bottomjs')
  @if(Request::is('user/*'))
    <script src="{{ asset('assets/js/pages/notifications.js') }}"></script>
  @endif
  @if(getUserPlanData('access_chat_list') == true && Request::is('user/cloudapi/chats/*'))
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/chat.js?v=2') }}"></script>
  @endif
  @if(Request::is('user/dashboard'))
    <script src="{{ asset('assets/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard_1.js') }}"></script>
  @endif
</body>

</html>