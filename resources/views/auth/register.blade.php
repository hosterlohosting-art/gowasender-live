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
                                <h3 class="font-weight-bold" style="color: #e9edef;">{{ __('Create Account') }}</h3>
                                <small style="color: #8696a0;">{{ __('Sign up to get started') }}</small>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative"
                                        style="background-color: #2a3942; border-radius: 0.5rem; border: 1px solid #2a3942;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="background-color: transparent; border: none; color: #8696a0;"><i
                                                    class="icofont-user-alt-7"></i></span>
                                        </div>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" placeholder="Full Name" required autocomplete="name"
                                            autofocus
                                            style="background-color: transparent; border: none; color: #e9edef; padding-left: 10px;">
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative"
                                        style="background-color: #2a3942; border-radius: 0.5rem; border: 1px solid #2a3942;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="background-color: transparent; border: none; color: #8696a0;"><i
                                                    class="icofont-email"></i></span>
                                        </div>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" placeholder="Email" required autocomplete="email"
                                            style="background-color: transparent; border: none; color: #e9edef; padding-left: 10px;">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative"
                                        style="background-color: #2a3942; border-radius: 0.5rem; border: 1px solid #2a3942;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="background-color: transparent; border: none; color: #8696a0;"><i
                                                    class="icofont-ui-password"></i></span>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Password" name="password" required autocomplete="new-password"
                                            style="background-color: transparent; border: none; color: #e9edef; padding-left: 10px;">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative"
                                        style="background-color: #2a3942; border-radius: 0.5rem; border: 1px solid #2a3942;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="background-color: transparent; border: none; color: #8696a0;"><i
                                                    class="icofont-ui-lock"></i></span>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" placeholder="Confirm Password" required
                                            autocomplete="new-password"
                                            style="background-color: transparent; border: none; color: #e9edef; padding-left: 10px;">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn my-4 shadow-lg"
                                        style="background-color: #00a884; color: #fff; border: none; width: 100%; border-radius: 2rem; font-weight: 600;">{{ __('Sign Up') }}</button>

                                    <div class="text-center mt-3">
                                        <span style="color: #8696a0;">Or</span>
                                    </div>

                                    <a href="{{ route('auth.google') }}" class="btn btn-neutral btn-icon my-3 shadow-none"
                                        style="width: 100%; border-radius: 2rem; background-color: #2a3942; border: 1px solid #2a3942; color: #e9edef;">
                                        <span class="btn-inner--icon"><img
                                                src="{{ asset('assets/img/icons/common/google.svg') }}"
                                                style="width: 20px; vertical-align: middle;"></span>
                                        <span
                                            class="btn-inner--text font-weight-bold ml-2">{{ __('Sign up with Google') }}</span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p style="color: #8696a0;">Already have an account? <a href="{{ route('login') }}"
                                    style="color: #00a884;"><strong>Sign In here</strong></a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection