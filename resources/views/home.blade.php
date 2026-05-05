@extends('layouts.app')

@section('title', 'Turno noche')
@section('meta_description', 'Tienda clandestina de máscaras japonesas cyberpunk. Cada máscara abre un distrito de la ciudad nocturna. Las identidades solo existen de noche.')

@section('content')

@php
    $sessionHash = strtoupper(substr(md5(date('Ymd-Hi')), 0, 6));
    $blockId = 'KSN-' . str_pad((int) date('z'), 3, '0', STR_PAD_LEFT);
    $colorMap = [
        'cyan' => '#22d3ee',
        'red' => '#ef4444',
        'violet' => '#8b5cf6',
        'gold' => '#f59e0b',
        'magenta' => '#ec4899',
        'blue' => '#3b82f6',
    ];
    $heroProduct = $featuredProducts->first() ?? $circuitProducts->first();
@endphp

{{-- ═══════════════════════════════════════════════════════════════════
     1 · HERO · color block ember edge-to-edge · brutalismo manifesto
     ═══════════════════════════════════════════════════════════════════ --}}
<section class="block-ember relative w-screen overflow-hidden flex flex-col"
         style="min-height: 100dvh; padding-top: clamp(5.5rem, 7vw, 8rem); padding-bottom: clamp(2.5rem, 4vw, 4rem);"
         aria-label="Bienvenida">

    {{-- scan grid de fondo --}}
    <div class="scan-grid scan-grid--ink" aria-hidden="true"></div>

    {{-- top status bar dentro del hero · debajo del header --}}
    <div class="relative z-20 flex items-center justify-between font-mono uppercase tracking-[0.22em] text-[0.72rem] font-medium text-ink"
         style="padding-left: clamp(1.25rem, 4vw, 5rem); padding-right: clamp(1.25rem, 4vw, 5rem);">
        <span class="flex items-center gap-2">
            <span class="inline-block w-2 h-2 bg-ink rounded-full"></span>
            node · kitsune · 35.6762°n · 139.6503°e
        </span>
        <span class="hidden md:inline">[ ingreso · {{ str_pad((int) date('H'), 2, '0', STR_PAD_LEFT) }}:{{ str_pad((int) date('i'), 2, '0', STR_PAD_LEFT) }} jst ]</span>
        <span>v.{{ date('y.m') }} · build · {{ $sessionHash }}</span>
    </div>

    {{-- ambient letters · scattered fluido por viewport · contraste pleno text-ink --}}
    <div class="absolute inset-0 pointer-events-none select-none z-[5] hidden lg:block" aria-hidden="true">
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 18%; left: 1.8vw; font-size: clamp(0.78rem, 1vw, 1rem);">k</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 36%; left: 3.5vw; font-size: clamp(0.78rem, 1vw, 1rem);">i</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 54%; left: 1.2vw; font-size: clamp(0.78rem, 1vw, 1rem);">t</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 72%; left: 4vw; font-size: clamp(0.78rem, 1vw, 1rem);">s</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 88%; left: 2vw; font-size: clamp(0.78rem, 1vw, 1rem);">u</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 18%; right: 1.5vw; font-size: clamp(0.78rem, 1vw, 1rem);">[loading]</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 36%; right: 3vw; font-size: clamp(0.78rem, 1vw, 1rem);">o</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 54%; right: 1.2vw; font-size: clamp(0.78rem, 1vw, 1rem);">b</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 72%; right: 4vw; font-size: clamp(0.78rem, 1vw, 1rem);">s</div>
        <div class="absolute font-mono tracking-[0.32em] font-medium text-ink" style="top: 88%; right: 2vw; font-size: clamp(0.78rem, 1vw, 1rem);">e</div>
    </div>

    {{-- ── HERO MAIN GRID · 2 columnas escalables ────────────────── --}}
    <div class="relative z-10 flex-1 flex flex-col lg:flex-row items-stretch"
         style="padding: clamp(2.5rem, 5vw, 5rem) clamp(1.5rem, 4vw, 5rem) 0;">

        {{-- ── IZQUIERDA · manifesto ──────────────────────────────── --}}
        <div class="flex-1 flex flex-col justify-between min-w-0" style="gap: clamp(2rem, 4vw, 4rem);">

            <div>
                {{-- H1 brutalista · 2 líneas Bebas · escala con vw --}}
                <h1 class="text-ink" data-glitch-flash
                    style="font-family: var(--font-display); text-transform: uppercase; letter-spacing: -0.005em; line-height: 0.86; font-size: clamp(3.5rem, 11vw, 14rem);">
                    <span data-reveal-line><span class="block">circuito</span></span>
                    <span data-reveal-line style="--reveal-delay: 140ms;"><span class="block">kitsune</span></span>
                </h1>

                {{-- tagline manifesto · 3 líneas separadas --}}
                <div data-reveal style="--reveal-delay: 380ms;"
                     class="mt-[clamp(1.5rem,3vw,3rem)]" >
                    <div class="text-ink" style="font-family: var(--font-display); text-transform: uppercase; line-height: 0.92; font-size: clamp(1.75rem, 3.4vw, 4rem);">marcado.</div>
                    <div class="text-ink" style="font-family: var(--font-display); text-transform: uppercase; line-height: 0.92; font-size: clamp(1.75rem, 3.4vw, 4rem);">asignado.</div>
                    <div class="text-ink" style="font-family: var(--font-display); text-transform: uppercase; line-height: 0.92; font-size: clamp(1.75rem, 3.4vw, 4rem);">devuelto.</div>
                </div>
            </div>

            <div class="flex flex-col" style="gap: clamp(1.5rem, 2.5vw, 2.5rem);">
                <p data-reveal style="--reveal-delay: 580ms; font-size: clamp(0.78rem, 0.95vw, 0.95rem); line-height: 1.7; max-width: clamp(28ch, 38vw, 56ch);"
                   class="font-mono uppercase tracking-[0.18em] font-medium text-ink">
                    monografías clandestinas iluminan los distritos nocturnos. cada máscara guarda un fragmento de identidad. el circuito te lee, te asigna un distrito y te devuelve una señal. la noche es la única jurisdicción.
                </p>

                <div data-reveal class="flex flex-wrap items-center gap-x-4 gap-y-4" style="--reveal-delay: 720ms;">
                    <a href="{{ route('products.index') }}" class="bracket-cta text-ink hover:text-ink" data-glitch>
                        <span class="bracket-cta__caret">&gt;_</span><span>entrar al archivo</span>
                    </a>
                    @php $randomProduct = $circuitProducts->where('status', App\Models\Product::STATUS_AVAILABLE)->random() ?? $circuitProducts->first(); @endphp
                    <a href="{{ route('products.show', $randomProduct) }}" class="bracket-cta text-ink hover:text-ink" data-glitch>
                        <span>selección aleatoria</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ── DERECHA · retrato dominante · escala con vw ─────────── --}}
        <div class="flex items-center justify-center lg:justify-end relative shrink-0"
             style="padding-top: clamp(2.5rem, 4vw, 0px); margin-left: clamp(0px, 3vw, 4rem);">

            <div class="relative" style="width: clamp(280px, 32vw, 620px); aspect-ratio: 3 / 4;">

                {{-- meta arriba del retrato --}}
                <div class="absolute -top-10 left-0 right-0 flex items-center justify-between font-mono uppercase tracking-[0.22em] font-medium text-ink"
                     style="font-size: clamp(0.65rem, 0.78vw, 0.78rem);">
                    <span>01 · {{ str_pad($circuitProducts->count(), 2, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ strtolower($heroProduct->name) }}</span>
                </div>

                <div class="frame-brackets w-full h-full" style="--bracket-color: var(--color-ink); --bracket-size: clamp(20px, 2.4vw, 36px); --bracket-offset: clamp(8px, 1vw, 18px);">
                    <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
                    <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
                    <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
                    <span class="frame-corner frame-corner--br" aria-hidden="true"></span>

                    <x-mask-portrait :product="$heroProduct" class="w-full h-full" />
                </div>

                {{-- meta debajo del retrato --}}
                <div class="absolute -bottom-12 left-0 right-0 flex items-center justify-between font-mono uppercase tracking-[0.22em] font-medium text-ink"
                     style="font-size: clamp(0.65rem, 0.78vw, 0.78rem);">
                    <span>id · 0x{{ strtoupper(substr(md5($heroProduct->slug), 0, 6)) }}</span>
                    <span>signal · {{ $heroProduct->signal_level }}/99</span>
                </div>
            </div>
        </div>
    </div>

    {{-- marquee inferior recursivo --}}
    <div class="absolute bottom-0 left-0 right-0 marquee text-ink" style="border-color: var(--color-ink);">
        <div class="marquee__track">
            @for($k = 0; $k < 3; $k++)
                <span class="marquee__item">turno noche activo</span><span class="marquee__sep">·</span>
                <span class="marquee__item">06 identidades disponibles</span><span class="marquee__sep">·</span>
                <span class="marquee__item">circuito kitsune · v.{{ date('y') }}</span><span class="marquee__sep">·</span>
                <span class="marquee__item">35.6762°n · 139.6503°e</span><span class="marquee__sep">·</span>
                <span class="marquee__item">señal abierta</span><span class="marquee__sep">·</span>
            @endfor
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     2 · QUOTE PAUSA · block-ink · 60vh
     ═══════════════════════════════════════════════════════════════════ --}}
