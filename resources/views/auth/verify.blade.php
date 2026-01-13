@extends('frontend.layouts.main')

@section('content')
    <div class="full_bg"
        style="background-color: #111b21; position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        <!-- Doodle Background Overlay -->
        <div
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ asset('assets/img/whatsapp-bg.png') }}'); opacity: 0.08; pointer-events: none;">
        </div>

        <div class="container" style="position: relative; z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="text-center mb-4">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/img/brand/white.png') }}" alt="logo" style="max-height: 60px;">
                        </a>
                    </div>

                    <div class="card border-0 shadow-lg" style="background-color: #202c33; border-radius: 1rem;">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center mb-4">
                                <h3 class="font-weight-bold" style="color: #e9edef;">{{ __('Security Verification') }}</h3>
                                <small style="color: #8696a0;">{{ __('Enter the code sent to your email') }}</small>
                            </div>

                            @if(session()->has('message'))
                                <div class="alert alert-info" style="background-color: #2a3942; border: none; color: #00a884;">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <form role="form" method="POST" action="{{ route('verify.store') }}">
                                @csrf

                                <div class="form-group mb-4">
                                    <div class="input-group input-group-merge input-group-alternative"
                                        style="background-color: #2a3942; border-radius: 0.5rem; border: 1px solid #2a3942;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="background-color: transparent; border: none; color: #00a884; font-size: 1.2rem; font-weight: bold;">
                                                <i class="ni ni-lock-circle-open"></i>
                                            </span>
                                        </div>
                                        <input class="form-control @error('two_factor_code') is-invalid @enderror"
                                            placeholder="######" type="text" name="two_factor_code" required autofocus
                                            maxlength="6"
                                            style="background-color: transparent; border: none; color: #e9edef; font-size: 1.5rem; letter-spacing: 0.5rem; text-align: center; font-weight: bold;">

                                        @error('two_factor_code')
                                            <span class="invalid-feedback d-block text-center mt-2" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="custom-control custom-control-alternative custom-checkbox mb-3 text-center">
                                    <input class="custom-control-input" id="rememberDevice" type="checkbox"
                                        name="remember_device" value="1">
                                    <label class="custom-control-label" for="rememberDevice">
                                        <span style="color: #8696a0;">{{ __('Don\'t ask again on this device') }}</span>
                                    </label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn my-4 shadow-lg"
                                        style="background-color: #00a884; color: #fff; border: none; width: 100%; border-radius: 2rem; font-weight: 600;">
                                        {{ __('Verify Code') }}
                                    </button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('verify.resend') }}"
                                        style="color: #8696a0; text-decoration: underline;"><small>{{ __('Didn\'t receive code? Resend') }}</small></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection