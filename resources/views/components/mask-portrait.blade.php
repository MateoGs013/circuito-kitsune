@props([
    'product' => null,
    'alt' => null,
])

@php
    $hasImage = $product && $product->hasImage();
    $imagePath = $hasImage ? asset($product->image_path) : null;
    $altText = $alt ?? ($product?->name ?? 'Retrato editorial silenciado');

    // detectar el tipo por slug · default a "blank"
    $slug = $product?->slug ?? '';
    $type = 'blank';
    if (str_starts_with($slug, 'kitsune')) $type = 'kitsune';
    elseif (str_starts_with($slug, 'oni')) $type = 'oni';
    elseif (str_starts_with($slug, 'karasu')) $type = 'karasu';
    elseif (str_starts_with($slug, 'neko')) $type = 'neko';
    elseif (str_starts_with($slug, 'sakura')) $type = 'sakura';
    elseif (str_starts_with($slug, 'ronin')) $type = 'ronin';
@endphp

<figure {{ $attributes->merge(['class' => 'mask-portrait']) }}>
    @if($hasImage)
        <img src="{{ $imagePath }}" alt="{{ $altText }}" loading="lazy" decoding="async" width="600" height="800">
    @else
        <svg class="mask-portrait__svg" viewBox="0 0 120 160" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">

            @switch($type)

                @case('kitsune')
                    {{-- ZORRO · orejas puntudas + hocico + marcas rojas --}}
                    {{-- orejas (triángulos largos hacia arriba) --}}
                    <path d="M 32 22 L 40 56 L 52 50 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    <path d="M 88 22 L 80 56 L 68 50 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    {{-- marcas internas de oreja (rojas decorativas) --}}
                    <path d="M 36 32 L 42 50 L 47 46 Z" fill="#FF1A38" opacity="0.6"/>
                    <path d="M 84 32 L 78 50 L 73 46 Z" fill="#FF1A38" opacity="0.6"/>
                    {{-- cara forma diamante alargada --}}
                    <path d="M 60 48 C 36 50, 34 88, 48 122 C 54 134, 66 134, 72 122 C 86 88, 84 50, 60 48 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    {{-- ojos almendrados oblicuos --}}
                    <path d="M 42 80 Q 50 74, 58 80 Q 50 86, 42 80 Z" fill="currentColor" opacity="0.7"/>
                    <path d="M 62 80 Q 70 74, 78 80 Q 70 86, 62 80 Z" fill="currentColor" opacity="0.7"/>
                    {{-- marcas rojas frente y mejillas --}}
                    <path d="M 56 60 L 60 50 L 64 60 Z" fill="#FF1A38" opacity="0.55"/>
                    <line x1="38" y1="98" x2="48" y2="100" stroke="#FF1A38" stroke-width="0.6"/>
                    <line x1="82" y1="98" x2="72" y2="100" stroke="#FF1A38" stroke-width="0.6"/>
                    {{-- hocico puntudo --}}
                    <path d="M 53 110 L 60 122 L 67 110" stroke="currentColor" stroke-width="0.7" fill="none"/>
                    @break

                @case('oni')
                    {{-- DEMONIO · cuernos + colmillos --}}
                    {{-- cuernos --}}
                    <path d="M 38 28 C 32 18, 30 12, 36 8 C 38 14, 42 22, 44 32" stroke="currentColor" stroke-width="0.9" fill="none"/>
                    <path d="M 82 28 C 88 18, 90 12, 84 8 C 82 14, 78 22, 76 32" stroke="currentColor" stroke-width="0.9" fill="none"/>
                    {{-- cara ovalada robusta --}}
                    <path d="M 60 30 C 28 34, 24 80, 32 110 C 38 134, 56 144, 60 144 C 64 144, 82 134, 88 110 C 96 80, 92 34, 60 30 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    {{-- ojos furiosos · forma de almendra inclinada --}}
                    <path d="M 36 76 L 54 70 L 56 80 L 38 84 Z" fill="currentColor" opacity="0.78"/>
                    <path d="M 84 76 L 66 70 L 64 80 L 82 84 Z" fill="currentColor" opacity="0.78"/>
                    {{-- ceja amenazante · marcas rojas --}}
                    <path d="M 32 60 L 56 60" stroke="#FF1A38" stroke-width="1" opacity="0.7"/>
                    <path d="M 64 60 L 88 60" stroke="#FF1A38" stroke-width="1" opacity="0.7"/>
                    {{-- boca abierta + colmillos --}}
                    <path d="M 42 110 Q 60 124, 78 110" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    <path d="M 50 110 L 52 122" stroke="currentColor" stroke-width="0.7" fill="none"/>
                    <path d="M 70 110 L 68 122" stroke="currentColor" stroke-width="0.7" fill="none"/>
                    {{-- marcas frente · 3 rayas verticales --}}
                    <line x1="55" y1="42" x2="55" y2="52" stroke="#FF1A38" stroke-width="0.6" opacity="0.7"/>
                    <line x1="60" y1="40" x2="60" y2="52" stroke="#FF1A38" stroke-width="0.7" opacity="0.7"/>
                    <line x1="65" y1="42" x2="65" y2="52" stroke="#FF1A38" stroke-width="0.6" opacity="0.7"/>
                    @break

                @case('karasu')
                    {{-- TENGU CUERVO · pico largo --}}
                    {{-- cabeza redondeada · más alta que ancha --}}
                    <path d="M 60 22 C 32 26, 28 70, 36 100 C 42 118, 78 118, 84 100 C 92 70, 88 26, 60 22 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    {{-- pico largo prominente · triángulo descendente --}}
                    <path d="M 50 96 L 60 142 L 70 96 Z" stroke="currentColor" stroke-width="0.9" fill="none"/>
                    <line x1="60" y1="100" x2="60" y2="138" stroke="currentColor" stroke-width="0.6"/>
                    {{-- ojos pequeños redondos --}}
                    <circle cx="46" cy="72" r="4" fill="currentColor" opacity="0.78"/>
                    <circle cx="74" cy="72" r="4" fill="currentColor" opacity="0.78"/>
                    {{-- pupilas inner --}}
                    <circle cx="46" cy="72" r="1.4" fill="#FF1A38" opacity="0.85"/>
                    <circle cx="74" cy="72" r="1.4" fill="#FF1A38" opacity="0.85"/>
                    {{-- ceja arqueada · marcas violet/red --}}
                    <path d="M 38 60 Q 46 56, 54 60" stroke="currentColor" stroke-width="0.7" fill="none"/>
                    <path d="M 66 60 Q 74 56, 82 60" stroke="currentColor" stroke-width="0.7" fill="none"/>
                    {{-- cresta superior · plumas estilizadas --}}
                    <path d="M 46 24 L 50 14" stroke="currentColor" stroke-width="0.6"/>
                    <path d="M 60 22 L 60 10" stroke="currentColor" stroke-width="0.6"/>
                    <path d="M 74 24 L 70 14" stroke="currentColor" stroke-width="0.6"/>
                    @break

                @case('neko')
                    {{-- GATO · orejas pequeñas + bigotes --}}
                    {{-- orejas pequeñas triangulares --}}
                    <path d="M 36 36 L 42 18 L 50 38 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    <path d="M 84 36 L 78 18 L 70 38 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    {{-- inner ear marks gold --}}
                    <path d="M 41 28 L 44 36 L 47 32 Z" fill="#F59E0B" opacity="0.5"/>
                    <path d="M 79 28 L 76 36 L 73 32 Z" fill="#F59E0B" opacity="0.5"/>
                    {{-- cara redonda --}}
                    <path d="M 60 36 C 30 38, 26 88, 38 122 C 46 138, 74 138, 82 122 C 94 88, 90 38, 60 36 Z" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    {{-- ojos almendra · pupila vertical felina --}}
                    <ellipse cx="46" cy="78" rx="6" ry="4" fill="currentColor" opacity="0.78"/>
                    <ellipse cx="74" cy="78" rx="6" ry="4" fill="currentColor" opacity="0.78"/>
                    <ellipse cx="46" cy="78" rx="0.8" ry="3" fill="#F59E0B" opacity="0.9"/>
                    <ellipse cx="74" cy="78" rx="0.8" ry="3" fill="#F59E0B" opacity="0.9"/>
                    {{-- nariz triangular --}}
                    <path d="M 56 100 L 64 100 L 60 106 Z" stroke="currentColor" stroke-width="0.6" fill="currentColor" fill-opacity="0.4"/>
                    {{-- bigotes laterales · 3 a cada lado --}}
                    <line x1="20" y1="100" x2="44" y2="98" stroke="currentColor" stroke-width="0.4"/>
                    <line x1="20" y1="106" x2="44" y2="104" stroke="currentColor" stroke-width="0.4"/>
                    <line x1="22" y1="112" x2="44" y2="110" stroke="currentColor" stroke-width="0.4"/>
                    <line x1="100" y1="100" x2="76" y2="98" stroke="currentColor" stroke-width="0.4"/>
                    <line x1="100" y1="106" x2="76" y2="104" stroke="currentColor" stroke-width="0.4"/>
                    <line x1="98" y1="112" x2="76" y2="110" stroke="currentColor" stroke-width="0.4"/>
                    {{-- boca pequeña · "w" --}}
                    <path d="M 54 116 Q 60 122, 66 116" stroke="currentColor" stroke-width="0.5" fill="none"/>
                    @break

                @case('sakura')
                    {{-- FLOR DE CEREZO · 5 pétalos --}}
                    {{-- 5 pétalos alrededor del centro --}}
                    @php
                        $petalsRotations = [0, 72, 144, 216, 288];
                    @endphp
                    @foreach($petalsRotations as $r)
                        <g transform="rotate({{ $r }} 60 80)">
                            <path d="M 60 80 C 52 60, 48 40, 60 30 C 72 40, 68 60, 60 80 Z"
                                  stroke="currentColor" stroke-width="0.7" fill="#EC4899" fill-opacity="0.18"/>
                            {{-- vena central del pétalo --}}
                            <line x1="60" y1="76" x2="60" y2="34" stroke="currentColor" stroke-width="0.4" opacity="0.5"/>
                            {{-- mella superior pétalo (típica sakura) --}}
                            <path d="M 56 32 L 60 38 L 64 32" stroke="currentColor" stroke-width="0.5" fill="none"/>
                        </g>
                    @endforeach
                    {{-- centro · estambres --}}
                    <circle cx="60" cy="80" r="6" fill="#FF1A38" fill-opacity="0.7"/>
                    @for($k = 0; $k < 8; $k++)
                        @php $a = $k * 45; @endphp
                        <line x1="60" y1="80" x2="{{ 60 + cos(deg2rad($a)) * 10 }}" y2="{{ 80 + sin(deg2rad($a)) * 10 }}"
                              stroke="#FF1A38" stroke-width="0.5" opacity="0.7"/>
                    @endfor
                    @break

                @case('ronin')
                    {{-- SAMURAI · marco rectangular minimal · cara impasible --}}
                    {{-- casco frontal rectangular · líneas estructurales --}}
                    <rect x="28" y="28" width="64" height="116" stroke="currentColor" stroke-width="0.8" fill="none"/>
                    {{-- tira frontal del kabuto · línea vertical superior --}}
                    <line x1="60" y1="28" x2="60" y2="46" stroke="currentColor" stroke-width="1.2"/>
                    {{-- frente · banda horizontal --}}
                    <line x1="28" y1="60" x2="92" y2="60" stroke="currentColor" stroke-width="0.6" opacity="0.7"/>
                    {{-- ojos · líneas finas horizontales (cara cubierta) --}}
                    <rect x="38" y="76" width="18" height="6" fill="currentColor" opacity="0.65"/>
                    <rect x="64" y="76" width="18" height="6" fill="currentColor" opacity="0.65"/>
                    {{-- nariz triangular invertida estilizada --}}
                    <path d="M 56 90 L 60 102 L 64 90" stroke="currentColor" stroke-width="0.5" fill="none"/>
                    {{-- línea de boca recta · impasible --}}
                    <line x1="50" y1="118" x2="70" y2="118" stroke="currentColor" stroke-width="0.7"/>
                    {{-- esquinas del marco · brackets internos minimal --}}
                    <line x1="34" y1="34" x2="42" y2="34" stroke="#3B82F6" stroke-width="0.7"/>
                    <line x1="34" y1="34" x2="34" y2="42" stroke="#3B82F6" stroke-width="0.7"/>
                    <line x1="86" y1="34" x2="78" y2="34" stroke="#3B82F6" stroke-width="0.7"/>
                    <line x1="86" y1="34" x2="86" y2="42" stroke="#3B82F6" stroke-width="0.7"/>
                    <line x1="34" y1="138" x2="42" y2="138" stroke="#3B82F6" stroke-width="0.7"/>
                    <line x1="34" y1="138" x2="34" y2="130" stroke="#3B82F6" stroke-width="0.7"/>
                    <line x1="86" y1="138" x2="78" y2="138" stroke="#3B82F6" stroke-width="0.7"/>
                    <line x1="86" y1="138" x2="86" y2="130" stroke="#3B82F6" stroke-width="0.7"/>
                    @break

                @default
                    {{-- BLANK · silueta editorial silenciada --}}
                    <path d="M 60 18 C 28 22, 22 64, 28 102 C 32 128, 46 144, 60 144 C 74 144, 88 128, 92 102 C 98 64, 92 22, 60 18 Z"
                          stroke="currentColor" stroke-width="0.7" fill="none" />
                    <path d="M 40 76 Q 48 70, 56 76 Q 48 82, 40 76 Z" fill="currentColor" opacity="0.55"/>
                    <path d="M 64 76 Q 72 70, 80 76 Q 72 82, 64 76 Z" fill="currentColor" opacity="0.55"/>
                    <line x1="50" y1="116" x2="70" y2="116" stroke="currentColor" stroke-width="0.6"/>
            @endswitch

        </svg>
        <span class="sr-only">{{ $altText }}</span>
    @endif
</figure>