<section class="block-ink relative w-screen min-h-[60vh] flex items-center justify-center px-6 sm:px-10 lg:px-16 py-24 border-y border-ash overflow-hidden" aria-label="Pausa">
    <div class="scan-grid" aria-hidden="true"></div>

    <span class="absolute top-10 right-6 sm:right-10 lg:right-16 font-cjk text-bone-dim opacity-25 leading-none"
          style="font-size: clamp(6rem, 14vw, 14rem);" aria-hidden="true">壱</span>

    <div class="absolute top-10 left-6 sm:left-10 lg:left-16 flex items-center gap-x-6 gap-y-2 flex-wrap">
        <div class="status-corner"><span>▸ fragmento 001</span></div>
        <div class="hud-hash"><span class="hud-hash__key">hash:</span><span class="hud-hash__value">0x{{ strtoupper(substr(md5('fragment-001'), 0, 6)) }}</span></div>
    </div>

    <blockquote data-reveal class="font-serif italic text-center text-bone max-w-3xl relative z-10"
                style="font-size: clamp(1.5rem, 3vw, 2.5rem); line-height: 1.35;">
        <p>«El circuito te lee.<br>Te asigna un distrito.<br>Te devuelve una señal.»</p>
        <footer class="mt-8 font-mono not-italic uppercase tracking-[0.22em] text-[0.7rem] text-bone-dim">
            ▸ protocolo de ingreso · transcripción
        </footer>
    </blockquote>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     3 · KANJI MONUMENTAL · 狐 + scrambled words desencriptables
     ═══════════════════════════════════════════════════════════════════ --}}
