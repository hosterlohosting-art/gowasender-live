@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> 'All Templates','buttons'=>[
	[
		'name'=>'<i class="fas fa-plus"></i> &nbspCreate Template',
		'url'=> route('user.template.create'),
	],
	[
        'name' => '<button class="btn btn-primary btn-sm check-status">' . __('Load Meta templates') . '</button>',
        'is_button' => true,
        ],
]])
@endsection
@section('content')

<div class="row justify-content-center">
	<div class="col-12">
		<div class="armi">
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="armi">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 total-transfers" id="total-device">
								   {{ $limit }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-layers mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Total Templates') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="armi">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 total-transfers" id="total-active">
									{{ $active_templates }}
								</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi fi-rs-template mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Active Templates') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card card-stats">
					<div class="card-body">
						<div class="armi">
							<div class="col">
								<span class="h2 font-weight-bold mb-0 completed-transfers" id="total-inactive">
								  {{ $inactive_templates }}
							    </span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
									<i class="fi  fi-rs-template-alt mt-2"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
						</p><h5 class="card-title  text-muted mb-0">{{ __('Inactive Templates') }}</h5>
						<p></p>
					</div>
				</div>
			</div>
		</div>

		@if(count($templates ?? []) == 0)
		<div class="row">
			<div class="col-sm-12">
			<div class="card shadow-lg border-0">
				<div class="card-body py-6 text-center">
					<div class="icon-shape bg-gradient-primary text-white rounded-circle shadow-lg mb-4" style="width: 80px; height: 80px; display: inline-flex; align-items: center; justify-content: center;">
						<i class="fi fi-rs-template fa-3x"></i>
					</div>
					<h4 class="text-dark font-weight-bold mb-2">{{ __('No Templates Found') }}</h4>
					<p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">{{ __('Create reusable message templates to save time.') }}</p>
					<a href="{{ route('user.template.create') }}" class="btn btn-primary btn-lg shadow-lg rounded-pill px-5" 
					   style="background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important; border: none;">
						<i class="fas fa-plus mr-2"></i> {{ __('Create a Template') }}
					</a>
				</div>
			</div>
		</div>
		</div>

		@else
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 table-responsive">
					<div class="form-group">
                             
                                    
                                
								<!--button class="btn btn-primary btn-sm check-status">{{ __('Check') }}</button-->
								<small>{{__(' Note:')}}</small> <small class="text-danger">{{ __('System Only fetch approved template from meta.') }}</small>
                    </div>
					<div id="alertPopup" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
    <span id="alertMessage">Kindly refresh the page to load your templates.</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
											
						<table class="table col-12">
							<thead>
								<tr>
									<th class="col-3">{{ __('Template Name') }}</th>
									<th class="col-2">{{ __('Type') }}</th>
									<th class="col-1">{{ __('Status') }}</th>
									<th class="col-2 text-right">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($templates ?? [] as $template)
									<tr>
										<td>
											{{ $template->title }}
										</td>
										<td>{{ $template->type }}</td>
										<td><span class="badge {{ badge($template->status)['class'] }}">{{ $template->status == 1 ? 'active' : 'inactive'  }}</span> </td>
										<td>
											<div class="btn-group mb-2 float-right">
												<button class="btn btn-neutral btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													{{ __('Action') }}
												</button>
												<div class="dropdown-menu">
													@if($template->type == 'text-with-template')
													<a class="dropdown-item has-icon" href="https://business.facebook.com/wa/manage/message-templates/"><i class="fas fa-pen"></i>{{ __('Edit Template') }}</a>
													@else
													<a class="dropdown-item has-icon" href="{{ route('user.template.edit',$template->id) }}"><i class="fas fa-pen"></i>{{ __('Edit Template') }}</a>
													@endif

													<a class="dropdown-item has-icon show-id" 
													href="javascript:void(0)" 
													data-toggle="modal" 
													data-uuid="{{ $template->uuid }}"
													data-templatename="{{ $template->title }}"
													data-target="#exampleModal"><i class="fas fa-id-card"></i>{{ __('View Template ID') }}</a>

													<a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)" data-action="{{ route('user.template.destroy',$template->id) }}"><i class="fas fa-trash"></i>{{ __('Remove Template') }}</a>
													

												</div>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="d-flex justify-content-center">{{ $templates->links('vendor.pagination.bootstrap-4') }}</div>
					</div>
				</div>
			</div>
		</div>
		
		@endif
	</div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="templateName"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	<label>{{ __('Template ID') }}</label>
        	<input type="text" class="form-control" value="" id="templateid" disabled="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="base_url" value="{{ url('/') }}">
@foreach($cloudapis as $cloudapi)
<input type="hidden" id="cloudapi" value="{{ $cloudapi->id }}">
@endforeach
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/user/template-index.js') }}"></script>
@endpush