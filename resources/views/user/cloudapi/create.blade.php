@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'Back',
		'url'=> route('user.cloudapi.index'),
	]
]])
@endsection
@section('content')
@if(env('MAIL_VERIFICATION') == true)
@if($users->email_verified_at != NULL)
@if(Session::has('new-user'))
<div class="row justify-content-center">
	<div class="col-sm-12">
		<div class="alert bg-gradient-primary text-white alert-dismissible fade show success-alert" role="alert">
			<span class="alert-text"><strong>{{ __('Hi. ').Auth::user()->name }}</strong> {{ __('Welcome to ').env('APP_NAME') }} {{ Session::get('new-user') }}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	</div>  
	@endif    
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Add CloudApi') }}</h4>
			</div>
			<div class="card-body">
				<form method="POST" class="ajaxform_instant_reload" action="{{ route('user.cloudapi.store') }}">
					@csrf
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WhatsApp Phone Number') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="phone" placeholder="Your WhatsApp Number " class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WhatsApp User Name') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="name" placeholder="It can be anything....." class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WA Phone Number ID') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="phone_number_id" placeholder="109058942226782" class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WA Business ID') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="wa_business_id" placeholder="109058942226782" class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Applicaton ID') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="meta_app_id" placeholder="109058942226782" class="form-control">
						</div>
					</div>
					
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WA Access Token') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="access_token" placeholder="EAALXhdrLgPABABttsp9TkYZ......." class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
						<div class="col-sm-12 col-md-7">
							<button type="submit" class="btn btn-outline-primary submit-btn">{{ __('Create Now') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	@else
	<div class="col-sm-12">
		<div class="alert bg-gradient-primary text-white alert-dismissible fade show success-alert" role="alert" style="background:linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important">
			<span class="alert-text"><strong>{{ __('Hi. ').Auth::user()->name }}</strong> {{ __('Check your mail inbox and Please verify your email first.') }}</span>
			<form id="resendVerificationForm" action="{{ route('verification.resend') }}" method="post">
    @csrf
    <button type="submit" class="btn btn-primary">Resend Verification Email</button>
</form>

<script>
    document.getElementById('resendVerificationForm').addEventListener('submit', function(event) {
        event.preventDefault();

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                alert('Verification email sent successfully.');
            } else {
                throw new Error('Failed to resend verification email. Try after 2 min');
            }
        })
        .catch(error => {
            console.error(error);
            alert('Failed to resend verification email. Please try again later.');
        });
    });
</script>
			</button>
		</div>
	</div>  
</div>
@endif
@else
@if(Session::has('new-user'))
<div class="row justify-content-center">
	<div class="col-sm-12">
		<div class="alert bg-gradient-primary text-white alert-dismissible fade show success-alert" role="alert">
			<span class="alert-text"><strong>{{ __('Hi. ').Auth::user()->name }}</strong> {{ __('Welcome to ').env('APP_NAME') }} {{ Session::get('new-user') }}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	</div>  
	@endif    
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>{{ __('Add CloudApi') }}</h4>
			</div>
			<div class="card-body">
				<form method="POST" class="ajaxform_instant_reload" action="{{ route('user.cloudapi.store') }}">
					@csrf
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WhatsApp Phone Number') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="phone" placeholder="Your WhatsApp Number " class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WhatsApp User Name') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="name" placeholder="It can be anything....." class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WA Phone Number ID') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="phone_number_id" placeholder="109058942226782" class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WA Business ID') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="wa_business_id" placeholder="109058942226782" class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Meta Applicaton ID') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="meta_app_id" placeholder="109058942226782" class="form-control">
						</div>
					</div>
					
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('WA Access Token') }}</label>
						<div class="col-sm-12 col-md-7">
							<input type="text" name="access_token" placeholder="EAALXhdrLgPABABttsp9TkYZ......." class="form-control">
						</div>
					</div>
					<div class="form-group row mb-4">
						<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
						<div class="col-sm-12 col-md-7">
							<button type="submit" class="btn btn-outline-primary submit-btn">{{ __('Create Now') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endif
@endsection