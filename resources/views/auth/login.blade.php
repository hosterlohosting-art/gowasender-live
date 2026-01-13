@extends('frontend.layouts.main')
@section('content')

<div class="full_bg" style="background-color: #111b21; position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
    <!-- Doodle Background Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ asset('assets/img/whatsapp-bg.png') }}'); opacity: 0.08; pointer-events: none;"></div>

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
                            <h3 class="font-weight-bold" style="color: #e9edef;">{{ __('Welcome Back!') }}</h3>
                            <small style="color: #8696a0;">{{ __('Login to your account') }}</small>
                        </div>

                        @if(session('auth-error'))
                            <div class="alert alert-danger" role="alert">
                                <strong>{{ session('auth-error') }}</strong>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative" style="background-color: #2a3942; border-radius: 0.5rem; border: 1px solid #2a3942;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: transparent; border: none; color: #8696a0;"><i class="icofont-email"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus style="background-color: transparent; border: none; color: #e9edef; padding-left: 10px;">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative" style="background-color: #2a3942; border-radius: 0.5rem; border: 1px solid #2a3942;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: transparent; border: none; color: #8696a0;"><i class="icofont-ui-password"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password" style="background-color: transparent; border: none; color: #e9edef; padding-left: 10px;">
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span style="color: #8696a0;">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn my-4 shadow-lg" style="background-color: #00a884; color: #fff; border: none; width: 100%; border-radius: 2rem; font-weight: 600;">{{ __('Sign in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="color: #8696a0;"><small>{{ __('Forgot password?') }}</small></a>
                        @endif
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ url('/pricing') }}" style="color: #00a884;"><small>{{ __('Create new account') }}</small></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection