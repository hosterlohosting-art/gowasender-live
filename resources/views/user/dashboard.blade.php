@extends('layouts.main.app')

@section('head')
    <!-- Custom Header removed for cleaner look -->
    <div class="header bg-white pb-4 pt-4 pt-md-6 border-bottom-0">
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
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="mb-1 text-dark">Welcome back, <span class="text-primary">{{ Auth::user()->name }}</span>!
                            👋</h3>
                        <p class="text-muted mb-0 small">Here's what's happening with your messaging campaigns today.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row">
        <!-- Stat Card 1 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold"
                                style="font-size: 0.7rem;">Connected APIs</h5>
                            <span class="h2 font-weight-bold mb-0 text-dark" id="total-device">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-light text-success rounded-circle shadow-none">
                                <i class="fas fa-server"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold"
                                style="font-size: 0.7rem;">Total Messages</h5>
                            <span class="h2 font-weight-bold mb-0 text-dark" id="total-messages">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-light text-primary rounded-circle shadow-none">
                                <i class="ni ni-spaceship"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold"
                                style="font-size: 0.7rem;">Pending Schedules</h5>
                            <span class="h2 font-weight-bold mb-0 text-dark" id="total-schedule">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-light text-warning rounded-circle shadow-none">
                                <i class="ni ni-calendar-grid-58"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold"
                                style="font-size: 0.7rem;">Total Contacts</h5>
                            <span class="h2 font-weight-bold mb-0 text-dark" id="total-contacts">
                                <i class="fas fa-spinner fa-spin text-muted small"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-light text-info rounded-circle shadow-none">
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
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Messages Transaction</h6>
                    <div class="card-header-action">
                        <select class="form-control bg-white border shadow-none cursor-pointer"
                            id="period" style="width: 140px; border-radius: 6px; font-weight: 600; color: #32325d;">
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
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Message Types</h6>
                    <div class="card-header-action">
                        <select class="form-control bg-white border shadow-none cursor-pointer"
                            id="messagesTypes" style="width: 120px; border-radius: 6px; font-weight: 600; color: #32325d;">
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
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Automatic Replies</h6>
                    <div class="card-header-action">
                        <select class="form-control bg-white border shadow-none cursor-pointer"
                            id="automaticReply" style="width: 140px; border-radius: 6px; font-weight: 600; color: #32325d;">
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
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent py-3">
                    <h6 class="h4 text-dark mb-0 ls-1 text-uppercase">Devices Status</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="device-list">
                        <!-- Loaded via JS -->
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
    #period, #messagesTypes, #automaticReply {
        color: #2d3748 !important;
        font-weight: 600 !important;
    }
    
    #period option, #messagesTypes option, #automaticReply option {
        color: #2d3748 !important;
        font-weight: 500 !important;
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
        document.addEventListener('DOMContentLoaded', function() {
            const selects = ['#period', '#messagesTypes', '#automaticReply'];
            selects.forEach(function(selector) {
                const element = document.querySelector(selector);
                if (element) {
                    element.style.setProperty('color', '#000000', 'important');
                    element.style.setProperty('font-weight', 'bold', 'important');
                    element.style.setProperty('opacity', '1', 'important');
                    
                    // Also style options
                    const options = element.querySelectorAll('option');
                    options.forEach(function(option) {
                        option.style.setProperty('color', '#000000', 'important');
                        option.style.setProperty('font-weight', 'bold', 'important');
                    });
                }
            });
        });
    </script>
@endpush