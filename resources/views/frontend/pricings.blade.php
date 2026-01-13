<section class="row_am pricing_section" id="pricing">
      <!-- container start -->
      <div class="container">
        <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
          <!-- h2 -->
          <h2>{{ __('Pricing to suite all size of business') }}</span></h2>
          <!-- p -->
          <p>{{ __('*We help companies of all sizes') }}</p>
        </div>
        <!-- toggle button -->
        <div class="toggle_block" data-aos="fade-up" data-aos-duration="1500">
          <span class="month active">Monthly</span>
          
        </div>

        <!-- pricing box  monthly start -->
        <div class="pricing_pannel monthly_plan active" data-aos="fade-up" data-aos-duration="1500">
          <!-- row start -->
          <div class="row">
          	<!-- pricing box 1 -->
             @foreach($plans ?? [] as $plan)
            <div class="col-md-4">
              <div class="pricing_block {{ $plan->is_recommended == 1 ? 'highlited_block' : '' }}">
                <div class="icon">
                <span class="icon {{ $plan->labelcolor }}"><i class="{{ $plan->iconname }}"></i></span>
                </div>
                <div class="pkg_name">
                  <h3>{{ $plan->title }}</h3>
                  <span>For the basics</span>
                </div>
                <span class="price">{{ amount_format($plan->price,'icon') }} </span>
                <ul class="benifits">
                @foreach($plan->data ?? [] as $key => $data)
                  <li>
                    <p> {{ ucfirst(str_replace('_',' ',planData($key,$data)['title'])) }}<i class="@if($data == 'true') icofont-check true @elseif($data == 'false') icofont-close false @endif"></i></p>
                  </li>
                  @endforeach
                </ul>
                <a href="{{ url('/register',$plan->id) }}" class="btn white_btn">{{ $plan->is_trial == 1 ? __('Free '.$plan->trial_days.' days trial') : __('Sign Up Now') }}</a>
              </div>
            </div>
            @endforeach
            
          </div>
          <!-- row end -->
        </div>
        <!-- pricing box monthly end -->
        <!-- pricing box yearly end -->
      </div>
      <!-- container start end -->
    </section>