<section class="block-ink relative w-screen min-h-[100dvh] overflow-hidden flex items-center justify-center" aria-label="Identidad del circuito">

    <div class="scan-grid" aria-hidden="true"></div>

    {{-- ambient row top · palabras scrambled-to-clear --}}
    <div class="absolute top-[18%] left-0 right-0 px-6 sm:px-10 lg:px-16 z-10">
        <div class="ambient-row" data-scramble-row>
            <span class="ambient-row__word" data-target="rostros">RXSTROS</span>
            <span class="ambient-row__word" data-target="del">DEL</span>
            <span class="ambient-row__word" data-target="turno">TVRNO</span>
            <span class="ambient-row__word" data-target="máscaras">MÁSCRAS</span>
            <span class="ambient-row__word" data-target="del">DEL</span>
            <span class="ambient-row__word" data-target="circuito">CRCUITO</span>
            <span class="ambient-row__word" data-target="donde">DONDR</span>
            <span class="ambient-row__word" data-target="pasado">PASDO</span>
        </div>
    </div>

    {{-- KANJI MONUMENTAL --}}
    <div class="relative" aria-hidden="true">
        <span class="kanji-monumental text-ember block">狐</span>
        {{-- circulo eclipse en el centro · efecto utopia --}}
        <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 block rounded-full"
              style="width: 38%; aspect-ratio: 1; background: var(--color-ink);"></span>
    </div>

    {{-- ambient row bottom --}}
    <div class="absolute bottom-[22%] left-0 right-0 px-6 sm:px-10 lg:px-16 z-10">
        <div class="ambient-row" data-scramble-row>
            <span class="ambient-row__word" data-target="y">Y</span>
            <span class="ambient-row__word" data-target="futuro">FVTRO</span>
            <span class="ambient-row__word" data-target="se">SE</span>
            <span class="ambient-row__word" data-target="cruzan">CRUZN</span>
            <span class="ambient-row__word" data-target="bajo">BAJP</span>
            <span class="ambient-row__word" data-target="señal">SEÑZL</span>
            <span class="ambient-row__word" data-target="abierta">ABIERT</span>
        </div>
    </div>

    {{-- crosshair tiny inferior --}}
    <span class="absolute bottom-[14%] left-1/2 -translate-x-1/2 crosshair" aria-hidden="true"></span>

    {{-- contador de sección --}}
    <div class="absolute top-10 right-6 sm:right-10 lg:right-16 font-mono uppercase tracking-[0.22em] text-[0.7rem] text-bone-dim">
        02 / 05 — circuito
    </div>

    {{-- marquee inferior --}}
    <div class="absolute bottom-0 left-0 right-0 marquee text-bone-dim" style="border-color: var(--color-ash);">
        <div class="marquee__track">
            @for($k = 0; $k < 3; $k++)
                <span class="marquee__item">faces of time</span><span class="marquee__sep">·</span>
                <span class="marquee__item">masks of utopia kitsune</span><span class="marquee__sep">·</span>
                <span class="marquee__item">where past and future collide</span><span class="marquee__sep">·</span>
                <span class="marquee__item">shadows of tomorrow</span><span class="marquee__sep">·</span>
            @endfor
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     4 · WALL OF IDENTITIES · grid asimétrico (Utopia ref-04)
     todas las 6 máscaras visibles + featured con brackets ember
     ═══════════════════════════════════════════════════════════════════ --}}
