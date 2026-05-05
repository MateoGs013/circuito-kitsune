@props([
    'items' => [],
    'duration' => null, // ej. '30s'
    'separator' => '·',
])

@php
    $items = is_array($items) ? $items : [$items];
    $style = $duration ? 'animation-duration: ' . $duration . ';' : '';
@endphp

<div {{ $attributes->merge(['class' => 'marquee']) }} aria-hidden="true">
    <div class="marquee__track" @if($style) style="{{ $style }}" @endif>
        @for ($i = 0; $i < 3; $i++)
            @foreach ($items as $item)
                <span class="marquee__item">{{ $item }}</span>
                <span class="marquee__sep">{{ $separator }}</span>
            @endforeach
        @endfor
    </div>
</div>
