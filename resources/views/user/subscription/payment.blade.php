@extends('gateways.main')
@section('content')
   <div class="row">
      <div class="col-12">
         <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
               <img src="{{ asset(get_option('primary_data', true)->logo ?? '') }}" alt="Logo" class="img-fluid"
                  style="max-height: 40px; width: auto;">
            </div>
            <div class="text-right">
               <h1 class="unpaid mb-0">{{ __('Unpaid') }}</h1>
            </div>
         </div>
      </div>

      @if(Session::has('error'))
         <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
               <span class="alert-text"><strong>{{ __('Payment Error') }}:</strong> {{ __('Transaction failed. If you were charged, please contact our support team immediately.') }}</span>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
         </div>
      @endif

      @if(Session::has('min-max'))
         <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
               <span class="alert-icon"><i class="fas fa-info-circle"></i></span>
               <span class="alert-text">{{ Session::get('min-max') }}</span>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
         </div>
      @endif

      @if($errors->any())
         <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <ul class="mb-0 pl-3">
                  @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                  @endforeach
               </ul>
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
         </div>
      @endif

      <div class="col-12 mb-4">
         <div class="card bg-secondary shadow-none border-0">
            <div class="card-body py-4">
               <h5 class="text-muted text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing: 0.025em;">
                  {{ __('Select Payment Method') }}</h5>
               <div class="row">
                  @foreach($gateways as $key => $gateway)
                     <div class="radiocontainer gateways col-6 col-sm-4 mb-3">
                        <input id="gateway_{{ $gateway->id }}" class="gateway-button" type="radio" name="paymentmethod"
                           value="{{$gateway->id}}" {{ $key == 0 ? 'checked' : '' }}
                           data-target="#gateway-form{{ $gateway->id }}" />
                        <label for="gateway_{{ $gateway->id }}" class="w-100">
                           <img src="{{ asset($gateway->logo) }}" class="img-fluid" style="max-height: 35px;" />
                        </label>
                     </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>

      @foreach($gateways as $key => $gateway)
         <div class="col-12 {{ $key != 0 ? 'none' : '' }} gateway-form" id="gateway-form{{ $gateway->id }}">
            <form method="post" action="{{ url('user/make-subscribe/' . $gateway->id . '/' . $plan->id) }}"
               class="ajaxform_next_page" enctype="multipart/form-data">
               @csrf
               <div class="table-responsive">
                  <table class="table items mb-0">
                     <thead>
                        <tr class="title">
                           <th class="px-0">{{ __('Payment Summary') }}</th>
                           <th class="text-right px-0">{{ __('Details') }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td class="px-0 border-0">{{ __('Method Name') }}</td>
                           <td class="text-right font-weight-bold px-0 border-0">{{ $gateway->name }}</td>
                        </tr>
                        @if($gateway->currency != null)
                           <tr>
                              <td class="px-0">{{ __('Gateway Currency') }}</td>
                              <td class="text-right px-0">{{ strtoupper($gateway->currency) }}</td>
                           </tr>
                        @endif
                        @if($gateway->charge != 0)
                           <tr>
                              <td class="px-0">{{ __('Gateway Charge') }}</td>
                              <td class="text-right text-danger px-0">{{ $gateway->charge }}</td>
                           </tr>
                        @endif
                        <tr class="bg-light-info">
                           <td class="font-weight-bold px-0">{{ __('Total Payable') }}</td>
                           <td class="text-right font-weight-bold text-primary px-0" style="font-size: 1.1rem;">
                              {{ $total * $gateway->multiply + $gateway->charge }}
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>

               @if($gateway->comment != null)
                  <div class="alert alert-info shadow-none border-0 mt-3 p-3">
                     <small class="font-weight-bold d-block mb-1 text-uppercase"
                        style="font-size: 0.65rem;">{{ __('Payment Instruction') }}:</small>
                     <div style="font-size: 0.85rem;">{!! $gateway->comment !!}</div>
                  </div>
               @endif

               @if($gateway->phone_required == 1)
                  <div class="form-group mt-3">
                     <label class="form-control-label">{{ __('Your phone number') }}</label>
                     <input type="number" name="phone" class="form-control" required="" value="{{ Auth::user()->phone }}">
                  </div>
               @endif
               @if($gateway->is_auto == 0)
                  <div class="form-group mt-3">
                     <label class="form-control-label">{{ __('Submit your payment proof') }}</label>
                     <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="customFile" required="" accept="image/*">
                        <label class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="form-control-label">{{ __('Comment') }}</label>
                     <textarea class="form-control" required="" name="comment" maxlength="500" rows="2"
                        placeholder="{{ __('Transaction ID or other info') }}"></textarea>
                  </div>
               @endif

               <button
                  class="btn btn-primary col-12 submit-button mb-4 mt-3 py-3 shadow-lg">{{ __('Complete Payment') }}</button>
            </form>
         </div>
      @endforeach

      <div class="col-12 py-3">
         <hr class="my-3">
      </div>

      <div class="col-12">
         <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
               <div class="addressbox p-3 border rounded bg-white h-100">
                  <strong>{{ __('Invoiced To') }}</strong>
                  <div class="text-muted mt-2" style="font-size: 0.85rem;">
                     <span class="d-block font-weight-bold text-dark">{{ Auth::user()->name }}</span>
                     @if(Auth::user()->address)
                        <span class="d-block mt-1">{{ Auth::user()->address }}</span>
                     @endif
                     <span class="d-block mt-1">{{ Auth::user()->email }}</span>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="addressbox p-3 border rounded bg-white h-100 shadow-sm border-primary">
                  <strong>{{ __('Official Merchant') }}</strong>
                  <div class="text-muted mt-2" style="font-size: 0.85rem;">
                     <span class="d-block font-weight-bold text-primary">{{ env('APP_NAME') }}</span>
                     @if($primary_data->address)
                        <span class="d-block mt-1"><i class="fas fa-map-marker-alt mr-1"></i> {{ $primary_data->address }}</span>
                     @endif
                     @if($primary_data->contact_email)
                        <span class="d-block mt-1"><i class="fas fa-envelope mr-1"></i> {{ $primary_data->contact_email }}</span>
                     @endif
                     @if($primary_data->contact_phone)
                        <span class="d-block mt-1"><i class="fas fa-phone mr-1"></i> {{ $primary_data->contact_phone }}</span>
                     @endif
                  </div>
               </div>
            </div>
         </div>

         <div class="table-responsive">
            <table class="table items mb-0">
               <thead class="thead-light">
                  <tr class="title">
                     <th class="px-0">{{ __('Description') }}</th>
                     <th class="text-right px-0">{{ __('Amount') }}</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td class="px-0">
                        <span class="font-weight-bold text-dark">{{ $plan->title }}</span>
                        <small class="d-block text-muted">{{ __('Subscription Plan') }}</small>
                     </td>
                     <td class="text-right font-weight-bold px-0">{{ amount_format($plan->price, 'name') }}</td>
                  </tr>
               </tbody>
            </table>
         </div>

         <div class="row justify-content-end mt-2">
            <div class="col-md-7 col-lg-6">
               <table class="table table-totals mb-0">
                  <tr>
                     <td class="text-right px-0">{{ __('Sub Total') }}:</td>
                     <td class="text-right font-weight-bold px-0" style="width: 120px;">
                        {{ amount_format($plan->price, 'name') }}</td>
                  </tr>
                  <tr>
                     <td class="text-right px-0">{{ __('Tax') }}:</td>
                     <td class="text-right font-weight-bold px-0">{{ amount_format($tax, 'name') }}</td>
                  </tr>
                  <tr class="total-row">
                     <td class="text-right px-0">{{ __('Grand Total') }}:</td>
                     <td class="text-right text-primary px-0 font-weight-bold">{{ amount_format($total, 'name') }}</td>
                  </tr>
               </table>
            </div>
         </div>

         <div class="text-center mt-5">
            <a href="{{ url('/user/subscription') }}" class="text-muted font-weight-600" style="font-size: 0.85rem;">
               <i class="fas fa-arrow-left mr-1"></i> {{ __('Cancel and return to plans') }}
            </a>
         </div>
      </div>
   </div>
@endsection

@push('js')
   <script>
      $('.custom-file-input').on('change', function () {
         let fileName = $(this).val().split('\\').pop();
         $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });
   </script>
   <script src="{{ asset('assets/js/pages/user/subscription-pay.js') }}"></script>
@endpush