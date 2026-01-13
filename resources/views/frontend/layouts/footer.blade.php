<footer>
  <div class="top_footer" id="contact">
    <!-- animation line -->
    <div class="anim_line dark_bg">
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
    <!-- container start -->
    <div class="container">
      <!-- row start -->
      <div class="row">
        <!-- footer link 1 -->
        <div class="col-lg-4 col-md-6 col-12">
          <div class="abt_side">
            <div class="logo"> <img src="{{ asset('assets/img/brand/blue.png') }}" alt="image">
            </div>
            <ul>
              <li><a
                  href="maito:{{ get_option('primary_data', true)->contact_email ?? '' }}">{{ get_option('primary_data', true)->contact_email ?? '' }}</a>
              </li>
              <li><a
                  href="tel:{{ get_option('primary_data', true)->contact_phone ?? '' }}">{{ get_option('primary_data', true)->contact_phone ?? '' }}</a>
              </li>
            </ul>
            <ul class="social_media">
              @if(!empty(get_option('primary_data', true)->socials->facebook))
                <li><a href="{{ get_option('primary_data', true)->socials->facebook }}"><i
                      class="icofont-facebook"></i></a></li>
              @endif
              @if(!empty(get_option('primary_data', true)->socials->twitter))
                <li><a href="{{ get_option('primary_data', true)->socials->twitter }}"><i class="icofont-twitter"></i></a>
                </li>
              @endif
              @if(!empty(get_option('primary_data', true)->socials->instagram))
                <li><a href="{{ get_option('primary_data', true)->socials->instagram }}"><i
                      class="icofont-instagram"></i></a></li>
              @endif
              @if(!empty(get_option('primary_data', true)->socials->linkedin))
                <li><a href="{{ get_option('primary_data', true)->socials->linkedin }}"><i
                      class="icofont-linkedin"></i></a></li>
              @endif
            </ul>
          </div>
        </div>

        <!-- footer link 2 -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="links">
            <h3>Useful Links</h3>
            <ul>
              <li><a href="{{ url('/features') }}">{{ __('Features') }}</a></li>
              <li><a href="{{ url('/about') }}">{{ __('About Us') }}</a></li>
              <li><a href="{{ url('/pricing') }}">Pricing</a></li>
              <li><a href="{{ url('/faq') }}">{{ __('FAQ') }}</a></li>
              <li><a href="{{ url('/blogs') }}">{{ __('News') }}</a></li>
            </ul>
          </div>
        </div>

        <!-- footer link 3 -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="links">
            <h3>Help & Support</h3>
            <ul>
              <li><a href="{{ url('/features') }}">{{ __('Features') }}</a></li>
              <li><a href="{{ url('/about') }}">{{ __('About Us') }}</a></li>
              <li><a href="{{ url('/pricing') }}">Pricing</a></li>
              <li><a href="{{ url('/faq') }}">{{ __('FAQ') }}</a></li>
              <li><a href="{{ url('/blogs') }}">{{ __('News') }}</a></li>
            </ul>
          </div>
        </div>

        <!-- footer link 4 -->
        <div class="col-lg-2 col-md-6 col-12">
          <div class="try_out">
            <h3>Let’s Try Out</h3>
            <ul class="app_btn">
              <li>
                <a href="{{ url('/login') }}"><i class="icofont-user"></i>
                  {{ get_option('banner', true, true)->btnsecond ?? '' }}
                </a>
              </li>
              <li>
                <a href="{{ url('/pricing') }}"><i class="icofont-globe"></i>
                  {{ get_option('banner', true, true)->btnfirst ?? '' }}
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- row end -->
    </div>
    <!-- container end -->
  </div>

  <!-- last footer -->
  <div class="bottom_footer">
    <!-- container start -->
    <div class="container">
      <!-- row start -->
      <div class="row">
        <div class="col-md-6">
          <p>© Copyrights {{ date('Y') }} Hosterlo Inc. All rights reserved.</p>
        </div>
        <div class="col-md-6">
          <p class="developer_text">Design & developed with Love </p>
        </div>
      </div>
      <!-- row end -->
    </div>
    <!-- container end -->
  </div>

  <!-- go top button -->
  <div class="go_top">
    <span><img src="{{ asset('assets/frontend/images/go_top.png')}}" alt="image"></span>
  </div>
</footer>