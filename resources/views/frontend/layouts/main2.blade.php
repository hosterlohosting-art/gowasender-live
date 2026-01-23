<!doctype html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    <meta name="theme-color" content="#16A34A">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/brand/favicon.png') }}">

    <!-- CSS / Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#F0FDF4',
                            100: '#DCFCE7',
                            200: '#BBF7D0',
                            400: '#4ADE80',
                            500: '#22C55E',
                            600: '#16A34A',
                            700: '#15803D',
                            900: '#14532D',
                            dark: '#022C22',
                        },
                        accent: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            500: '#3B82F6',
                            600: '#2563EB',
                            700: '#1D4ED8',
                            900: '#1E3A8A',
                        }
                    },
                    boxShadow: {
                        'glow': '0 0 40px -10px rgba(34, 197, 94, 0.4)',
                        'card': '0 20px 40px -15px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 30px 60px -15px rgba(34, 197, 94, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
    @stack('css')
</head>

<body class="bg-white text-gray-800 antialiased font-sans overflow-x-hidden">
    @include('frontend.layouts.header')

    @yield('content')

    @include('frontend.layouts.footer')

    <!-- Scripts -->
    <script src="{{ asset('assets/frontend/js/jquery.js') }}"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic',
        });

        // Initialize Tilt on elements with data-tilt attribute
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 15,
            speed: 400,
            glare: true,
            "max-glare": 0.5,
        });
    </script>
    @stack('js')
    @include('components.ai-chatbot')

    {{-- Floating WhatsApp Support Widget --}}
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