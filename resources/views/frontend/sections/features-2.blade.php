<section class="row_am modern_ui_section">
      <!-- container start -->
      <div class="container">
      	<!-- row start -->
        <div class="row">
          <div class="col-lg-6">
          	<!-- UI content -->
            <div class="ui_text">
              <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                <h2>{{$overview->overview_header ?? null}}</span></h2>
                <p>
                  {{$overview->overview_subheader ?? null }}
                </p>
              </div>
              <ul class="design_block">
                <li data-aos="fade-up" data-aos-duration="1500">
                  <h4>{{$overview->overview_title_1 ?? null }}</h4>
                  <p>{{$overview->overview_subtitle_1 ?? null }}</p>
                </li>
                <li data-aos="fade-up" data-aos-duration="1500">
                <h4>{{$overview->overview_title_2 ?? null}}</h4>
                  <p>{{$overview->overview_subtitle_2 ?? null }}</p>
                </li>
                <li data-aos="fade-up" data-aos-duration="1500">
                <h4>{{$overview->overview_title_3 ?? null }}</h4>
                  <p>{{$overview->overview_subtitle_3 ?? null }}</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg-6">
          	<!-- UI Image -->
            <div class="ui_images" data-aos="fade-in" data-aos-duration="1500">
              <div class="left_img">
                <img class="moving_position_animatin" src="{{ asset($overview->overview_image_1 ?? '') }}" alt="image" >
              </div>
              <!-- UI Image -->
              <div class="right_img">
                <img class="moving_position_animatin" src="{{ asset('assets/frontend/images/secure_data.png')}}" alt="image" >
                <img class="moving_position_animatin" src="{{ asset($overview->overview_image_2 ?? '') }}" alt="image" >
                <img class="moving_position_animatin" src="{{ asset($overview->overview_image_3 ?? '') }}" alt="image" >
              </div>
            </div>
          </div>
        </div>
        <!-- row end -->
      </div>
      <!-- container end -->
    </section>