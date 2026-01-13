@extends('frontend.layouts.main')
@section('content')
   @include('frontend.layouts.header')
   <main>
      @include('frontend.sections.about')
      @include('frontend.sections.faq')

   </main>
@endsection