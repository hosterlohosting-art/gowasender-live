@extends('layouts.main.app')
@section('head')
    @include('layouts.main.headersection', [
        'title' => __('WhatsApp Devices'),
        'buttons' => []
    ])
@endsection
@section('content')

               <div class="row">
        <div class="col-12 text-center py-5">
            <div class="icon icon-shape bg-soft-primary text-primary rounded-circle mb-4" style="width: 80px; height: 80px; font-size: 40px;">
                <i class="fab fa-w
                hatsapp"></i>

                    </div>
            <h4 class="text-dark font-weight-bold">{{ __('Unofficial API Discontinued') }}</h4>
            <p class="text-muted">{{ __('We have moved exclusively to the Official WhatsApp Cloud API for better security and reliability.') }}</p>
            <a href="{{ route('user.cloudapi.index') }}" class="btn btn-primary rounded-pill px-5">
                <i class="fas fa-rocket mr-2"></i> {{ __('Go to Official Cloud API') }}
            </a>
        </div>    </div>
@endsection
@endsection
