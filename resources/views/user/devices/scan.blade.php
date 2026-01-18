@extends('layouts.main.app')

@section('head')
    @include('layouts.main.headersection', [
        'title' => __('Scan QR Code'),
        'prev' => route('user.device.index')
    ])
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <div class="card border-0 shadow-lg" style="border-radius: 25px;">
            <div class="card-body py-5">
                <h2 class="font-weight-bold mb-4">{{ __('Scan WhatsApp QR Code') }}</h2>
                <p class="text-muted mb-5">{{ __('Open WhatsApp on your phone, tap Menu or Settings, and select Linked Devices.') }}</p>
                
                <div id="qr-container" class="mb-5 d-flex justify-content-center align-items-center" style="min-height: 300px;">
                    <div class="spinner-grow text-primary" role="status" id="qr-spinner">
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </div>
                    <div id="qr-placeholder" class="d-none">
                        <img src="" id="qr-image" style="width: 250px; height: 250px; border-radius: 15px; border: 1px solid #eee;">
                    </div>
                </div>

                <div id="connection-status" class="alert bg-soft-info text-info border-0 d-inline-block px-4 py-2" style="border-radius: 50px;">
                    <i class="fas fa-sync-alt fa-spin mr-2"></i> {{ __('Waiting for QR...') }}
                </div>
            </div>
            <div class="card-footer border-0 bg-soft-light py-4" style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;">
                <p class="mb-0 text-sm">
                    <strong>{{ __('Device ID:') }}</strong> {{ $device->uuid }}
                </p>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="status_url" value="{{ route('user.device.status', $device->uuid) }}">
<input type="hidden" id="qr_url" value="{{ route('user.device.qr', $device->uuid) }}">
<input type="hidden" id="redirect_url" value="{{ route('user.device.index') }}">
@endsection

@push('js')
<script>
    "use strict";

    const qrUrl = $('#qr_url').val();
    const statusUrl = $('#status_url').val();
    const redirectUrl = $('#redirect_url').val();
    let statusInterval;

    loadQR();

    function loadQR() {
        $.ajax({
            type: 'GET',
            url: qrUrl,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#qr-spinner').addClass('d-none');
                    $('#qr-placeholder').removeClass('d-none');
                    $('#qr-image').attr('src', response.qr);
                    $('#connection-status').html('<i class="fas fa-qrcode mr-2"></i> {{ __("QR Code Ready! Please scan.") }}');
                    startStatusCheck();
                } else {
                    $('#connection-status').removeClass('text-info').addClass('text-danger').html('<i class="fas fa-exclamation-triangle mr-2"></i> ' + response.message);
                }
            },
            error: function(xhr) {
                $('#connection-status').removeClass('text-info').addClass('text-danger').html('<i class="fas fa-exclamation-triangle mr-2"></i> {{ __("Failed to load QR code.") }}');
            }
        });
    }

    function startStatusCheck() {
        statusInterval = setInterval(function() {
            $.ajax({
                type: 'GET',
                url: statusUrl,
                dataType: 'json',
                success: function(response) {
                    if (response.connected) {
                        clearInterval(statusInterval);
                        $('#connection-status').removeClass('text-info').addClass('text-success').html('<i class="fas fa-check-circle mr-2"></i> {{ __("Connected Successfully!") }}');
                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 2000);
                    }
                }
            });
        }, 3000);
    }
</script>
@endpush
