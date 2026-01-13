<section class="row_am trusted_section">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
          <!-- h2 -->
          <h2>Trusted by <span>multiple</span> companies</h2>
          <!-- p -->
        </div>

        <!-- logos slider start -->
        <div class="company_logos" >
          <div id="company_slider" class="owl-carousel owl-theme">
          @foreach($brands as $brandKey => $brand)
               @if($brand->lang == 'partner')
            <div class="item">
              <div class="logo">
                <img src="{{ asset($brand->slug) }}" alt="image" >
              </div>
            </div>
            @endif
            @endforeach
          </div>
        </div>
        <!-- logos slider end -->
      </div>
      <!-- container end -->
    </section>