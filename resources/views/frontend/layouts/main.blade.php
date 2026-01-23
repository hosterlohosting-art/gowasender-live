<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   {!! SEOMeta::generate() !!}
   {!! OpenGraph::generate() !!}
   {!! Twitter::generate() !!}
   {!! JsonLd::generate() !!}

   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_option('primary_data', true)->favicon ?? '') }}">

   <!-- CSS here -->
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/icofont.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/aos.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
   @if (request()->is('contact') || request()->is('blogs') || request()->is('blog/*'))
      <link rel="stylesheet" href="{{ asset('assets/frontend/css/style2.css') }}">
   @endif

   <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
</head>

<body>
   <!-- Page-wrapper-Start -->
   <div class="page_wrapper">

      <!-- Preloader -->
      <!-- Preloader -->
      @include('layouts.preloader')
      @yield('content')
      @if (!request()->is('login') && !request()->is('register*') && !request()->is('blogs'))
         @include('frontend.layouts.footer')
      @endif


      <!-- JS here -->
      <script src="{{ asset('assets/frontend/js/jquery.js') }}"></script>
      <script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script>
      <script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('assets/frontend/js/aos.js') }}"></script>
      <script src="{{ asset('assets/frontend/js/jquery.magnific-popup.js') }}"></script>
      <script src="{{ asset('assets/frontend/js/main.js') }}"></script>
      <!-- Floating WhatsApp Support Widget -->
      <a href="https://wa.me/18044854344" target="_blank"
         class="wa-btn-floating shadow-glow hover:scale-110 transition-transform" title="Get Support on WhatsApp">
         <i class="fab fa-whatsapp"></i>
      </a>

      <style>
         .wa-btn-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            z-index: 9999;
            box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.15);
            animation: wa-pulse 2s infinite;
         }

         @keyframes wa-pulse {
            0% {
               box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
               box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }

            100% {
               box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
         }
      </style>
</body>

</html>