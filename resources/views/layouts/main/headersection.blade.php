@if(!Request::is('user/dashboard'))
  <div class="header-section animate-fade-in-down">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-12 col-md-6">
          <h1 class="h3 font-weight-800 text-dark mb-0">{!! $title ?? '' !!}</h1>
        </div>
        <div class="col-12 col-md-6 text-md-right mt-3 mt-md-0">
          @isset($buttons)
            <div class="header-action-btns">
              @foreach($buttons as $button)
                @if(is_array($button) && isset($button['is_button']) && $button['is_button'] == true)
                  <button type="button" {!! $button['components'] ?? '' !!}
                    class="btn btn-sm premium-btn btn-white border shadow-sm">{!! $button['name'] ?? '' !!}</button>
                @elseif(is_array($button))
                  <a href="{{ $button['url'] ?? '' }}" {!! $button['components'] ?? '' !!}
                    class="{{ str_contains($button['components'] ?? '', 'premium-btn') ? '' : 'btn btn-sm premium-btn btn-white border shadow-sm' }}">
                    {!! $button['name'] ?? '' !!}
                  </a>
                @endif
              @endforeach
            </div>
          @endisset
        </div>
      </div>
    </div>
  </div>
@endif