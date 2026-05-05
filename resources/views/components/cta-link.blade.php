@props([
    'href' => '#',
    'variant' => 'primary',
    'tag' => 'a',
])

@php
    $classes = 'cta-link cta-link--' . ($variant === 'ghost' ? 'ghost' : 'primary');
@endphp

@if($tag === 'button')
    <button type="button" {{ $attributes->merge(['class' => $classes]) }}>
        <span>{{ $slot }}</span>
        <span class="cta-link__arrow" aria-hidden="true">→</span>
    </button>
@else
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        <span>{{ $slot }}</span>
        <span class="cta-link__arrow" aria-hidden="true">→</span>
    </a>
@endif
