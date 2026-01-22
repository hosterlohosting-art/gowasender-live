@extends('frontend.layouts.main2')
@section('content')
  <main class="overflow-hidden">
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
      <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
        <h1 class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
          {{ $page->title }}
        </h1>
        <nav class="flex justify-center" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <a href="{{ url('/') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-brand-600">
                Home
              </a>
            </li>
            <li>
              <div class="flex items-center">
                <span class="text-gray-400 mx-2">/</span>
                <span class="text-sm font-medium text-gray-500">{{ $page->title }}</span>
              </div>
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <!-- Page Content -->
    <section class="py-24 bg-white">
      <div class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white rounded-[2.5rem] p-8 md:p-16 border border-gray-100 shadow-xl prose prose-brand lg:prose-xl">
          {!! filterXss($page->description->value ?? '') !!}
        </div>
      </div>
    </section>
  </main>

  <style>
    /* Custom prose styles to match our brand */
    .prose h2 {
      color: #111827;
      font-family: 'Outfit', sans-serif;
      font-weight: 800;
      margin-top: 2em;
    }

    .prose p {
      color: #4B5563;
      line-height: 1.8;
    }

    .prose ul li::marker {
      color: #16A34A;
    }
  </style>
@endsection