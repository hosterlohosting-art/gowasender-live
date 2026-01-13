@extends('layouts.main.app')

@section('head')
    <!-- Header Section with Gradient -->
    <div class="header-gradient pb-6 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h2 class="display-4 font-weight-bold mb-2 text-white">Simple, Transparent Pricing</h2>
                        <p class="h4 text-white-50 mb-5">Choose the plan that best fits your business needs.</p>

                        <a href="{{ url('/user/subscriptions/log') }}" class="btn btn-white text-primary shadow-none mb-4">
                            <i class="fas fa-history mr-2"></i> Subscription History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Pricing Cards -->
    <div class="row justify-content-center mt-4">

        <!-- Errors (Checking specific session keys usually used in this app) -->
        @if(Session::has('saas_error') || Session::has('error'))
            <div class="col-md-10 mb-4">
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <span class="alert-icon mr-2"><i class="fas fa-exclamation-circle"></i></span>
                    <span class="alert-text"><strong>Oops!</strong>
                        {{ Session::get('saas_error') ?? Session::get('error') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if(Session::has('success'))
            <div class="col-md-10 mb-4">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <span class="alert-icon mr-2"><i class="fas fa-check-circle"></i></span>
                    <span class="alert-text"><strong>Success!</strong> {{ Session::get('success') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @foreach($plans as $plan)
            <div class="col-lg-4 col-md-6 mb-4">
                <!-- Card with Dynamic Top Border Color -->
                <div class="card border-0 shadow-sm hover-lift h-100 pricing-card plan-{{ $plan->labelcolor ?? 'default' }}">

                    <!-- Colored Label Badge -->
                    @if($plan->labelcolor)
                        <div class="plan-badge-container">
                            <span class="badge badge-pill text-white text-uppercase plan-badge-{{ $plan->labelcolor }}">
                                {{ $plan->labelcolor == 'price-color-1' ? 'Best Value' : ($plan->labelcolor == 'price-color-2' ? 'Recommended' : 'Top Choice') }}
                            </span>
                        </div>
                    @endif

                    <div class="card-body p-4 p-md-5 d-flex flex-column">

                        <!-- Plan Header -->
                        <div class="text-center mb-4 mt-2">
                            <h3 class="text-uppercase font-weight-bold price-text-{{ $plan->labelcolor ?? 'default' }}"
                                style="letter-spacing: 1px;">{{ $plan->title }}</h3>
                            <div class="d-flex justify-content-center align-items-baseline mb-3">
                                <span class="h1 font-weight-800 text-dark mb-0">{{ amount_format($plan->price) }}</span>
                            </div>
                            <span class="badge badge-pill badge-light text-muted px-3 py-2 text-uppercase font-weight-600"
                                style="font-size: 11px;">
                                {{ $plan->days == 30 ? 'Per Month' : ($plan->days == 365 ? 'Per Year' : ($plan->days == 1825 ? 'Lifetime' : $plan->days . ' Days')) }}
                            </span>
                        </div>

                        <hr class="my-4" style="border-color: #f0f2f5;">

                        <!-- Features List -->
                        <ul class="list-unstyled mb-5 flex-grow-1">
                            @foreach($plan->data ?? [] as $key => $data)
                                <li class="d-flex align-items-start mb-3">
                                    @php $pData = planData($key, $data); @endphp

                                    <!-- Logic for Icon -->
                                    @if($pData['is_bool'] == true)
                                        @if($pData['value'] == true)
                                            <div class="icon icon-xs bg-soft-success text-success rounded-circle mr-3">
                                                <i class="fas fa-check"></i>
                                            </div>
                                        @else
                                            <div class="icon icon-xs bg-soft-danger text-danger rounded-circle mr-3">
                                                <i class="fas fa-times"></i>
                                            </div>
                                        @endif
                                    @else
                                        <div class="icon icon-xs bg-soft-success text-success rounded-circle mr-3">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    @endif

                                    <!-- Feature Text -->
                                    <span class="text-sm text-muted font-weight-500">
                                        {{ str_replace('_', ' ', $pData['title']) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Action Button -->
                        <div class="mt-auto">
                            @if(Auth::user()->plan_id == $plan->id)
                                <button type="button" class="btn btn-block btn-secondary disabled" disabled>
                                    <i class="fas fa-check-circle mr-2"></i> Current Plan
                                </button>
                            @else
                                <a href="{{ route('user.subscription.show', $plan->id) }}"
                                    class="btn btn-block btn-primary text-white shadow-none font-weight-600 py-3 btn-plan-{{ $plan->labelcolor ?? 'default' }}">
                                    Choose Plan
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        /* Header Gradient */
        .header-gradient {
            background: linear-gradient(135deg, #075E54 0%, #25D366 100%);
            /* No border radius here, let it fill the background like a hero section */
            background-size: cover;
            background-position: center top;
            position: relative;
        }

        .btn-white {
            background: #fff;
            color: #075E54;
            border: none;
        }

        .btn-white:hover {
            background: #f8f9fa;
            color: #054c44;
        }

        /* Card Styling */
        .pricing-card {
            border-top: 5px solid transparent;
            border-radius: 15px;
            overflow: hidden;
        }

        /* Dynamic Colors based on labelcolor */

        /* Default / WhatsApp Green */
        .plan-default {
            border-color: #25D366;
        }

        .price-text-default {
            color: #075E54;
        }

        .btn-plan-default {
            background-color: #25D366;
            border-color: #25D366;
        }

        .btn-plan-default:hover {
            background-color: #128C7E;
            border-color: #128C7E;
        }

        /* Price Color 1: Pink/Rose */
        .plan-price-color-1 {
            border-color: #e83e8c;
        }

        .price-text-price-color-1 {
            color: #e83e8c;
        }

        .btn-plan-price-color-1 {
            background-color: #e83e8c;
            border-color: #e83e8c;
        }

        .btn-plan-price-color-1:hover {
            background-color: #d63384;
            border-color: #d63384;
        }

        .plan-badge-price-color-1 {
            background-color: #e83e8c;
        }

        /* Price Color 2: Sky Blue */
        .plan-price-color-2 {
            border-color: #11cdef;
        }

        .price-text-price-color-2 {
            color: #11cdef;
        }

        .btn-plan-price-color-2 {
            background-color: #11cdef;
            border-color: #11cdef;
        }

        .btn-plan-price-color-2:hover {
            background-color: #0da5c0;
            border-color: #0da5c0;
        }

        .plan-badge-price-color-2 {
            background-color: #11cdef;
        }

        /* Price Color 3: Yellow/Orange */
        .plan-price-color-3 {
            border-color: #fb6340;
        }

        .price-text-price-color-3 {
            color: #fb6340;
        }

        .btn-plan-price-color-3 {
            background-color: #fb6340;
            border-color: #fb6340;
        }

        .btn-plan-price-color-3:hover {
            background-color: #ea3005;
            border-color: #ea3005;
        }

        .plan-badge-price-color-3 {
            background-color: #fb6340;
        }

        /* Badges */
        .plan-badge-container {
            text-align: center;
            margin-top: -30px;
            /* Pull badge up to overlap card */
            margin-bottom: 10px;
        }

        .plan-badge-container .badge {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 5px 15px;
            font-size: 0.75rem;
        }

        /* Lift Effect */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-soft-success {
            background-color: rgba(37, 211, 102, 0.1);
        }

        .bg-soft-danger {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .icon-xs {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }
    </style>

@endsection