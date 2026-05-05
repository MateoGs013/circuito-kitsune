@props(['product', 'mode' => 'editorial'])

@php
    $colorHex = str_replace(['background-color: ', ';'], '', $product->dominantColorStyle());
    // Kanji por categoría/familia (decorativo, no requiere instalación de font extra)
    $familyKanji = match (true) {
        str_starts_with($product->code, 'KSN') => '狐',  // kitsune
        str_starts_with($product->code, 'ONI') => '鬼',  // oni
        str_starts_with($product->code, 'KRS') => '烏',  // karasu
        str_starts_with($product->code, 'NKO') => '猫',  // neko
        str_starts_with($product->code, 'SKR') => '桜',  // sakura
        str_starts_with($product->code, 'RNX') => '浪',  // ronin (drift)
        default => '面',
    };
@endphp

@if ($product->hasImage())
    <img
        src="{{ asset($product->image_path) }}"
        alt="Máscara {{ $product->name }}"
        class="h-full w-full object-cover"
        loading="lazy"
    >
@else
    <div
        class="relative flex h-full w-full items-center justify-center overflow-hidden"
        role="img"
        aria-label="Identidad pendiente de sincronización · {{ $product->name }}"
        style="background-color: {{ $colorHex }};"
    >
        {{-- Kanji familiar enorme de fondo --}}
        <span
            class="kanji-mark absolute inset-0 flex items-center justify-center"
            style="opacity: 0.18;"
            aria-hidden="true"
        >
            <span class="font-jp font-extrabold leading-none" style="font-size: clamp(12rem, 60%, 36rem); color: var(--color-sumi);">{{ $familyKanji }}</span>
        </span>

        {{-- Silueta de máscara minimal --}}
        <svg
            viewBox="0 0 200 240"
            class="relative z-10 h-3/4 w-auto max-h-[80%]"
            fill="none"
            stroke="currentColor"
            stroke-width="1.2"
            style="color: var(--color-sumi);"
            aria-hidden="true"
        >
            <defs>
                <linearGradient id="maskInk{{ $product->id ?? $product->code }}" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="currentColor" stop-opacity="0.18"/>
                    <stop offset="100%" stop-color="currentColor" stop-opacity="0.04"/>
                </linearGradient>
            </defs>

            <path d="M100 14 C56 14, 32 60, 36 130 C40 188, 70 226, 100 226 C130 226, 160 188, 164 130 C168 60, 144 14, 100 14 Z"
                  fill="url(#maskInk{{ $product->id ?? $product->code }})"
                  stroke-width="1.4"/>

            <path d="M100 22 L100 218" stroke-dasharray="1 6" opacity="0.4"/>

            {{-- ojos minimal --}}
            <path d="M50 100 Q70 86, 88 100" stroke-width="1.6"/>
            <path d="M112 100 Q130 86, 150 100" stroke-width="1.6"/>
            <circle cx="69" cy="100" r="2" fill="currentColor"/>
            <circle cx="131" cy="100" r="2" fill="currentColor"/>

            {{-- marca inferior central --}}
            <path d="M86 156 L100 172 L114 156" stroke-width="1.4"/>
            <circle cx="100" cy="184" r="3.5" fill="currentColor" opacity="0.85"/>
        </svg>

        {{-- Esquinas técnicas como portrait-frame --}}
        @if ($mode === 'editorial')
            <span class="absolute left-4 top-4 font-mono text-[10px] uppercase tracking-[0.3em]" style="color: var(--color-sumi); opacity: 0.7;">{{ $product->code }}</span>
            <span class="absolute right-4 top-4 font-mono text-[10px] uppercase tracking-[0.3em]" style="color: var(--color-sumi); opacity: 0.5;">no.{{ str_pad((string) ($product->id ?? 0), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="absolute bottom-4 left-4 font-jp text-[10px] uppercase tracking-[0.3em]" style="color: var(--color-sumi); opacity: 0.55;">{{ $product->rarityLabel() }}</span>
            <span class="absolute bottom-4 right-4 font-mono text-[10px] uppercase tracking-[0.3em]" style="color: var(--color-sumi); opacity: 0.45;">imagen 仮 · pendiente</span>
        @endif
    </div>
@endif
