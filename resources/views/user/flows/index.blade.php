@extends('layouts.main.app')

@section('head')
    <title>My Automation Flows | Digioverse</title>
@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Automation Flows</h1>
                <div class="section-header-button">
                    <a href="{{ route('user.flows.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create
                        New Flow</a>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    @forelse($flows as $flow)
                        <div class="col-xl-4 col-md-6 mb-4 animate-fade-in-up"
                            style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="card premium-card h-100 shadow-sm border-0">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="icon icon-shape bg-soft-success text-success rounded-circle shadow-sm">
                                            <i class="fas fa-project-diagram"></i>
                                        </div>
                                        @if($flow->status)
                                            <span class="badge badge-pill badge-success shadow-none font-weight-bold"
                                                style="background: rgba(37, 211, 102, 0.1); color: #128C7E;">{{ __('ACTIVE') }}</span>
                                        @else
                                            <span class="badge badge-pill badge-danger shadow-none font-weight-bold"
                                                style="background: rgba(234, 67, 53, 0.1); color: #ea4335;">{{ __('INACTIVE') }}</span>
                                        @endif
                                    </div>

                                    <h4 class="h3 font-weight-800 text-dark mb-1">{{ $flow->name }}</h4>

                                    @if($flow->device_name)
                                        <div class="mb-2">
                                            <span class="badge badge-pill badge-primary-soft text-primary font-weight-bold"
                                                style="font-size: 0.7rem;">
                                                <i class="fab fa-whatsapp mr-1"></i> {{ __('Assigned to:') }}
                                                {{ $flow->device_name }} ({{ $flow->device_phone }})
                                            </span>
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <span class="badge badge-pill badge-soft-warning text-warning font-weight-bold"
                                                style="font-size: 0.7rem;">
                                                <i class="fas fa-exclamation-triangle mr-1"></i> {{ __('Unassigned') }}
                                            </span>
                                        </div>
                                    @endif

                                    <p class="text-muted small mb-4">
                                        <i class="far fa-clock mr-1"></i> {{ __('Updated') }}
                                        {{ \Carbon\Carbon::parse($flow->updated_at)->diffForHumans() }}
                                    </p>

                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ route('user.flows.edit', $flow->id) }}"
                                                class="btn btn-sm btn-white border shadow-none rounded-pill px-3">
                                                <i class="fas fa-edit mr-1"></i> {{ __('Edit') }}
                                            </a>
                                            <a href="{{ route('user.flows.delete', $flow->id) }}"
                                                class="btn btn-sm btn-outline-danger shadow-none rounded-pill px-3 ml-2 delete-confirm">
                                                <i class="fas fa-trash mr-1"></i> {{ __('Delete') }}
                                            </a>
                                        </div>

                                        <a href="{{ route('user.flows.edit', $flow->id) }}"
                                            class="btn btn-icon-only btn-neutral rounded-circle shadow-none">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card premium-card border-0 text-center py-6">
                                <div class="card-body">
                                    <div class="icon-shape bg-soft-primary text-primary rounded-circle shadow-lg mb-4 mx-auto"
                                        style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-magic fa-3x"></i>
                                    </div>
                                    <h2 class="text-dark font-weight-800 mb-2">{{ __('No Automation Flows Yet') }}</h2>
                                    <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                                        {{ __('Create your first automated flow to engage with your customers 24/7. Turn conversations into conversions effortlessly.') }}
                                    </p>
                                    <a href="{{ route('user.flows.create') }}"
                                        class="btn premium-btn premium-btn-primary shadow-lg">
                                        <i class="fas fa-plus mr-2"></i> {{ __('Create Your First Flow') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection