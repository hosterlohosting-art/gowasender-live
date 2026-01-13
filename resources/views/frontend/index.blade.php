@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header')
<!-- tp-offcanvus-area-start -->
<div class="body-overlay"></div>
<main>
      @include('frontend.sections.hero-1')
      @include('frontend.sections.trusted')
      @include('frontend.sections.features',['limit'=> 6])
       @include('frontend.sections.about')
       @include('frontend.sections.features-2')
      @include('frontend.sections.work')
      @include('frontend.pricings')
      <!-- tp-testimonial-area-start -->
      @include('frontend.sections.feedback-1')
      <!-- tp-testimonial-area-end -->
      <!-- tp-support-area-start -->
      @include('frontend.sections.faq')
      <!-- tp-support-area-end -->
      @include('frontend.sections.area')


   </main>
@endsection
