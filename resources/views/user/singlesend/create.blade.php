@extends('layouts.main.app')
@section('head')
    @include('layouts.main.headersection', ['title' => __('Single Send')])
@endsection
@push('topcss')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/css/uikit.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">

@endpush
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">

            <div class="card-body p-0">
                <div class="row">
                    <div class="col-12 col-sm-12 scrollbar-inner" style="overflow-x:auto; padding: 15px;">
                        <ul class="nav nav-pills" style="flex-wrap: nowrap;" id="myTab4" role="tablist">
                            <li class="nav-ar nav-item">
                                <a class="nav-link active premium-tab" id="home-tab4" data-toggle="tab" href="#mode_1"
                                    role="tab" aria-controls="home" aria-selected="true"><i
                                        class="fas fa-align-left mr-2"></i>{{ __('Plain Text') }}</a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_2"
                                    role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="fas fa-file-alt mr-2"></i>{{ __('Documents') }}</a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_3"
                                    role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="fas fa-image mr-2"></i>{{ __('Image') }}</a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_4"
                                    role="tab" aria-controls="profile" aria-selected="false">
                                    <i class="fas fa-check-double mr-2"></i>{{ __('Template') }} <small
                                        style="font-size: 10px; opacity: 0.8;">(Meta)</small>
                                </a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_10"
                                    role="tab" aria-controls="profile" aria-selected="false">
                                    <i class="fas fa-hand-pointer mr-2"></i>{{ __('Button') }}
                                </a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_5"
                                    role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="fas fa-list mr-2"></i>{{ __('List') }}</a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_6"
                                    role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="fas fa-microphone mr-2"></i>{{ __('Audio') }}</a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_7"
                                    role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="fas fa-map-marker-alt mr-2"></i>{{ __('Location') }}</a>
                            </li>
                            <li class="nav-ar nav-item">
                                <a class="nav-link premium-tab" id="profile-tab4" data-toggle="tab" href="#mode_9"
                                    role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="fas fa-video mr-2"></i>{{ __('Video') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-content no-padding" id="myTab2Content">


    <div class="tab-pane fade show active" id="mode_1" role="tabpanel" aria-labelledby="home-tab4">
        <form method="POST" action="{{ route('user.sent.customtext', 'plain-text') }}" class="ajaxform_reset_form">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-center animate-fade-in-up">
                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-user-tag text-primary mr-2"></i>{{__('Recipient')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group pb-0">
                                    <label class="form-control-label">{{ __('Phone Number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input id="phone" type="number" class="form-control" name="phone"
                                            placeholder="{{ __('e.g. 1234567890') }}" value="" required=""
                                            minlength="10" maxlength="15" />
                                    </div>
                                    <small class="text-muted mt-2"><i
                                            class="fas fa-info-circle mr-1"></i>{{ __('Include country code (e.g. 1 for USA)') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-comment-dots text-primary mr-2"></i>{{__('Message')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12 p-0">
                                <div class="form-group mb-0">
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-sm btn-light border"
                                            onclick="insertTag('myTextarea1', '*', '*')"><b>B</b></button>
                                        <button type="button" class="btn btn-sm btn-light border"
                                            onclick="insertTag('myTextarea1', '_', '_')"><i>I</i></button>
                                        <button type="button" class="btn btn-sm btn-light border"
                                            onclick="insertTag('myTextarea1', '~', '~')"><strike>S</strike></button>
                                        <button type="button" class="emojipick btn btn-sm btn-light border"><i
                                                class="far fa-smile"></i></button>
                                    </div>
                                    <textarea id="myTextarea1" class="form-control mt-1" name="message" required=""
                                        maxlength="1000" rows="6" placeholder="{{ __('Type your message here...') }}"
                                        oninput="updatePreview('myTextarea1', 'previewText1')"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-eye text-primary mr-2"></i>{{__('Preview')}}</h3>
                        </div>
                        <div class="card-body p-0" style="background: #e5ddd5; min-height: 250px; position: relative;">
                            <div
                                style="background-image: url('{{ asset('assets/img/whatsapp-bg.png') }}'); opacity: 0.1; position: absolute; inset: 0;">
                            </div>
                            <div class="p-3" style="position: relative; z-index: 1;">
                                <div
                                    style="background: white; border-radius: 8px; padding: 10px; max-width: 85%; margin-left: auto; box-shadow: 0 1px 2px rgba(0,0,0,0.1); position: relative;">
                                    <p class="mb-1" id="previewText1"
                                        style="white-space: pre-wrap; word-break: break-word; color: #111b21;">This is
                                        an example message preview.</p>
                                    <div class="text-right">
                                        <small class="text-muted" style="font-size: 10px;">{{ date('H:i') }} <i
                                                class="fas fa-check-double text-primary ml-1"></i></small>
                                    </div>
                                    <div
                                        style="position: absolute; right: -8px; top: 0; width: 0; height: 0; border-top: 10px solid white; border-right: 10px solid transparent;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center py-4">
                            <button id="submitBtn" type="submit"
                                class="premium-btn premium-btn-primary w-100">{{ __('Send Message') }} <i
                                    class="fas fa-paper-plane ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!------------------------>
    <!------------------------>
    <div class="tab-pane fade" id="mode_2" role="tabpanel" aria-labelledby="profile-tab4">
        <form method="POST" action="{{ route('user.sent.customtext', 'text-with-media') }}" class="ajaxform_reset_form"
            enctype="multipart/form-data">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-center">
                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Recipient')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group focused">
                                    <label class="form-control-label">Message To</label><br>
                                    <input id="phone" type="number" class="form-control" name="phone"
                                        placeholder="{{ __('Phone number with country code') }}" value="" required=""
                                        autofocus="" minlength="10" maxlength="15" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Messages')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Select File') }}</label>
                                    <input id="pdfInput" type="file" class="form-control" name="file" required=""
                                        onchange="previewFile('pdfInput', 'filePreviewPdf', 'pdf')" />
                                    <small>{{__(' Supported file type:')}}</small> <small
                                        class="text-danger">{{ __('pdf,docx,xlsx,csv,txt') }}</small>
                                </div>


                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea2', '*', '*')">Bold</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea2', '_', '_')">Italic</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea2', '~', '~')">Strike</button>
                                    <button type="button" class="emojipick btn btn-outline-primary btn-sm"
                                        style="padding:8px;">Emoji</button>
                                    <textarea id="myTextarea2" class="form-control one mt-1" name="message" required=""
                                        maxlength="1000"
                                        oninput="updatePreview('myTextarea2', 'previewText2')"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Preview')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body"
                                style="justify-content: flex-end; text-align: right; background: url('{{ asset('assets/img/bg.png') }}');">
                                <div class="card"
                                    style="text-align: left; border-top-left-radius: 0; margin-bottom: 5px;">
                                    <img id="filePreviewPdf" class="card-img-top" style=""
                                        src="{{ asset('assets/img/pdf.png') }}" alt="Card image cap">
                                    <div class="card-body" style="">
                                        <p class="card-text" id="previewText2">This is the example Documents messages to
                                            demonstrate the Preview panel of whatsApp Api</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="text-align:center;margin-bottom: 10px;">
                            <button id="submitBtn" type="submit"
                                class="btn btn-outline-primary submit-button">{{ __('Send Message') }}</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <!------------------------>
    <!------------------------>
    <div class="tab-pane fade" id="mode_3" role="tabpanel" aria-labelledby="profile-tab4">
        <form method="POST" action="{{ route('user.sent.customtext', 'text-with-image') }}" class="ajaxform_reset_form"
            enctype="multipart/form-data">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-centeranimate-fade-in-up">
                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-user-tag text-primary mr-2"></i>{{__('Recipient')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group pb-0">
                                    <label class="form-control-label">{{ __('Phone Number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input id="phone" type="number" class="form-control" name="phone"
                                            placeholder="{{ __('e.g. 1234567890') }}" value="" required=""
                                            minlength="10" maxlength="15" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-images text-primary mr-2"></i>{{__('Image & Caption')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12 p-0">
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Select Image') }}</label>
                                    <input id="imageInput" type="file" class="form-control" name="image" required=""
                                        onchange="previewFile('imageInput', 'filePreviewImage', 'image')" />
                                    <small class="text-muted"><i class="fas fa-file-image mr-1"></i>
                                        {{__('Allowed formats: jpg, jpeg, png')}}</small>
                                </div>
                            </div>

                            <div class="col-sm-12 p-0">
                                <div class="form-group mb-0">
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-sm btn-light border"
                                            onclick="insertTag('myTextarea3', '*', '*')"><b>B</b></button>
                                        <button type="button" class="btn btn-sm btn-light border"
                                            onclick="insertTag('myTextarea3', '_', '_')"><i>I</i></button>
                                        <button type="button" class="btn btn-sm btn-light border"
                                            onclick="insertTag('myTextarea3', '~', '~')"><strike>S</strike></button>
                                        <button type="button" class="emojipick btn btn-sm btn-light border"><i
                                                class="far fa-smile"></i></button>
                                    </div>
                                    <textarea id="myTextarea3" class="form-control mt-1" name="message" required=""
                                        maxlength="1000" rows="4" placeholder="{{ __('Type your caption here...') }}"
                                        oninput="updatePreview('myTextarea3', 'previewText3')"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-eye text-primary mr-2"></i>{{__('Preview')}}</h3>
                        </div>
                        <div class="card-body p-0" style="background: #e5ddd5; min-height: 250px; position: relative;">
                            <div
                                style="background-image: url('{{ asset('assets/img/whatsapp-bg.png') }}'); opacity: 0.1; position: absolute; inset: 0;">
                            </div>
                            <div class="p-3" style="position: relative; z-index: 1;">
                                <div
                                    style="background: white; border-radius: 8px; padding: 5px; max-width: 85%; margin-left: auto; box-shadow: 0 1px 2px rgba(0,0,0,0.1); position: relative;">
                                    <div class="p-1">
                                        <img id="filePreviewImage" class="img-fluid"
                                            style="border-radius: 6px; width: 100%; object-fit: cover;"
                                            src="{{ asset('assets/img/img.jpg') }}" alt="Preview">
                                    </div>
                                    <div class="px-2 py-1">
                                        <p class="mb-1" id="previewText3"
                                            style="white-space: pre-wrap; word-break: break-word; color: #111b21;">Image
                                            caption example.</p>
                                        <div class="text-right">
                                            <small class="text-muted" style="font-size: 10px;">{{ date('H:i') }} <i
                                                    class="fas fa-check-double text-primary ml-1"></i></small>
                                        </div>
                                    </div>
                                    <div
                                        style="position: absolute; right: -8px; top: 0; width: 0; height: 0; border-top: 10px solid white; border-right: 10px solid transparent;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center py-4">
                            <button id="submitBtn" type="submit"
                                class="premium-btn premium-btn-primary w-100">{{ __('Send Message') }} <i
                                    class="fas fa-paper-plane ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--------------------------------------------->
    <!--------------------------------------------->

    <div class="tab-pane fade" id="mode_5" role="tabpanel" aria-labelledby="profile-tab4">
        <form method="POST" action="{{ route('user.sent.customtext','text-with-list') }}" class="ajaxform_reset_form">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-center animate-fade-in-up">
                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-user-tag text-primary mr-2"></i>{{__('Recipient')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group pb-0">
                                    <label class="form-control-label">{{ __('Phone Number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input id="phone" type="number" class="form-control" name="phone"
                                            placeholder="{{ __('e.g. 1234567890') }}" value="" required=""
                                            minlength="10" maxlength="15" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card premium-card mt-4">
                        <div
                            class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h3 class="mb-0 font-weight-bold"><i class="fas fa-list-ul text-primary mr-2"></i>{{
                                __('List Options') }}</h3>
                            <a href="javascript:void(0)" id="add-more-option" class="btn btn-sm btn-neutral"><i
                                    class="fa fa-plus-circle mr-1"></i> {{ __('Add Card') }}</a>
                        </div>
                        <div class="card-body list-area px-3">
                            <div class="card card-item border mb-3" style="border-radius: 12px; overflow: hidden;">
                                <div class="card-header bg-light py-2 px-3">
                                    <h4 class="mb-0" style="font-size: 14px;">{{ __('List Group 1') }}</h4>
                                </div>
                                <div class="card-body p-3">
                                    <div class="form-group mb-3">
                                        <label class="small font-weight-bold text-muted text-uppercase">{{ __('Group
                                            Title') }}</label>
                                        <input type="text" class="form-control form-control-sm" name="section[1][title]"
                                            placeholder="{{ __('Fruit Selection') }}" value="" required=""
                                            maxlength="50" />
                                    </div>
                                    <div class="list-item-area1">
                                        <div class="row no-gutters mb-2">
                                            <div class="col-6 pr-1">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="section[1][value][1][title]" placeholder="{{ __('Banana') }}"
                                                    required="" />
                                            </div>
                                            <div class="col-6 pl-1">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="section[1][value][1][description]"
                                                    placeholder="{{ __('Healthy fruit') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <a href="javascript:void(0)" class="small font-weight-bold add-more-option-item"
                                            data-target=".list-item-area1" data-key="1"><i
                                                class="fas fa-plus mr-1"></i>{{ __('Add Item') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i class="fas fa-tasks text-primary mr-2"></i>{{__('List
                                Content')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-control-label">{{ __('Header Title') }}</label>
                                <input id="heading4" type="text" class="form-control" name="header_title"
                                    placeholder="{{ __('Choose an option') }}" value="" required="" maxlength="50"
                                    oninput="updatePreview('heading4', 'previewheader4')" />
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-control-label">{{ __('Description Body') }}</label>
                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm btn-light border p-1 px-2"
                                        onclick="insertTag('myTextarea4', '*', '*')"><b>B</b></button>
                                    <button type="button" class="btn btn-sm btn-light border p-1 px-2"
                                        onclick="insertTag('myTextarea4', '_', '_')"><i>I</i></button>
                                </div>
                                <textarea id="myTextarea4" class="form-control" required="" name="message" rows="3"
                                    placeholder="{{ __('Select from the list below...') }}"
                                    oninput="updatePreview('myTextarea4', 'previewText4')"></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-control-label">{{ __('Footer Text') }}</label>
                                <input id="footerText4" type="text" class="form-control" name="footer_text"
                                    placeholder="{{ __('Powered by GoWaSender') }}" value="" required="" maxlength="50"
                                    oninput="updatePreview('footerText4', 'previewFooter4')" />
                            </div>

                            <div class="form-group mb-0">
                                <label class="form-control-label">{{ __('Select Button Label') }}</label>
                                <input id="buttonText4" type="text" class="form-control" name="button_text"
                                    placeholder="{{ __('Show Options') }}" value="" required="" maxlength="50"
                                    oninput="updatePreview('buttonText4', 'buttonlist4')" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card premium-card">
                        <div class="card-header bg-white border-0 py-3">
                            <h3 class="mb-0 font-weight-bold"><i
                                    class="fas fa-eye text-primary mr-2"></i>{{__('Preview')}}</h3>
                        </div>
                        <div class="card-body p-0" style="background: #e5ddd5; min-height: 250px; position: relative;">
                            <div
                                style="background-image: url('{{ asset('assets/img/whatsapp-bg.png') }}'); opacity: 0.1; position: absolute; inset: 0;">
                            </div>
                            <div class="p-3" style="position: relative; z-index: 1;">
                                <div
                                    style="background: white; border-radius: 8px; overflow: hidden; max-width: 85%; margin-left: auto; box-shadow: 0 1px 2px rgba(0,0,0,0.1); position: relative;">
                                    <div class="p-2 border-bottom bg-light">
                                        <h5 class="mb-0 text-primary" id="previewheader4"
                                            style="font-size: 14px; font-weight: 700;">List Header</h5>
                                    </div>
                                    <div class="p-2 text-dark">
                                        <p class="mb-1" id="previewText4"
                                            style="font-size: 13px; white-space: pre-wrap;">Select an option...</p>
                                        <small id="previewFooter4" class="text-muted" style="font-size: 10px;">Footer
                                            text here</small>
                                    </div>
                                    <div class="p-2 border-top text-center bg-white">
                                        <span id="buttonlist4" class="font-weight-bold"
                                            style="color: #008069; font-size: 13px;"><i
                                                class="fas fa-list mr-1"></i>Show Options</span>
                                    </div>
                                    <div
                                        style="position: absolute; right: -8px; top: 0; width: 0; height: 0; border-top: 10px solid #f8f9fa; border-right: 10px solid transparent;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center py-4">
                            <button id="submitBtn" type="submit" class="premium-btn premium-btn-primary w-100">{{
                                __('Send Message') }} <i class="fas fa-paper-plane ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!------------------------------------------------------------>
    <!------------------------------------------------------------>
    <div class="tab-pane fade" id="mode_10" role="tabpanel" aria-labelledby="profile-tab4">
        <form method="POST" action="{{ route('user.sent.customtext', 'text-with-button') }}" class="ajaxform_reset_form"
            enctype="multipart/form-data">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-center">
                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Recipient')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group focused">
                                    <label class="form-control-label">Message To</label><br>
                                    <input id="phone" type="number" class="form-control" name="phone"
                                        placeholder="{{ __('Phone number with country code') }}" value="" required=""
                                        autofocus="" minlength="10" maxlength="15" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Messages')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea9', '*', '*')">Bold</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea9', '_', '_')">Italic</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea9', '~', '~')">Strike</button>
                                    <button type="button" class="emojipick btn btn-outline-primary btn-sm"
                                        style="padding:8px;">Emoji</button>
                                    <textarea id="myTextarea9" class="form-control one mt-1" name="message" required=""
                                        maxlength="1000"
                                        oninput="updatePreview('myTextarea9', 'previewText9')"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Header Text (Optional)') }}</label>
                                    <input id="headerButton9" type="text" class="form-control" name="header_text"
                                        autofocus="" maxlength="100"
                                        oninput="updatePreview('headerButton9', 'headerPreview9')" />
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Footer Text (Optional)') }}</label>
                                    <input id="footerButton9" type="text" class="form-control" name="footer_text"
                                        autofocus="" maxlength="100"
                                        oninput="updatePreview('footerButton9', 'footerPreview9')" />
                                </div>
                            </div>

                            <div class="col-sm-12" id="list-button-appendarea">
                                <div class="form-group plain_button_message_text">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>{{ __('Button 1 Text') }}</label>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:void(0)" id="add-more"
                                                class="btn btn-sm btn-primary btn-neutral float-right mb-1"><i
                                                    class="fa fa-plus"></i>&nbsp{{ __('Add More') }}</a>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="buttons[]" required="" autofocus=""
                                        maxlength="50" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Preview')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body"
                                style="justify-content: flex-end; text-align: right; background: url('{{ asset('assets/img/bg.png') }}');">
                                <div class="card"
                                    style="text-align: left; border-top-left-radius: 0; margin-bottom: 5px;">

                                    <div class="card-body" style="">
                                        <h2 class="heading" id="headerPreview9">This is the heading</h2>
                                        <p class="card-text" id="previewText9">This is the example of Button messages to
                                            demonstrate the Preview panel of whatsApp Api</p>
                                        <span id="footerPreview9" class="text-muted text-xs">This is footer
                                            example</span>
                                    </div>
                                </div>
                                <div class="card" style="text-align: center; margin-bottom: 5px;">
                                    <div class="card-body" style="padding:1rem">
                                        <span class="" style="color: #00a5f4">Buttons</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="text-align:center;margin-bottom: 10px;">
                            <button id="submitBtn" type="submit"
                                class="btn btn-outline-primary submit-button">{{ __('Send Message') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!---------------------------------------------------------------->
    <!---------------------------------------------------------------->

    <div class="tab-pane fade" id="mode_6" role="tabpanel" aria-labelledby="profile-tab4">
        <form method="POST" action="{{ route('user.sent.customtext', 'text-with-audio') }}" class="ajaxform_reset_form">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-center">
                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Recipient')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group focused">
                                    <label class="form-control-label">Message To</label><br>
                                    <input id="phone" type="number" class="form-control" name="phone"
                                        placeholder="{{ __('Phone number with country code') }}" value="" required=""
                                        autofocus="" minlength="10" maxlength="15" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Messages')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Select Audio File') }}</label>
                                    <input id="phone" type="file" class="form-control" name="audio" required="" />
                                    <small>{{__(' Supported image type:')}}</small> <small
                                        class="text-danger">{{ __('mp3,wav,ogg') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Preview')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body"
                                style="justify-content: flex-end; text-align: right; background: url('{{ asset('assets/img/bg.png') }}');">
                                <div class="card"
                                    style="text-align: left; border-top-left-radius: 0; margin-bottom: 5px;">
                                    <audio controls style="width:auto">
                                        <!-- Specify the audio file source -->
                                        <source src="example.mp3" type="audio/mp3">
                                    </audio>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="text-align:center;margin-bottom: 10px;">
                            <button id="submitBtn" type="submit"
                                class="btn btn-outline-primary submit-button">{{ __('Send Message') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!---------------------------------------------------------------->
    <!---------------------------------------------------------------->

    <div class="tab-pane fade" id="mode_7" role="tabpanel" aria-labelledby="profile-tab4">
        <form method="POST" action="{{ route('user.sent.customtext', 'text-with-location') }}"
            class="ajaxform_reset_form">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-center">
                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Recipient')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group focused">
                                    <label class="form-control-label">Message To</label><br>
                                    <input id="phone" type="number" class="form-control" name="phone"
                                        placeholder="{{ __('Phone number with country code') }}" value="" required=""
                                        autofocus="" minlength="10" maxlength="15" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Messages')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Latitude') }}</label>
                                    <input type="number" step="any" name="degreesLatitude" required=""
                                        class="form-control" placeholder="Example: 24.121231">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Longitude') }}</label>
                                    <input type="number" step="any" name="degreesLongitude" required=""
                                        class="form-control" placeholder="Example: 55.1121221">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Preview')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body"
                                style="justify-content: flex-end; text-align: right; background: url('{{ asset('assets/img/bg.png') }}');">
                                <div class="card"
                                    style="text-align: left; border-top-left-radius: 0; margin-bottom: 5px;">
                                    <iframe
                                        src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=latitude,longitude"
                                        allowfullscreen></iframe>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="text-align:center;margin-bottom: 10px;">
                            <button id="submitBtn" type="submit"
                                class="btn btn-outline-primary submit-button">{{ __('Send Message') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!----------------------------------------------------------------------->
    <!----------------------------------------------------------------------->

    <div class="tab-pane fade" id="mode_9" role="tabpanel" aria-labelledby="profile-tab4">
        <form method="POST" action="{{ route('user.sent.customtext','text-with-video') }}" class="ajaxform_reset_form">
            @csrf
            @include('user.singlesend.gateway_selector')
            <div class="row justify-content-center">
                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Recipient')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="campign_elements">
                                <div id="form-group-contact_id" class="form-group focused">
                                    <label class="form-control-label">Message To</label><br>
                                    <input id="phone" type="number" class="form-control" name="phone"
                                        placeholder="{{ __('Phone number with country code') }}" value="" required=""
                                        autofocus="" minlength="10" maxlength="15" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Messages')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Select video File') }}</label>
                                    <input id="videoInput" type="file" class="form-control" name="video" required=""
                                        onchange="previewFile('videoInput', 'filePreviewVideo', 'video')" />
                                    <small>{{__(' Supported Video type:')}}</small> <small class="text-danger">{{
                                        __('mp4 | max : 6mb') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea5', '*', '*')">Bold</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea5', '_', '_')">Italic</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" style="padding:8px;"
                                        onclick="insertTag('myTextarea5', '~', '~')">Strike</button>
                                    <button type="button" class="emojipick btn btn-outline-primary btn-sm"
                                        style="padding:8px;">Emoji</button>
                                    <textarea id="myTextarea5" class="form-control one mt-1" name="message" required=""
                                        maxlength="1000"
                                        oninput="updatePreview('myTextarea5', 'previewText5')"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Preview')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body"
                                style="justify-content: flex-end; text-align: right; background: url('{{ asset('assets/img/bg.png') }}');">
                                <div class="card"
                                    style="text-align: left; border-top-left-radius: 0; margin-bottom: 5px;">
                                    <video id="filePreviewVideo" controls>
                                        <source src="example.mp4" type="video/mp4">
                                    </video>
                                    <div class="card-body" style="">
                                        <p class="card-text" id="previewText5">This is the example of Caption and text
                                            related to Video file. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="text-align:center;margin-bottom: 10px;">
                            <button id="submitBtn" type="submit" class="btn btn-outline-primary submit-button">{{
                                __('Send Message') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------->

    <div class="tab-pane fade" id="mode_4" role="tabpanel" aria-labelledby="profile-tab4">
        <form id="metatemplate" method="POST" action="{{ route('user.sent.customtext','meta-template') }}"
            class="ajaxform_reset_form" enctype="multipart/form-data">
            @csrf
            @include('user.singlesend.gateway_selector')
            <input type="hidden" name="language" id="language" value="">
            <div class="row justify-content-center">
                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('📢 Meta Approved')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('user.singlesend.new.campaign')
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Variables')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('user.singlesend.new.variables')
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">{{__('Preview')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('user.singlesend.new.preview')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-------------------------------------------------------------->
    <!-------------------------------------------------------------->


    <!------------------------------------------------------------->
    <!------------------------------------------------------------->

</div>
</div>
@foreach($cloudapis as $cloudapi)
<input type="hidden" id="ccuuid" value="{{ $cloudapi->uuid }}">
@endforeach
<input type="hidden" id="base_url" value="{{ url('/') }}">
@endsection
@push('js')
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="https://woody180.github.io/vanilla-javascript-emoji-picker/vanillaEmojiPicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit-icons.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/bulk/template.js') }}"></script>
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


    function insertTag(textareaId, openTag, closeTag) {
        var textarea = document.getElementById(textareaId);
        var startPos = textarea.selectionStart;
        var endPos = textarea.selectionEnd;
        var selectedText = textarea.value.substring(startPos, endPos);
        var newText = openTag + selectedText + closeTag;
        textarea.value = textarea.value.substring(0, startPos) + newText + textarea.value.substring(endPos, textarea.value.length);
        textarea.focus();
        textarea.setSelectionRange(endPos + openTag.length + closeTag.length, endPos + openTag.length + closeTag.length);
    }

    function saveToLocalStorage(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }
    function getFromLocalStorage(key) {
        const storedValue = localStorage.getItem(key);

        // Parse the stored JSON value
        return storedValue ? JSON.parse(storedValue) : null;
    }

    const exampleKey = 'cloudapi';
    const exampleValue = document.getElementById('ccuuid').value;

    // Save the key-value pair
    saveToLocalStorage(exampleKey, exampleValue);
    const retrievedValue = getFromLocalStorage(exampleKey);

    console.log(retrievedValue);

</script>

<script>
    function updatePreview(textareaId, previewId) {
        // Get the value from the corresponding textarea
        var message = document.getElementById(textareaId).value;

        // Update the content of the corresponding preview element
        document.getElementById(previewId).textContent = message;
    }
</script>

<script>
    function previewFile(inputId, previewId, fileType) {
        var input = document.getElementById(inputId);
        var preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if (fileType === 'image') {
                    preview.src = e.target.result;
                } else if (fileType === 'video') {
                    preview.src = e.target.result;
                } else if (fileType === 'pdf') {
                    // Handle PDF preview, e.g., use a PDF viewer or convert pages to images
                    preview.innerHTML = 'PDF Preview: ' + input.files[0].name;
                }
            }

            if (fileType !== 'pdf') {
                reader.readAsDataURL(input.files[0]);
            } else {
                // Handle PDF preview, e.g., use a PDF viewer or convert pages to images
                preview.innerHTML = 'PDF Preview: ' + input.files[0].name;
            }
        } else {
            if (fileType !== 'pdf') {
                preview.src = "";
            } else {
                preview.innerHTML = 'No PDF selected';
            }
        }
    }
</script>

@endpush