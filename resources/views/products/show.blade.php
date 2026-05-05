@extends('layouts.app')

@section('title', $product->name)
@section('section_label', 'EXPEDIENTE · ' . strtoupper($product->code))
@section('meta_description', $product->short_description)

@php
    [$productCode, $productAlias] = array_pad(explode(': ', $product->name, 2), 2, $product->name);
    $hash = '0x' . strtoupper(substr(md5($product->slug), 0, 6));
    $crc = abs(crc32($product->slug));
    $lat = number_format(35.65 + ($crc % 10000) / 100000, 4);
    $lng = number_format(139.70 + ($crc % 10000) / 100000, 4);
    $signalBars = (int) round(($product->signal_level ?? 0) / 10);
    $bodyParagraphs = preg_split("/\n\s*\n/", trim((string) $product->long_description)) ?: [];
    $attrKanji = ['信' => 'SEÑAL', '速' => 'AGILIDAD', '魂' => 'ESPÍRITU', '怒' => 'FEROCIDAD'];
    $isAvailable = $product->isAvailable();
@endphp

@section('content')
    {{-- (1) HERO COLOR-DRIVEN --}}
    <section class="product-hero" aria-labelledby="product-heading">
        <span class="product-hero__glow glow-{{ $product->dominant_color ?? 'cyan' }}" aria-hidden="true"></span>

        <div class="product-hero__inner">
            <div class="product-hero__info">
                <x-system-tag :label="'EXPEDIENTE ' . $product->code . ' · ' . strtoupper($product->statusLabel()) . ' · ' . strtoupper($product->dominant_color ?? 'CYAN') . '·SIGNAL'" pulse />
                <h1 id="product-heading" class="product-hero__name" data-reveal>{{ strtoupper($productCode) }}</h1>
                <p class="product-hero__alias" data-reveal style="--reveal-delay: 100ms;">{{ strtoupper($productAlias) }}.</p>
                <p class="product-hero__body t-body-lg" data-reveal style="--reveal-delay: 180ms;">{{ $product->short_description }}</p>

                <div class="product-hero__hud">
                    <span>hash<strong>{{ $hash }}</strong></span>
                    <span>block<strong>EXP-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</strong></span>
                    <span>signal<strong class="product-hero__signal-bars" aria-label="{{ $product->signal_level }} de 99">
                        @for ($i = 1; $i <= 10; $i++)
                            <span class="{{ $i > $signalBars ? 'is-off' : '' }}"></span>
                        @endfor
                    </strong></span>
                    <span>distrito<strong>{{ $product->district }}</strong></span>
                    <span>rareza<strong>{{ $product->rarity }}</strong></span>
                    <span>precio<strong>{{ $product->formattedPrice() }}</strong></span>
                </div>

                <div class="product-hero__cta-row">
                    <a href="#accion"
                       class="bracket-cta bracket-cta--ember {{ $isAvailable ? '' : 'is-disabled' }}"
                       @if(!$isAvailable) aria-disabled="true" @endif>
                        <span aria-hidden="true">[</span>
                        <span class="bracket-cta__text">&gt;_ {{ $isAvailable ? 'RESERVAR' : strtoupper($product->statusLabel()) }}</span>
                        <span aria-hidden="true">]</span>
                        <span class="bracket-cta__arrow" aria-hidden="true">→</span>
                    </a>
                    <span class="product-hero__microcopy">el carrito se abre en la próxima fase del circuito.</span>
                </div>
            </div>

            <figure class="product-hero__portrait">
                @if($product->hasImage())
                    <img src="{{ asset($product->image_path) }}"
                         class="product-hero__portrait-img"
                         alt="{{ $product->name }}"
                         width="800" height="1067"
                         decoding="async"
                         fetchpriority="high">
                @else
                    <x-mask-portrait :product="$product" :brackets="false" :glow="false" class="product-hero__portrait-img" />
                @endif
                <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--br" aria-hidden="true"></span>
            </figure>
        </div>
    </section>

    {{-- (2) ATRIBUTOS --}}
    <section class="product-attrs" aria-labelledby="attrs-heading">
        <div class="product-section__head">
            <x-system-tag label="01 · ATRIBUTOS" />
            <h2 id="attrs-heading" class="product-section__title" data-reveal><span class="title-line">CÓMO SE COMPORTA</span><span class="title-line">EL CIRCUITO.</span></h2>
        </div>
        <div class="product-attrs__grid">
            @foreach($attrKanji as $kanji => $label)
                @php
                    $value = match($label) {
                        'SEÑAL' => $product->signal_level,
                        'AGILIDAD' => $product->agility,
                        'ESPÍRITU' => $product->spirit,
                        'FEROCIDAD' => $product->ferocity,
                        default => 0,
                    };
                @endphp
                <div class="product-attr">
                    <span class="product-attr__kanji" aria-hidden="true">{{ $kanji }}</span>
                    <div class="product-attr__label">{{ $label }}</div>
                    <div class="product-attr__value">{{ str_pad($value ?? 0, 2, '0', STR_PAD_LEFT) }}<span class="product-attr__suffix">/99</span></div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- (3) PROTOCOLO --}}
    <section class="product-protocol" aria-labelledby="protocol-heading">
        <div class="product-section__head">
            <x-system-tag label="02 · PROTOCOLO" />
            <h2 id="protocol-heading" class="product-section__title" data-reveal>EXPEDIENTE.</h2>
        </div>
        <article class="product-protocol__article">
            @forelse($bodyParagraphs as $paragraph)
                <p>{{ $paragraph }}</p>
            @empty
                <p>{{ $product->short_description }}</p>
            @endforelse
        </article>
        <p class="product-protocol__meta">última sync · {{ now()->format('d/m/Y · H:i') }} · coords {{ $lat }}°N · {{ $lng }}°E</p>
    </section>

    {{-- (4) ACCIÓN (block-ember invertido) --}}
    <section id="accion" class="product-action" aria-labelledby="action-heading">
        <x-system-tag :label="strtoupper($product->statusLabel()) . ' · ' . $product->code . ' · ' . strtoupper($product->district)" variant="ink" />
        <h2 id="action-heading" class="product-action__title" data-reveal><span class="title-line">RESERVÁ ESTA</span><span class="title-line">MÁSCARA.</span></h2>
        <p class="product-action__body t-body-lg">
            @if($isAvailable)
                {{ strtoupper($product->code) }} está activa esta noche en {{ $product->district }}. Una señal por máscara, una máscara por turno.
            @else
                {{ strtoupper($product->code) }} no está disponible esta noche. Volvé en el próximo turno o explorá otras identidades del archivo.
            @endif
        </p>
        <div class="product-action__cta">
            <a href="#"
               class="bracket-cta bracket-cta--ink {{ $isAvailable ? '' : 'is-disabled' }}"
               @if(!$isAvailable) aria-disabled="true" tabindex="-1" @endif>
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ {{ $isAvailable ? 'RESERVAR' : 'NO DISPONIBLE' }}</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </a>
        </div>
        <p class="product-action__microcopy">el carrito se abre en la próxima fase del circuito.</p>
        <a href="{{ route('products.index') }}" class="product-action__back">← VOLVER AL ARCHIVO</a>
    </section>
@endsection
