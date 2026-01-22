<!-- Nav items -->
<style>
  .navbar-nav .nav-link {
    padding: 0.85rem 1.25rem;
    margin: 0.25rem 0.75rem;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    color: #4a5568 !important;
    display: flex;
    align-items: center;
  }

  .navbar-nav .nav-link:hover {
    background-color: #f7fafc;
    color: #1a202c !important;
    transform: translateX(5px);
  }

  .navbar-nav .nav-link.active {
    background: linear-gradient(135deg, #128C7E 0%, #075E54 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(18, 140, 126, 0.25);
  }

  .navbar-nav .nav-link.active i {
    color: #ffffff !important;
  }

  .navbar-nav .nav-link i {
    min-width: 1.75rem;
    font-size: 1.1rem;
    display: flex;
    justify-content: center;
    margin-right: 0.75rem;
  }

  .navbar-heading {
    padding: 1.5rem 1.5rem 0.75rem !important;
    font-size: 0.75rem !important;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 700;
    color: #a0aec0 !important;
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
      <i class="fi fi-rs-sensor-on"></i>
      <span class="nav-link-text">{{ __('WhatsApp (Official)') }}</span>
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
        <span class="badge badge-warning ml-auto whatsapp-unread-count d-none"
          style="border-radius: 50%; padding: 4px 8px; font-size: 11px;">0</span>
      @endif
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/device*') ? 'active' : '' }}" href="{{ route('user.device.index') }}">
      <i class="fi fi-rs-smartphone"></i>
      <span class="nav-link-text">{{ __('WhatsApp (Unofficial)') }}</span>
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
      <span class="nav-link-text">{{ __('Auto Reply') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/flows*') ? 'active' : '' }}" href="{{ route('user.flows.index') }}">
      <i class="fas fa-project-diagram"></i>
      <span class="nav-link-text">{{ __('Flow Builder') }}</span>
    </a>
  </li>

  <h6 class="navbar-heading">{{ __('Contacts & Content') }}</h6>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/contact*') ? 'active' : '' }}" href="{{ route('user.contact.index') }}">
      <i class="fas fa-address-book"></i>
      <span class="nav-link-text">{{ __('Contact List') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/template*') ? 'active' : '' }}" href="{{ url('user/template') }}">
      <i class="fas fa-layer-group"></i>
      <span class="nav-link-text">{{ __('Message Templates') }}</span>
    </a>
  </li>

  <h6 class="navbar-heading">{{ __('Campaigns') }}</h6>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/bulk-message*') ? 'active' : '' }}" href="{{ url('user/bulk-message') }}">
      <i class="fas fa-mail-bulk"></i>
      <span class="nav-link-text">{{ __('Bulk Sending') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/schedule-message*') ? 'active' : '' }}"
      href="{{ url('user/schedule-message') }}">
      <i class="fas fa-calendar-alt"></i>
      <span class="nav-link-text">{{ __('Scheduling') }}</span>
    </a>
  </li>
  <li class="nav-item ">
    <a class="nav-link {{ Request::is('user/logs*') ? 'active' : '' }}" href="{{ url('user/logs') }}">
      <i class="fas fa-history"></i>
      <span class="nav-link-text">{{ __('Activity Logs') }}</span>
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