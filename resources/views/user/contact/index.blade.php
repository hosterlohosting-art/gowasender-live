@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title' => __('Contacts Book'),
'buttons' =>[
	[
		'name'=>'<i class="fas fa-plus mr-1"></i>'. __('Create Contact'),
		'url'=> route('user.contact.create'),
        'components' => 'class="btn btn-sm premium-btn premium-btn-primary"'
	],
	[
		'name'=>'<i class="fas fa-users mr-1"></i>'. __('Groups'),
		'url'=> route('user.group.index'),
        'components' => 'class="btn btn-sm premium-btn btn-white border ml-2"'
	],
	[
		'name'=>'<i class="fas fa-file-import mr-1"></i>'. __('Import'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#import-contact" class="btn btn-sm premium-btn btn-white border ml-2"', 
		'is_button'=>true
	]
]])
@endsection
@push('topcss')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">

@endpush
@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="row animate-fade-in-up">
			<div class="col-xl-6">
				<div class="card premium-card">
					<div class="card-body p-4">
						<div class="row align-items-center">
							<div class="col">
								<h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Total Contacts') }}</h6>
								<span class="h2 font-weight-800 mb-0 total-transfers" id="total-device">{{ $total_contacts }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow-lg">
									<i class="fas fa-address-book"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6">
				<div class="card premium-card">
					<div class="card-body p-4">
						<div class="row align-items-center">
							<div class="col">
								<h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Plan Limit') }}</h6>
								<span class="h2 font-weight-800 mb-0 total-transfers" id="total-active">{{ $limit }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow-lg">
									<i class="fas fa-id-card"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@if(count($contacts ?? []) > 0)
		<div class="card premium-card mt-4 overflow-hidden border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 font-weight-800 text-dark">
                    <i class="fas fa-user-friends text-success mr-2"></i>{{ __('Verified Contacts') }}
                </h3>
                <div class="badge badge-soft-primary px-3 py-2 rounded-pill font-weight-bold">
                    {{ count($contacts) }} {{ __('Total') }}
                </div>
            </div>
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider">{{ __('Contact Details') }}</th>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">{{ __('Groups') }}</th>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-right">{{ __('Whatsapp Number') }}</th>
							<th scope="col" class="text-right"></th>
						</tr>
					</thead>
					<tbody class="list">
						@foreach($contacts ?? [] as $contact)
						<tr>
							<td>
								<div class="d-flex align-items-center">
									<div class="avatar avatar-sm rounded-circle bg-soft-primary text-primary mr-3 font-weight-bold">
										{{ strtoupper(substr($contact->name, 0, 1)) }}
									</div>
									<span class="mb-0 text-sm font-weight-700 text-dark">{{ $contact->name }}</span>
								</div>
							</td>
							<td class="text-center">
								@foreach($contact->groupcontact as $groupcontact)
								<span class="badge badge-pill badge-soft-success font-weight-bold mx-1" style="background: rgba(37, 211, 102, 0.1); color: #128C7E;">{{ $groupcontact->name }}</span>
								@endforeach
							</td>
							<td class="text-right font-weight-700 text-dark">
								<i class="fab fa-whatsapp text-success mr-1"></i> {{ $contact->phone }}
							</td>									
							<td class="text-right">
								<div class="dropdown">
									<button class="btn btn-sm btn-icon-only text-light shadow-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="fas fa-ellipsis-v"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-right shadow border-0">
										<a class="dropdown-item edit-contact py-2" href="#" 
											data-action="{{ route('user.contact.update',$contact->id) }}" 
											data-name="{{ $contact->name }}"  
											data-phone="{{ $contact->phone }}"
											data-groupid="{{ $contact->groupcontact[0]->id ?? '' }}"
											data-param = "{{ implode(',', array_filter([$contact->param1, $contact->param2, $contact->param3, $contact->param4, $contact->param5, $contact->param6, $contact->param7])) }}"
											data-toggle="modal" 
											data-target="#editModal"
										>
											<i class="fas fa-edit text-primary mr-3"></i>{{ __('Edit Contact') }}
										</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete-confirm py-2 text-danger" href="javascript:void(0)" data-action="{{ route('user.contact.destroy',$contact->id) }}">
											<i class="fas fa-trash-alt mr-3"></i>{{ __('Remove Number') }}
										</a>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer bg-white border-0 py-4">
				<div class="d-flex justify-content-end">{{ $contacts->links('vendor.pagination.bootstrap-4') }}</div>
			</div>
		</div>
		@else
		<div class="card premium-card border-0 shadow-sm mt-4">
			<div class="card-body py-7 text-center">
				<div class="icon-shape bg-soft-success text-success rounded-circle shadow-lg mb-4 mx-auto" style="width: 100px; height: 100px; display: inline-flex; align-items: center; justify-content: center;">
					<i class="fas fa-address-book fa-3x"></i>
				</div>
				<h2 class="text-dark font-weight-800 mb-2">{{ __('Start Your Audience') }}</h2>
				<p class="text-muted mb-5 mx-auto" style="max-width: 500px;">{{ __('Your contact book is empty. Import your existing customers or add new ones manually to begin your automation journey.') }}</p>
				<div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
					<a href="{{ route('user.contact.create') }}" class="btn premium-btn premium-btn-primary mb-3 mb-sm-0 mx-2">
						<i class="fas fa-plus mr-2"></i> {{ __('Create Contact') }}
					</a>
					<a href="#" data-toggle="modal" data-target="#import-contact" class="btn premium-btn btn-white border mx-2">
						<i class="fas fa-file-import mr-2"></i> {{ __('Import CSV') }}
					</a>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form type="POST" action="" class="edit-modal ajaxform_instant_reload">
				@csrf
				@method('PUT')

				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Contact') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>{{ __('User Name') }}</label>
						<input type="text" name="name" id="user_name" placeholder="Jhone Doe" maxlength="50" class="form-control" required="">
					</div>
					<div class="form-group">
						<label>{{ __('Whatsapp Number') }}</label>
						<input type="number" name="phone" id="user_phone" placeholder="{{ __('Enter Phone Number With Country Code') }}" maxlength="15" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ __('Parameters') }}</label>
						<input type="text" name="param" id="paramInput" placeholder="{{ __('param1, param2, param3, param4 ......') }}" class="form-control" oninput="limitParameters()">
                        <small class="text-danger" id="paramErrorMessage">You can add up to 7 parameters here with a comma</small>
					</div>
					<div class="form-group">
						<label>{{ __('Select Group') }}</label>
						<select name="group" class="form-control" id="group-list">
							@foreach($groups as $group)
							<option value="{{ $group->id }}">{{ $group->name }}</option>
							@endforeach
						</select>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary submit-btn">{{ __('Save changes') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="import-contact" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form type="POST" action="{{ route('user.contact.import') }}" class="ajaxform" enctype="multipart/form-data">
				@csrf
				

				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ __('Import Contact') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>{{ __('Select CSV') }} <a href="{{ asset('uploads/demo-contact.csv') }}" download="">{{ __('(Download Sample)')  }}</a></label>
						<input type="file" accept=".csv" name="file"  class="form-control" required="">
					</div>	

					<div class="form-group">
						<label>{{ __('Select Group') }}</label>
						<select name="group" class="form-control" >
							@foreach($groups as $group)
							<option value="{{ $group->id }}">{{ $group->name }}</option>
							@endforeach
						</select>
					</div>									
				</div>

				

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
					<button type="submit" class="btn btn-primary submit-btn">{{ __('Import') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection
@push('topjs')
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
@endpush
@push('js')
<script>
    // Submit the form when it's ready
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.bulk_send_form');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Submit the form using AJAX
            sendFormWithAjax();
        });
    });

    function sendFormWithAjax() {
        const form = document.querySelector('.bulk_send_form');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Redirecting to bulk sending page' && data.redirect) {
                // Redirect to the URL provided in the JSON response
                window.location.href = data.redirect;
            } else {
                // Handle other responses or errors here
                console.error('Unexpected response:', data);
            }
        })
        .catch(error => {
            // Handle fetch errors here
            console.error('Fetch error:', error);
        });
    }
</script>
<script>
    function limitParameters() {
        var input = document.getElementById("paramInput");
        var errorMessage = document.getElementById("paramErrorMessage");
        
        // Splitting the input value by commas and counting the number of parameters
        var parameterCount = input.value.split(",").length;
        
        // Display an error message if more than 7 parameters are entered
        if (parameterCount > 7) {
            errorMessage.style.display = "block";
            input.value = input.value.substring(0, input.value.lastIndexOf(","));
        } else {
            errorMessage.style.display = "none";
        }
    }
</script>
<script src="{{ asset('assets/js/pages/user/contact.js') }}"></script>
@endpush
