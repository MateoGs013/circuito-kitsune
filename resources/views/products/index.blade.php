@extends('layouts.app')

@section('title', 'Archivo de máscaras')
@section('section_label', 'ARCHIVO · ' . str_pad($products->count(), 2, '0', STR_PAD_LEFT))
@section('meta_description', 'Archivo de máscaras del circuito. Seis identidades, seis distritos, una señal por máscara.')

@php
    $filters = [
        null         => 'TODOS',
        'disponibles' => 'DISPONIBLES',
        'proximas'    => 'PRÓXIMAS',
        'agotadas'    => 'AGOTADAS',
        'raras'       => 'RARAS',
        'legendarias' => 'LEGENDARIAS',
    ];
@endphp

@section('content')
    <section class="catalog-hero" aria-labelledby="catalog-heading">
        <x-system-tag :label="'ARCHIVO · ' . str_pad($totalCount, 2, '0', STR_PAD_LEFT) . ' IDENTIDADES'" pulse />
        <h1 id="catalog-heading" class="catalog-hero__title" data-reveal><span class="title-line">ARCHIVO DE</span><span class="title-line">MÁSCARAS.</span></h1>
        <p class="catalog-hero__lede t-body-lg">
            Cada máscara opera en un distrito propio. Filtros sincronizados con el estado de la noche. Click en cualquier expediente para abrir.
        </p>
    </section>

    <nav class="catalog-filters" aria-label="Filtrar archivo">
        <div class="catalog-filters__inner">
            @foreach($filters as $key => $label)
                @php
                    $isActive = $activeFilter === $key || ($activeFilter === null && $key === null);
                    $url = $key === null
                        ? route('products.index')
                        : route('products.index', ['filter' => $key]);
                @endphp
                <a href="{{ $url }}"
                   class="catalog-filter"
                   @if($isActive) aria-current="page" @endif>
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </nav>

    @if($products->isEmpty())
        <div class="catalog-empty">
            <p class="catalog-empty__msg">NINGÚN EXPEDIENTE COINCIDE CON ESTE FILTRO</p>
            <x-bracket-cta :href="route('products.index')" variant="ember">VER TODOS</x-bracket-cta>
        </div>
    @else
        <section class="catalog" aria-labelledby="catalog-heading">
            <div class="catalog__grid">
                @foreach($products as $p)
                    @php $statusOff = !$p->isAvailable(); @endphp
                    <a href="{{ route('products.show', $p) }}"
                       class="catalog-card {{ $p->is_featured ? 'catalog-card--featured' : '' }}"
                       aria-label="{{ $p->name }} — {{ $p->statusLabel() }}">
                        <span class="catalog-card__glow glow-{{ $p->dominant_color ?? 'cyan' }}" aria-hidden="true"></span>
                        @if($p->hasImage())
                            <img src="{{ asset($p->image_path) }}"
                                 class="catalog-card__img"
                                 alt="{{ $p->name }}"
                                 width="600" height="800"
                                 loading="lazy" decoding="async">
                        @else
                            <x-mask-portrait :product="$p" :brackets="false" :glow="false" class="catalog-card__img" />
                        @endif
                        <div class="catalog-card__top">
                            <strong>[{{ $p->code }}]</strong>
                            <span>{{ strtoupper($p->rarity) }}</span>
                        </div>
                        <div class="catalog-card__bottom">
                            <h2 class="catalog-card__name">{{ strtoupper($p->name) }}</h2>
                            <div class="catalog-card__meta">
                                <span>{{ strtoupper($p->district) }}</span>
                                <span class="catalog-card__status {{ $statusOff ? 'catalog-card__status--off' : '' }}">{{ strtoupper($p->statusLabel()) }} · {{ $p->formattedPrice() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
