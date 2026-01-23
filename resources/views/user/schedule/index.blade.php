@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title'   => __('Message Scheduling'),
'buttons' =>[
	[
	'name'=>'<i class="fas fa-calendar-plus mr-1"></i>'. __('Create Schedule'),
	'url'=> route('user.schedule-message.create'),
    'components' => 'class="btn btn-sm premium-btn premium-btn-primary"'
	]
]])
@endsection
@section('content')
<div class="row justify-content-center">
	<div class="col-12">
		<div class="row animate-fade-in-up">
			<div class="col-xl-3 col-md-6">
				<div class="card premium-card border-0 shadow-sm">
					<div class="card-body p-4">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">{{ __('Total') }}</h6>
								<span class="h1 font-weight-800 mb-0 text-dark">{{ number_format($totalSchedule ?? 0) }}</span>
							</div>
							<div class="icon icon-shape bg-soft-primary text-primary rounded-circle shadow-sm">
								<i class="fas fa-calendar-alt"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-md-6">
				<div class="card premium-card border-0 shadow-sm">
					<div class="card-body p-4">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">{{ __('Pending') }}</h6>
								<span class="h1 font-weight-800 mb-0 text-dark">{{ number_format($pendingSchedule ?? 0) }}</span>
							</div>
							<div class="icon icon-shape bg-soft-warning text-warning rounded-circle shadow-sm">
								<i class="fas fa-clock"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-md-6">
				<div class="card premium-card border-0 shadow-sm">
					<div class="card-body p-4">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">{{ __('Executed') }}</h6>
								<span class="h1 font-weight-800 mb-0 text-dark">{{ number_format($deliveredSchedule?? 0)  }}</span>
							</div>
							<div class="icon icon-shape bg-soft-success text-success rounded-circle shadow-sm">
								<i class="fas fa-check-double"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-md-6">
				<div class="card premium-card border-0 shadow-sm">
					<div class="card-body p-4">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">{{ __('Failed') }}</h6>
								<span class="h1 font-weight-800 mb-0 text-dark">{{ number_format($failedSchedule ?? 0) }}</span>
							</div>
							<div class="icon icon-shape bg-soft-danger text-danger rounded-circle shadow-sm">
								<i class="fas fa-exclamation-triangle"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if(getUserPlanData('schedule_message') == false)
		<div class="row">
			<div class="col-sm-12">
				<div class="alert bg-soft-danger text-danger border-0 shadow-none d-flex align-items-center" role="alert">
					<span class="alert-icon mr-3"><i class="fas fa-exclamation-circle fa-2x"></i></span>
					<span class="alert-text">
						<strong>{{ __('Upgrade Required!') }}</strong> 
						{{ __('The Message Scheduling feature is not available in your current plan. Upgrade now to unlock advanced automation.') }}
					</span>
                    <a href="{{ route('user.subscription.index') }}" class="btn btn-sm btn-danger ml-auto rounded-pill px-4">{{ __('Upgrade Plan') }}</a>
				</div>
			</div>
		</div>
		@endif

		@if(count($posts) > 0)
		<div class="card premium-card border-0 shadow-sm mt-4 overflow-hidden">
            <div class="card-header bg-white border-0 py-4">
                <h3 class="mb-0 font-weight-800 text-dark"><i class="fas fa-calendar-check text-primary mr-2"></i>{{ __('Scheduled Campaigns') }}</h3>
            </div>
			<div class="table-responsive">
				<table class="table align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider">{{ __('Route') }}</th>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider">{{ __('Campaign Title') }}</th>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">{{ __('Type') }}</th>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">{{ __('Status') }}</th>
							<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">{{ __('Delivery Date') }}</th>
							<th scope="col" class="text-right"></th>
						</tr>
					</thead>
					<tbody class="list">
						@foreach($posts as $post)
							<tr>
								<td>
                                    <span class="badge badge-soft-primary px-2 py-1 rounded-pill">
                                        <i class="fab fa-whatsapp mr-1"></i> {{ $post->cloudapi->phone ?? 'API' }}
                                    </span>
                                </td>
								<td class="font-weight-700 text-dark">{{ Str::limit($post->title ?? '', 50)  }}</td>
								<td class="text-center">
                                    <span class="text-sm">{{ $post->body !=  null ? __('Plain Text') : __('Template')  }}</span>
                                </td>
								<td class="text-center">
                                    @php 
                                        $status_class = [
                                            'pending' => 'badge-soft-warning',
                                            'delivered' => 'badge-soft-success',
                                            'failed' => 'badge-soft-danger'
                                        ][$post->status] ?? 'badge-soft-primary';
                                    @endphp
                                    <span class="badge badge-pill {{ $status_class }} font-weight-bold px-3">{{ strtoupper($post->status) }}</span>
                                </td>
								<td class="text-center text-sm">
                                    <div class="d-flex flex-column text-dark font-weight-600">
                                        <span>{{ Carbon\Carbon::parse($post->schedule_at)->copy()->tz($post->zone)->format('M j, Y') }}</span>
                                        <small class="text-muted">{{ Carbon\Carbon::parse($post->schedule_at)->copy()->tz($post->zone)->format('g:i A') }}</small>
                                    </div>
                                </td>
								<td class="text-right">
									<div class="dropdown">
										<button class="btn btn-sm btn-icon-only text-light shadow-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div class="dropdown-menu dropdown-menu-right shadow border-0">
											<a class="dropdown-item py-2" href="{{ route('user.schedule-message.show',$post->id) }}">
												<i class="fas fa-eye text-primary mr-3"></i>{{ __('View Log') }}
											</a>

											@if($post->status == 'pending')
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete-confirm py-2 text-danger" href="javascript:void(0)" data-action="{{ route('user.schedule-message.destroy',$post->id) }}">
												<i class="fas fa-trash-alt mr-3"></i>{{ __('Remove Schedule') }}
											</a>
											@endif
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer bg-white border-0 py-4">
				<div class="d-flex justify-content-end">{{ $posts->links('vendor.pagination.bootstrap-4') }}</div>
			</div>
		</div>
		@else
		<div class="card premium-card border-0 shadow-sm mt-4">
			<div class="card-body py-7 text-center">
				<div class="icon-shape bg-soft-primary text-primary rounded-circle shadow-lg mb-4 mx-auto" style="width: 100px; height: 100px; display: inline-flex; align-items: center; justify-content: center;">
					<i class="fas fa-calendar-plus fa-3x"></i>
				</div>
				<h2 class="text-dark font-weight-800 mb-2">{{ __('Plan Ahead') }}</h2>
				<p class="text-muted mb-5 mx-auto" style="max-width: 500px;">{{ __('You have no scheduled messages. Create your first campaign to be delivered automatically at the perfect time.') }}</p>
				<a href="{{ route('user.schedule-message.create') }}" class="btn premium-btn premium-btn-primary mx-2">
					<i class="fas fa-calendar-plus mr-2"></i> {{ __('Create Schedule') }}
				</a>
			</div>
		</div>
		@endif
	</div>
</div>



<input type="hidden" id="base_url" value="{{ url('/') }}">
<input type="hidden" id="bulk_message_link" value="{{ route('user.bulk-message.store') }}">
@csrf
@endsection
@push('js')
<script src="{{ asset('assets/js/pages/bulk/jquery.csv.min.js') }}" ></script>
<script src="{{ asset('assets/js/pages/bulk/bulkmessage.js') }}" ></script>


@endpush