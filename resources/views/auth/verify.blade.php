@extends('layouts.main.app')

@section('head')
    <div class="header" style="background: transparent !important; padding-top: 10px; padding-bottom: 0px;">
        <div class="container-fluid">
            <div class="header-body">
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0" style="border-radius: 20px;">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>Two Factor Verification</small>
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-info">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <form role="form" method="POST" action="{{ route('verify.store') }}">
                            @csrf
                            <p class="text-center text-muted">
                                You have received a verification code to your email.
                            </p>
                            <div class="form-group mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control @error('two_factor_code') is-invalid @enderror"
                                        placeholder="Two Factor Code" type="text" name="two_factor_code" required autofocus>
                                    @error('two_factor_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">Verify</button>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('verify.resend') }}" class="text-light"><small>Resend Code?</small></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection