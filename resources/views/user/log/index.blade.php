@extends('layouts.main.app')
@section('head')
	@include('layouts.main.headersection', ['title' => 'Messages log reports'])
@endsection
@section('content')
	<div class="row justify-content-center">
		<div class="col-12">
			<div class="row animate-fade-in-up">
				<div class="col-xl-4 col-md-4">
					<div class="card premium-card border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">
										{{ __('Total Logs') }}</h6>
									<span
										class="h1 font-weight-800 mb-0 text-dark">{{ number_format($total_messages) }}</span>
								</div>
								<div class="icon icon-shape bg-soft-primary text-primary rounded-circle shadow-sm">
									<i class="fas fa-layer-group"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-4">
					<div class="card premium-card border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">
										{{ __('Today\'s Activity') }}</h6>
									<span
										class="h1 font-weight-800 mb-0 text-dark">{{ number_format($today_messages) }}</span>
								</div>
								<div class="icon icon-shape bg-soft-success text-success rounded-circle shadow-sm">
									<i class="fas fa-bolt"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-4">
					<div class="card premium-card border-0 shadow-sm">
						<div class="card-body p-4">
							<div class="d-flex justify-content-between align-items-center">
								<div>
									<h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">
										{{ __('30-Day Volume') }}</h6>
									<span
										class="h1 font-weight-800 mb-0 text-dark">{{ number_format($last30_messages) }}</span>
								</div>
								<div class="icon icon-shape bg-soft-info text-info rounded-circle shadow-sm">
									<i class="fas fa-chart-line"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			@if(count($logs ?? []) == 0)
				<div class="card premium-card border-0 shadow-sm mt-4">
					<div class="card-body py-7 text-center">
						<div class="icon-shape bg-soft-primary text-primary rounded-circle shadow-lg mb-4 mx-auto"
							style="width: 100px; height: 100px; display: inline-flex; align-items: center; justify-content: center;">
							<i class="fas fa-file-invoice fa-3x"></i>
						</div>
						<h2 class="text-dark font-weight-800 mb-2">{{ __('No Activity Recorded') }}</h2>
						<p class="text-muted mb-5 mx-auto" style="max-width: 500px;">
							{{ __('Your account message activity logs are empty. Start sending messages to see detailed performance reports here.') }}
						</p>
					</div>
				</div>
			@else
				<div class="card premium-card border-0 shadow-sm mt-4 overflow-hidden">
					<div class="card-header bg-white border-0 py-4">
						<h3 class="mb-0 font-weight-800 text-dark"><i
								class="fas fa-list-ul text-primary mr-2"></i>{{ __('Detailed Activity Feed') }}</h3>
					</div>
					<div class="table-responsive">
						<table class="table align-items-center table-flush">
							<thead class="thead-light">
								<tr>
									<th scope="col" class="font-weight-800 text-uppercase tracking-wider">{{ __('Sender') }}
									</th>
									<th scope="col" class="font-weight-800 text-uppercase tracking-wider">{{ __('Receiver') }}
									</th>
									<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">
										{{ __('Content Type') }}</th>
									<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">
										{{ __('Module') }}</th>
									<th scope="col" class="font-weight-800 text-uppercase tracking-wider text-right">
										{{ __('Date & Time') }}</th>
								</tr>
							</thead>
							<tbody class="list text-dark">
								@foreach($logs ?? [] as $log)
									<tr>
										<td class="font-weight-700">
											<i class="fab fa-whatsapp text-success mr-1"></i> {{ $log->from }}
										</td>
										<td class="font-weight-600 font-italic">
											{{ $log->to }}
										</td>
										<td class="text-center">
											@if($log->template != null)
												<span
													class="badge badge-soft-primary px-2 py-1 rounded-pill">{{ __('Template') }}</span>
											@else
												<span
													class="badge badge-soft-neutral border px-2 py-1 rounded-pill">{{ __('Plain Text') }}</span>
											@endif
										</td>

										<td class="text-center">
											<span
												class="badge badge-soft-info font-weight-bold px-3 py-1 rounded-pill text-uppercase">{{ $log->type }}</span>
										</td>
										<td class="text-right text-sm">
											<div class="d-flex flex-column text-dark font-weight-600">
												<span>{{ $log->created_at->format('d M Y') }}</span>
												<small class="text-muted">{{ $log->created_at->format('H:i A') }}</small>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="card-footer bg-white border-0 py-4">
						<div class="d-flex justify-content-end">{{ $logs->links('vendor.pagination.bootstrap-4') }}</div>
					</div>
				</div>
			@endif
		</div>
	</div>


@endsection