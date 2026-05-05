@props([
    'href' => null,
    'variant' => 'ember', // 'ember' | 'ink' | 'bone'
    'arrow' => '→',
    'disabled' => false,
])

@php
    $tag = $href ? 'a' : 'button';
    $classes = 'bracket-cta bracket-cta--' . $variant;
    if ($disabled) $classes .= ' is-disabled';

    $base = $attributes->merge(['class' => $classes]);
    if ($href && !$disabled) $base = $base->merge(['href' => $href]);
    if ($disabled) $base = $base->merge(['aria-disabled' => 'true']);
    if (!$href) $base = $base->merge(['type' => 'button']);
@endphp

<{{ $tag }} {{ $base }}>
    <span aria-hidden="true">[</span>
    <span class="bracket-cta__text">{{ $slot }}</span>
    <span aria-hidden="true">]</span>
    @if($arrow)
        <span class="bracket-cta__arrow" aria-hidden="true">{{ $arrow }}</span>
    @endif
</{{ $tag }}>
