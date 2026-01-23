@extends('layouts.main.app')

@section('head')
    {{-- Ideally, pass $buttons from the Controller. If you must keep it here, this is fine. --}}
    @include('layouts.main.headersection', [
        'title' => __('WhatsApp API'),
        'buttons' => [
            [
                'name' => '<i class="fas fa-plus"></i> ' . __('Add New API'),
                'url' => route('user.cloudapi.create'),
            ]
        ]
    ])
@endsection

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        
        {{-- @forelse handles the loop AND the empty state in one go --}}
        @forelse($cloudapis as $cloudapi)
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12 layout-spacing">
                <div class="row">
                    {{-- Webhook Widget --}}
                    <div class="col-md-12">
                        <div class="widget dashboard-table bg-light-warning">
                            <div class="widget-content">
                                <a href="{{ route('user.cloudapi.hook', $cloudapi->uuid) }}" class="box">
                                    <div class="box-body">
                                        <span class="text-warning font-45"><i class="fa fa-chart-bar"></i></span>
                                        <div class="text-warning stronger font-17 mb-2"> {{ __('Meta Webhook') }}</div>
                                        <div class="text-dark"> {{ __('Configure it from here') }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Messages Widget --}}
                    <div class="col-md-12 mt-4">
                        <div class="widget dashboard-table">
                            <div class="widget-content">
                                <a href="{{ url('/user/cloudapi/chats/'.$cloudapi->uuid) }}" class="box">
                                    <div class="box-body">
                                        <span class="text-primary font-45"><i class="fa fa-comments"></i></span>
                                        <div class="text-primary stronger font-17 mb-2"> {{ __('Messages') }}</div>
                                        <div class="text-dark"> {{ __('Start the Conversation') }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Logs Widget --}}
                    <div class="col-md-12 mt-4">
                        <div class="widget dashboard-table bg-light-info">
                            <div class="widget-content">
                                <a href="{{ route('user.cloudapi.show', $cloudapi->uuid) }}" class="box">
                                    <div class="box-body">
                                        <span class="text-info font-45"><i class="fa fa-globe-americas"></i></span>
                                        <div class="text-info stronger font-17 mb-2"> {{ __('Logs') }}</div>
                                        <div class="text-dark"> {{ __('View Message Logs') }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Info Card --}}
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-three widget-best-seller">
                    <div class="widget-heading mb-0"></div>
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="fab fa-whatsapp font-45 text-success"></i>
                        </div>
                        <h3>
                            @if(!empty($cloudapi->phone))
                                <a href="{{ route('user.cloudapi.hook', $cloudapi->uuid) }}">{{ $cloudapi->phone }}</a>
                            @endif
                        </h3>
                        <p> {{ $cloudapi->name }}</p>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-centered table-nowrap mb-2">
                            <tbody>
                                <tr>
                                    <td style="width: 30%;"><p class="mb-0"> {{ __('Total Messages') }}</p></td>
                                    {{-- Ensure 'smstransaction_count' is eager loaded in controller --}}
                                    <td style="width: 25%;"><h5 class="mb-0"> {{ number_format($cloudapi->smstransaction_count ?? 0) }}</h5></td>
                                    <td>
                                        <div class="bg-transparent progress"><div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"></div></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p class="mb-0"> {{ __('Status') }}</p></td>
                                    <td><h5 class="mb-0"> {{ $cloudapi->status == 1 ? __('Active') : __('Inactive') }} </h5></td>
                                    <td>
                                        <div class="bg-transparent progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p class="mb-0"> {{__('Graph API')}}</p></td>
                                    <td><h5 class="mb-0"> 20.0 </h5></td>
                                    <td>
                                        <div class="bg-transparent progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"></div></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Actions (Edit/Delete) --}}
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 layout-spacing">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget widget-chart-two bg-violet">
                            <div class="widget-heading pt-4 mb-0"><h5 class="text-white pt-5"> {{ __('Profile & Keys') }}</h5></div>
                            <div class="widget-content mt-4 pr-3 pl-3">
                                <p class="py-15 font-15 text-white mb-4"> {{ __('Edit Your WhatsApp Profile, Account Token and Keys') }}</p>
                                <a href="{{ route('user.cloudapi.edit', $cloudapi->uuid) }}" class="btn btn-sm btn-white text-primary"> {{ __('Edit WhatsApp') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="widget widget-chart-two bg-danger">
                            <div class="widget-heading pt-4 mb-0"><h5 class="text-white pt-5"> {{ __('Remove API') }}</h5></div>
                            <div class="widget-content mt-4 pr-3 pl-3">
                                <p class="py-15 font-15 text-white mb-4"> {{ __('Do You really Want to remove Your WhatsApp API?') }}</p>
                                {{-- Ensure 'delete-confirm' class is handled in JS with CSRF --}}
                                <a href="javascript:void(0)" data-action="{{ route('user.cloudapi.destroy', $cloudapi->uuid) }}" class="btn btn-sm btn-white text-danger delete-confirm"> {{ __('Remove Now') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            {{-- This runs if $cloudapis is empty --}}
            <div class="col-md-6 mt-4">
                <div class="widget widget-chart-one bg-gradient-secondary">
                    <div class="widget-heading">
                        <h5 class="text-white"> {{ __('Alert') }}</h5>
                    </div>
                    <div class="widget-content">
                        <h6 class="text-white"> {{ __('Opps There Is No CloudApi Found....') }}</h6>
                        <span class="text-white font-13"> {{ __('Configure WhatsApp API ') }}  </span>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget iq-card dash-hover-blank d-flex align-items-center iq-card-block iq-card-stretch iq-card-height p-4">
                    <div class="iq-card-body text-center w-100">
                        <i class="fas fa-plug font-45 text-muted mb-3"></i>
                        <h5 class="text-muted"> {{ __('No more APIs found.') }}</h5>
                        <p class="small text-muted mb-0">{{ __('Use the button in the header to add more.') }}</p>
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