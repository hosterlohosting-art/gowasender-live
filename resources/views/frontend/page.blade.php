@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header')
<main>


<div class="bred_crumb">
      <div class="container">
        <!-- shape animation  -->
        <span class="banner_shape1"> <img src="{{ asset('assets/frontend/images/banner-shape1.png')}}" alt="image" > </span>
        <span class="banner_shape2"> <img src="{{ asset('assets/frontend/images/banner-shape2.png')}}" alt="image" > </span>
        <span class="banner_shape3"> <img src="{{ asset('assets/frontend/images/banner-shape3.png')}}" alt="image" > </span>

        <div class="bred_text">
          <h1>{{ $page->title }}</h1>
          <ul>
            <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li><span>»</span></li>
            <li>{{ $page->title }}</li>
          </ul>
        </div>
      </div>
    </div>
<!-- breadcrumb area end -->
<section class="blog_detail_section">
<div class="container">
        <div class="blog_inner_pannel">
		<div class="section_title">
                        {{ $page->title }}
                        </div>                 
                        <div class="info">
                           <p>{!!  filterXss($page->description->value ?? '') !!}</p>
                           </div>
	</div>
</div>
</section>
</main>
@endsection