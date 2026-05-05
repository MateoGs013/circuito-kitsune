@props([
    'product' => null,
    'alt' => null,
    'brackets' => true,
    'variant' => 'bone', // 'bone' | 'ink' (color de los brackets)
    'glow' => true,
    'framed' => false,  // true = bg ink-deep + border ash (para wall/mapa)
])

@php
    $altText = $alt ?? optional($product)->name ?? 'Máscara';
    $type = $product ? \Illuminate\Support\Str::before($product->slug, '-') : null;
    $glowClass = $product ? 'glow-' . ($product->dominant_color ?? 'cyan') : 'glow-cyan';
    $wrapperClass = 'mask-portrait';
    if ($framed) $wrapperClass .= ' mask-portrait--framed';
    if ($variant === 'ink') $wrapperClass .= ' mask-portrait--ember';
@endphp

<figure {{ $attributes->merge(['class' => $wrapperClass . ($brackets ? ' frame-brackets mask-portrait__brackets' : '')]) }}>
    @if($glow && $product)
        <div class="mask-portrait__glow {{ $glowClass }}" aria-hidden="true"></div>
    @endif

    @if($product && $product->hasImage())
        <img class="mask-portrait__img"
             src="{{ asset($product->image_path) }}"
             alt="{{ $altText }}"
             width="800" height="1067"
             loading="lazy" decoding="async">
    @else
        {{-- SVG por tipo · R65 --}}
        <svg class="mask-portrait__svg" viewBox="0 0 300 400" fill="none" stroke="currentColor" stroke-width="1.5" preserveAspectRatio="xMidYMid meet" aria-hidden="true">
            <rect x="20" y="20" width="260" height="360" stroke="var(--color-ash)" />
            @switch($type)
                @case('kitsune')
                    {{-- orejas zorro + marcas frente --}}
                    <path d="M90 80 L60 30 L100 70 Z" stroke="var(--color-bone)" />
                    <path d="M210 80 L240 30 L200 70 Z" stroke="var(--color-bone)" />
                    <ellipse cx="150" cy="200" rx="70" ry="100" stroke="var(--color-bone)" />
                    <path d="M120 180 L130 150 M180 180 L170 150" stroke="var(--color-ember)" stroke-width="2" />
                    <circle cx="130" cy="210" r="4" fill="var(--color-ember)" />
                    <circle cx="170" cy="210" r="4" fill="var(--color-ember)" />
                    @break
                @case('oni')
                    {{-- cuernos arriba + colmillos --}}
                    <path d="M90 80 L70 20 L110 60 Z" stroke="var(--color-bone)" fill="var(--color-bone-dim)" fill-opacity="0.2" />
                    <path d="M210 80 L230 20 L190 60 Z" stroke="var(--color-bone)" fill="var(--color-bone-dim)" fill-opacity="0.2" />
                    <ellipse cx="150" cy="220" rx="80" ry="110" stroke="var(--color-bone)" />
                    <circle cx="125" cy="200" r="6" fill="var(--color-ember)" />
                    <circle cx="175" cy="200" r="6" fill="var(--color-ember)" />
                    <path d="M135 280 L140 305 M165 280 L160 305" stroke="var(--color-bone)" stroke-width="2" />
                    @break
                @case('karasu')
                    {{-- pico largo descendente --}}
                    <ellipse cx="150" cy="170" rx="60" ry="80" stroke="var(--color-bone)" />
                    <path d="M150 220 L150 320 L130 290 Z" stroke="var(--color-bone)" fill="var(--color-bone-dim)" fill-opacity="0.3" />
                    <circle cx="130" cy="160" r="3" fill="var(--color-ember)" />
                    <circle cx="170" cy="160" r="3" fill="var(--color-ember)" />
                    @break
                @case('neko')
                    {{-- orejas pequeñas + bigotes --}}
                    <path d="M100 90 L90 50 L120 80 Z" stroke="var(--color-bone)" />
                    <path d="M200 90 L210 50 L180 80 Z" stroke="var(--color-bone)" />
                    <ellipse cx="150" cy="210" rx="70" ry="95" stroke="var(--color-bone)" />
                    <line x1="80" y1="220" x2="120" y2="225" stroke="var(--color-bone-dim)" />
                    <line x1="80" y1="240" x2="120" y2="240" stroke="var(--color-bone-dim)" />
                    <line x1="220" y1="220" x2="180" y2="225" stroke="var(--color-bone-dim)" />
                    <line x1="220" y1="240" x2="180" y2="240" stroke="var(--color-bone-dim)" />
                    <circle cx="130" cy="200" r="4" fill="var(--color-ember)" />
                    <circle cx="170" cy="200" r="4" fill="var(--color-ember)" />
                    @break
                @case('sakura')
                    {{-- 5 pétalos circulares --}}
                    <g transform="translate(150 200)">
                        @for ($i = 0; $i < 5; $i++)
                            <ellipse cx="0" cy="-50" rx="20" ry="40" stroke="var(--color-bone)" transform="rotate({{ $i * 72 }})" />
                        @endfor
                    </g>
                    <circle cx="150" cy="200" r="12" fill="var(--color-ember)" />
                    @break
                @case('ronin')
                    {{-- marco rectangular minimal --}}
                    <rect x="90" y="120" width="120" height="180" stroke="var(--color-bone)" />
                    <line x1="90" y1="180" x2="210" y2="180" stroke="var(--color-bone-dim)" />
                    <line x1="90" y1="240" x2="210" y2="240" stroke="var(--color-bone-dim)" />
                    @break
                @default
                    <circle cx="150" cy="200" r="80" stroke="var(--color-bone)" />
            @endswitch
        </svg>
    @endif

    @if($brackets)
        <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--br" aria-hidden="true"></span>
    @endif
</figure>
