<div class="form-group mb-3">
    <label class="form-control-label">{{ __('Select Gateway') }}</label>
    <select name="gateway_type" class="form-control gateway_type_selector" required>
        <option value="official" selected>{{ __('Official WhatsApp API') }}</option>
        <option value="unofficial">{{ __('Unofficial WhatsApp (QR Code)') }}</option>
    </select>
</div>

<div class="form-group mb-3 official_gateway_area">
    <label class="form-control-label">{{ __('Select Official API') }}</label>
    <select name="cloudapi" class="form-control">
        @foreach($cloudapis as $api)
            <option value="{{ $api->id }}">{{ $api->phone ?? $api->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group mb-3 unofficial_gateway_area" style="display: none;">
    <label class="form-control-label">{{ __('Select Unofficial Device') }}</label>
    <select name="device" class="form-control">
        @forelse($devices as $device)
            <option value="{{ $device->uuid }}" {{ $device->status != 1 ? 'disabled' : '' }}>
                {{ $device->name }} ({{ $device->status == 1 ? __('Connected') : __('Disconnected') }})
            </option>
        @empty
            <option value="" disabled>{{ __('No devices found') }}</option>
        @endforelse
    </select>
    @if($devices->count() == 0)
        <small class="text-danger"><i class="fas fa-exclamation-triangle mr-1"></i>
            {{ __('Please add a device in "WhatsApp (Unofficial)" section first.') }}</small>
    @endif
</div>