@extends('frontend.layouts.main2')
@section('content')
  <main class="overflow-hidden">
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-brand-50/50">
      <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
        <span class="text-brand-600 font-bold tracking-wider uppercase text-sm mb-2 block">Support Center</span>
        <h1 class="text-5xl lg:text-7xl font-display font-extrabold leading-tight text-gray-900 mb-8 tracking-tight">
          Get in <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-600">Touch.</span>
        </h1>
        <p class="text-gray-500 text-lg md:text-xl leading-relaxed mx-auto">
          Have questions or need technical assistance? Our team is here to help you scale your WhatsApp marketing journey.
        </p>
      </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="py-24 bg-white -mt-10 lg:-mt-20">
      <div class="container mx-auto px-6">
        <div
          class="flex flex-col lg:flex-row gap-16 bg-white rounded-[3rem] shadow-2xl p-8 md:p-16 border border-gray-100 relative z-20">
          <!-- Left: Form -->
          <div class="lg:w-3/5">
            <h2 class="text-3xl font-display font-bold text-gray-900 mb-8">Send us a message</h2>
            <form action="{{ route('send.mail') }}" method="POST" class="space-y-6 ajaxform">
              @csrf
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Your Name</label>
                  <input type="text" name="name" required
                    class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-brand-500 focus:bg-white transition"
                    placeholder="John Doe">
                </div>
                <div>
                  <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                  <input type="email" name="email" required
                    class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-brand-500 focus:bg-white transition"
                    placeholder="john@example.com">
                </div>
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                <input type="text" name="subject" required
                  class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-brand-500 focus:bg-white transition"
                  placeholder="How can we help?">
              </div>
              <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                <textarea name="message" required rows="5"
                  class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-200 focus:outline-none focus:border-brand-500 focus:bg-white transition"
                  placeholder="Tell us more about your needs..."></textarea>
              </div>
              <button type="submit"
                class="w-full md:w-auto px-10 py-5 bg-brand-600 text-white font-bold text-lg rounded-2xl shadow-xl hover:-translate-y-1 transition duration-300 flex items-center justify-center gap-3 submit-btn">
                <i class="fas fa-paper-plane"></i> Send Message
              </button>
            </form>
          </div>

          <!-- Right: Info -->
          <div class="lg:w-2/5 flex flex-col justify-between">
            <div>
              <div class="mb-12">
                <img src="{{ asset('public/uploads/support_3d.png') }}" alt="Support"
                  class="w-full h-auto rounded-3xl animate-float max-w-sm">
              </div>
              <div class="space-y-8">
                <div class="flex items-start gap-6">
                  <div
                    class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 text-xl shrink-0">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <div>
                    <h4 class="font-bold text-gray-900 mb-1 text-lg">Email Us</h4>
                    <p class="text-gray-500">support@hosterlo.com</p>
                  </div>
                </div>
                <div class="flex items-start gap-6">
                  <div
                    class="w-12 h-12 rounded-xl bg-accent-50 flex items-center justify-center text-accent-600 text-xl shrink-0">
                    <i class="fab fa-whatsapp"></i>
                  </div>
                  <div>
                    <h4 class="font-bold text-gray-900 mb-1 text-lg">Chat with Us</h4>
                    <p class="text-gray-500">Available 24/7 via WhatsApp</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-12 bg-gray-50 p-8 rounded-3xl border border-gray-100">
              <h4 class="font-bold text-gray-900 mb-4">Office Hours</h4>
              <div class="space-y-2 text-sm text-gray-500">
                <div class="flex justify-between"><span>Mon - Fri</span><span>9:00 AM - 6:00 PM</span></div>
                <div class="flex justify-between"><span>Saturday</span><span>10:00 AM - 2:00 PM</span></div>
                <div class="flex justify-between font-bold text-brand-600"><span>Sunday</span><span>Support Only</span>
                </div>
              </div>
            </div>
          </div>
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
        transform: translateY(-15px);
      }

      100% {
        transform: translateY(0px);
      }
    }

    .animate-float {
      animation: float 5s ease-in-out infinite;
    }
  </style>
@endsection