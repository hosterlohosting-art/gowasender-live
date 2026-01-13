@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header')
  <main>

      <!-- tp-price-area-start -->
      @include('frontend.pricings')
      <!-- tp-price-area-end -->
      <!-- tp-support-area-start -->
      @include('frontend.sections.faq')
      <!-- tp-support-area-end -->

   </main>
@endsection