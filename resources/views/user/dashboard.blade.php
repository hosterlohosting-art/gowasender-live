@extends('layouts.main.app')

@section('head')
    <!-- Custom Header removed for cleaner look -->
    <div class="header" style="background: transparent !important; padding-top: 10px; padding-bottom: 0px;">
        <div class="container-fluid">
            <div class="header-body">
            </div>
        </div>
    </div>
@endsection

@section('content')

    <!-- Hero Section: Welcome & Meta Branding -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0 overflow-hidden"
                style="border-radius: 20px; position: relative; min-height: 220px;">
                <!-- Background with Gradient & Doodle -->
                <div
                    style="position: absolute; inset: 0; background: linear-gradient(135deg, #075E54 0%, #0c1317 100%); z-index: 0;">
                </div>
                <div
                    style="position: absolute; inset: 0; background-image: url('{{ asset('assets/img/whatsapp-bg.png') }}'); opacity: 0.08; z-index: 0;">
                </div>

                <div class="card-body position-relative d-flex align-items-center justify-content-between p-4 p-md-5"
                    style="z-index: 1;">
                    <div class="d-flex align-items-center">
                        <!-- User Avatar/Icon -->
                        <div class="icon icon-shape bg-white text-success rounded-circle shadow-lg mr-4 p-3 d-none d-md-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fab fa-whatsapp fa-3x"></i>
                        </div>
                        <div>
                            <span class="badge badge-pill badge-success mb-2 px-3 py-1"
                                style="background-color: #25D366; color: #075E54; font-weight: 800; letter-spacing: 0.5px;">ONLINE</span>
                            <h2 class="text-white mb-1 font-weight-800"
                                style="font-family: 'Plus Jakarta Sans', sans-serif;">Welcome back,
                                {{ Auth::user()->name }}! 👋
                            </h2>
                            <p class="text-white-50 mb-0 font-weight-500">Your automation empire is running smoothly.</p>

                            <!-- Quick Actions (New) -->
                            <div class="mt-4">
                                <a href="{{ route('user.flows.index') }}"
                                    class="btn btn-white text-success font-weight-bold shadow-sm rounded-pill px-4">
                                    <i class="fas fa-bolt mr-2"></i> Create Flow
                                </a>
                                <a href="{{ route('user.cloudapi.index') }}"
                                    class="btn btn-outline-white font-weight-bold rounded-pill px-4 ml-2">
                                    <i class="fas fa-mobile-alt mr-2"></i> Devices
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Meta / Tech Provider Badge (Premium Touch) -->
                    <div class="d-none d-lg-block text-right">
                        <div class="d-flex align-items-center justify-content-end mb-2">
                            <span class="text-white-50 mr-2 text-xs font-weight-bold text-uppercase tracking-wider">Powered
                                By</span>
                            <img src="{{ asset('assets/img/meta.png') }}" alt="Meta"
                                style="height: 24px; filter: brightness(0) invert(1);">
                        </div>
                        <div class="bg-white-10 rounded-lg p-3 backdrop-blur"
                            style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shield-alt text-success mr-2 fa-lg"></i>
                                <div>
                                    <h6 class="text-white mb-0 font-weight-bold">Meta Tech Provider</h6>
                                    <small class="text-white-50" style="font-size: 0.7rem;">Official API Partner</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tutorial & Learning Section (New Request) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-dark border-0 shadow-lg overflow-hidden"
                style="border-radius: 15px; background: linear-gradient(90deg, #1f2937 0%, #111827 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow-sm mr-3">
                                    <i class="fab fa-youtube fa-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-white mb-1 font-weight-bold">Master Automation with our Tutorials</h4>
                                    <p class="text-white-50 mb-0 small">Learn how to build complex flows, connect webhooks,
                                        and scale your business in minutes.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-right mt-3 mt-md-0">
                            <a href="https://www.youtube.com/@GoWaSender/videos" target="_blank"
                                class="btn btn-danger rounded-pill px-4 font-weight-bold shadow-lg transform-hover">
                                <i class="fas fa-play mr-2"></i> Watch Tutorials
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid (Refined Premium Cards) -->
    <div class="row">
        <!-- Stat Card 1 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4 hover-translate-y" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-xs">Connected Devices
                            </h5>
                            <span class="h2 font-weight-800 mb-0 text-dark" id="total-device">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                <i class="fas fa-server"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Active</span>
                        <span class="text-nowrap text-muted">Real-time status</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4 hover-translate-y" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-xs">Total Messages
                            </h5>
                            <span class="h2 font-weight-800 mb-0 text-dark" id="total-messages">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                <i class="ni ni-spaceship"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-primary mr-2"><i class="fa fa-arrow-up"></i> Sent</span>
                        <span class="text-nowrap text-muted">Lifetime volume</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4 hover-translate-y" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-xs">Pending Schedules
                            </h5>
                            <span class="h2 font-weight-800 mb-0 text-dark" id="total-schedule">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                <i class="ni ni-calendar-grid-58"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-warning mr-2"><i class="fas fa-clock"></i> Queued</span>
                        <span class="text-nowrap text-muted">Awaiting delivery</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4 hover-translate-y" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-xs">Total Contacts
                            </h5>
                            <span class="h2 font-weight-800 mb-0 text-dark" id="total-contacts">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-collection"></i>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span class="text-info mr-2"><i class="fas fa-users"></i> Audience</span>
                        <span class="text-nowrap text-muted">Total reach</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section (Preserved) -->
    <div class="row">
        @if(Session::has('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert"
                    style="border-radius: 10px;">
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
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert"
                    style="border-radius: 10px;">
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
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase font-weight-bold">Messages Transaction</h6>
                    <div class="card-header-action">
                        <select class="form-control border-0 bg-light shadow-none cursor-pointer text-dark font-weight-bold"
                            id="period" style="width: 140px; border-radius: 8px;">
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
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase font-weight-bold">Message Types</h6>
                    <div class="card-header-action">
                        <select class="form-control border-0 bg-light shadow-none cursor-pointer text-dark font-weight-bold"
                            id="messagesTypes" style="width: 120px; border-radius: 8px;">
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

    <div class="row mt-4">
        <!-- Auto Replies Bar Chart -->
        <div class="col-xl-6">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase font-weight-bold">Automatic Replies</h6>
                    <div class="card-header-action">
                        <select class="form-control border-0 bg-light shadow-none cursor-pointer text-dark font-weight-bold"
                            id="automaticReply" style="width: 140px; border-radius: 8px;">
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
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase font-weight-bold">Devices Status</h6>
                    <a href="{{ route('user.cloudapi.index') }}" class="btn btn-sm btn-dark rounded-pill px-3 shadow-none">Manage
                        Devices</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="device-list">
                        <!-- Loaded via JS -->
                        <div id="device-list-empty" class="text-center py-5 d-none">
                            <div class="icon icon-shape bg-light text-muted rounded-circle mb-3">
                                <i class="fas fa-mobile-alt fa-2x"></i>
                            </div>
                            <h6 class="text-muted">No connected devices found</h6>
                            <a href="{{ route('user.cloudapi.index') }}" class="btn btn-sm btn-outline-primary mt-2">Connect
                                Now</a>
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