@php
    // collage asimétrico · cada índice mapea a una clase pos-N con grid-area distinta
    // pos-2 es la featured GIGANTE centro
    $wallPositions = [1, 2, 3, 4, 5, 6];
    $featuredIndex = 1; // (0-based) → pos-2 = KITSUNE-01 al medio gigante
@endphp

<section class="block-ink relative w-screen px-6 sm:px-10 lg:px-16 py-24 lg:py-36 border-t border-ash overflow-hidden" aria-labelledby="wall-heading">

    <div class="scan-grid" aria-hidden="true"></div>

    <div class="relative z-10 max-w-[1500px] mx-auto">

        {{-- header de la sección --}}
        <div class="flex flex-wrap items-end justify-between gap-y-6 mb-12 lg:mb-16">
            <div data-reveal>
                <div class="status-corner mb-4">
                    <span class="status-corner__dot" aria-hidden="true"></span>
                    <span>archivo · 06 identidades activas</span>
                </div>
                <h2 id="wall-heading" class="display-manifesto display-manifesto--lg text-bone">
                    selección<br>de <span class="text-ember">máscaras</span>.
                </h2>
                <p class="font-serif italic text-bone-dim mt-4 max-w-md" style="font-size: 1.1rem; line-height: 1.55;">
                    cada cuadro es un expediente. cada bracket rojo señala una identidad disponible para reservar esta noche.
                </p>
            </div>
            <div data-reveal class="flex items-center gap-x-6 gap-y-2 flex-wrap text-[0.7rem]">
                <div class="hud-hash"><span class="hud-hash__key">cluster:</span><span class="hud-hash__value">06/06</span></div>
                <div class="hud-hash"><span class="hud-hash__key">node:</span><span class="hud-hash__value">{{ $blockId }}</span></div>
                <span class="font-mono uppercase tracking-[0.22em] text-bone-dim">▸ click para abrir expediente</span>
            </div>
        </div>

        {{-- WALL collage asimétrico · cells de tamaños drásticamente distintos --}}
        <div class="wall-grid">
            @foreach($circuitProducts as $i => $product)
                @php
                    $pos = $wallPositions[$i] ?? 1;
                    $hex = $colorMap[$product->dominant_color] ?? '#737373';
                    $isFeatured = ($i === $featuredIndex);
                    $expediente = str_pad((int) preg_replace('/\D/', '', $product->code) ?: ($i + 1), 4, '0', STR_PAD_LEFT);
                    $productHash = '0x' . strtoupper(substr(md5($product->slug), 0, 6));
                @endphp
                <a href="{{ route('products.show', $product) }}"
                   class="wall-cell wall-cell--pos-{{ $pos }} {{ $isFeatured ? 'wall-cell--active' : '' }}"
                   aria-label="Abrir expediente de {{ $product->name }}">

                    @if($isFeatured)
                        <span class="wall-cell-bracket-bl" aria-hidden="true"></span>
                        <span class="wall-cell-bracket-br" aria-hidden="true"></span>
                        <span class="wall-cell__plus" aria-hidden="true">+</span>
                    @endif

                    <span class="wall-cell__glow" style="--cell-color: {{ $hex }};" aria-hidden="true"></span>
                    <span class="wall-cell__id" aria-hidden="true">{{ $product->code }}</span>
                    <span class="wall-cell__portrait">
                        <x-mask-portrait :product="$product" />
                    </span>
                    <span class="wall-cell__tag" aria-hidden="true">
                        <span class="wall-cell__tag-name">{{ explode(':', $product->name)[0] }}</span>
                        <span>{{ strtoupper(substr($product->statusLabel(), 0, 4)) }}</span>
                    </span>
                </a>
            @endforeach
        </div>

        {{-- pie de la wall · CTAs + meta global --}}
        <div data-reveal class="mt-16 lg:mt-20 flex flex-wrap items-center justify-between gap-y-6">
            <div class="flex flex-wrap items-center gap-x-5 gap-y-2">
                <a href="{{ route('products.index') }}" class="bracket-cta text-ember" data-glitch>
                    <span class="bracket-cta__caret">&gt;_</span><span>archivo completo</span>
                </a>
            </div>
            <div class="font-mono uppercase tracking-[0.22em] text-[0.7rem] text-bone-dim">
                ▸ los 6 expedientes están sincronizados con el turno noche
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     5 · FEATURED MASK HERO · protagónica única (Utopia ref-02)
     kanji enorme + nombre brutalista + retrato glitched
     ═══════════════════════════════════════════════════════════════════ --}}
