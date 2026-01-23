@extends('layouts.main.app')
@push('topcss')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endpush
@section('head')
@include('layouts.main.headersection',['buttons'=>[
	[
		'name'=>'<i class="fas fa-rocket mr-1"></i>'. __('Send Bulk Message'),
		'url'=>route('user.bulk-message.create'),
		'is_button'=>false,
        'components' => 'class="btn btn-sm premium-btn premium-btn-primary"'
	],
	[
		'name'=>'<i class="fas fa-layer-group mr-1"></i>'. __('Send With Template'),
		'url'=>'#',
		'components'=>'data-toggle="modal" data-target="#send-template-bulk" class="btn btn-sm premium-btn btn-white border ml-2"',
		'is_button'=>true
	]
],'title' => 'Bulk Message History'])
@endsection
@section('content')
<div class="modal fade" id="send-template-bulk" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
   <div class="modal-dialog">
      @if(count($templates) > 0 && count($groups) > 0)
      <div class="modal-content">
         <form type="POST" action="{{ route('user.contact.send-template-bulk') }}" class="ajaxform bulk_send_form">
            @csrf
            <input type="hidden" name="page_url" value="{{ request()->fullUrl() }}">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">{{ __('Send Bulk Message With Template') }}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Select Official API') }}</label>
                  <select name="cloudapi" class="form-control" required>
                      @foreach($cloudapis as $api)
                          <option value="{{ $api->id }}">{{ $api->phone ?? $api->name }}</option>
                      @endforeach
                  </select>
                  <input type="hidden" name="gateway_type" value="official">
               </div>

               <div class="template_area">
                  <div class="form-group">
                     <label>{{ __('Select Template') }}</label>
                     <select class="form-control" name="template" id="templateid" onchange="updateInputFields(this)">
                        @foreach($templates as $template)
                           <option value="{{ $template->id }}" data-template-raw="{{ json_encode($template['body']) }}">
                              {{ $template->title }} - @if($template->type == 'meta-template') (meta) @elseif ($template->type == 'text-with-list') (List) @else Others  @endif
                           </option>
                        @endforeach
                     </select>
                     <small class="text-danger">Please be cautious as some templates may not function properly in this context.</small>
                  </div>
               </div>

               <div class="plain_text_area none">
                  <div class="form-group">
                     <label>{{ __('Message') }}</label>
                     <textarea name="message" class="form-control h-200" placeholder="{{ __('Type your message here...') }}"></textarea>
                  </div>
               </div>
               <div class="card-body" style="justify-content: flex-end; text-align: right; background: url('{{ asset('assets/img/bg.png') }}');">
           <div class="card" id="previewElement" style="min-width: 18rem; text-align: left; border-top-left-radius: 0; margin-bottom: 5px;">
               <div id="documentPrev"></div>
               <div id ="imagePrev"></div>
               <div class="card-body" style="">
                   <h4 id="headertext" class="card-title mb-2"></h4>
                   <p id="combody" class="card-text"></p>
                   <span id="footerPrev" class="text-muted text-xs"></span>
                </div>
                   
           </div>
            <div id ="buttonsPrev"></div>
       </div>

        <div class="form-group header-parameters" id="header-variable">
            <!-- Input fields for header parameters will be added here -->
        </div>

        <div class="form-group message-parameters" id="body-variable">
            <!-- Input fields for message parameters will be added here -->
        </div>	
               <div class="form-group receivers">
                  <label>{{ __('Select Contacts Group') }}</label>
                  <select  class="form-control select2" name="group" >
                     @foreach($groups as $group)
                     <option value="{{ $group->id }}">{{ $group->name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-neutral submit-btn float-right">{{ __('Sent Now') }}</button>
            </div>
         </form>
      </div>
      @else
      <div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Create some template and contacts') }}</span></div>
      @endif
   </div>
</div>
<div class="row justify-content-center">
   <div class="col-12">
      <div class="row animate-fade-in-up">
         <div class="col-xl-4">
            <div class="card premium-card overflow-hidden border-0 shadow-sm">
               <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center">
                     <div>
                        <h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">{{ __('Lifetime Sent') }}</h6>
                        <span class="h1 font-weight-800 mb-0 text-dark">{{ number_format($total) }}</span>
                     </div>
                     <div class="icon icon-shape bg-soft-primary text-primary rounded-circle shadow-sm">
                        <i class="fas fa-paper-plane"></i>
                     </div>
                  </div>
                  <div class="mt-3">
                    <span class="badge badge-soft-success font-weight-bold">
                        <i class="fa fa-check-circle mr-1"></i> {{ __('All Time') }}
                    </span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="card premium-card overflow-hidden border-0 shadow-sm">
               <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center">
                     <div>
                        <h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">{{ __('Last 30 Days') }}</h6>
                        <span class="h1 font-weight-800 mb-0 text-dark">{{ number_format($last30_messages ?? 0) }}</span>
                     </div>
                     <div class="icon icon-shape bg-soft-success text-success rounded-circle shadow-sm">
                        <i class="fas fa-calendar-check"></i>
                     </div>
                  </div>
                  <div class="mt-3">
                    <span class="badge badge-soft-info font-weight-bold">
                        <i class="fa fa-chart-line mr-1"></i> {{ __('Monthly Growth') }}
                    </span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-4">
            <div class="card premium-card overflow-hidden border-0 shadow-sm">
               <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center">
                     <div>
                        <h6 class="text-uppercase text-muted mb-1 font-weight-800 text-xs">{{ __('Sent Today') }}</h6>
                        <span class="h1 font-weight-800 mb-0 text-dark">{{ number_format($today_transaction) }}</span>
                     </div>
                     <div class="icon icon-shape bg-soft-info text-info rounded-circle shadow-sm">
                        <i class="fas fa-clock"></i>
                     </div>
                  </div>
                  <div class="mt-3">
                    <span class="badge badge-soft-primary font-weight-bold">
                        <i class="fa fa-bolt mr-1"></i> {{ __('Live Stats') }}
                    </span>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="card premium-card border-0 shadow-sm mt-4">
         <div class="card-header bg-white border-0 py-4">
            <h3 class="mb-0 font-weight-800 text-dark">
                <i class="fas fa-history text-primary mr-2"></i>{{ __('Transmission Logs') }}
            </h3>
         </div>
         <div class="table-responsive">
            @if(count($posts) > 0)
            <table class="table align-items-center table-flush">
               <thead class="thead-light">
                  <tr>
                     <th scope="col" class="font-weight-800 text-uppercase tracking-wider">{{ __('Sender/Receiver') }}</th>
                     <th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">{{ __('Type') }}</th>
                     <th scope="col" class="font-weight-800 text-uppercase tracking-wider text-center">{{ __('Template') }}</th>
                     <th scope="col" class="font-weight-800 text-uppercase tracking-wider text-right">{{ __('Requested At') }}</th>
                  </tr>
               </thead>
               <tbody class="list">
                  @foreach($posts as $log)
                  <tr>
                     <td>
                        <div class="d-flex flex-column">
                            <span class="text-sm font-weight-700 text-dark"><i class="fas fa-sign-out-alt text-muted mr-1"></i> {{ $log->from }}</span>
                            <span class="text-xs text-muted mt-1"><i class="fas fa-sign-in-alt text-muted mr-1"></i> {{ $log->to }}</span>
                        </div>
                     </td>
                     <td class="text-center">
                        @if($log->template != null)
                            <span class="badge badge-pill badge-primary">{{ __('Template') }}</span>
                        @else
                            <span class="badge badge-pill badge-neutral border">{{ __('Plain Text') }}</span>
                        @endif
                     </td>
                     <td class="text-center font-weight-600 text-dark">
                        {{ $log->template->title ?? '-' }}
                     </td>
                     <td class="text-right font-weight-600 text-dark">
                        {{ $log->created_at->format('d F Y') }} <br>
                        <small class="text-muted">{{ $log->created_at->format('H:i') }}</small>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
            @else
            <div class="card-body text-center py-6">
                <div class="icon-shape bg-soft-primary text-primary rounded-circle shadow-sm mb-4 mx-auto" style="width: 80px; height: 80px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fas fa-inbox fa-3x"></i>
                </div>
                <h4 class="text-dark font-weight-800 mb-2">{{ __('No Transaction Found') }}</h4>
                <p class="text-muted mx-auto" style="max-width: 400px;">{{ __('Your bulk messaging history will appear here once you start sending campaigns.') }}</p>
            </div>
            @endif
         </div>
         @if(count($posts) > 0)
         <div class="card-footer bg-white border-0 py-4">
            <div class="d-flex justify-content-end">{{ $posts->links('vendor.pagination.bootstrap-4') }}</div>
         </div>
         @endif
      </div>
   </div>
</div>
@endsection
@push('topjs')

<script>
    // Submit the form when it's ready
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.ajaxform');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            // Submit the form using AJAX
            sendFormWithAjax();
        });
    });

    function sendFormWithAjax() {
        const form = document.querySelector('.ajaxform');
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

<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/user/wa-bulk-index.js?v=1') }}" ></script>
@endpush