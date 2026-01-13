@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'=> __('Update Addons'),
'buttons'=>[
	[
		'name'=>__('Back'),
		'url'=>route('admin.page.index'),
	]
 ]
])
@endsection
@section('content')

	<div class="row justify-content-center">
		<div class="col-lg-10 card-wrapper">	
			@if(Session::has('error'))
			<div class="alert bg-gradient-danger text-white alert-dismissible fade show success-alert" role="alert">
			<span class="alert-text">{{ Session::get('error') }}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		   </div>
		   @endif

		   @if(Session::has('success'))
			<div class="alert bg-gradient-success text-white alert-dismissible fade show success-alert" role="alert">
			<span class="alert-text">{{ Session::get('success') }}</span>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		   </div>
		   @endif

		   @if(!Session::has('update-data'))
			<!-- Alerts -->
			<div class="card">
				<div class="card-header">
					<div class="row w-100">
						<div class="col-6">
							<h3 class="mb-0">{{ __('Actiavte Addons') }}</h3>
						</div>
					

						<div class="col-6">
							<h3 style="color:blue; text-decoration:underline;" class="float-right"><a target="_blank" href="https://ionfirm.com/shop">Click Here to Purchase Addons for WhatsCloud</a></h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					
		
										
						<form class="update_form" method="post" action="{{ route('admin.addons.store') }}">
							@csrf
							
							<div class="form-group">
						<label>{{ __('Purchase Key') }}</label>
						<input type="text" name="purchase_key" value="" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Addon Code') }}</label>
						<input type="text" name="addoncode" value="" class="form-control">
					</div>
						<div class="form-group">
						<label>{{ __('Addon Version') }}</label>
						<input type="text" name="version" value="" class="form-control">
					</div>
							<div class="from-group  mt-3">	
							<button class="btn btn-neutral btn-sm float-right submit-btn"><i class="fi fi-rs-download"></i> {{ __('Activate now') }}</button>
						</div>
						</form>
					
				</div>
			</div>
			@endif
			
			<div class="alert bg-gradient-primary text-white alert-dismissible fade show success-alert" role="alert">
				<span class="alert-text"><strong>{{ __('Note') }}</strong> {{ __('If you have customised the script from codebase do not use this option. you will lose your customization.') }} </span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			

		</div>		
	</div>

@endsection
@push('js')
<script type="text/javascript">
	"use strict";



let $update_form = $('.update_form');
let $updateLoader = '<div class="spinner-border spinner-border-sm" role="status">' +
    '<span class="visually-hidden">please wait...</span>' +
    '</div>';
$update_form.initFormValidation();

$(document).on('submit', '.update_form', function (e) {
	e.preventDefault();

	Swal.fire({
		title: 'Note!',
		text: "Before sent a request for new Addon please take a backup of your site with database.",
		icon: 'warning',
		confirmButtonText: 'Procced for activate',
		showCancelButton: true,
		confirmButtonColor: '#6777ef',
		cancelButtonColor: '#fc544b',
	}).then((result) => {
		if (result.value) {

			 let $this = $(this);
    let $submitBtn = $this.find('.submit-btn');
    let $oldSubmitBtn = $submitBtn.html();

    if ($update_form.valid()) {
        $.ajax({
            type: 'POST',
            url: this.action,
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $submitBtn.html($updateLoader).addClass('disabled').attr('disabled', true);
            },
            success: function (res) {
                $submitBtn.html($oldSubmitBtn).removeClass('disabled').attr('disabled', false);
                window.sessionStorage.hasPreviousMessage = true;
                window.sessionStorage.previousMessage = res.message ?? null;

                if (res.redirect) {
                    location.href = res.redirect;
                }
            },
            error: function (xhr) {
                $submitBtn.html($oldSubmitBtn).removeClass('disabled').attr('disabled', false);
                NotifyAlert('error', xhr.responseJSON);
                showInputErrors(xhr.responseJSON);
            }
        });
      }
		}
	});
});

</script>
@endpush