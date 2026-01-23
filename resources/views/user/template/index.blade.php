@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',['title'=> 'Message Templates','buttons'=>[
	[
		'name'=>'<i class="fas fa-plus mr-1"></i>'. __('Create Template'),
		'url'=> route('user.template.create'),
        'components' => 'class="btn btn-sm premium-btn premium-btn-primary"'
	],
	[
        'name' => '<i class="fas fa-sync-alt mr-1"></i>' . __('Load Meta Templates'),
        'url' => '#',
        'components' => 'class="btn btn-sm premium-btn btn-white border ml-2 check-status"',
        'is_button' => true,
    ],
]])
@endsection
@section('content')

<div class="row justify-content-center">
	<div class="col-12">
		<div class="row animate-fade-in-up">
			<div class="col-xl-4 col-md-6">
				<div class="card premium-card">
					<div class="card-body p-4">
						<div class="row align-items-center">
							<div class="col">
								<h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Total Templates') }}</h6>
								<span class="h2 font-weight-800 mb-0 total-transfers" id="total-device">{{ $limit }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow-lg">
									<i class="fas fa-layer-group"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-md-6">
				<div class="card premium-card">
					<div class="card-body p-4">
						<div class="row align-items-center">
							<div class="col">
								<h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Active') }}</h6>
								<span class="h2 font-weight-800 mb-0 total-transfers" id="total-active">{{ $active_templates }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow-lg">
									<i class="fas fa-check-circle"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-md-6">
				<div class="card premium-card">
					<div class="card-body p-4">
						<div class="row align-items-center">
							<div class="col">
								<h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Inactive') }}</h6>
								<span class="h2 font-weight-800 mb-0 completed-transfers" id="total-inactive">{{ $inactive_templates }}</span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow-lg">
									<i class="fas fa-times-circle"></i>
								</div>
							</div>
						</div>
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
		<div class="card premium-card mt-4">
            <div class="card-header bg-white border-0 py-3">
                <h3 class="mb-0 font-weight-bold"><i class="fas fa-layer-group text-primary mr-2"></i>{{ __('Templates List') }}</h3>
            </div>
			<div class="card-body p-0">
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
									<th class="col-2">{{ __('WhatsApp API') }}</th>
									<th class="col-2">{{ __('Status') }}</th>
									<th class="col-3 text-right">{{ __('Action') }}</th>
								</tr>
							</thead>
							<tbody class="tbody">
								@foreach($templates ?? [] as $template)
									<tr>
										<td>
											{{ $template->title }}
										</td>
										<td>
											<span class="badge badge-soft-primary text-uppercase">{{ str_replace('-', ' ', $template->type) }}</span>
										</td>
										<td>
											@if($template->cloudapi)
												<div class="d-flex align-items-center">
													<i class="fab fa-whatsapp text-success mr-2"></i>
													<span class="text-xs font-weight-bold">{{ $template->cloudapi->phone ?? $template->cloudapi->name }}</span>
												</div>
											@else
												<span class="text-muted small">{{ __('All/Local') }}</span>
											@endif
										</td>
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