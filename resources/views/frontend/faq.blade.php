@extends('frontend.layouts.main2')
@section('content')
  <main class="overflow-hidden">
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
      <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
        <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Help Center</span>
        <h1 class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
          Frequently Asked <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-600">Questions.</span>
        </h1>
        <p class="text-gray-500 text-lg md:text-xl leading-relaxed mx-auto max-w-2xl">
          Find answers to common questions about our platform, security, and WhatsApp marketing best practices.
        </p>
      </div>
    </section>

    <section class="py-24 bg-white relative min-h-screen">
      <!-- Floating shapes background -->
      <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div
          class="absolute top-20 left-10 w-72 h-72 bg-brand-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob">
        </div>
        <div
          class="absolute top-20 right-10 w-72 h-72 bg-accent-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
          class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000">
        </div>
      </div>

      <div class="container mx-auto px-6 relative z-10">

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-16 relative" data-aos="fade-up">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <i class="fas fa-search text-gray-400"></i>
          </div>
          <input type="text" id="faqSearch" placeholder="Search for answers (e.g. 'Billing', 'API', 'Setup')"
            class="w-full pl-12 pr-4 py-4 rounded-2xl border-0 shadow-lg ring-1 ring-gray-200 focus:ring-2 focus:ring-brand-500 transition-all text-lg placeholder-gray-400 bg-white/80 backdrop-blur-sm">
        </div>

        <div class="flex flex-col lg:flex-row gap-16 items-start">
          <!-- Left: 3D Image -->
          <div class="lg:w-1/3 hidden lg:block sticky top-32" data-aos="fade-right">
            <div class="relative group" data-tilt>
              <div
                class="absolute -inset-1 bg-gradient-to-r from-brand-600 to-accent-600 rounded-3xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200">
              </div>
              <img src="{{ asset('assets/frontend/images/faq_illustration.png') }}"
                onerror="this.src='https://placehold.co/400x500/e2e8f0/1e293b?text=Knowledge+Base'" alt="Knowledge"
                class="relative rounded-3xl shadow-xl w-full">
            </div>

            <div class="mt-12 p-8 bg-white/60 backdrop-blur-md rounded-3xl border border-white/50 shadow-lg">
              <h4 class="font-bold text-gray-900 mb-2">Still need help?</h4>
              <p class="text-sm text-gray-600 mb-6">If you can't find your answer here, our team is always ready to assist
                you personally.</p>
              <a href="{{ url('/contact') }}"
                class="text-brand-600 font-bold flex items-center gap-2 hover:gap-4 transition-all">Contact Support <i
                  class="fas fa-arrow-right"></i></a>
            </div>
          </div>

          <!-- Right: Searchable Grid -->
          <div class="lg:w-2/3 w-full">
            <div class="space-y-4" id="faqContainer">
              @foreach($faqs ?? [] as $faq)
                <div
                  class="faq-item group border border-white/50 rounded-2xl bg-white/60 backdrop-blur-md shadow-card hover:shadow-card-hover hover:bg-white transition-all duration-300"
                  data-aos="fade-up">
                  <button class="w-full p-6 text-left flex justify-between items-center"
                    onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.icon').classList.toggle('rotate-180')">
                    <span
                      class="text-lg font-bold text-gray-900 group-hover:text-brand-600 transition faq-title">{{ $faq->title }}</span>
                    <i
                      class="fas fa-chevron-down text-brand-500 transition-transform icon bg-brand-50 p-2 rounded-full"></i>
                  </button>
                  <div class="hidden px-6 pb-6 text-gray-600 leading-relaxed animate-fade-in-down">
                    {{ $faq->excerpt->value ?? '' }}
                  </div>
                </div>
              @endforeach

              <!-- No Results Message -->
              <div id="noResults" class="hidden text-center p-12">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-bold text-gray-900">No results found</h3>
                <p class="text-gray-500">Try searching for something else.</p>
              </div>

              @if(empty($faqs) || count($faqs) == 0)
                <div class="text-center p-12 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                  <div class="text-5xl mb-4">📭</div>
                  <h3 class="text-xl font-bold text-gray-900 mb-2">No FAQs Yet</h3>
                  <p class="text-gray-500">We are currently building our knowledge base. Check back soon!</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      // Simple Live Search
      document.getElementById('faqSearch').addEventListener('keyup', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.faq-item');
        let hasResults = false;

        items.forEach(item => {
          const title = item.querySelector('.faq-title').innerText.toLowerCase();
          if (title.includes(searchTerm)) {
            item.style.display = 'block';
            hasResults = true;
          } else {
            item.style.display = 'none';
          }
        });

        const noResults = document.getElementById('noResults');
        if (hasResults) {
          noResults.classList.add('hidden');
        } else {
          noResults.classList.remove('hidden');
        }
      });
    </script>

    <!-- Search/Help CTA -->
    <section class="py-24 bg-gray-50 border-t border-gray-200">
      <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-display font-bold text-gray-900 mb-8">Can't find what you're looking for?</h2>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="{{ url('/contact') }}"
            class="px-8 py-4 bg-brand-600 text-white font-bold rounded-xl shadow-lg hover:-translate-y-1 transition duration-300">Talk
            to an Expert</a>
          <a href="{{ url('/features') }}"
            class="px-8 py-4 bg-white text-gray-800 border border-gray-200 font-bold rounded-xl shadow-sm hover:border-brand-500 transition duration-300">Explore
            Features</a>
        </div>
      </div>
    </section>
  </main>

  <style>
    @keyframes float {
      0% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-20px);
      }

      100% {
        transform: translateY(0px);
      }
    }

    .animate-float {
      animation: float 6s ease-in-out infinite;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in-down {
      animation: fadeInDown 0.3s ease-out;
    }
  </style>
@endsection