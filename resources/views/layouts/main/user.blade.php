<!-- Nav items -->
<style>
  /* Custom Sidebar Styles */
  .navbar-nav .nav-link {
    padding: 0.75rem 1rem;
    margin-bottom: 0.25rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    font-weight: 500;
  }

  .navbar-nav .nav-link:hover {
    background-color: #f6f9fc;
    transform: translateX(4px);
  }

  .navbar-nav .nav-link.active {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
    color: #fff !important;
    box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    /* shadow-md */
  }

  .navbar-nav .nav-link.active i {
    color: #fff !important;
  }

  .navbar-nav .nav-link i {
    min-width: 2rem;
  }
</style>
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/dashboard*') ? 'active' : '' }}" href="{{ route('user.dashboard.index') }}">
      <i class="fi fi-rs-dashboard"></i>
      <span class="nav-link-text">{{ __('Dashboard') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/cloudapi*') ? 'active' : '' }}" href="{{ route('user.cloudapi.index') }}">
      <i class="fi-rs-sensor-on"></i>
      <span class="nav-link-text">{{ __('WhatsApp') }}</span>
      @php
        $unreadMessagesCount = \App\Models\Notification::where('user_id', Auth::id())
          ->where('comment', 'whatsapp-message')
          ->where('seen', 0)
          ->count();
      @endphp
      @if($unreadMessagesCount > 0)
        <span class="badge badge-warning ml-auto whatsapp-unread-count"
          style="border-radius: 50%; padding: 4px 8px; font-size: 11px;">{{ $unreadMessagesCount }}</span>
      @else
        <span class="badge badge-warning ml-auto whatsapp-unread-count d-none" style="border-radius: 50%; padding: 4px 8px; font-size: 11px;">0</span>
      @endif
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/sent-text-message*') ? 'active' : '' }}"
      href="{{ url('user/sent-text-message') }}">
      <i class="fi fi-rs-paper-plane"></i>
      <span class="nav-link-text">{{ __('Single Send') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/chatbot*') ? 'active' : '' }}" href="{{ route('user.chatbot.index') }}">
      <i class="fas fa-robot"></i>
      <span class="nav-link-text">{{ __('Chatbot (Auto Reply)') }}</span>
    </a>
  </li>
  {{-- FLOW BUILDER --}}
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/flows*') ? 'active' : '' }}" href="{{ route('user.flows.index') }}">
      <i class="fas fa-project-diagram"></i>
      <span class="nav-link-text">{{ __('Flow Builder') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/apps*') ? 'active' : '' }}" href="{{ route('user.apps.index') }}">
      <i class="fi fi-rs-apps-add"></i>
      <span class="nav-link-text">{{ __('My Apps') }}</span>
    </a>
  </li>
  <!-- if ---->
  <!--------------------->
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/contact*') ? 'active' : '' }}" href="{{ route('user.contact.index') }}">
      <i class="fi  fi-rs-address-book"></i>
      <span class="nav-link-text">{{ __('Contacts Book') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/template*') ? 'active' : '' }}" href="{{ url('user/template') }}">
      <i class="fi  fi-rs-template-alt"></i>
      <span class="nav-link-text">{{ __('My Templates') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/bulk-message*') ? 'active' : '' }}" href="{{ url('user/bulk-message') }}">
      <i class="fi fi-rs-rocket-lunch"></i>
      <span class="nav-link-text">{{ __('Send Bulk Message') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/schedule-message*') ? 'active' : '' }}"
      href="{{ url('user/schedule-message') }}">
      <i class="ni ni-calendar-grid-58"></i>
      <span class="nav-link-text">{{ __('Scheduled Message') }}</span>
    </a>
  </li>
  <li class="nav-item ">
    <a class="nav-link {{ Request::is('user/logs*') ? 'active' : '' }}" href="{{ url('user/logs') }}">
      <i class="ni ni-ui-04"></i>
      <span class="nav-link-text">{{ __('Message Log') }}</span>
    </a>
  </li>
</ul>


<!-- Divider -->
<hr class="my-3 mt-6">
<!-- Heading -->
<h6 class="navbar-heading p-0 text-muted">{{ __('Settings') }}</h6>
<!-- Navigation -->
<ul class="navbar-nav mb-md-3">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/subscription*') ? 'active' : '' }}" href="{{ url('/user/subscription') }}">
      <i class="ni ni-spaceship"></i>
      <span class="nav-link-text">{{ __('Subscription') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/support*') ? 'active' : '' }}" href="{{ url('/user/support') }}">
      <i class="fas fa-headset"></i>
      <span class="nav-link-text">{{ __('Help & Support') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('/user/profile') }}">
      <i class="ni ni-settings-gear-65"></i>
      <span class="nav-link-text">{{ __('Profile Settings') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/auth-key*') ? 'active' : '' }}" href="{{ url('/user/auth-key') }}">
      <i class="ni ni-key-25"></i>
      <span class="nav-link-text">{{ __('Auth Key') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link logout-button" href="#">
      <i class="ni ni-button-power"></i>
      <span class="nav-link-text">{{ __('Logout') }}</span>
    </a>
  </li>
</ul>