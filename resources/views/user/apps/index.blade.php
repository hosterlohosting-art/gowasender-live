@extends('layouts.main.app')
@section('head')
   @include('layouts.main.headersection', [
      'title' => __('Apps'),
      'buttons' => [
         [
            'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create App'),
            'url' => '#',
            'components' => 'data-toggle="modal" data-target="#addRecord" id="add_record"',
            'is_button' => true
         ]
      ]
   ])
@endsection
@section('content')
@section('content')
    <!-- Header Stats -->
    <div class="row mb-4">
        <!-- Card 1: Total Apps -->
        <div class="col-xl-4 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4 hover-translate-y" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-xs">{{ __('Total Apps') }}</h5>
                            <span class="h2 font-weight-800 mb-0 text-dark">{{ $limit }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                <i class="fi fi-rs-apps-add"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Messages -->
        <div class="col-xl-4 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4 hover-translate-y" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-xs">{{ __('Total Messages Sent') }}</h5>
                            <span class="h2 font-weight-800 mb-0 text-dark">{{ number_format($total) }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Last 30 Days -->
        <div class="col-xl-4 col-md-6">
            <div class="card card-stats border-0 shadow-lg mb-4 hover-translate-y" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 font-weight-bold text-xs">{{ __('Last 30 Days Messages') }}</h5>
                            <span class="h2 font-weight-800 mb-0 text-dark">{{ number_format($last30_messages ?? 0) }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-calendar-grid-58"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- App List or Empty State -->
    <div class="row">
        @if(count($apps ?? []) == 0)
            <div class="col-12">
                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-body py-6 text-center">
                        <div class="icon-shape bg-gradient-primary text-white rounded-circle shadow-lg mb-4" 
                             style="width: 80px; height: 80px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fi fi-rs-apps-add fa-3x"></i>
                        </div>
                        <h4 class="text-dark font-weight-bold mb-2">{{ __('No Apps Found') }}</h4>
                        <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto;">{{ __('You haven\'t created any apps yet. Connect an API to get started!') }}</p>
                        <a href="#" data-toggle="modal" data-target="#addRecord" id="add_record" 
                           class="btn btn-primary btn-lg shadow-lg rounded-pill px-5" 
                           style="background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important; border: none;">
                            <i class="fas fa-plus mr-2"></i> {{ __('Create New App') }}
                        </a>
                    </div>
                </div>
            </div>
        @else
            @foreach($apps as $app)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-lg hover-translate-y mb-4" style="border-radius: 20px;">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon icon-shape bg-light text-primary rounded-circle">
                                     <i class="fi fi-rs-apps"></i>
                                </div>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-icon-only text-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item" href="{{ route('user.app.logs', $app->uuid) }}">
                                            <i class="ni ni-align-left-2"></i> {{ __('Messages Log') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('user.app.integration', $app->uuid) }}">
                                            <i class="fas fa-code"></i> {{ __('REST API') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete-confirm text-danger" href="javascript:void(0)" data-action="{{ route('user.apps.destroy', $app->uuid) }}">
                                            <i class="fas fa-trash"></i> {{ __('Remove App') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="h3 font-weight-bold mb-1 text-dark">{{ $app->title }}</h5>
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-pill badge-primary text-xs mr-2">{{ __('Active') }}</span>
                                <small class="text-muted">{{$app->cloudapi->phone ?? 'No Phone'}}</small>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-6">
                                    <small class="text-uppercase text-muted font-weight-bold">{{ __('Messages') }}</small>
                                    <h4 class="mb-0 text-dark">{{number_format($app->live_messages_count)}}</h4>
                                </div>
                                <div class="col-6 text-right">
                                     <a href="{{ route('user.app.integration', $app->uuid) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                         {{ __('Integration') }} <i class="fas fa-arrow-right ml-1"></i>
                                     </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="col-12 mt-4">
                <div class="d-flex justify-content-center">
                    {{ $apps->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
      <div class="modal fade" id="addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <form method="POST" action="{{ route('user.apps.store') }}" class="ajaxform_instant_reload">
                  @csrf
                  <div class="modal-header">

                    <h3>{{ __('Create New App') }}</h3>

                 </div>

                 <div class="modal-body">
                     <div class="form-group">
                        <label>{{ __('Select Number') }}</label>
                        <select class="form-control"  name="cloudapi" required="">
                           @foreach($cloudapis as $cloudapi)
                              <option value="{{ $cloudapi->id }}">
                                 {{ $cloudapi->name }} 
                                 @if(!empty($cloudapi->phone)) 
                                    ({{ $cloudapi->phone }}) 
                                 @endif
                              </option>
                           @endforeach
                        </select>
                        <small>{{ __('User Will Receive Message From The Selected Number') }}</small>
                     </div>
                     <div class="form-group">
                        <label>{{ __('App Name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label>{{ __('Website Link') }}</label>
                        <input type="url" name="website" class="form-control" required="">
                     </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-primary col-12" >{{ __('Create Now') }}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection