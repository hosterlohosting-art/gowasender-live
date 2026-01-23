@php
  $unreadMessagesCount = \App\Models\Notification::where('user_id', Auth::id())
    ->where('comment', 'whatsapp-message')
    ->where('seen', 0)
    ->count();
@endphp
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/dashboard*') ? 'active' : '' }}" href="{{ route('user.dashboard.index') }}">
      <i class="fas fa-th-large"></i>
      <span class="nav-link-text">{{ __('Dashboard') }}</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ Request::is('user/cloudapi*') ? 'active' : '' }}" href="{{ route('user.cloudapi.index') }}">
      <i class="fas fa-plug"></i>
      <span class="nav-link-text">{{ __('WhatsApp API') }}</span>
      @if($unreadMessagesCount > 0)
        <span class="badge badge-warning ml-auto whatsapp-unread-count"
          style="border-radius: 50%; padding: 4px 8px; font-size: 11px;">{{ $unreadMessagesCount }}</span>
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