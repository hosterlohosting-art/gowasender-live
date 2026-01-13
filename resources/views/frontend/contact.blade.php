@extends('frontend.layouts.main')
@section('content')
  @include('frontend.layouts.header')
  <main>
    <div class="bred_crumb">
      <div class="container">
        <!-- shape animation  -->
        <span class="banner_shape1"> <img src="{{ asset('assets/frontend/images/banner-shape1.png')}}" alt="image">
        </span>
        <span class="banner_shape2"> <img src="{{ asset('assets/frontend/images/banner-shape2.png')}}" alt="image">
        </span>
        <span class="banner_shape3"> <img src="{{ asset('assets/frontend/images/banner-shape3.png')}}" alt="image">
        </span>

        <div class="bred_text">
          <h1>{{ __('Contact us') }}</h1>
          <p>If you have an query, please get in touch with us, we will revert back quickly.</p>
          <ul>
            <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li><span>»</span></li>
            <li>{{ __('Contact us') }}</li>
          </ul>
        </div>
      </div>
    </div>

    <section class="contact_page_section">
      <div class="container">
        <div class="contact_inner">
          <div class="contact_form">
            <div class="section_title">
              <h2>Leave a <span>message</span></h2>
              <p>Fill up form below, our team will get back soon</p>
            </div>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @if(Session::has('success'))
              <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
              </div>
            @endif
            @if(Session::has('error'))
              <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
              </div>
            @endif
            <form action="{{ route('send.mail') }}" method="POST">
              @csrf
              <div class="form-group">
                <input type="text" required="" name="name" maxlength="20" placeholder="{{ __('Enter your Name') }}"
                  class="form-control @error('name') is-invalid @enderror">
              </div>
              <div class="form-group">
                <input type="email" required="" name="email" maxlength="40" placeholder="{{ __('Enter your Mail') }}"
                  class="form-control @error('email') is-invalid @enderror">
              </div>
              <div class="form-group">
                <input type="number" required="" name="phone" maxlength="15" placeholder="{{ __('Enter your Number') }}"
                  class="form-control @error('phone') is-invalid @enderror">
              </div>
              <div class="form-group">
                <input type="text" placeholder="{{ __('Subject') }}" maxlength="100" required="" name="subject"
                  class="form-control @error('subject') is-invalid @enderror">
              </div>
              <div class="form-group">
                <textarea placeholder="{{ __('Type your Message') }}" maxlength="500" required="" name="message"
                  class="form-control @error('message') is-invalid @enderror"></textarea>
              </div>
              <div class="form-group term_check">
                <input type="checkbox" id="term">
                <label for="term">I agree to receive emails, newsletters and promotional messages</label>
              </div>
              <div class="form-group mb-0">
                <button type="submit" class="btn puprple_btn">SEND MESSAGE</button>
              </div>
            </form>
          </div>

          <div class="contact_info">
            <div class="icon"><img src="{{ asset('assets/frontend/images/contact_message_icon.png')}}" alt="image"></div>
            <div class="section_title">
              <h2>Have any <span>question?</span></h2>
              <p>If you have any question about our product, service, payment or company.</a></p>
            </div>
            <ul class="contact_info_list">
              <li>
                <div class="img">
                  <img src="{{ asset('assets/frontend/images/mail_icon.png')}}" alt="image">
                </div>
                <div class="text">
                  <span>Email Us</span>
                  <a href="mailto:support@gowasender.com">support@gowasender.com</a>
                </div>
              </li>
              <li>
                <div class="img">
                  <img src="{{ asset('assets/frontend/images/call_icon.png')}}" alt="image">
                </div>
                <div class="text">
                  <span>Call Us</span>
                  <a href="tel:+16183561311">+1 (618) 356-1311</a>
                </div>
              </li>
              <li>
                <div class="img">
                  <img src="{{ asset('assets/frontend/images/location_icon.png')}}" alt="image">
                </div>
                <div class="text">
                  <span>Visit Us</span>
                  <p>117 South Lexington Street Ste 100, Harrisonville, MO 64701, USA</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection