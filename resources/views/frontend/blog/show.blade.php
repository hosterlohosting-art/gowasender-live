@extends('frontend.layouts.main2')
@section('content')
    <main class="overflow-hidden">
        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
            <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
                <nav class="flex justify-center mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ url('/') }}" class="text-sm font-medium text-gray-500 hover:text-brand-600">Home</a>
                        </li>
                        <li><span class="text-gray-400 mx-2">/</span></li>
                        <li class="inline-flex items-center">
                            <a href="{{ url('/blogs') }}"
                                class="text-sm font-medium text-gray-500 hover:text-brand-600">Blog</a>
                        </li>
                    </ol>
                </nav>
                <h1
                    class="text-4xl md:text-6xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
                    {{ $blog->title }}
                </h1>
                <div class="flex items-center justify-center gap-4">
                    <div class="flex items-center gap-2">
                        <img class="w-10 h-10 rounded-full" src="https://ui-avatars.com/api/?name=Admin" alt="">
                        <span class="font-bold text-gray-900">Administrator</span>
                    </div>
                    <span class="text-gray-400">•</span>
                    <span
                        class="text-gray-500">{{ $blog->created_at ? $blog->created_at->format('M d, Y') : date('M d, Y') }}</span>
                </div>
            </div>
        </section>

        <!-- Content -->
        <section class="py-24 bg-white relative">
            <div class="container mx-auto px-6 max-w-4xl">
                <!-- Main Image -->
                <div class="mb-16 -mt-32 lg:-mt-48 relative z-20">
                    <img src="{{ asset($blog->preview->value ?? '') }}" alt="{{ $blog->title }}"
                        class="w-full h-auto rounded-[3rem] shadow-2xl">
                </div>

                <!-- Content -->
                <article class="prose prose-brand lg:prose-xl mx-auto">
                    {!! filterXss($blog->mainDescription->value ?? ($blog->longDescription->value ?? '')) !!}
                </article>

                <!-- Share -->
                <div
                    class="mt-20 pt-10 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex gap-4 items-center">
                        <span class="font-bold text-gray-900">Share:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank"
                            class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-brand-600 hover:text-white transition"><i
                                class="fab fa-twitter"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"
                            class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-brand-600 hover:text-white transition"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ url()->current() }}" target="_blank"
                            class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-600 hover:bg-brand-600 hover:text-white transition"><i
                                class="fab fa-whatsapp"></i></a>
                    </div>
                    <a href="{{ url('/blogs') }}" class="font-bold text-brand-600 flex items-center gap-2">&larr; Back to
                        Blog</a>
                </div>
            </div>
        </section>

        <!-- Related Articles (Optional Placeholder) -->
    </main>

    <style>
        .prose h1,
        .prose h2,
        .prose h3 {
            color: #111827;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
        }

        .prose p {
            color: #4B5563;
            line-height: 1.8;
        }

        .prose blockquote {
            border-left-color: #16A34A;
            background: #F0FDF4;
            padding: 20px;
            border-radius: 0 20px 20px 0;
        }
    </style>
@endsection