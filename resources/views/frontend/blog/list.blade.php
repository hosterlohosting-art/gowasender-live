@extends('frontend.layouts.main2')
@section('content')
	<main class="overflow-hidden">
		<!-- Hero Section -->
		<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
			<div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
				<span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Our Insights</span>
				<h1
					class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
					Latest from the <span
						class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-600">Blog.</span>
				</h1>
				<p class="text-gray-500 text-lg md:text-xl leading-relaxed mx-auto max-w-2xl">
					Expert tips, industry news, and automation strategies to help you master WhatsApp marketing.
				</p>
			</div>
		</section>

		<!-- Blog Grid -->
		<section class="py-24 bg-white -mt-10 lg:-mt-20">
			<div class="container mx-auto px-6">
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
					@foreach($blogs ?? [] as $blog)
						<div
							class="group h-full flex flex-col bg-white rounded-[2.5rem] border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
							<div class="relative overflow-hidden h-64">
								<img src="{{ asset($blog->preview->value ?? '') }}" alt="{{ $blog->title }}"
									class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
								<div class="absolute top-4 left-4">
									<span
										class="bg-brand-600 text-white px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">Automation</span>
								</div>
							</div>
							<div class="p-10 flex flex-col flex-1">
								<h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-brand-600 transition">
									{{ $blog->title }}</h3>
								<p class="text-gray-500 leading-relaxed mb-8 flex-1">
									{{ Str::limit($blog->shortDescription->value ?? '', 140) }}
								</p>
								<a href="{{ url('/blog', $blog->slug) }}"
									class="inline-flex items-center gap-2 text-brand-600 font-bold hover:gap-4 transition-all">
									Read More <i class="fas fa-arrow-right"></i>
								</a>
							</div>
						</div>
					@endforeach
				</div>

				@if(count($blogs) == 0)
					<div class="text-center p-24 bg-gray-50 rounded-[3rem] border border-dashed border-gray-300">
						<div class="text-6xl mb-6">📝</div>
						<h3 class="text-2xl font-bold text-gray-900 mb-2">No Articles Found</h3>
						<p class="text-gray-500">Please check back later as we are preparing fresh content for you.</p>
					</div>
				@endif

				<div class="mt-20 flex justify-center">
					{{ $blogs->appends($request->all())->links('vendor.pagination.bootstrap-5') }}
				</div>
			</div>
		</section>
	</main>
@endsection