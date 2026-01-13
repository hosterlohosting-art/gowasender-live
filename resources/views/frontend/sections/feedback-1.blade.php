<section class="row_am testimonial_section"> 
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <!-- h2 -->
          <h2>{{ $home->testimonial->title ?? '' }}</h2>
        </div>
        <div class="testimonial_block" data-aos="fade-in" data-aos-duration="1500">
          <div id="testimonial_slider" class="owl-carousel owl-theme">
          	<!-- user 1 -->
             @foreach($testimonials as $testimonial)
            <div class="item">
              <div class="testimonial_slide_box">
                <div class="rating">
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                  <span><i class="icofont-star"></i></span>
                </div>
                <p class="review">
                  “ {{ Str::limit($testimonial->excerpt->value ?? '',150) }} ”
                </p>
                <div class="testimonial_img">
                  <img src="{{ asset($testimonial->preview->value ?? '') }}" alt="image" >
                </div>
                <h3>{{ $testimonial->title ?? '' }}</h3>
                <span class="designation">({{ $testimonial->slug ?? '' }})</span>
              </div>
            </div>
            @endforeach

          <!-- total review -->
          <div class="total_review">
            <div class="rating">
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <span><i class="icofont-star"></i></span>
              <p>5.0 / 5.0</p>
            </div>
          </div>
          <!-- avtar faces -->
          <div class="avtar_faces">
            <img src="{{ asset('assets/frontend/images/avtar_testimonial.png')}}" alt="image" >
          </div>
        </div>
      </div>
      <!-- container end -->
    </section>