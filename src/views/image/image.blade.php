<figure class="st-image">
  <img src="{{ $url }}" alt="" loading="lazy" decoding="async" fetchPriority="low" />

@if (!empty($text))
  <figcaption>{{ $text }}</figcaption>
@endif
</figure>
