@extends('frontend.layouts.main')
@section('content')
    @include('frontend.layouts.header')
    <main>

        <section class="row_am features_section" id="features">
            <!-- container start -->
            <div class="container">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <!-- h2 -->
                    <h2>{!! filterXss(optional($features)->feature_header) !!}</h2>
                    <!-- p -->
                    <p>{{ optional($features)->feature_subheader }}</p>
                </div>
                <div class="feature_detail">
                    <!-- feature box left -->
                    <div class="left_data feature_box">

                        <!-- feature box -->
                        <div class="data_block" data-aos="fade-right" data-aos-duration="1500">
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/secure_data.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <h4>{{ optional($features)->feature_1 }}</h4>
                                <p>{{ optional($features)->feature_1_details }}</p>
                            </div>
                        </div>

                        <!-- feature box -->
                        <div class="data_block" data-aos="fade-right" data-aos-duration="1500">
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/functional.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <h4>{{ optional($features)->feature_2 }}</h4>
                                <p>{{ optional($features)->feature_2_details }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- feature box right -->
                    <div class="right_data feature_box">

                        <!-- feature box -->
                        <div class="data_block" data-aos="fade-left" data-aos-duration="1500">
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/live-chat.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <h4>{{ optional($features)->feature_3 }}</h4>
                                <p>{{ optional($features)->feature_3_details }}</p>
                            </div>
                        </div>

                        <!-- feature box -->
                        <div class="data_block" data-aos="fade-left" data-aos-duration="1500">
                            <div class="icon">
                                <img src="{{ asset('assets/frontend/images/support.png') }}" alt="image">
                            </div>
                            <div class="text">
                                <h4>{{ optional($features)->feature_4 }}</h4>
                                <p>{{ optional($features)->feature_4_details }}</p>
                            </div>
                        </div>

                    </div>
                    <!-- feature image -->
                    <div class="feature_img" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                        <img src="{{ asset(optional($features)->feature_image) }}" alt="image">
                    </div>
                </div>
            </div>
            <!-- container end -->
        </section>

        <section class="row_am modern_ui_section">
            <!-- container start -->
            <div class="container">
                <!-- row start -->
                <div class="row">
                    <div class="col-lg-6">
                        <!-- UI content -->
                        <div class="ui_text">
                            <div class="section_title" data-aos="fade-up" data-aos-duration="1500"
                                data-aos-delay="100">
                                <h2>{{ optional($overview)->overview_header }}</span></h2>
                                <p>
                                    {{ optional($overview)->overview_subheader }}
                                </p>
                            </div>
                            <ul class="design_block">
                                <li data-aos="fade-up" data-aos-duration="1500">
                                    <h4>{{ optional($overview)->overview_title_1 }}</h4>
                                    <p>{{ optional($overview)->overview_subtitle_1 }}</p>
                                </li>
                                <li data-aos="fade-up" data-aos-duration="1500">
                                    <h4>{{ optional($overview)->overview_title_2 }}</h4>
                                    <p>{{ optional($overview)->overview_subtitle_2 }}</p>
                                </li>
                                <li data-aos="fade-up" data-aos-duration="1500">
                                    <h4>{{ optional($overview)->overview_title_3 }}</h4>
                                    <p>{{ optional($overview)->overview_subtitle_3 }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- UI Image -->
                        <div class="ui_images" data-aos="fade-in" data-aos-duration="1500">
                            <div class="left_img">
                                <img class="moving_position_animatin"
                                    src="{{ asset(optional($overview)->overview_image_1) }}" alt="image">
                            </div>
                            <!-- UI Image -->
                            <div class="right_img">
                                <img class="moving_position_animatin"
                                    src="{{ asset('assets/frontend/images/secure_data.png') }}" alt="image">
                                <img class="moving_position_animatin"
                                    src="{{ asset(optional($overview)->overview_image_2) }}" alt="image">
                                <img class="moving_position_animatin"
                                    src="{{ asset(optional($overview)->overview_image_3) }}" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row end -->
            </div>
            <!-- container end -->
        </section>
    </main>
@endsection