@php
    $featuredMask = $circuitProducts[$featuredIndex] ?? $circuitProducts->first();
    $featuredHex = $colorMap[$featuredMask->dominant_color] ?? '#FF1A38';
    $featuredKanji = match($featuredMask->dominant_color) {
        'cyan' => '狐', 'red' => '鬼', 'violet' => '烏',
        'gold' => '猫', 'magenta' => '桜', 'blue' => '浪',
        default => '面',
    };
    $featuredHash = '0x' . strtoupper(substr(md5($featuredMask->slug), 0, 6));
    $featuredExpediente = str_pad((int) preg_replace('/\D/', '', $featuredMask->code) ?: 1, 4, '0', STR_PAD_LEFT);
@endphp
<section class="featured-hero block-ink" aria-labelledby="featured-heading">

    <div class="scan-grid" aria-hidden="true"></div>

    {{-- glow del color dominante centrado fuerte --}}
    <div class="absolute inset-0 z-0" aria-hidden="true"
         style="background: radial-gradient(circle at 50% 50%, {{ $featuredHex }}33 0%, transparent 55%); filter: blur(40px);"></div>

    {{-- top bar status --}}
    <div class="absolute top-0 left-0 right-0 px-6 sm:px-10 lg:px-16 pt-28 z-20">
        <div class="flex flex-wrap items-center justify-between gap-y-3 font-mono uppercase tracking-[0.22em] text-[0.72rem] text-bone-dim">
            <div class="flex items-center gap-5 flex-wrap">
                <span class="status-corner"><span class="status-corner__dot"></span><span>destacada · turno noche</span></span>
                <span class="hud-hash"><span class="hud-hash__key">id:</span><span class="hud-hash__value">{{ $featuredHash }}</span></span>
            </div>
            <span>03 / 05 — featured</span>
        </div>
    </div>

    {{-- KANJI gigante centrado · ember --}}
    <span class="featured-hero__kanji" aria-hidden="true">{{ $featuredKanji }}</span>

    {{-- contenido superpuesto: nombre brutalista + retrato + meta --}}
    <div class="relative z-10 grid grid-cols-12 gap-x-4 lg:gap-x-8 px-6 sm:px-10 lg:px-16 w-full">

        {{-- columna izquierda · nombre brutalista --}}
        <div class="col-span-12 lg:col-span-5 flex flex-col justify-center order-2 lg:order-1 mt-12 lg:mt-0">
            <h2 id="featured-heading" class="display-manifesto display-manifesto--xl text-bone" data-glitch-flash>
                {{ explode(':', $featuredMask->name)[0] }}
            </h2>
            <div class="display-manifesto display-manifesto--md text-ember mt-2">
                {{ trim(explode(':', $featuredMask->name)[1] ?? '') }}.
            </div>

            <p class="font-serif italic text-bone-dim mt-6 max-w-md" style="font-size: clamp(1.1rem, 1.4vw, 1.4rem); line-height: 1.55;">
                {{ $featuredMask->short_description }}
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-[0.7rem]">
                <span class="font-mono uppercase tracking-[0.22em] text-bone-dim">
                    <span class="text-ember">▸</span> {{ $featuredMask->code }} · {{ strtoupper($featuredMask->rarityLabel()) }} · {{ $featuredMask->formattedPrice() }}
                </span>
            </div>

            <div class="mt-10">
                <a href="{{ route('products.show', $featuredMask) }}" class="bracket-cta text-ember" data-glitch>
                    <span class="bracket-cta__caret">&gt;_</span><span>abrir expediente destacado</span>
                </a>
            </div>
        </div>

        {{-- columna derecha · retrato dominante centrado · efecto RGB-shift --}}
        <div class="col-span-12 lg:col-span-7 flex items-center justify-center order-1 lg:order-2 mt-32 lg:mt-0">
            <div class="featured-hero__portrait featured-hero__portrait--glitch frame-brackets" style="--bracket-offset: 16px; --bracket-size: 26px; --bracket-color: var(--color-bone);">
                <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
                <span class="frame-corner frame-corner--br" aria-hidden="true"></span>
                <x-mask-portrait :product="$featuredMask" />
            </div>
        </div>
    </div>

    {{-- stats line abajo · 4 stats horizontales --}}
    <div class="absolute bottom-16 left-6 sm:left-10 lg:left-16 right-6 sm:right-10 lg:right-16 z-10">
        <div class="grid grid-cols-4 gap-3 lg:gap-8 max-w-4xl">
            @foreach([
                ['señal', $featuredMask->signal_level],
                ['agilidad', $featuredMask->agility],
                ['espíritu', $featuredMask->spirit],
                ['ferocidad', $featuredMask->ferocity],
            ] as [$label, $value])
                <div class="stat-block">
                    <div class="stat-block__label">{{ $label }}</div>
                    <div class="stat-block__value">{{ str_pad($value, 2, '0', STR_PAD_LEFT) }}<span class="stat-block__suffix">/99</span></div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- marquee inferior --}}
    <div class="absolute bottom-0 left-0 right-0 marquee text-bone-dim" style="border-color: var(--color-ash);">
        <div class="marquee__track">
            @for($k = 0; $k < 3; $k++)
                <span class="marquee__item">expediente destacado · {{ strtoupper($featuredMask->code) }}</span><span class="marquee__sep">·</span>
                <span class="marquee__item">distrito · {{ strtoupper($featuredMask->district ?? 'sin asignar') }}</span><span class="marquee__sep">·</span>
                <span class="marquee__item">{{ strtoupper($featuredMask->rarityLabel()) }}</span><span class="marquee__sep">·</span>
                <span class="marquee__item">señal {{ $featuredMask->signal_level }}/99</span><span class="marquee__sep">·</span>
            @endfor
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     5 · TRANSMISIONES · feed editorial (Bebas heading)
     ═══════════════════════════════════════════════════════════════════ --}}
