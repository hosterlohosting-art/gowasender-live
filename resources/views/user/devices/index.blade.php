@extends('layouts.main.app')

@section('head')
    @include('layouts.main.headersection', [
        'title' => __('WhatsApp Devices (Unofficial)'),
        'buttons' => $buttons ?? []
    ])
@endsection

@section('content')
<div class="row">
    @forelse($devices as $device)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-0 shadow-lg hover-translate-y" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon icon-shape bg-soft-success text-success rounded-circle">
                             <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-icon-only text-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" href="{{ route('user.device.scan', $device->uuid) }}">
                                    <i class="fas fa-qrcode"></i> {{ __('Scan & Connect') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete-confirm text-danger" href="javascript:void(0)" data-action="{{ route('user.device.destroy', $device->uuid) }}">
                                    <i class="fas fa-trash"></i> {{ __('Remove Device') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="h3 font-weight-bold mb-1 text-dark">{{ $device->name }}</h5>
                    <div class="d-flex align-items-center mb-3">
                        @if($device->status == 1)
                            <span class="badge badge-pill badge-success text-xs mr-2">{{ __('Connected') }}</span>
                            <small class="text-muted">{{ $device->phone }}</small>
                        @else
                            <span class="badge badge-pill badge-warning text-xs mr-2">{{ __('Disconnected') }}</span>
                            <small class="text-muted">{{ __('Pending Scan') }}</small>
                        @endif
                    </div>

                    <div class="row align-items-center">
                        <div class="col-12">
                             <a href="{{ route('user.device.scan', $device->uuid) }}" class="btn btn-sm btn-block {{ $device->status == 1 ? 'btn-outline-success' : 'btn-primary' }} rounded-pill">
                                 {{ $device->status == 1 ? __('Manage Connection') : __('Scan QR Code') }} <i class="fas fa-arrow-right ml-1"></i>
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="icon icon-shape bg-soft-primary text-primary rounded-circle mb-4" style="width: 80px; height: 80px; font-size: 40px;">
                <i class="fi fi-rs-sensor-on"></i>
            </div>
            <h4 class="text-dark font-weight-bold">{{ __('No Devices Found') }}</h4>
            <p class="text-muted">{{ __('Add a device to start sending messages via QR code.') }}</p>
            <button class="btn btn-primary rounded-pill px-5" data-toggle="modal" data-target="#addDevice">
                <i class="fas fa-plus mr-2"></i> {{ __('Add New Device') }}
            </button>
        </div>
    @endforelse
</div>

{{-- Add Device Modal --}}
<div class="modal fade" id="addDevice" tabindex="-1" role="dialog" aria-labelledby="addDeviceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0" style="border-radius: 20px;">
            <form method="POST" action="{{ route('user.device.store') }}" class="ajaxform_instant_reload">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title h3 font-weight-bold" id="addDeviceLabel">{{ __('Add WhatsApp Device') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-control-label">{{ __('Device Name') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{ __('e.g. My Personal Mobile') }}" required>
                    </div>
                    <div class="alert bg-soft-info text-info border-0 mb-0" style="border-radius: 12px;">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ __('After creating, you will need to scan a QR code from your phone.') }}
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 basicbtn">{{ __('Create & Scan') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
