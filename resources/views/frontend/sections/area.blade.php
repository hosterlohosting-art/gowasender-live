<section class="row_am free_app_section" id="getstarted">
    	<!-- container start -->
        <div class="container">
            <div class="free_app_inner" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100"> 
              <!-- vertical line animation -->
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
              	<!-- row start -->
                <div class="row">
                	<!-- content -->
                    <div class="col-md-6">
                        <div class="free_text">
                            <div class="section_title">
                                <h2>{{$download->download_header ?? ''}}</h2>
                                <p>{{$download->download_subheader ?? ''}}</p>
                            </div>
                            <ul class="app_btn">
                              <li>
                              <a href="{{ url('/pricing') }}"><i class="icofont-globe"></i>
                                {!! filterXss($banner->btnfirst) !!}
                              </a>
                              </li>
                              <li>
                              <a href="{{ url('/login') }}"><i class="icofont-user"></i>
                              {!! filterXss($banner->btnsecond) !!}
                              </a>
                              </li>
                            </ul>
                        </div>
                    </div>

                    <!-- images -->
                    <div class="col-md-6">
                        <div class="free_img">
                            <img src="{{ asset($download->hero_image_1 ?? '') }}" alt="image" >
                            <img class="mobile_mockup" src="{{ asset($download->hero_image_2 ?? '') }}" alt="image" >
                        </div>
                    </div>
                </div>
                <!-- row end -->
            </div>
        </div>
        <!-- container end -->
    </section>