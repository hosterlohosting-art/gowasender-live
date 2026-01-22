<div class="header-section py-4 border-bottom bg-white mb-4 animate-fade-in-down">
  @if(!Request::is('user/dashboard'))
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-12 col-md-6">
          <h1 class="h2 font-weight-800 text-dark mb-0 ls-1">{!! $title ?? '' !!}</h1>
        </div>
        <div class="col-12 col-md-6 text-md-right mt-3 mt-md-0">
          @isset($buttons)
            @foreach($buttons as $button)
              @if(isset($button['is_button']) && $button['is_button'] == true)
                <button type="button" {!! $button['components'] ?? '' !!}
                  class="btn btn-sm premium-btn btn-white border">{!! $button['name'] ?? '' !!}</button>
              @else
                <a href="{{ $button['url'] ?? '' }}" {!! $button['components'] ?? '' !!} @if(isset($button['components']) && str_contains($button['components'], 'premium-btn')) {!! $button['components'] !!} @else
                class="btn btn-sm premium-btn btn-white border" @endif>{!! $button['name'] ?? '' !!}</a>
              @endif
            @endforeach
          @endisset
        </div>
      </div>
    </div>
  @endif
</div>