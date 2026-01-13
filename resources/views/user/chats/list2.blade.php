@extends('layouts.main.app')
@section('head')
@include('layouts.main.headersection',[
'title' => __('Chat List'),
'buttons'=>[
[
'name'=> __('CloudApis List'),
'url'=> route('user.cloudapi.index'),
]
]])
@endsection
@push('css')
<style>.header-body{display:none;}</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cloudapi.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')

<div class="layout-px-spacing">
    <div class="layout-top-spacing">
        <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="widget-content searchable-container grid">
                        <div class="card-box">
                            <div class="chat-container">
                                <div class="hamburger">
                                    <i class="fa fa-bars fadeIn"></i>
                                </div>
                                <div class="user-container">
                                    <div class="own-details">
                                        <img src="{{ Auth::user()->avatar == null ? 'https://ui-avatars.com/api/?name='.Auth::user()->name : asset(Auth::user()->avatar) }}" />
                                        <h3>{{ Auth::user()->name }}</h3>
                                        <p> {{Auth::user()->email }}</p>
                                        <div class="dropdown chat-own-setting mt-1">
                                            <a class="dropdown-toggle" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog font-20"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown" style="will-change: transform;">
                                                <a class="dropdown-item" href="{{ route('user.cloudapi.edit',$cloudapi->uuid) }}"> {{__('Edit WhatsApp API')}}</a>
                                                <a class="dropdown-item" href="javascript:void(0);"> {{__('Chats')}}</a>
                                                <a class="dropdown-item" href="{{ route('user.contact.index') }}"> {{__('Add People')}}</a>
                                                <a class="dropdown-item" href="{{route('user.support.create') }}"> {{__('Help')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="user-list-box">
                                        <div class="search">
                                            <i class="fa fa-search toggle-search"></i>
                                            <input type="text" class="form-control" placeholder="{{__('Search')}}" />
                                        </div>
                                        <div class="people">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-details">
                                    
                                    <div class="chat-details-header">
                                        <div class="chat-with">
                                            <p> {{__('Chat With')}}</p>
                                            <h3 class="chat-with-name"></h3>
                                        </div>
                                        <div class="chat-with-options">
                                            <span class="start-video-call" title="{{__('Video Call')}}"><i class="fa fa-video"></i></span>
                                            <span class="start-call" title="{{__('Call')}}"><i class="fa fa-phone"></i></span>
                                            
                                            <div class="dropdown chat-with-op mt-1">
                                                <a class="dropdown-toggle" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown" style="will-change: transform;">
                                                    
                                                    <a id="downloadButton" class="dropdown-item" href="javascript:void(0);"> {{__('Export Chat')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="loading" style="display:none;">Loading&#8230;</div>
                                    <div class="chatting-container" data-chat="person" data-last-timestamp="0">
                                        
                                    </div>
                                    <div class="chat-input-container">
                                        <form style="display: contents;" id="chatForm" class="chat-form" method="post" action="javascript:void(0);" enctype="multipart/form-data">
                                        @csrf
                                        <div class="cic pointer">
                                            <i class="fa fa-grin-beam emojipick"></i>
                                            <input class="chat-text-input one" placeholder="{{__('Write something here')}}"/>
                                        </div>
                                        <div class="loading-input" style="display: none;"></div>
                                        <label for="addon" class="mb-0">
                                            <a class="send" title="{{__('To Attach a file, upgrade the License')}}"><i class="fa fa-ban"></i></a>
                                        </label>
                                        <input type="hidden" readonly="" id="receiver" name="receiver" value="" class="form-control bg-white receiver-number">
                                        <a class="send chat-send" title="Send"><i class="fa fa-paper-plane"></i></a>
                                        </form>
                                    </div>
                                </div>
                                <div class="chat-details empty">
                                    <p> {{__('Please select a user to start chatting')}}</p>
                                </div>
                                <div class="chat-user-details">
                                    <div class="hide-chat-user-details">
                                        <i class="fa fa-arrow-left"></i>
                                    </div>
                                    <div class="other-details">
                                        <img src="{{asset('/assets/img/whatsapp.png')}}" />
                                        <h3 class="chat-with-name"></h3>
                                        <p class="chat-number"></p>
                                        
                                    </div>
                                    
                                    
                                    <div class="single-chat-option">
                                        <a href="#" data-toggle="modal" data-target="#send-template"><i class="fa fa-envelope" disabled></i> {{ __('Send Templates') }}</a>
                                    </div>
                                    <div class="single-chat-option">
                                        <a style="color: #e7e4e4;" href="#" data-toggle="modal" data-target="#mute-notification"><i class="fa fa-volume-mute"></i> {{__('Mute Notificatios')}}</a>
                                    </div>
                                    
                                    <div class="single-chat-option">
                                        <a style="color: #e7e4e4;" href="#" data-toggle="modal" data-target="#pin-top"><i class="fa fa-thumbtack"></i> {{__('Pin Your Conversation')}}</a>
                                    </div>
                                    
                                    <div class="single-chat-option">
                                        <a class="dropdown-item" id="downloadButton"><i class="fa fa-cloud-download-alt"></i> {{__('Export Chat')}}</a>
                                    </div>
                                    <div class="single-chat-option">
                                        <a class="text-danger" id="clear-chat"><i class="fa fa-eraser"></i> {{__('Clear All Messages')}}</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="send-template" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
      @if(count($templates) > 0 )
      <div class="modal-content">
         <form id="metatemplate" method="POST" action="{{ route('user.sent.customtext','text-with-template') }}" class="ajaxform_reset_form"  enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="phone" type="number" name="phone" value="">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">{{ __('Send Meta Approved Templates') }}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>{{ __('Select Template') }}</label>
                  <select  class="form-control" name="template" id="templateid" onchange="updateInputFields(this)">
                      <option value="">Select a Template</option>
                     @foreach($templates as $template)
                     @if($template->type == 'meta-template')
        <option value="{{ $template->id }}" data-template-raw="{{ json_encode($template['body']) }}">
                        {{ $template->title }}
                    </option>
                    @endif
@endforeach

                  </select>
                  <small class="text-danger">Please be cautious as some templates may not function properly in this context.</small>
               </div>
               <div class="card-body" style="justify-content: flex-end; text-align: right; background: url('{{ asset('assets/img/bg.png') }}');">
           <div class="card" id="previewElement" style="min-width: 18rem; text-align: left; border-top-left-radius: 0; margin-bottom: 5px;">
               <div id="documentPrev"></div>
               <div id ="imagePrev"></div>
               <div id ="videoPrev"></div>
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
               <div class="form-group">
                     <input type="hidden" value="{{ $cloudapi->id }}" name="cloudapi">
               </div>
               
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-neutral submit-btn float-right">{{ __('Sent Now') }}</button>
            </div>
         </form>
      </div>
      @else
      <div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('Create some Meta Approved template') }}</span></div>
      @endif
   </div>
</div>
<div class="modal fade" id="mute-notification" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('If You are an admin, Upgrade Your License to enable this feature.') }}</span></div>
    </div>
</div>
<div class="modal fade" id="pin-top" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
    <div class="alert  bg-gradient-primary text-white"><span class="text-left">{{ __('If You are an admin, Upgrade Your License to enable this feature.') }}</span></div>
    </div>
</div>
<input type="hidden" id="uuid" value="{{$cloudapi->uuid}}">
<input type="hidden" id="base_url" value="{{ url('/') }}">
<script src="https://woody180.github.io/vanilla-javascript-emoji-picker/vanillaEmojiPicker.js"></script>
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/user/wa-bulk-index.js?v=1') }}" ></script>

<script>
    new EmojiPicker({
            trigger: [
                {
                    selector: '.emojipick',
                    insertInto: ['.one'] // '.selector' can be used without array
                }
            ],
            closeButton: true,
            //specialButtons: green
        });
</script>

@endsection
