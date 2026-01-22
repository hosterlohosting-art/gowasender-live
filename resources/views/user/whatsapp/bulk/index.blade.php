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
            <input type="hidden" name="page_url" value="{{ url()->full() }}">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">{{ __('Send Bulk Message With Template') }}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Select Gateway') }}</label>
                  <select name="gateway_type" class="form-control gateway_type_selector" required>
                      <option value="official" selected>{{ __('Official WhatsApp API') }}</option>
                      <option value="unofficial">{{ __('Unofficial WhatsApp (QR Code)') }}</option>
                  </select>
               </div>

               <div class="form-group official_gateway_area">
                  <label>{{ __('Select Official API') }}</label>
                  <select name="cloudapi" class="form-control">
                      @foreach($cloudapis as $api)
                          <option value="{{ $api->id }}">{{ $api->phone ?? $api->name }}</option>
                      @endforeach
                  </select>
               </div>

               <div class="form-group unofficial_gateway_area none">
                  <label>{{ __('Select Unofficial Device') }}</label>
                  <select name="device" class="form-control">
                      @foreach($devices as $device)
                          <option value="{{ $device->uuid }}" {{ $device->status != 1 ? 'disabled' : '' }}>{{ $device->name }} ({{ $device->status == 1 ? __('Connected') : __('Disconnected') }})</option>
                      @endforeach
                  </select>
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
         <div class="col-xl-4 col-md-6">
            <div class="card premium-card overflow-hidden">
               <div class="card-body p-4">
                  <div class="row align-items-center">
                     <div class="col">
                        <h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Total Sent') }}</h6>
                        <span class="h2 font-weight-800 mb-0 total-transfers">{{ number_format($total) }}</span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow-lg">
                           <i class="fas fa-paper-plane"></i>
                        </div>
                     </div>
                  </div>
                  <div class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> Lifetime</span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-4 col-md-6">
            <div class="card premium-card overflow-hidden">
               <div class="card-body p-4">
                  <div class="row align-items-center">
                     <div class="col">
                        <h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Last 30 Days') }}</h6>
                        <span class="h2 font-weight-800 mb-0 pending-transfers">{{ number_format($last30_messages ?? 0) }}</span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow-lg">
                           <i class="fas fa-calendar-alt"></i>
                        </div>
                     </div>
                  </div>
                  <div class="mt-3 mb-0 text-sm">
                    <span class="text-primary mr-2"><i class="fa fa-chart-line"></i> Monthly Activity</span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-4 col-md-6">
            <div class="card premium-card overflow-hidden">
               <div class="card-body p-4">
                  <div class="row align-items-center">
                     <div class="col">
                        <h6 class="text-uppercase text-muted mb-1 font-weight-bold text-xs">{{ __('Today') }}</h6>
                        <span class="h2 font-weight-800 mb-0 completed-transfers">{{ number_format($today_transaction) }}</span>
                     </div>
                     <div class="col-auto">
                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow-lg">
                           <i class="fas fa-history"></i>
                        </div>
                     </div>
                  </div>
                  <div class="mt-3 mb-0 text-sm">
                    <span class="text-info mr-2"><i class="fa fa-clock"></i> Active Today</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="row">
               @if(count($posts) > 0)
               <div class="col-sm-12">
                  <h4>{{ __('Transaction History') }}</h4>
               </div>
               <div class="col-sm-12 table-responsive">
                  <table class="table col-12">
                     <thead>
                        <tr>
                        	<th>{{ __('Message From') }}</th>
                        	<th>{{ __('Message To') }}</th>
                        	<th>{{ __('Message Type') }}</th>
                        	<th>{{ __('Template name') }}</th>
                        	<th class="text-right">{{ __('Requested At') }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($posts as $log)
                        <tr>
                        	<td>
                        		{{ $log->from }}
                        	</td>
                        	<td>
                        		{{ $log->to }}
                        	</td>
                        	<td>{{ $log->template != null ? 'Template' : 'Plain Text' }}</td>

                        	<td>
                        		{{ $log->template->title ?? '' }}
                        	</td>
                        	<td class="text-right">
                        		{{ $log->created_at->format('d F Y') }}
                        	</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="d-flex justify-content-center">{{ $posts->links('vendor.pagination.bootstrap-4') }}</div>
               </div>
               @else
               <div class="btn btn-neutral  col-12 text-center">{{ __('No Transaction Found') }}</div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('topjs')
<script>
    $(document).on('change', '.gateway_type_selector', function() {
        let val = $(this).val();
        let modal = $(this).closest('.modal-content');
        
        if (val === 'official') {
            modal.find('.official_gateway_area').show();
            modal.find('.unofficial_gateway_area').hide();
            modal.find('.template_area').show();
            modal.find('.plain_text_area').hide();
            modal.find('select[name="template"]').attr('required', 'required');
            modal.find('textarea[name="message"]').removeAttr('required');
        } else {
            modal.find('.official_gateway_area').hide();
            modal.find('.unofficial_gateway_area').show().removeClass('none');
            modal.find('.template_area').hide();
            modal.find('.plain_text_area').show().removeClass('none');
            modal.find('select[name="template"]').removeAttr('required');
            modal.find('textarea[name="message"]').attr('required', 'required');
        }
    });
</script>
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