<section class="block-ink relative w-screen px-6 sm:px-10 lg:px-16 py-24 lg:py-40 border-t border-ash overflow-hidden" aria-labelledby="feed-heading">
    <div class="scan-grid opacity-50" aria-hidden="true"></div>
    <div class="max-w-3xl mx-auto relative z-10">
        <div data-reveal class="mb-16 lg:mb-24">
            <div class="status-corner mb-6">
                <span class="status-corner__dot" aria-hidden="true"></span>
                <span>feed activo</span>
                <span class="status-corner__sep" aria-hidden="true"></span>
                <span>03 señales destacadas</span>
            </div>
            <h2 id="feed-heading" class="display-manifesto display-manifesto--lg text-bone">
                transmitiendo<br><span class="text-ember">ahora.</span>
            </h2>
        </div>

        @php $kanjiNumbers = ['壱', '弐', '参', '肆', '伍']; @endphp

        <ul class="space-y-12 lg:space-y-16">
            @foreach($featuredPosts as $i => $post)
                @php
                    $postHash = '0x' . strtoupper(substr(md5($post->slug), 0, 6));
                    $postBlock = 'TX-' . str_pad(($i + 1) * 47, 3, '0', STR_PAD_LEFT);
                    $postSignal = 4 + (($i * 3) % 6);
                    $postEmpty = 10 - $postSignal;
                @endphp
                <li data-reveal style="--reveal-delay: {{ $i * 90 }}ms;">
                    <a href="{{ route('posts.show', $post) }}" class="block group">
                        <div class="flex items-baseline gap-6 mb-4">
                            <span class="font-cjk italic text-ember leading-none" style="font-size: clamp(2rem, 3vw, 3rem);" aria-hidden="true">
                                {{ $kanjiNumbers[$i] ?? ($i + 1) }}
                            </span>
                            <span class="font-mono uppercase tracking-[0.22em] text-[0.7rem] text-bone-dim">
                                ▸ {{ strtoupper($post->category) }} · {{ $post->readingTimeLabel() }}
                            </span>
                        </div>
                        <h3 class="font-serif text-bone group-hover:text-ember transition-colors"
                            style="font-size: clamp(1.5rem, 2.5vw, 2.25rem); line-height: 1.2; font-weight: 500;">
                            {{ $post->title }}
                        </h3>
                        <p class="font-serif italic text-bone-dim mt-3" style="font-size: 1.125rem; line-height: 1.55;">
                            {{ $post->excerpt }}
                        </p>
                        <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-[0.7rem]">
                            <div class="font-mono uppercase tracking-[0.22em] text-bone-dim">
                                {{ $post->author }} · {{ $post->formattedDate() }}
                            </div>
                            <div class="hud-hash"><span class="hud-hash__key">hash:</span><span class="hud-hash__value">{{ $postHash }}</span></div>
                            <div class="hud-hash"><span class="hud-hash__key">block:</span><span class="hud-hash__value">{{ $postBlock }}</span></div>
                            <div class="signal-meter">
                                <span aria-hidden="true"><span class="signal-meter__bars">{{ str_repeat('▓', $postSignal) }}</span><span class="signal-meter__bars-empty">{{ str_repeat('░', $postEmpty) }}</span></span>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div data-reveal class="mt-20 lg:mt-28">
            <a href="{{ route('posts.index') }}" class="bracket-cta text-ember" data-glitch>
                <span class="bracket-cta__caret">&gt;_</span><span>archivo completo</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════
     6 · CLOSING · color block ember invertido
     ═══════════════════════════════════════════════════════════════════ --}}
