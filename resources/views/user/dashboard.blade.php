@extends('layouts.main.app')

@section('head')
    <!-- Custom Header removed for cleaner look -->
    <div class="header bg-white pb-2 pt-3 pt-md-4 border-bottom-0">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-2">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 d-inline-block mb-0 text-dark">Dashboard</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-white p-0 m-0 text-sm font-weight-600">
                                <li class="breadcrumb-item"><a href="#" class="text-muted"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#" class="text-muted">Overview</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0"
                style="background-color: #075E54 !important; position: relative; overflow: hidden; border-radius: 12px;">
                <!-- Doodle Overlay -->
                <!-- WhatsApp Dark Green Theme: #075E54 -->
                <div
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ asset('assets/img/whatsapp-bg.png') }}'); opacity: 0.1; pointer-events: none;">
                </div>

                <div class="card-body d-flex align-items-center py-4" style="position: relative; z-index: 1;">
                    <div class="mr-4 text-white d-none d-md-block">
                        <div class="icon icon-shape bg-white text-success rounded-circle shadow-lg"
                            style="width: 60px; height: 60px;">
                            <i class="fab fa-whatsapp fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="mb-1 text-white">Welcome back, <span
                                class="font-weight-bold">{{ Auth::user()->name }}</span>! 👋</h3>
                        <p class="text-white mb-0 opacity-8 small">Here's what's happening with your messaging campaigns
                            today.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row">
        <!-- Stat Card 1: Connected APIs (Green) -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4"
                style="background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-white mb-0 font-weight-bold"
                                style="font-size: 0.7rem; opacity: 0.8;">Connected APIs</h5>
                            <span class="h2 font-weight-bold mb-0 text-white" id="total-device">
                                <i class="fas fa-spinner fa-spin text-white small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-success rounded-circle shadow-none">
                                <i class="fas fa-server"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 2: Total Messages (Blue/Purple) -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4"
                style="background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-white mb-0 font-weight-bold"
                                style="font-size: 0.7rem; opacity: 0.8;">Total Messages</h5>
                            <span class="h2 font-weight-bold mb-0 text-white" id="total-messages">
                                <i class="fas fa-spinner fa-spin text-white small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-primary rounded-circle shadow-none">
                                <i class="ni ni-spaceship"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 3: Pending Schedules (Orange) -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4"
                style="background: linear-gradient(87deg, #fb6340 0, #fbb140 100%) !important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-white mb-0 font-weight-bold"
                                style="font-size: 0.7rem; opacity: 0.8;">Pending Schedules</h5>
                            <span class="h2 font-weight-bold mb-0 text-white" id="total-schedule">
                                <i class="fas fa-spinner fa-spin text-white small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-warning rounded-circle shadow-none">
                                <i class="ni ni-calendar-grid-58"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 4: Total Contacts (Info/Cyan) -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4"
                style="background: linear-gradient(87deg, #11cdef 0, #1171ef 100%) !important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-white mb-0 font-weight-bold"
                                style="font-size: 0.7rem; opacity: 0.8;">Total Contacts</h5>
                            <span class="h2 font-weight-bold mb-0 text-white" id="total-contacts">
                                <i class="fas fa-spinner fa-spin text-white small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-white text-info rounded-circle shadow-none">
                                <i class="ni ni-collection"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="row">
        @if(Session::has('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <span class="alert-icon mr-2"><i class="fas fa-check-circle"></i></span>
                    <span class="alert-text"><strong>Success!</strong> {{ Session::get('success') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @if(Session::has('saas_error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <span class="alert-icon mr-2"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="alert-text">
                        <strong>Attention Needed!</strong>
                        <a class="text-white font-weight-bold text-underline"
                            href="{{ url(Auth::user()->plan_id == null ? '/user/subscription' : '/user/subscription/' . Auth::user()->plan_id) }}">
                            {{ Session::get('saas_error') }}
                        </a>
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Messages Transaction Chart -->
        <div class="col-xl-8">
            <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3"
                    style="border-bottom: 1px solid rgba(0,0,0,0.05); border-left: 5px solid #5e72e4;">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Messages Transaction</h6>
                    <div class="card-header-action">
                        <select class="form-control bg-white border shadow-none cursor-pointer" id="period"
                            style="width: 140px; border-radius: 6px; font-weight: 600; color: #32325d;">
                            <option value="7">Last 7 Days</option>
                            <option value="1">Today</option>
                            <option value="30">Last 30 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="chart-sales" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Type Doughnut -->
        <div class="col-xl-4">
            <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3"
                    style="border-bottom: 1px solid rgba(0,0,0,0.05); border-left: 5px solid #11cdef;">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Message Types</h6>
                    <div class="card-header-action">
                        <select class="form-control bg-white border shadow-none cursor-pointer" id="messagesTypes"
                            style="width: 120px; border-radius: 6px; font-weight: 600; color: #32325d;">
                            <option value="7">Last 7 Days</option>
                            <option value="1">Today</option>
                            <option value="30">30 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="chart-doughnut" class="chart-canvas" height="280"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Auto Replies Bar Chart -->
        <div class="col-xl-6">
            <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3"
                    style="border-bottom: 1px solid rgba(0,0,0,0.05); border-left: 5px solid #fb6340;">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Automatic Replies</h6>
                    <div class="card-header-action">
                        <select class="form-control bg-white border shadow-none cursor-pointer" id="automaticReply"
                            style="width: 140px; border-radius: 6px; font-weight: 600; color: #32325d;">
                            <option value="7">Last 7 Days</option>
                            <option value="1">Today</option>
                            <option value="30">Last 30 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devices List -->
        <div class="col-xl-6">
            <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between"
                    style="border-bottom: 1px solid rgba(0,0,0,0.05); border-left: 5px solid #2dce89;">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Devices Status</h6>
                    <a href="{{ url('/user/device') }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-none">Manage
                        Devices</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="device-list">
                        <!-- Loaded via JS -->
                        <!-- Fallback / Empty State Visualization (Visible if JS is slow or list empty) -->
                        <div id="device-list-empty" class="text-center py-5 d-none">
                            <div class="icon icon-shape bg-light text-muted rounded-circle mb-3">
                                <i class="fas fa-mobile-alt fa-2x"></i>
                            </div>
                            <h6 class="text-muted">No connected devices found</h6>
                            <a href="{{ url('/user/device') }}" class="btn btn-sm btn-outline-primary mt-2">Connect Now</a>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="static-data" value="{{ route('user.dashboard.static') }}">
    <input type="hidden" id="base_url" value="{{ url('/') }}">

@endsection


<style>
    /* Force dropdown text to be dark and visible */
    #period,
    #messagesTypes,
    #automaticReply {
        color: #2d3748 !important;
        font-weight: 600 !important;
    }

    #period option,
    #messagesTypes option,
    #automaticReply option {
        color: #2d3748 !important;
        font-weight: 500 !important;
    }

    /* Force Remove Green Strip or Gradient Behind Header */
    .header {
        background: transparent !important;
        background-color: transparent !important;
    }

    .main-content {
        background-color: #f0f2f5 !important;
    }

    body {
        background-color: #f0f2f5 !important;
    }
</style>

@push('js')
    <script src="{{ asset('assets/vendor/chart.js/dist/chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/canvas-confetti/confetti.browser.min.js') }}"></script>
@endpush

@push('bottomjs')
    <script src="{{ asset('assets/js/pages/user/dashboard.js') }}"></script>

    <script>
        // Force dropdown text to be dark
        document.addEventListener('DOMContentLoaded', function () {
            const selects = ['#period', '#messagesTypes', '#automaticReply'];
            selects.forEach(function (selector) {
                const element = document.querySelector(selector);
                if (element) {
                    element.style.setProperty('color', '#000000', 'important');
                    element.style.setProperty('font-weight', 'bold', 'important');
                    element.style.setProperty('opacity', '1', 'important');

                    // Also style options
                    const options = element.querySelectorAll('option');
                    options.forEach(function (option) {
                        option.style.setProperty('color', '#000000', 'important');
                        option.style.setProperty('font-weight', 'bold', 'important');
                    });
                }
            });
        });
    </script>
@endpush