<section class="row_am how_it_works" id="how_it_work">
    <!-- container start -->
    <div class="container">
        <div class="how_it_inner">
            <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                <!-- h2 -->
                <h2>{{ optional($work)->work_header }}</h2>
                <!-- p -->
                <p>{{ optional($work)->work_subheader }}</p>
            </div>
            <div class="step_block">
                <!-- UL -->
                <ul>
                    <!-- step 1 -->
                    <li>
                        <div class="step_text" data-aos="fade-right" data-aos-duration="1500">
                            <h4>{{ optional($work)->step_title_1 }}</h4>
                            <span>{{ optional($work)->step_subtitle_1 }}</span>
                            <p>{{ optional($work)->step_description_1 }}</p>
                        </div>
                        <div class="step_number">
                            <h3>01</h3>
                        </div>
                        <div class="step_img" data-aos="fade-left" data-aos-duration="1500">
                            <img src="{{ asset(optional($work)->step_image_1) }}" alt="image">
                        </div>
                    </li>

                    <!-- step 2 -->
                    <li>
                        <div class="step_text" data-aos="fade-left" data-aos-duration="1500">
                            <h4>{{ optional($work)->step_title_2 }}</h4>
                            <span>{{ optional($work)->step_subtitle_2 }}</span>
                            <p>{{ optional($work)->step_description_2 }}</p>
                        </div>
                        <div class="step_number">
                            <h3>02</h3>
                        </div>
                        <div class="step_img" data-aos="fade-right" data-aos-duration="1500">
                            <img src="{{ asset(optional($work)->step_image_2) }}" alt="image">
                        </div>
                    </li>

                    <!-- step 3 -->
                    <li>
                        <div class="step_text" data-aos="fade-right" data-aos-duration="1500">
                            <h4>{{ optional($work)->step_title_3 }}</h4>
                            <span>{{ optional($work)->step_subtitle_3 }}</span>
                            <p>{{ optional($work)->step_description_3 }}</p>
                        </div>
                        <div class="step_number">
                            <h3>03</h3>
                        </div>
                        <div class="step_img" data-aos="fade-left" data-aos-duration="1500">
                            <img src="{{ asset(optional($work)->step_image_3) }}" alt="image">
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- video section start -->
        <div class="yt_video" data-aos="fade-in" data-aos-duration="1500">
            <!-- animation line -->
            <div class="anim_line dark_bg">
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
                <span><img src="{{ asset('assets/frontend/images/anim_line.png') }}" alt="anim_line"></span>
            </div>
            <div class="thumbnil">
                <img src="{{ asset(optional($work)->video_image) }}" alt="image">
                <a class="popup-youtube play-button" data-url="{{ optional($work)->video_url }}" data-toggle="modal"
                    data-target="#myModal" title="">
                    <span class="play_btn">
                        <img src="{{ asset('assets/frontend/images/play_icon.png') }}" alt="image">
                        <div class="waves-block">
                            <div class="waves wave-1"></div>
                            <div class="waves wave-2"></div>
                            <div class="waves wave-3"></div>
                        </div>
                    </span>
                    {{ optional($work)->video_header }}
                </a>
            </div>
        </div>
        <!-- video section end -->
    </div>
    <!-- container end -->
</section>
