@props(['as' => null, 'href' => null, 'disabled' => false, 'arrow' => true])

@php
    $tag = $as ?? ($href ? 'a' : 'button');
@endphp

<{{ $tag }}
    @if ($tag === 'a' && ! $disabled) href="{{ $href }}" @endif
    @if ($tag === 'button') type="button" @endif
    @if ($disabled) aria-disabled="true" @disabled(true) @endif
    {{ $attributes->merge(['class' => 'ink-button']) }}
    data-cursor="big"
>
    <span>{{ $slot }}</span>
    @if ($arrow)
        <span class="ink-button__arrow" aria-hidden="true">→</span>
    @endif
</{{ $tag }}>
