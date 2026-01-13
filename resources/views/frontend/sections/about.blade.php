<section class="row_am about_app_section">
    <!-- container start -->
    <div class="container">
        <!-- row start -->
        <div class="row">
            <div class="col-lg-6">
                <!-- about images -->
                <div class="about_img" data-aos="fade-in" data-aos-duration="1500">
                    <div class="frame_img">
                        <img class="moving_position_animatin" src="{{ asset(optional($about)->frame_image) }}" alt="image">
                    </div>
                    <div class="screen_img">
                        <img class="moving_animation" src="{{ asset(optional($about)->frame_image_2) }}" alt="image">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- about text -->
                <div class="about_text">
                    <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                        <!-- h2 -->
                        <h2>{{ optional($about)->about_header }}</h2>
                        <!-- p -->
                        <p>{{ optional($about)->about_subheader }}</p>
                    </div>
                    <!-- UL -->
                    <ul class="app_statstic" id="counter" data-aos="fade-in" data-aos-duration="1500">
                        <li>
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/download.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <p><span class="counter-value" data-count="{{ optional($about)->about_api }}">0</span><span>+</span></p>
                                <p>Connected Api</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/followers.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <p><span class="counter-value" data-count="{{ optional($about)->satisfied_user }}">0 </span><span>+</span></p>
                                <p>Satisfied user</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/reviews.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <p><span class="counter-value" data-count="{{ optional($about)->customer_review }}">1500</span><span>+</span></p>
                                <p>Reviews</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/countries.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <p><span class="counter-value" data-count="{{ optional($about)->about_countries }}">0</span><span>+</span></p>
                                <p>Countries</p>
                            </div>
                        </li>
                    </ul>
                    <!-- UL end -->
                    <a href="{{ !Auth::check() ? url('/pricing') : url('/login') }}" class="btn puprple_btn" data-aos="fade-in" data-aos-duration="1500">START FREE TRIAL</a>
                </div>
            </div>
        </div>
        <!-- row end -->
    </div>
    <!-- container end -->
</section>
