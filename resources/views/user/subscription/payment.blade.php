@extends('gateways.main')
@section('content')
   <div class="col-sm-12">
      <div class="row align-items-center mb-4">
         <div class="col">
            <img src="{{ asset(get_option('primary_data', true)->logo ?? '') }}" alt="Logo" class="img-fluid"
               style="max-height: 50px;">
         </div>
         <div class="col-auto text-right">
            <h1 class="unpaid mb-0">{{ __('Unpaid') }}</h1>
         </div>
      </div>
   </div>

   @if(Session::has('error'))
      <div class="col-sm-12">
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="fas fa-sad-tear"></i></span>
            <span class="alert-text"><strong>{{ __('Opps ') }}</strong>
               {{ __('Transaction failed if you make payment successfully please contact us.') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
      </div>
   @endif

   <div class="col-sm-12 mb-4">
      <div class="card bg-secondary shadow-none border-0">
         <div class="card-body">
            <div class="row">
               @foreach($gateways as $key => $gateway)
                  <div class="radiocontainer gateways col-sm-4 mb-3">
                     <input id="gateway_{{ $gateway->id }}" class="gateway-button" type="radio" name="paymentmethod"
                        value="{{$gateway->id}}" {{ $key == 0 ? 'checked' : '' }}
                        data-target="#gateway-form{{ $gateway->id }}" />
                     <label for="gateway_{{ $gateway->id }}">
                        <img src="{{ asset($gateway->logo) }}" class="gateway-img" />
                     </label>
                  </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>

   @foreach($gateways as $key => $gateway)
      <div class="col-sm-12 {{ $key != 0 ? 'none' : '' }} gateway-form" id="gateway-form{{ $gateway->id }}">
         <form method="post" action="{{ url('user/make-subscribe/' . $gateway->id . '/' . $plan->id) }}"
            class="ajaxform_next_page" enctype="multipart/form-data">
            @csrf
            <div class="table-responsive">
               <table class="table items align-items-center">
                  <tr class="title">
                     <td>{{ __('Payment Summary') }}</td>
                     <td class="text-right">{{ __('Details') }}</td>
                  </tr>
                  <tr>
                     <td>{{ __('Method Name') }}</td>
                     <td class="text-right font-weight-bold">{{ $gateway->name }}</td>
                  </tr>
                  @if($gateway->currency != null)
                     <tr>
                        <td>{{ __('Gateway Currency') }}</td>
                        <td class="text-right">{{ strtoupper($gateway->currency) }}</td>
                     </tr>
                  @endif
                  @if($gateway->charge != 0)
                     <tr>
                        <td>{{ __('Gateway Charge') }}</td>
                        <td class="text-right text-danger">{{ $gateway->charge }}</td>
                     </tr>
                  @endif
                  <tr class="bg-light">
                     <td class="font-weight-bold">{{ __('Total Payable') }}</td>
                     <td class="text-right font-weight-bold text-primary" style="font-size: 1.25rem;">
                        {{ $total * $gateway->multiply + $gateway->charge }}
                     </td>
                  </tr>
               </table>

               @if($gateway->comment != null)
                  <div class="alert alert-info shadow-none border-0 mt-3">
                     <small class="font-weight-bold d-block mb-1 text-uppercase">{{ __('Payment Instruction') }}:</small>
                     {!! $gateway->comment !!}
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
                     <input type="file" name="image" class="form-control" required="" accept="image/*">
                  </div>
                  <div class="form-group">
                     <label class="form-control-label">{{ __('Comment') }}</label>
                     <textarea class="form-control" required="" name="comment" maxlength="500" rows="3"></textarea>
                  </div>
               @endif
            </div>
            <button class="btn btn-primary col-12 submit-button mb-4 mt-2 py-3">{{ __('Complete Payment') }}</button>
         </form>
      </div>
   @endforeach

   <div class="col-sm-12">
      <div class="row mb-4">
         <div class="col-12">
            <div class="addressbox p-3 border rounded bg-white">
               <strong>{{ __('Invoiced To') }}</strong>
               <div class="text-muted">
                  {{ Auth::user()->name }}<br />
                  @if(Auth::user()->address)
                     {{ Auth::user()->address }}
                  @endif
               </div>
            </div>
         </div>
      </div>

      <div class="table-responsive">
         <table class="table items align-items-center">
            <thead class="thead-light">
               <tr class="title">
                  <th>{{ __('Description') }}</th>
                  <th class="text-right">{{ __('Amount') }}</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>
                     <span class="font-weight-bold text-dark">{{ $plan->title }}</span>
                     <small class="d-block text-muted">{{ __('Subscription Plan') }}</small>
                  </td>
                  <td class="text-right font-weight-bold">{{ amount_format($plan->price, 'name') }}</td>
               </tr>
            </tbody>
         </table>

         <div class="row justify-content-end">
            <div class="col-md-5 col-lg-4">
               <table class="table table-totals">
                  <tr>
                     <td class="text-right">{{ __('Sub Total') }}:</td>
                     <td class="text-right font-weight-bold">{{ amount_format($plan->price, 'name') }}</td>
                  </tr>
                  <tr>
                     <td class="text-right">{{ __('Tax') }}:</td>
                     <td class="text-right font-weight-bold">{{ amount_format($tax, 'name') }}</td>
                  </tr>
                  <tr class="total-row">
                     <td class="text-right">{{ __('Grand Total') }}:</td>
                     <td class="text-right text-primary">{{ amount_format($total, 'name') }}</td>
                  </tr>
               </table>
            </div>
         </div>
      </div>

      <div class="text-center mt-4">
         <a href="{{ url('/user/subscription') }}" class="text-muted">
            <i class="fas fa-times-circle mr-1"></i> {{ __('Cancel and return to plans') }}
         </a>
      </div>
   </div>
@endsection
@push('js')
   <script src="{{ asset('assets/js/pages/user/subscription-pay.js') }}"></script>
@endpush