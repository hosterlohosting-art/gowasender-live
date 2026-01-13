@extends('frontend.layouts.main')
@section('content')

    <div class="full_bg">
        <div class="container">
            <section class="signup_section">

                <div class="top_part">

                    <a href="{{ url('/') }}" class="back_btn"><i class="icofont-arrow-left"></i> Back</a>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset(get_option('primary_data', true)->logo ?? '') }}" alt="image">
                    </a>
                </div>

                <div class="signup_form">
                    <div class="section_title">
                        <h2>{{ __('Create') }}<span> {{ __('Account') }} </span></h2>
                        <p>{{ __('Sign up to get started') }}</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name"
                                autofocus>
                            @error('name')
                                <span style="display:block !important" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                            @error('email')
                                <span style="display:block !important" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <span style="display:block !important" class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                placeholder="Confirm Password" required autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <button class="btn puprple_btn" type="submit">SIGN UP</button>
                        </div>
                    </form>
                    <p class="or_block">
                        <span>OR</span>
                    </p>
                    <div class="or_option">
                        <p>Already have an account? <a href="{{ route('login') }}">Sign In here</a></p>
                    </div>
                </div>
            </section>
        </div>

    </div>
@endsection