<section class="block-ember relative w-screen min-h-[90vh] flex items-center justify-center px-6 sm:px-10 lg:px-16 py-32 overflow-hidden" aria-label="Cierre">

    {{-- ambient letters · cierre --}}
    <div class="absolute inset-0 pointer-events-none select-none" aria-hidden="true">
        <div class="absolute top-[18%] left-[5%] font-mono text-[0.75rem] tracking-[0.32em] text-ink/45">[end]</div>
        <div class="absolute bottom-[18%] right-[5%] font-mono text-[0.75rem] tracking-[0.32em] text-ink/45">[end]</div>
    </div>

    <div class="text-center max-w-5xl relative z-10">
        <span class="block font-cjk text-ink/70 mb-12" style="font-size: clamp(2rem, 4vw, 3.5rem); line-height: 1;" aria-hidden="true">終</span>

        <h2 data-reveal data-glitch-flash class="display-manifesto display-manifesto--xl text-ink">
            <span class="block">elegí una.</span>
            <span class="block">antes de que</span>
            <span class="block">la señal cambie.</span>
        </h2>

        <div data-reveal class="mt-12 flex items-center justify-center gap-6" style="--reveal-delay: 200ms;">
            <span class="display-manifesto display-manifesto--md text-ink">marcá.</span>
            <span class="display-manifesto display-manifesto--md text-ink">elegí.</span>
            <span class="display-manifesto display-manifesto--md text-ink">volvé.</span>
        </div>

        <div data-reveal class="mt-14 flex flex-wrap items-center justify-center gap-x-4 gap-y-4" style="--reveal-delay: 320ms;">
            <a href="{{ route('products.index') }}" class="bracket-cta text-ink" data-glitch>
                <span class="bracket-cta__caret">&gt;_</span><span>abrir el archivo</span>
            </a>
            <a href="{{ route('posts.index') }}" class="bracket-cta text-ink" data-glitch>
                <span>leer transmisiones</span>
            </a>
        </div>
    </div>

    {{-- marquee inferior recursivo · ember inverted --}}
    <div class="absolute bottom-0 left-0 right-0 marquee text-ink" style="border-color: var(--color-ink);">
        <div class="marquee__track">
            @for($k = 0; $k < 3; $k++)
                <span class="marquee__item">turno noche · identidad asignada</span><span class="marquee__sep">·</span>
                <span class="marquee__item">señal abierta</span><span class="marquee__sep">·</span>
                <span class="marquee__item">circuito kitsune activo</span><span class="marquee__sep">·</span>
                <span class="marquee__item">35.6762°n · 139.6503°e</span><span class="marquee__sep">·</span>
            @endfor
        </div>
    </div>
