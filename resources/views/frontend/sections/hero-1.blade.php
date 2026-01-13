<section class="banner_section">
      <!-- container start -->
      <div class="container">
      	<!-- vertical animation line -->
        <div class="anim_line">
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
            <span><img src="{{ asset('assets/frontend/images/anim_line.png')}}" alt="anim_line"></span>
        </div>
        <!-- row start -->
        <div class="row">
          <div class="col-lg-6 col-md-12"  data-aos="fade-right" data-aos-duration="1500">
          	<!-- banner text -->
            <div class="banner_text">
              <!-- h1 -->
              <h1>{!! filterXss($banner->banner_header) !!}</span></h1>
              <!-- p -->
             
            </div>
            <!-- app buttons -->
            <ul class="app_btn">
              <li>
                <a href="{{ url('/pricing') }}"><i class="icofont-globe"></i>
                {!! filterXss($banner->btnfirst) !!}
                </a>
              </li>
              <li>
                <a href="{{ !Auth::check() ? url('/login') : url('/login') }}"><i class="icofont-user"></i>
                {{ !Auth::check() ? __('Sign In') : __('Dashboard') }}
                </a>
              </li>
            </ul>

            <!-- users -->
            <div class="used_app">
              <ul>
                <li><img src="{{ asset('assets/frontend/images/used01.png')}}" alt="image" ></li>
                <li><img src="{{ asset('assets/frontend/images/used02.png')}}" alt="image" ></li>
                <li><img src="{{ asset('assets/frontend/images/used03.png')}}" alt="image" ></li>
                <li><img src="{{ asset('assets/frontend/images/used04.png')}}" alt="image" ></li>
              </ul>
              <p>{!! filterXss($banner->usedthis) !!}</p>
            </div>
          </div>

          <!-- banner slides start -->
          <div class="col-lg-6 col-md-12"  data-aos="fade-in" data-aos-duration="1500">
            <div class="banner_slider">
              <div class="left_icon">
                <img src="{{ asset('assets/frontend/images/message_icon.png')}}" alt="image" >
              </div>
              <div class="right_icon">
                <img src="{{ asset('assets/frontend/images/shield_icon.png')}}" alt="image" >
              </div>
              <div id="frmae_slider" class="owl-carousel owl-theme">
                <div class="item">
                  <div class="slider_img">
                    <img src="{{ asset($banner->phone_image_1 ?? '') }}" alt="image" >
                  </div>
                </div>
                <div class="item">
                  <div class="slider_img">
                    <img src="{{ asset($banner->phone_image_2 ?? '') }}" alt="image" >
                  </div>
                </div>
                <div class="item">
                  <div class="slider_img">
                    <img src="{{ asset($banner->phone_image_3 ?? '') }}" alt="image" >
                  </div>
                </div>
              </div>
              <div class="slider_frame">
                <img src="{{ asset('assets/frontend/images/mobile_frame_svg.svg')}}" alt="image" >
              </div>
            </div>
          </div>
          <!-- banner slides end -->

        </div>
        <!-- row end -->
      </div>
      <!-- container end -->
    </section>





























<!-- tp-slider-area-start -->
