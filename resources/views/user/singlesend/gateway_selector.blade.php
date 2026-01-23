<div class="form-group mb-3">
    <label class="form-control-label">{{ __('Select Official API') }}</label>
    <select name="cloudapi" class="form-control" required>
        <option value="" disabled selected>{{ __('Select Gateway') }}</option>
        @foreach($cloudapis as $api)
            <option value="{{ $api->id }}">{{ $api->phone ?? $api->name }}</option>
        @endforeach
    </select>
    <input type="hidden" name="gateway_type" value="official">
</div>