</section>

@endsection

{{-- ═══════════════════════════════════════════════════════════════════
     SCRIPTS · scramble-to-clear de las ambient rows en viewport
     ═══════════════════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
(function() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        // mostrar palabras claras directo
        document.querySelectorAll('[data-scramble-row] [data-target]').forEach(el => {
            el.textContent = el.dataset.target.toUpperCase();
        });
        return;
    }
    if (!('IntersectionObserver' in window)) return;

    const chars = '!<>?#%&+=*0123456789';

    const scrambleWord = (el, duration = 700) => {
        const target = (el.dataset.target || el.textContent).toUpperCase();
        const start = performance.now();
        const len = target.length;
        const tick = (now) => {
            const t = Math.min(1, (now - start) / duration);
            const stable = Math.floor(t * len);
            let out = target.substring(0, stable);
            for (let i = stable; i < len; i++) {
                const c = target[i];
                out += (c === ' ' || c === '·') ? c : chars[Math.floor(Math.random() * chars.length)];
            }
            el.textContent = out;
            if (t < 1) {
                el.classList.add('is-glitched');
                requestAnimationFrame(tick);
            } else {
                el.textContent = target;
                el.classList.remove('is-glitched');
            }
        };
        requestAnimationFrame(tick);
    };

    const obs = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const words = entry.target.querySelectorAll('[data-target]');
                words.forEach((w, i) => {
                    setTimeout(() => scrambleWord(w, 720), i * 80);
                });
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('[data-scramble-row]').forEach(el => obs.observe(el));
})();
</script>
@endpush
