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
    :root {
        --wa-green: #25D366;
        --wa-dark: #075E54;
        --soft-bg: #f0f7ff;
    }
    .tutorial-card {
        border-radius: 24px;
        border: none;
        overflow: hidden;
        background: #fff;
        position: relative;
    }
    .tutorial-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--wa-green), var(--wa-dark));
    }
    .step-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        position: relative;
    }
    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        border-color: rgba(37, 211, 102, 0.2);
    }
    .step-number {
        position: absolute;
        top: -15px;
        left: 30px;
        width: 35px;
        height: 35px;
        background: var(--wa-green);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }
    .id-badge {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'JetBrains Mono', monospace;
        color: #ef4444;
        font-size: 0.85rem;
    }
    .premium-link {
        color: var(--wa-green);
        font-weight: 700;
        text-decoration: none;
        border-bottom: 2px solid rgba(37, 211, 102, 0.1);
        transition: all 0.2s;
    }
    .premium-link:hover {
        color: var(--wa-dark);
        border-bottom-color: var(--wa-dark);
    }
    .guide-header-icon {
        width: 80px;
        height: 80px;
        background: rgba(37, 211, 102, 0.1);
        color: var(--wa-green);
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .whatsapp-support-banner {
        background: linear-gradient(135deg, #075E54 0%, #128C7E 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .whatsapp-support-banner::after {
        content: '\f232';
        font-family: 'Font Awesome 5 Brands';
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 150px;
        opacity: 0.1;
    }
</style>
@endsection

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing justify-content-center">
        <div class="col-xl-9 col-lg-10">
            
            <div class="card tutorial-card shadow-xl mb-5">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="guide-header-icon">
                            <i class="fab fa-whatsapp fa-3x"></i>
                        </div>
                        <h1 class="display-4 font-weight-800 text-dark mb-2">{{ __('Official WhatsApp API') }}</h1>
                        <p class="lead text-muted">{{ __('Setup your automated messaging empire in 5 quick steps.') }}</p>
                    </div>

                    {{-- STEPS CONTAINER --}}
                    <div class="steps-wrapper mt-5">
                        
                        {{-- STEP 1 --}}
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="font-weight-800 text-dark mb-3">{{ __('Meta Developer Portal') }}</h3>
                                    <p class="text-muted mb-0">
                                        {{ __('Create your developer account at') }} 
                                        <a href="https://developers.facebook.com/" target="_blank" class="premium-link">developers.facebook.com</a>.
                                        {{ __('Create a "Business" type App to unlock WhatsApp features.') }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-center d-none d-md-block">
                                    <i class="fas fa-laptop-code fa-4x text-light"></i>
                                </div>
                            </div>
                        </div>

                        {{-- STEP 2 --}}
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h3 class="font-weight-800 text-dark mb-3">{{ __('Add WhatsApp Product') }}</h3>
                            <p class="text-muted">
                                {{ __('In your app sidebar, click "Add Product" and select WhatsApp. Click "Set Up" to generate your first test credentials.') }}
                            </p>
                        </div>

                        {{-- STEP 3 --}}
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h3 class="font-weight-800 text-dark mb-3">{{ __('Copy Your Credentials') }}</h3>
                            <p class="text-muted mb-4">{{ __('Navigate to WhatsApp -> API Setup. You need these three keys:') }}</p>
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 bg-light rounded-lg h-100">
                                        <h6 class="text-uppercase small font-weight-bold text-muted mb-2">Access Token</h6>
                                        <i class="fas fa-key text-warning mb-2"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 bg-light rounded-lg h-100">
                                        <h6 class="text-uppercase small font-weight-bold text-muted mb-2">Phone Number ID</h6>
                                        <i class="fas fa-phone text-primary mb-2"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="p-3 bg-light rounded-lg h-100">
                                        <h6 class="text-uppercase small font-weight-bold text-muted mb-2">WABA ID</h6>
                                        <i class="fas fa-building text-success mb-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- STEP 4 --}}
                        <div class="step-card border-left-success" style="border-left-width: 5px;">
                            <div class="step-number">4</div>
                            <h3 class="font-weight-800 text-dark mb-3">{{ __('Configure Webhooks') }}</h3>
                            <p class="text-muted mb-4">{{ __('Go to Configuration in the WhatsApp menu and set these exact values:') }}</p>
                            
                            <div class="bg-dark p-4 rounded-xl shadow-inner mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-white-50 small">Callback URL</span>
                                    <i class="fas fa-copy text-white-50 cursor-pointer"></i>
                                </div>
                                <code class="text-success wrap-text">{{ url('/send-webhook/') }}/[YOUR_ID]</code>
                                
                                <div class="d-flex justify-content-between mt-3 mb-2">
                                    <span class="text-white-50 small">Verify Token</span>
                                </div>
                                <code class="text-success">gowasender</code>
                            </div>
                            
                            <div class="alert alert-setup mb-0 border-0">
                                <strong>{{ __('Crucial Step:') }}</strong> {{ __('Once configured, find "Webhook Fields" below and click "Manage" to subscribe to') }} <strong>{{ __('messages') }}</strong>.
                            </div>
                        </div>

                        {{-- STEP 5 --}}
                        <div class="step-card bg-soft-bg border-0">
                            <div class="step-number" style="background:#000">5</div>
                            <div class="text-center py-4">
                                <h3 class="font-weight-800 text-dark mb-3">{{ __('Go Live!') }}</h3>
                                <p class="text-muted mb-4">{{ __('Head over to our API connection page and paste the keys you gathered.') }}</p>
                                <a href="{{ route('user.cloudapi.create') }}" class="btn btn-success btn-lg px-5 rounded-pill shadow-lg transform-hover">
                                    {{ __('Connect API Now') }} <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- WHATSAPP SUPPORT BANNER --}}
            <div class="whatsapp-support-banner shadow-2xl mb-5">
                <h2 class="font-weight-800 mb-2">{{ __('Stuck? We are here to help!') }}</h2>
                <p class="mb-4 opacity-80">{{ __('Our team can help you set up your Meta App via WhatsApp support.') }}</p>
                <a href="https://wa.me/18044854344" target="_blank" class="btn btn-white btn-lg rounded-pill px-5 text-success font-weight-bold">
                    <i class="fab fa-whatsapp mr-2"></i> {{ __('Chat with Support') }}
                </a>
            </div>

            <div class="text-center pb-5">
                <a href="{{ route('user.dashboard.index') }}" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Back to Dashboard</a>
            </div>

        </div>
    </div>
</div>
@endsection
