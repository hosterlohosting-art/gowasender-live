@extends('layouts.main.app')

@section('head')
@include('layouts.main.headersection', [
    'title' => __('WhatsApp Cloud API Setup Guide'),
    'buttons' => [
        [
            'name' => '<i class="fas fa-plus"></i> ' . __('Add New API'),
            'url' => route('user.cloudapi.create'),
        ]
    ]
])
<style>
    .tutorial-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        background: #fff;
    }
    .tutorial-step-number {
        width: 40px;
        height: 40px;
        background: var(--primary);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.2rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .tutorial-img-container {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eee;
        margin: 20px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .tutorial-img-container img {
        width: 100%;
        transition: transform 0.3s ease;
    }
    .tutorial-img-container:hover img {
        transform: scale(1.02);
    }
    .id-badge {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 5px 12px;
        border-radius: 6px;
        font-family: monospace;
        color: #e11d48;
        font-weight: 600;
    }
    .alert-setup {
        background: #fffbeb;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }
</style>
@endsection

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing justify-content-center">
        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 layout-spacing">
            
            <div class="card tutorial-card shadow-lg mb-4">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <i class="fab fa-whatsapp fa-4x text-success mb-3"></i>
                        <h2 class="font-weight-800 text-dark">{{ __('Connect Your Official WhatsApp Cloud API') }}</h2>
                        <p class="text-muted">{{ __('Follow these 5 simple steps to get your enterprise-grade messaging API running in minutes.') }}</p>
                    </div>

                    {{-- STEP 1 --}}
                    <div class="d-flex align-items-start mb-5 animate-fade-in-up">
                        <div class="tutorial-step-number mr-4">1</div>
                        <div>
                            <h4 class="font-weight-700 text-dark mb-2">{{ __('Create a Meta Developer App') }}</h4>
                            <p class="text-muted">
                                {{ __('Go to the') }} <a href="https://developers.facebook.com/" target="_blank" class="font-weight-bold">Meta for Developers Portal</a>. 
                                {{ __('Click "My Apps" -> "Create App". Select "Other" then choose "Business" as your App Type.') }}
                            </p>
                            <div class="alert alert-setup p-3 mt-3">
                                <i class="fas fa-info-circle mr-2"></i> {{ __('Make sure you link it to your verified Business Account for production use.') }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-5 opacity-1">

                    {{-- STEP 2 --}}
                    <div class="d-flex align-items-start mb-5 animate-fade-in-up" style="animation-delay: 0.1s">
                        <div class="tutorial-step-number mr-4">2</div>
                        <div>
                            <h4 class="font-weight-700 text-dark mb-2">{{ __('Add WhatsApp to Your App') }}</h4>
                            <p class="text-muted">
                                {{ __('In your App Dashboard, find "WhatsApp" and click "Set Up". This will create a temporary number for testing.') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-5 opacity-1">

                    {{-- STEP 3 --}}
                    <div class="d-flex align-items-start mb-5 animate-fade-in-up" style="animation-delay: 0.2s">
                        <div class="tutorial-step-number mr-4">3</div>
                        <div>
                            <h4 class="font-weight-700 text-dark mb-2">{{ __('Gather Your API Keys') }}</h4>
                            <p class="text-muted">
                                {{ __('Navigate to WhatsApp -> API Setup. You will need to copy the following IDs into our portal:') }}
                            </p>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> {{ __('Temporary/Permanent') }} <strong>{{ __('Access Token') }}</strong></li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> <strong>{{ __('Phone Number ID') }}</strong></li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> <strong>{{ __('WhatsApp Business Account ID') }}</strong></li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-5 opacity-1">

                    {{-- STEP 4 --}}
                    <div class="d-flex align-items-start mb-5 animate-fade-in-up" style="animation-delay: 0.3s">
                        <div class="tutorial-step-number mr-4">4</div>
                        <div>
                            <h4 class="font-weight-700 text-dark mb-2">{{ __('Configure Webhooks') }}</h4>
                            <p class="text-muted">
                                {{ __('This is critical for receiving messages. Go to WhatsApp -> Configuration.') }}
                            </p>
                            <div class="p-4 bg-light rounded-lg border-dashed">
                                <p class="mb-2"><strong>{{ __('Callback URL:') }}</strong> <span class="id-badge">{{ url('/send-webhook/') }}/ID</span></p>
                                <p class="mb-0"><strong>{{ __('Verify Token:') }}</strong> <span class="id-badge">gowasender</span></p>
                            </div>
                            <p class="mt-3 text-muted small">
                                <i class="fas fa-exclamation-triangle mr-1 text-warning"></i> {{ __('Don\'t forget to subscribe to "messages" in the Webhook Fields section!') }}
                            </p>
                        </div>
                    </div>

                    <hr class="my-5 opacity-1">

                    {{-- FINAL STEP --}}
                    <div class="d-flex align-items-start mb-5 animate-fade-in-up" style="animation-delay: 0.4s">
                        <div class="tutorial-step-number mr-4">5</div>
                        <div>
                            <h4 class="font-weight-700 text-dark mb-2">{{ __('Connect in Portal') }}</h4>
                            <p class="text-muted">
                                {{ __('Now, go to our "Add New API" page and paste the keys you collected.') }}
                            </p>
                            <a href="{{ route('user.cloudapi.create') }}" class="btn btn-primary btn-lg shadow-lg px-5 mt-3">
                                {{ __('Start Connecting Now') }} <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Support Footer --}}
            <div class="text-center pb-5">
                <p class="text-muted">{{ __('Still confused?') }} <a href="{{ url('/user/support') }}" class="text-primary font-weight-bold">{{ __('Contact Support') }}</a></p>
            </div>

        </div>
    </div>
</div>
@endsection
