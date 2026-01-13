@extends('frontend.layouts.main')
@section('content')

  <div class="full_bg"
    style="background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="text-center mb-4">
            <a href="{{ url('/') }}">
              <img src="{{ asset('assets/img/brand/white.png') }}" alt="logo" style="max-height: 60px;">
            </a>
          </div>

          <div class="card bg-secondary border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <h3 class="text-dark font-weight-bold">{{ __('Welcome Back!') }}</h3>
                <small>{{ __('Login to your account') }}</small>
              </div>

              @if(session('auth-error'))
                <div class="alert alert-danger" role="alert">
                  <strong>{{ session('auth-error') }}</strong>
                </div>
              @endif

              <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative"
                    style="box-shadow: 0 1px 3px rgba(50,50,93,.15), 0 1px 0 rgba(0,0,0,.02);">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="icofont-email"></i></span>
                    </div>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                      value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus
                      style="padding-left: 10px;">
                  </div>
                  @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative"
                    style="box-shadow: 0 1px 3px rgba(50,50,93,.15), 0 1px 0 rgba(0,0,0,.02);">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="icofont-ui-password"></i></span>
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                      placeholder="Password" name="password" required autocomplete="current-password"
                      style="padding-left: 10px;">
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
                    <span class="text-muted">{{ __('Remember me') }}</span>
                  </label>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4 shadow-lg"
                    style="background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important; border: none; width: 100%;">{{ __('Sign in') }}</button>
                </div>
              </form>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-6">
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-light"><small>{{ __('Forgot password?') }}</small></a>
              @endif
            </div>
            <div class="col-6 text-right">
              <a href="{{ url('/pricing') }}" class="text-light"><small>{{ __('Create new account') }}</small></a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection