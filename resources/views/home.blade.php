@extends('layouts.app')

@section('title', 'Circuito Kitsune')
@section('section_label', 'TURNO · NOCHE')

@php
    $hero = $circuitProducts->firstWhere('slug', 'kitsune-01-zorro-de-neon')
        ?? $featuredProducts->first()
        ?? $circuitProducts->first();
    $heroBuildHash = '0x' . strtoupper(substr(md5(date('Ymd')), 0, 6));
    $heroVersion = 'V.' . date('y.m');
    $availableCount = $circuitProducts->where('status', \App\Models\Product::STATUS_AVAILABLE)->count();
    $totalCount = $circuitProducts->count();
    $signalLevel = $hero->signal_level ?? 88;
    $signalBars = (int) round($signalLevel / 10); // 0-10
    $publishedCount = \App\Models\Post::query()->published()->count();
    $nightsActive = 11; // decorativo · calendario ficcional del circuito
@endphp

@section('content')
    {{-- ============================================================
         § 8.1.1 — SECCIÓN 1 · HERO (block-ember) — composición v3
         ============================================================ --}}
    <section class="hero" aria-labelledby="hero-title">

        <div class="hero__status-bar">
            <span class="hero__status-bar__group">
                <x-system-tag label="CIRCUITO KITSUNE" pulse />
                <span>· 35.6762°N · 139.6503°E</span>
            </span>
            <span class="hero__status-bar__group">TOKIO · TURNO NOCHE</span>
        </div>

        <div class="hero__masthead">
            <h1 id="hero-title" class="hero__h1" data-reveal>
                <span class="hero__h1-filled">CIRCUITO</span><span class="hero__h1-outline">KITSUNE</span>
            </h1>
        </div>

        <div class="hero__columns">
            <div class="hero__col hero__col--tagline">
                <div data-reveal style="--reveal-delay: 120ms;">
                    <p class="hero__tagline">
                        <span class="hero__tagline-line">CADA NOCHE<span class="hero__tagline-dot" aria-hidden="true"></span></span>
                        <span class="hero__tagline-line">UNA MÁSCARA<span class="hero__tagline-dot" aria-hidden="true"></span></span>
                        <span class="hero__tagline-line">UN DISTRITO<span class="hero__tagline-dot" aria-hidden="true"></span></span>
                    </p>
                </div>
                <a href="{{ route('products.index') }}"
                   class="bracket-cta bracket-cta--ink hero__cta-primary"
                   data-reveal style="--reveal-delay: 220ms;">
                    <span aria-hidden="true">[</span>
                    <span class="bracket-cta__text">&gt;_ ENTRAR AL ARCHIVO</span>
                    <span aria-hidden="true">]</span>
                    <span class="bracket-cta__arrow" aria-hidden="true">→</span>
                </a>
            </div>

            <div class="hero__col hero__col--prose" data-reveal style="--reveal-delay: 180ms;">
                <div class="hero__prose-meta">
                    <span>▸ EXPEDIENTE 01 · 06</span>
                    <span>02:45 JST</span>
                </div>
                <p class="hero__prose">
                    Tienda clandestina de máscaras del turno noche. Seis identidades, seis distritos, una señal por máscara. El circuito asigna; vos reservás antes de que cambie.
                </p>
                <a href="{{ route('posts.index') }}" class="hero__prose-link">
                    <span>LEER TRANSMISIONES</span>
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="hero__col hero__col--portrait">
                @if($hero && $hero->hasImage())
                    <img class="hero__portrait-img"
                         src="{{ asset($hero->image_path) }}"
                         alt="{{ $hero->name }}"
                         width="800" height="1067"
                         decoding="async"
                         fetchpriority="high">
                @else
                    <x-mask-portrait :product="$hero" :brackets="false" :glow="false" class="hero__portrait-img" />
                @endif
            </div>
        </div>

        <div class="hero__bottom">
            <span class="hero__bottom__group">
                <span>id · 0xKSN001</span>
                <span>· signal · {{ $signalLevel }}/99</span>
                <span>· {{ strtolower($hero->district ?? 'shibuya static') }}</span>
            </span>
            <span class="hero__signal" aria-hidden="true">
                @for ($i = 1; $i <= 10; $i++)
                    <span class="hero__signal-bar {{ $i > $signalBars ? 'hero__signal-bar--off' : '' }}"
                          style="height: {{ 6 + $i }}px;"></span>
                @endfor
            </span>
            <span class="hero__bottom__group">{{ $heroVersion }} · BUILD · {{ $heroBuildHash }}</span>
        </div>

        <x-marquee class="hero__marquee"
                   :items="[
                        'TURNO NOCHE ACTIVO',
                        str_pad($totalCount, 2, '0', STR_PAD_LEFT) . ' IDENTIDADES',
                        str_pad($availableCount, 2, '0', STR_PAD_LEFT) . ' DISPONIBLES',
                        '35.6762°N · 139.6503°E',
                        'SEÑAL ABIERTA',
                   ]" />
    </section>

    {{-- ============================================================
         § 8.1.2 — SECCIÓN 2 · STATS GLOBALES (block-ink propio CK)
         ============================================================ --}}
    <section class="stats-strip" aria-labelledby="stats-heading">
        <div class="stats-strip__head">
            <x-system-tag id="stats-heading" label="ESTADO DEL CIRCUITO · 35.6762°N · TURNO NOCHE" pulse />
            <span class="stats-strip__counter">{{ $heroVersion }} · CICLO 0{{ date('w') ?: 7 }}/07</span>
        </div>
        <div class="stats-strip__grid">
            <x-stat-block label="IDENTIDADES" :value="$totalCount" suffix="/06" />
            <x-stat-block label="DISPONIBLES" :value="$availableCount" suffix="/06" />
            <x-stat-block label="NOCHES ACTIVAS" :value="$nightsActive" suffix="/30" />
            <x-stat-block label="SEÑALES" :value="$publishedCount" suffix="/05" />
        </div>
    </section>

    {{-- ============================================================
         § 8.1.3 — SECCIÓN 3 · WALL ASIMÉTRICO (block-ink, R35)
         ============================================================ --}}
    <section class="wall block-ink" aria-labelledby="wall-heading">
        <div class="wall__head">
            <div class="wall__head-main">
                <x-system-tag label="ARCHIVO · 06 IDENTIDADES ACTIVAS" pulse />
                <h2 id="wall-heading" class="wall__title" data-reveal><span class="title-line">ARCHIVO DE</span><span class="title-line">MÁSCARAS.</span></h2>
                <p class="wall__lede t-body">
                    Cada cuadro es un expediente. Cada bracket rojo señala una identidad disponible esta noche. Hacé click para abrir.
                </p>
            </div>
            <div class="wall__hud">
                <div>cluster: <strong>06/06</strong></div>
                <div>node: <strong>KSN-124</strong></div>
                <div>▸ click para abrir</div>
            </div>
        </div>

        <div class="wall__grid">
            @foreach($circuitProducts as $p)
                @php
                    $type = \Illuminate\Support\Str::before($p->slug, '-');
                    $isFeatured = $p->slug === 'kitsune-01-zorro-de-neon';
                    $modifier = $isFeatured ? 'featured' : $type;
                    $statusOff = !$p->isAvailable();
                @endphp
                <a href="{{ route('products.show', $p) }}"
                   class="wall__cell wall__cell--{{ $modifier }}"
                   aria-label="{{ $p->name }} — {{ $p->statusLabel() }}">
                    <span class="wall__cell-glow glow-{{ $p->dominant_color ?? 'cyan' }}" aria-hidden="true"></span>
                    @if($isFeatured)
                        <span class="wall__cell-plus" aria-hidden="true">+</span>
                    @endif
                    @if($p->hasImage())
                        <img src="{{ asset($p->image_path) }}"
                             class="wall__cell-img"
                             alt="{{ $p->name }}"
                             width="600" height="800"
                             loading="lazy" decoding="async">
                    @else
                        <x-mask-portrait :product="$p" :brackets="false" :glow="false" class="wall__cell-img" />
                    @endif
                    <span class="wall__cell-tag wall__cell-tag--top">[{{ $p->code }}]</span>
                    <span class="wall__cell-tag wall__cell-tag--bottom">
                        <span>{{ strtoupper($p->district) }}</span>
                        <span class="wall__cell-status {{ $statusOff ? 'wall__cell-status--off' : '' }}">{{ strtoupper($p->statusLabel()) }}</span>
                    </span>
                </a>
            @endforeach
        </div>

        <div class="wall__cta-row">
            <span class="wall__cta-hud">los 06 expedientes están sincronizados con el turno noche · señal abierta</span>
            <x-bracket-cta :href="route('products.index')" variant="ember">ARCHIVO COMPLETO</x-bracket-cta>
        </div>
    </section>

    {{-- ============================================================
         § 8.1.4 — SECCIÓN 4 · FEATURED MASK HERO (block-ink, kanji individual)
         ============================================================ --}}
    @php
        $featuredKanjiMap = [
            'kitsune' => '狐',
            'oni' => '鬼',
            'karasu' => '烏',
            'neko' => '猫',
            'sakura' => '桜',
            'ronin' => '浪',
        ];
        $featuredType = \Illuminate\Support\Str::before($hero->slug, '-');
        $featuredKanji = $featuredKanjiMap[$featuredType] ?? '狐';
        [$featuredCode, $featuredAlias] = array_pad(explode(': ', $hero->name, 2), 2, $hero->name);
    @endphp
    <section class="featured-mask" aria-labelledby="featured-mask-heading">
        <span class="featured-mask__kanji" aria-hidden="true">{{ $featuredKanji }}</span>
        <span class="featured-mask__glow glow-{{ $hero->dominant_color ?? 'cyan' }}" aria-hidden="true"></span>

        <div class="featured-mask__status-bar">
            <span><x-system-tag label="DESTACADA · TURNO NOCHE · ID 0xKSN001" pulse /></span>
            <span>04 / 08 — <strong>FEATURED</strong></span>
        </div>

        <div class="featured-mask__inner">
            <div class="featured-mask__info" data-reveal>
                <h2 id="featured-mask-heading" class="featured-mask__name">{{ strtoupper($featuredCode) }}</h2>
                <p class="featured-mask__subtitle">{{ strtoupper($featuredAlias) }}.</p>
                <p class="featured-mask__body t-body-lg">{{ $hero->short_description }}</p>
                <div class="featured-mask__meta-row">
                    <span>distrito<strong>{{ $hero->district }}</strong></span>
                    <span>rareza<strong>{{ $hero->rarity }}</strong></span>
                    <span>signal<strong>{{ $hero->signal_level }}/99</strong></span>
                    <span>precio<strong>{{ $hero->formattedPrice() }}</strong></span>
                </div>
                <a href="{{ route('products.show', $hero) }}"
                   class="bracket-cta bracket-cta--ember featured-mask__cta">
                    <span aria-hidden="true">[</span>
                    <span class="bracket-cta__text">&gt;_ ABRIR EXPEDIENTE</span>
                    <span aria-hidden="true">]</span>
                    <span class="bracket-cta__arrow" aria-hidden="true">→</span>
                </a>
            </div>

            <figure class="featured-mask__portrait">
                @if($hero && $hero->hasImage())
                    <img src="{{ asset($hero->image_path) }}"
                         class="featured-mask__portrait-img"
                         alt="{{ $hero->name }}"
                         width="800" height="1067"
                         loading="lazy" decoding="async">
                @else
                    <x-mask-portrait :product="$hero" :brackets="false" :glow="false" class="featured-mask__portrait-img" />
                @endif
                <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--br" aria-hidden="true"></span>
            </figure>
        </div>

        <div class="featured-mask__stats">
            <x-stat-block label="SEÑAL" :value="$hero->signal_level" suffix="/99" variant="ember" />
            <x-stat-block label="AGILIDAD" :value="$hero->agility" suffix="/99" variant="ember" />
            <x-stat-block label="ESPÍRITU" :value="$hero->spirit" suffix="/99" variant="ember" />
            <x-stat-block label="FEROCIDAD" :value="$hero->ferocity" suffix="/99" variant="ember" />
        </div>

        <x-marquee class="featured-mask__marquee"
                   :items="[
                        'EXPEDIENTE DESTACADO · ' . strtoupper($hero->code ?? 'KSN-01'),
                        'DISTRITO ' . strtoupper($hero->district),
                        strtoupper($hero->rarity),
                        $hero->formattedPrice(),
                        'SEÑAL · ' . $hero->signal_level . '/99',
                   ]" />
    </section>

    {{-- ============================================================
         § 8.1.5 — SECCIÓN 5 · MAPA DE DISTRITOS (block-ink propio CK)
         ============================================================ --}}
    <section class="district-map" aria-labelledby="district-map-heading">
        <div class="district-map__head">
            <div class="district-map__head-main">
                <x-system-tag label="TERRITORIOS · 06 DISTRITOS DEL CIRCUITO" pulse />
                <h2 id="district-map-heading" class="district-map__title" data-reveal><span class="title-line">MAPA DEL</span><span class="title-line">CIRCUITO.</span></h2>
                <p class="district-map__lede t-body">
                    Cada máscara opera en un distrito propio. La asignación cambia con la noche. Las coordenadas son ficcionales pero deterministas.
                </p>
            </div>
            <div class="district-map__hud">
                <div>nodo: <strong>KSN-CORE</strong></div>
                <div>turno: <strong>NOCHE</strong></div>
                <div>cobertura: <strong>06/06</strong></div>
            </div>
        </div>

        <div class="district-map__grid">
            @foreach($circuitProducts as $i => $p)
                @php
                    $crc = abs(crc32($p->slug));
                    $lat = number_format(35.65 + ($crc % 10000) / 100000, 4);
                    $lng = number_format(139.70 + ($crc % 10000) / 100000, 4);
                    $statusOff = !$p->isAvailable();
                @endphp
                <a href="{{ route('products.show', $p) }}"
                   class="district-cell"
                   aria-label="Distrito {{ $p->district }} — {{ $p->name }}">
                    <span class="district-cell__glow glow-{{ $p->dominant_color ?? 'cyan' }}" aria-hidden="true"></span>

                    <div class="district-cell__top">
                        <span class="district-cell__no">DISTRITO {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="district-cell__coords">{{ $lat }}°N · {{ $lng }}°E</span>
                    </div>

                    <h3 class="district-cell__name">{{ strtoupper($p->district) }}</h3>

                    <div class="district-cell__bottom">
                        <span><strong>{{ $p->code }}</strong></span>
                        <span class="district-cell__status {{ $statusOff ? 'district-cell__status--off' : '' }}">{{ strtoupper($p->statusLabel()) }}</span>
                    </div>

                    <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
                    <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
                    <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
                    <span class="frame-corner frame-corner--br" aria-hidden="true"></span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ============================================================
         § 8.1.6 — SECCIÓN 6 · ÚLTIMA TRANSMISIÓN DESTACADA (propio CK)
         ============================================================ --}}
    @php $latestPost = \App\Models\Post::query()->published()->latest('published_at')->first(); @endphp
    @if($latestPost)
        <section class="last-tx" aria-labelledby="last-tx-heading">
            <div class="last-tx__inner">
                <div class="last-tx__head">
                    <x-system-tag label="ÚLTIMA SEÑAL · INTERCEPTADA HACE 4 H" pulse />
                    <div class="last-tx__meta">
                        <span>guía<strong>{{ $latestPost->reading_time }} MIN</strong></span>
                        <span>hash<strong>0x{{ strtoupper(substr(md5($latestPost->slug), 0, 6)) }}</strong></span>
                        <span>block<strong>TX-{{ str_pad($latestPost->id, 3, '0', STR_PAD_LEFT) }}</strong></span>
                    </div>
                    <h2 id="last-tx-heading" class="last-tx__title" data-reveal>
                        <a href="{{ route('posts.show', $latestPost) }}">{{ strtoupper($latestPost->title) }}.</a>
                    </h2>
                    <p class="last-tx__excerpt t-body-lg">{{ $latestPost->excerpt }}</p>
                    <div class="last-tx__meta">
                        <span>archivo<strong>KITSUNE</strong></span>
                        <span>fecha<strong>{{ $latestPost->formattedDate() }}</strong></span>
                        <span>señal<strong>87/99</strong></span>
                    </div>
                    <a href="{{ route('posts.show', $latestPost) }}"
                       class="bracket-cta bracket-cta--ember last-tx__cta">
                        <span aria-hidden="true">[</span>
                        <span class="bracket-cta__text">&gt;_ LEER COMPLETA</span>
                        <span aria-hidden="true">]</span>
                        <span class="bracket-cta__arrow" aria-hidden="true">→</span>
                    </a>
                </div>
                <div class="last-tx__visual" aria-hidden="true">
                    <span class="last-tx__visual-kanji">信</span>
                    <span class="last-tx__visual-cross">+</span>
                </div>
            </div>
        </section>
    @endif

    {{-- ============================================================
         § 8.1.7 — SECCIÓN 7 · FEED 2 TRANSMISIONES
         ============================================================ --}}
    @php
        $otherPosts = \App\Models\Post::query()
            ->published()
            ->latest('published_at')
            ->skip(1)
            ->take(2)
            ->get();
        $kanjiNumbers = ['壱', '弐', '参', '肆', '伍'];
    @endphp
    @if($otherPosts->isNotEmpty())
        <section class="feed-tx" aria-labelledby="feed-tx-heading">
            <div class="feed-tx__inner">
                <div class="feed-tx__head">
                    <x-system-tag :label="'MÁS SEÑALES · ' . str_pad($otherPosts->count(), 2, '0', STR_PAD_LEFT) . ' RESTANTES EN FEED'" />
                    <h2 id="feed-tx-heading" class="feed-tx__title">OTRAS TRANSMISIONES.</h2>
                </div>
                <ul class="feed-tx__list">
                    @foreach($otherPosts as $i => $post)
                        <li>
                            <a href="{{ route('posts.show', $post) }}" class="feed-tx__item">
                                <span class="feed-tx__item-kanji" aria-hidden="true">{{ $kanjiNumbers[$i + 1] ?? '参' }}</span>
                                <div class="feed-tx__item-body">
                                    <span class="feed-tx__item-tag">[{{ strtoupper($post->category) }} · {{ $post->reading_time }} MIN]</span>
                                    <h3 class="feed-tx__item-title">{{ strtoupper($post->title) }}</h3>
                                    <p class="feed-tx__item-excerpt">{{ \Illuminate\Support\Str::limit($post->excerpt, 130) }}</p>
                                    <span class="feed-tx__item-meta">{{ strtoupper($post->author) }} · {{ $post->formattedDate() }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="feed-tx__cta-row">
                    <x-bracket-cta :href="route('posts.index')" variant="ember">&gt;_ ARCHIVO COMPLETO</x-bracket-cta>
                </div>
            </div>
        </section>
    @endif

    {{-- ============================================================
         § 8.1.8 — SECCIÓN 8 · CLOSING (block-ember invertido)
         ============================================================ --}}
    <section class="closing" aria-labelledby="closing-heading">
        <span class="closing__kanji" aria-hidden="true">終</span>
        <div class="closing__inner">
            <h2 id="closing-heading" class="closing__title" data-reveal>
                <span class="closing__title-line">ELEGÍ TU TURNO<span class="closing__title-dot" aria-hidden="true"></span></span>
                <span class="closing__title-line">ABRÍ TU SEÑAL<span class="closing__title-dot" aria-hidden="true"></span></span>
                <span class="closing__title-line">ENTRÁ AL CIRCUITO<span class="closing__title-dot" aria-hidden="true"></span></span>
            </h2>
            <p class="closing__body t-body-lg" data-reveal style="--reveal-delay: 200ms;">
                La noche es la única jurisdicción. Cada máscara es una entrada. El carrito se abre en la próxima fase del circuito.
            </p>
            <div class="closing__cta-row" data-reveal style="--reveal-delay: 320ms;">
                <a href="{{ route('products.index') }}" class="bracket-cta bracket-cta--ink">
                    <span aria-hidden="true">[</span>
                    <span class="bracket-cta__text">&gt;_ ABRIR EL ARCHIVO</span>
                    <span aria-hidden="true">]</span>
                    <span class="bracket-cta__arrow" aria-hidden="true">→</span>
                </a>
                <a href="{{ route('posts.index') }}" class="bracket-cta bracket-cta--ink">
                    <span aria-hidden="true">[</span>
                    <span class="bracket-cta__text">LEER TRANSMISIONES</span>
                    <span aria-hidden="true">]</span>
                    <span class="bracket-cta__arrow" aria-hidden="true">→</span>
                </a>
            </div>
        </div>
        <x-marquee class="closing__marquee"
                   :items="[
                        'TURNO NOCHE',
                        'IDENTIDAD ASIGNADA',
                        'SEÑAL ABIERTA',
                        'CIRCUITO KITSUNE ACTIVO',
                        '35.6762°N · 139.6503°E',
                   ]" />
    </section>
@endsection
