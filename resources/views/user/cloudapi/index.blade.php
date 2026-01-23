@extends('layouts.main.app')

@section('head')
    @include('layouts.main.headersection', [
        'title' => __('WhatsApp API Management'),
        'buttons' => [
            [
                'name' => '<i class="fas fa-plus"></i> ' . __('Add New API'),
                'url' => route('user.cloudapi.create'),
                'components' => 'class="btn btn-sm premium-btn premium-btn-primary"'
            ]
        ]
    ])
@endsection

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        
        @forelse($cloudapis as $cloudapi)
        <div class="col-12 layout-spacing">
            <div class="card premium-card animate-fade-in-up border-0 shadow-lg overflow-hidden" 
                 style="border-radius: 16px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                
                {{-- Horizontal layout for all screen sizes --}}
                <div class="card-body p-0">
                    <div class="row no-gutters align-items-stretch" style="min-height: 140px;">
                        
                        {{-- LEFT: Identity & Status --}}
                        <div class="col-lg-3 col-md-4 d-flex align-items-center p-4 border-right" 
                             style="background: linear-gradient(135deg, rgba(37, 211, 102, 0.05) 0%, transparent 100%);">
                            <div class="d-flex align-items-center">
                                <div class="icon-shape bg-gradient-success text-white rounded-circle shadow-lg mr-3 p-3 flex-shrink-0" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fab fa-whatsapp fa-2x"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="mb-1 font-weight-800 text-dark text-truncate">
                                        {{ $cloudapi->phone ?? 'Unconfigured' }}
                                    </h4>
                                    <p class="text-muted small mb-1 text-truncate">{{ $cloudapi->name }}</p>
                                    <span class="badge badge-pill {{ $cloudapi->status == 1 ? 'badge-soft-success' : 'badge-soft-danger' }} font-weight-bold">
                                        <i class="fas fa-circle mr-1 small"></i> {{ $cloudapi->status == 1 ? __('Connected') : __('Disconnected') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- CENTER: Quick Stats --}}
                        <div class="col-lg-4 col-md-4 d-flex align-items-center px-4 py-3">
                            <div class="w-100">
                                <div class="row text-center mb-3">
                                    <div class="col-6">
                                        <h6 class="text-uppercase text-muted ls-1 mb-1" style="font-size: 0.65rem;">{{ __('Messages') }}</h6>
                                        <span class="h4 font-weight-800 text-primary mb-0">{{ number_format($cloudapi->smstransaction_count ?? 0) }}</span>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="text-uppercase text-muted ls-1 mb-1" style="font-size: 0.65rem;">{{ __('Graph API') }}</h6>
                                        <span class="h4 font-weight-800 text-warning mb-0">v20.0</span>
                                    </div>
                                </div>
                                <div class="progress progress-sm bg-light shadow-none mb-0">
                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{ $cloudapi->status == 1 ? '100%' : '0%' }}"></div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: Actions --}}
                        <div class="col-lg-5 col-md-4 d-flex align-items-center justify-content-end px-4 py-3" 
                             style="background: rgba(246, 249, 252, 0.5);">
                            <div class="d-flex flex-wrap justify-content-end align-items-center">
                                
                                {{-- Primary Action: Messages --}}
                                <a href="{{ url('/user/cloudapi/chats/'.$cloudapi->uuid) }}" 
                                   class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 py-2 mr-2 position-relative transform-hover">
                                    <i class="fas fa-comments text-primary mr-2"></i> {{ __('Chats') }}
                                    @if($cloudapi->unread_messages_count > 0)
                                        <span class="badge badge-circle badge-danger position-absolute" 
                                              style="top: -5px; right: -5px; border: 2px solid #fff; width: 22px; height: 22px; line-height: 18px; padding: 0;">
                                            {{ $cloudapi->unread_messages_count }}
                                        </span>
                                    @endif
                                </a>

                                {{-- Other Core Actions --}}
                                <div class="btn-group">
                                    <a href="{{ route('user.cloudapi.show', $cloudapi->uuid) }}" class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 py-2 mr-2 transform-hover" title="{{ __('Logs') }}">
                                        <i class="fas fa-list-ul text-info mr-1"></i> <span class="d-none d-lg-inline">{{ __('Logs') }}</span>
                                    </a>
                                    <a href="{{ route('user.cloudapi.hook', $cloudapi->uuid) }}" class="btn btn-sm btn-white border shadow-sm rounded-pill px-3 py-2 mr-2 transform-hover" title="{{ __('Webhook') }}">
                                        <i class="fas fa-network-wired text-warning mr-1"></i> <span class="d-none d-lg-inline">{{ __('Keys') }}</span>
                                    </a>
                                </div>

                                {{-- Secondary/Admin Actions --}}
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-neutral p-0 rounded-circle shadow-sm transform-hover" 
                                            style="width: 35px; height: 35px;" type="button" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right p-2 shadow-xl border-0" style="border-radius: 12px;">
                                        <a class="dropdown-item has-icon font-weight-600 mb-1 rounded" 
                                           style="padding: 10px;"
                                           href="{{ route('user.cloudapi.edit', $cloudapi->uuid) }}">
                                            <i class="fas fa-edit text-primary"></i> {{ __('Edit Settings') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item has-icon font-weight-600 text-danger rounded delete-confirm" 
                                           style="padding: 10px;"
                                           href="javascript:void(0)" 
                                           data-action="{{ route('user.cloudapi.destroy', $cloudapi->uuid) }}">
                                            <i class="fas fa-trash-alt"></i> {{ __('Remove Device') }}
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 mt-5">
            <div class="card premium-card border-0 shadow-none text-center py-6" style="background: transparent;">
                <div class="card-body">
                    <div class="icon-shape bg-soft-primary text-primary rounded-circle mb-4" style="width: 100px; height: 100px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fas fa-plug fa-3x"></i>
                    </div>
                    <h3 class="text-dark font-weight-800 mb-2">{{ __('No Meta APIs Connected') }}</h3>
                    <p class="text-muted mb-4 mx-auto" style="max-width: 450px;">
                        Connect your official Meta WhatsApp Cloud API to start automating your messaging empire. 
                    </p>
                    <a href="{{ route('user.cloudapi.create') }}" class="btn btn-primary btn-lg shadow-lg rounded-pill px-5">
                        <i class="fas fa-plus mr-2"></i> {{ __('Connect First API Now') }}
                    </a>
                </div>
            </div>
        </div>
        @endforelse

    </div>
</div>

<input type="hidden" id="base_url" value="{{ url('/') }}">
@endsection

@push('js')
<script src="{{ asset('assets/js/pages/user/cloudapi.js') }}"></script>
@endpush

<style>
    .badge-soft-success {
        background-color: rgba(37, 211, 102, 0.1);
        color: #25D366;
    }
    .badge-soft-danger {
        background-color: rgba(245, 54, 92, 0.1);
        color: #f5365c;
    }
    .transform-hover {
        transition: transform 0.2s ease;
    }
    .transform-hover:hover {
        transform: translateY(-2px);
    }
</style>