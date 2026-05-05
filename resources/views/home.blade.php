@extends('layouts.app')

@section('title', '鬼 · Circuito Kitsune')
@section('description', 'Circuito Kitsune. Identidades nocturnas. Máscaras del mercado nocturno japonés. Cada máscara abre una puerta distinta.')

@section('content')
    {{-- ════════════════════════════════════════════════════════════════════
         RAIL · capítulos del ritual (lateral fija, desktop only)
    ════════════════════════════════════════════════════════════════════ --}}
    <aside class="chapter-rail" aria-label="Acto del ritual" data-chapter-rail>
        @foreach ([
            ['key' => 'preludio',    'kanji' => '序'],
            ['key' => 'manifiesto',  'kanji' => '壱'],
            ['key' => 'archivo',     'kanji' => '弐'],
            ['key' => 'transmision', 'kanji' => '参'],
            ['key' => 'cierre',      'kanji' => '終'],
        ] as $i => $ch)
            <span class="chapter-rail__item" data-chapter-key="{{ $ch['key'] }}" aria-hidden="true">
                <span>{{ $ch['kanji'] }}</span>
                <span class="tick"></span>
            </span>
        @endforeach
    </aside>

    {{-- ════════════════════════════════════════════════════════════════════
         序 · HERO · título fragmentado en grid + word reveal + JP mix
    ════════════════════════════════════════════════════════════════════ --}}
    <section
        data-chapter="preludio"
        class="vignette light-leak-double scanlines paper-grain grain-strong relative min-h-screen w-screen overflow-hidden bg-ink-deep text-bone"
        aria-labelledby="hero-titulo"
    >
        {{-- Kanji 鬼 con parallax real --}}
        <span class="kanji-mark parallax-up absolute -right-[8vw] top-[2vh] font-jp leading-[0.8]" style="font-size: clamp(20rem, 60vw, 60rem); color: var(--color-vermillion); opacity: 0.16; text-shadow: 0 0 80px rgba(230, 57, 70, 0.30);" aria-hidden="true">鬼</span>

        {{-- Vertical meta izquierda --}}
        <div class="absolute left-6 top-1/2 hidden -translate-y-1/2 sm:block lg:left-20 z-10">
            <p class="vertical-text font-jp text-[11px] uppercase tracking-[0.4em] text-bone/55">
                circuito kitsune · 35.6762°N · 139.6503°E · turno noche
            </p>
        </div>

        {{-- Hash decorativo --}}
        <div class="absolute right-6 top-28 hidden text-right sm:right-10 sm:top-32 lg:block z-10">
            <p class="hash-code text-bone/55">{{ strtoupper(substr(md5('hero'), 0, 16)) }}</p>
            <p class="hash-code text-bone/35 mt-1">{{ strtoupper(substr(md5(date('Y-m-d-H')), 0, 14)) }}</p>
        </div>

        {{-- TÍTULO FRAGMENTADO en 12-col grid --}}
        <div class="relative grid min-h-screen w-full grid-cols-12 grid-rows-[auto_1fr_auto] px-6 py-32 sm:px-16 lg:px-24">
            {{-- meta arriba --}}
            <div class="col-span-12 row-start-1 flex items-center gap-4">
                <span class="font-mono text-[11px] uppercase tracking-[0.4em] text-vermillion glow-vermillion">序 · preludio</span>
                <span class="h-px flex-1 max-w-[160px] bg-bone/25"></span>
                <span class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55">acceso · autorizado</span>
            </div>

            {{-- TÍTULO en piezas, grid asimétrico --}}
            <h1 id="hero-titulo" class="col-span-12 row-start-2 self-center">
                <span class="sr-only">Las identidades solo existen de noche.</span>
                <span class="grid grid-cols-12 gap-y-2" aria-hidden="true">
                    <span class="col-span-12 sm:col-span-9 headline text-[clamp(3rem,11vw,11rem)] text-bone leading-[0.9]" data-words>las identidades</span>
                    <span class="col-span-12 sm:col-span-3 sm:col-start-10 headline text-[clamp(2rem,5vw,4.5rem)] italic text-bone/65 leading-[1] self-end" data-words>existen,</span>
                    <span class="col-span-12 sm:col-span-7 sm:col-start-2 headline text-[clamp(3rem,11vw,11rem)] text-vermillion glow-vermillion leading-[0.9]" data-words>solo de</span>
                    <span class="col-span-6 sm:col-span-2 headline-jp text-[clamp(3rem,11vw,11rem)] text-bone leading-[0.9] flex items-end">夜</span>
                    <span class="col-span-6 sm:col-span-3 headline text-[clamp(3rem,11vw,11rem)] text-bone leading-[0.9] outline-text-thick">noche.</span>
                </span>
            </h1>

            {{-- info abajo --}}
            <div class="col-span-12 row-start-3 mt-12 grid gap-8 lg:grid-cols-12 lg:gap-12">
                <p class="font-display text-xl italic leading-relaxed text-bone/85 lg:col-span-6 lg:text-2xl">
                    Una tienda clandestina de máscaras.
                    Cada una abre un distrito distinto del mercado nocturno.
                </p>

                <div class="lg:col-span-4 lg:col-start-9 space-y-2">
                    <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-2">
                        <span class="neon-dot"></span> archivo · {{ str_pad((string) $circuitProducts->count(), 2, '0', STR_PAD_LEFT) }} identidades
                    </p>
                    <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-2">
                        <span class="neon-dot neon-dot--gold"></span> señales · {{ str_pad((string) ($featuredPosts->count() ?: 0), 2, '0', STR_PAD_LEFT) }} transmisiones
                    </p>
                    <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-vermillion flex items-center gap-2">
                        <span class="neon-dot neon-dot--vermillion"></span> circuito · activo<span class="blink ml-1">_</span>
                    </p>
                </div>

                <div class="lg:col-span-12 mt-8 flex flex-wrap items-center gap-8 sm:gap-12">
                    <x-ink-button href="#manifiesto" class="text-bone glow-cyan">
                        Entrar al ritual
                    </x-ink-button>
                    <x-ink-button :href="route('products.index')" :arrow="false" class="text-bone/65 text-base">
                        o saltar al archivo
                    </x-ink-button>
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-12 right-6 hidden flex-col items-center gap-3 sm:flex sm:right-10 z-10" aria-hidden="true">
            <span class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55">下へ</span>
            <span class="block h-12 w-px bg-gradient-to-b from-neon-cyan/70 to-transparent"></span>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         一 · MANIFIESTO · número leading + strikethrough
    ════════════════════════════════════════════════════════════════════ --}}
    <section
        id="manifiesto"
        data-chapter="manifiesto"
        class="paper-grain grain-strong vignette light-leak-cyan relative w-screen overflow-hidden bg-sumi text-bone"
        aria-labelledby="manifiesto-titulo"
    >
        {{-- Numero gigante decorativo de fondo, parallax --}}
        <span class="parallax-down pointer-events-none absolute -left-[2vw] top-[8vh] font-display italic font-medium leading-[0.8] text-vermillion/12" style="font-size: clamp(18rem, 35vw, 32rem);" aria-hidden="true">01</span>

        <div class="relative grid w-full grid-cols-12 gap-y-12 px-6 py-32 sm:px-16 sm:py-40 lg:px-24">
            <div class="col-span-12 lg:col-span-5 lg:col-start-1">
                <p class="reveal font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-3">
                    <span class="block h-1 w-6 bg-vermillion"></span>
                    壱 · uno · manifiesto
                </p>

                <h2 id="manifiesto-titulo" class="reveal mt-12 font-display font-medium leading-[0.92] tracking-[-0.025em] text-bone">
                    <span class="block text-[clamp(2.25rem,5vw,4.5rem)]">No es un</span>
                    <span class="block text-[clamp(3.5rem,8vw,7rem)]"><span class="strike-through">mercado</span>.</span>
                    <span class="block mt-4 text-[clamp(2.25rem,5vw,4.5rem)] italic text-bone/65">Es un</span>
                    <span class="block uppercase tracking-[0.04em] text-[clamp(3rem,7.5vw,7rem)] text-neon-cyan glow-cyan">ritual</span>
                    <span class="block text-[clamp(2.25rem,5vw,4.5rem)] italic text-bone/65">de acceso.</span>
                </h2>
            </div>

            <div class="col-span-12 lg:col-span-6 lg:col-start-7 lg:self-end">
                <div class="reveal drop-cap max-w-2xl space-y-5 font-display text-lg leading-[1.7] text-bone/85 lg:text-xl" style="--drop-cap-color: var(--color-neon-cyan);">
                    <p>
                        Cada máscara es una identidad. No un disfraz. Define cómo te
                        movés, qué corredores abrís, a qué hora podés cruzar. Cuando
                        elegís una, el circuito te lee, te asigna un distrito y te
                        devuelve una señal.
                    </p>
                    <p>
                        Algunas son comunes y atraviesan la ciudad sin fricción.
                        Otras son raras, prohibidas, sombra. Otras solo aparecen
                        cuando los lectores están vacíos. El catálogo no ordena por
                        precio: ordena por <em>cómo se comporta el circuito</em> con
                        vos puesta.
                    </p>
                </div>

                <div class="reveal ink-divider mt-12 text-bone" aria-hidden="true"></div>
                <p class="reveal mt-8 max-w-md font-mono text-[11px] uppercase leading-[1.7] tracking-[0.22em] text-bone/55">
                    <span class="text-vermillion">▸</span> archivo del operador · catalogado por familia, distrito,
                    rareza, señal y disponibilidad.
                </p>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         BREAK · 面 aislado, full-vh, respiración narrativa
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="break-section paper-grain grain-strong relative bg-ink-deep text-bone" aria-hidden="false" aria-label="Pausa narrativa: máscara">
        <span class="break-section__kanji parallax-slow text-bone outline-text">面</span>
        <p class="absolute bottom-[12vh] left-1/2 -translate-x-1/2 px-6 text-center font-display text-lg italic text-bone/70 sm:text-xl">
            <span class="text-vermillion">—</span> elegí una y el sistema te asigna un distrito.
        </p>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         MARQUEE 1
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="relative w-screen overflow-hidden border-y border-bone/10 bg-ink-deep py-6 sm:py-8" aria-hidden="true">
        <div class="marquee">
            <div class="marquee-track items-center gap-12 sm:gap-16">
                @for ($i = 0; $i < 2; $i++)
                    @foreach (['面 · MÁSCARAS', '識 · IDENTIDADES', '区 · DISTRITOS', '夜 · NOCHE', '鬼 · CIRCUITO'] as $word)
                        <span class="font-display text-4xl italic text-bone sm:text-6xl lg:text-7xl">{{ $word }}</span>
                        <span class="font-jp text-3xl text-vermillion glow-vermillion sm:text-5xl lg:text-6xl flicker">·</span>
                    @endforeach
                @endfor
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════════
         二 · ARCHIVO HORIZONTAL · número display + horizontal track
    ════════════════════════════════════════════════════════════════════ --}}
    <section
        id="archivo"
        data-chapter="archivo"
        class="relative w-screen overflow-hidden bg-sumi text-bone"
        aria-labelledby="archivo-titulo"
        x-data="{ index: 0, total: {{ $circuitProducts->count() }} }"
    >
        <div class="grid w-full grid-cols-12 gap-y-8 px-6 pt-24 sm:px-16 sm:pt-32 lg:px-24">
            <div class="col-span-12 lg:col-span-2">
                <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-3">
                    <span class="block h-1 w-6 bg-vermillion"></span>
                    弐 · dos
                </p>
                <span class="float-num mt-6 block text-vermillion glow-vermillion leading-none">06</span>
                <p class="mt-2 font-display text-base italic text-bone/65">en rotación.</p>
            </div>

            <div class="col-span-12 lg:col-span-9 lg:col-start-4 lg:self-end">
                <h2 id="archivo-titulo" class="font-display font-medium leading-[0.95] tracking-[-0.02em]">
                    <span class="block text-[clamp(2.25rem,4.5vw,4rem)] italic text-bone/65">archivo · identidades</span>
                    <span class="block text-[clamp(3rem,7vw,6rem)] text-bone uppercase tracking-[-0.01em]">máscaras</span>
                    <span class="block text-[clamp(2rem,3.5vw,3rem)] italic text-bone/55">— activas esta semana.</span>
                </h2>

                <p class="mt-8 max-w-md font-mono text-[10px] uppercase tracking-[0.28em] text-bone/55">
                    <span class="text-neon-cyan">▸</span> desplazá horizontalmente · cada identidad ocupa una pantalla.
                    <span class="ml-3">posición · </span><span x-text="String(index + 1).padStart(2, '0')" class="text-neon-cyan glow-cyan">01</span><span class="text-bone/45"> / {{ str_pad((string) $circuitProducts->count(), 2, '0', STR_PAD_LEFT) }}</span>
                </p>
            </div>
        </div>

        {{-- TRACK horizontal --}}
        <div
            class="snap-x-mandatory snap-x-start scrollbar-hide mt-16 flex w-screen overflow-x-auto sm:mt-20"
            x-ref="track"
            @scroll.passive="index = Math.round($refs.track.scrollLeft / window.innerWidth)"
        >
            @foreach ($circuitProducts as $idx => $product)
                @php
                    $colorHex = str_replace(['background-color: ', ';'], '', $product->dominantColorStyle());
                    $familyKanji = match (true) {
                        str_starts_with($product->code, 'KSN') => '狐',
                        str_starts_with($product->code, 'ONI') => '鬼',
                        str_starts_with($product->code, 'KRS') => '烏',
                        str_starts_with($product->code, 'NKO') => '猫',
                        str_starts_with($product->code, 'SKR') => '桜',
                        str_starts_with($product->code, 'RNX') => '浪',
                        default => '面',
                    };
                @endphp
                <article
                    class="vignette scanlines paper-grain relative flex h-[85vh] w-screen shrink-0 items-center overflow-hidden"
                    style="background-color: {{ $colorHex }};"
                >
                    <span
                        class="kanji-mark absolute font-jp font-extrabold leading-[0.78]"
                        style="font-size: clamp(28rem, 80vh, 64rem); color: var(--color-ink-deep); opacity: 0.16; right: -8vw; top: -4vh;"
                        aria-hidden="true"
                    >{{ $familyKanji }}</span>

                    <span class="absolute left-6 top-6 font-mono text-[11px] uppercase tracking-[0.32em] sm:left-16 sm:top-10 z-10" style="color: var(--color-ink-deep); opacity: 0.7;">
                        no.{{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }} <span class="opacity-50">/ {{ str_pad((string) $circuitProducts->count(), 2, '0', STR_PAD_LEFT) }}</span>
                    </span>

                    <span class="absolute right-6 top-6 font-mono text-[11px] uppercase tracking-[0.32em] sm:right-16 sm:top-10 z-10 flex items-center gap-2" style="color: var(--color-ink-deep); opacity: 0.7;">
                        {{ $product->code }}
                        <span class="opacity-60">·</span>
                        {{ strtoupper(substr(md5($product->slug), 0, 6)) }}
                    </span>

                    <div class="relative z-10 grid w-full grid-cols-12 items-center gap-y-8 px-6 sm:px-16 lg:px-24">
                        <div class="col-span-12 lg:col-span-7" style="color: var(--color-ink-deep);">
                            <p class="font-mono text-[10px] uppercase tracking-[0.32em]" style="opacity: 0.7;">
                                {{ $product->category }}
                            </p>
                            <h3 class="headline mt-4 text-[clamp(2.5rem,7vw,7rem)]" style="color: var(--color-ink-deep);">
                                {{ $product->name }}
                            </h3>

                            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 font-mono text-[11px] uppercase tracking-[0.28em]" style="opacity: 0.78;">
                                <span>{{ $product->district }}</span>
                                <span>·</span>
                                <span>{{ $product->rarityLabel() }}</span>
                                <span>·</span>
                                <span>{{ $product->statusLabel() }}</span>
                            </div>

                            <p class="mt-6 max-w-xl font-display text-lg italic leading-relaxed sm:text-xl" style="color: var(--color-ink-deep); opacity: 0.88;">
                                {{ $product->short_description }}
                            </p>

                            <dl class="mt-8 grid grid-cols-4 gap-3 sm:gap-6">
                                @foreach ([
                                    'señal' => $product->signal_level,
                                    'agilidad' => $product->agility,
                                    'espíritu' => $product->spirit,
                                    'ferocidad' => $product->ferocity,
                                ] as $label => $value)
                                    <div>
                                        <dt class="font-mono text-[9px] uppercase tracking-[0.24em]" style="opacity: 0.55;">{{ $label }}</dt>
                                        <dd class="mt-1.5 font-display text-3xl font-medium sm:text-4xl" style="color: var(--color-ink-deep);">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>

                            <div class="mt-10 flex flex-wrap items-center gap-6 sm:gap-10">
                                <x-ink-button :href="route('products.show', $product)" style="color: var(--color-ink-deep);">
                                    Ver expediente
                                </x-ink-button>
                                <span class="font-display text-2xl font-medium" style="color: var(--color-ink-deep);">
                                    {{ $product->formattedPrice() }}
                                </span>
                            </div>
                        </div>

                        <div class="col-span-12 lg:col-span-4 lg:col-start-9">
                            <a
                                href="{{ route('products.show', $product) }}"
                                class="portrait-frame relative block aspect-[3/4] w-full overflow-hidden"
                                style="color: var(--color-ink-deep);"
                                aria-label="Ver expediente de {{ $product->name }}"
                            >
                                <x-mask-placeholder :product="$product" mode="editorial" />
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Controles paginación --}}
        <div class="grid w-full grid-cols-12 items-center px-6 py-10 sm:px-16 lg:px-24">
            <div class="col-span-12 flex items-center justify-between gap-6 sm:col-span-8 sm:col-start-3">
                <button
                    type="button"
                    @click="$refs.track.scrollBy({ left: -window.innerWidth, behavior: 'smooth' })"
                    :disabled="index === 0"
                    class="font-display text-base italic text-bone/70 transition-colors hover:text-bone disabled:opacity-30"
                    aria-label="Identidad anterior"
                >← anterior</button>

                <div class="flex items-center gap-2.5" role="group" aria-label="Paginación">
                    @foreach ($circuitProducts as $idx => $product)
                        <button
                            type="button"
                            @click="$refs.track.scrollTo({ left: window.innerWidth * {{ $idx }}, behavior: 'smooth' })"
                            :class="index === {{ $idx }} ? 'h-2 w-8 bg-vermillion' : 'h-2 w-2 bg-bone/35 hover:bg-bone/65'"
                            class="rounded-full transition-all duration-300"
                            aria-label="Ir a identidad {{ $idx + 1 }}"
                        ></button>
                    @endforeach
                </div>

                <button
                    type="button"
                    @click="$refs.track.scrollBy({ left: window.innerWidth, behavior: 'smooth' })"
                    :disabled="index === total - 1"
                    class="font-display text-base italic text-bone/70 transition-colors hover:text-bone disabled:opacity-30"
                    aria-label="Identidad siguiente"
                >siguiente →</button>
            </div>
        </div>

        <div class="grid w-full grid-cols-12 px-6 pb-24 sm:px-16 lg:px-24">
            <div class="col-span-12 lg:col-span-6 lg:col-start-1">
                <x-ink-button :href="route('products.index')">Abrir archivo completo</x-ink-button>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         BREAK · 声 aislado, respiración 2
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="break-section paper-grain grain-strong relative bg-ink-deep text-bone" aria-label="Pausa narrativa: voz">
        <span class="break-section__kanji parallax-slow text-neon-magenta outline-text" style="opacity: 0.85;">声</span>
        <p class="absolute bottom-[12vh] left-1/2 -translate-x-1/2 px-6 text-center font-display text-lg italic text-bone/70 sm:text-xl">
            <span class="text-neon-magenta">—</span> el archivo intercepta señales sueltas.
        </p>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         MARQUEE 2
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="relative w-screen overflow-hidden border-y border-bone/10 bg-ink-deep py-3" aria-hidden="true">
        <div class="marquee" style="--marquee-duration: 24s;">
            <div class="marquee-track items-center gap-8">
                @for ($i = 0; $i < 3; $i++)
                    @foreach (['機密 · CLASIFICADO', '夜 · ACTIVO', '信 · SEÑAL VERIFICADA', '面 · IDENTIDAD ANCLADA', '声 · CANAL ABIERTO'] as $word)
                        <span class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/65">{{ $word }}</span>
                        <span class="font-jp text-xs text-vermillion">●</span>
                    @endforeach
                @endfor
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════════
         三 · TRANSMISIONES · outline text + magazine asimétrico
    ════════════════════════════════════════════════════════════════════ --}}
    <section
        data-chapter="transmision"
        class="paper-grain grain-strong vignette light-leak-magenta relative w-screen overflow-hidden bg-sumi text-bone"
        aria-labelledby="transmisiones-titulo"
    >
        @php $japNumbers = ['壱', '弐', '参', '肆', '伍', '陸']; @endphp

        <div class="grid w-full grid-cols-12 gap-y-12 px-6 py-32 sm:px-16 sm:py-40 lg:px-24">
            <div class="col-span-12 lg:col-span-7">
                <p class="reveal font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-3">
                    <span class="block h-1 w-6 bg-neon-magenta"></span>
                    参 · tres · señales
                </p>

                <h2 id="transmisiones-titulo" class="reveal mt-8 font-display font-medium leading-[0.92] tracking-[-0.02em] text-bone">
                    <span class="block text-[clamp(2.5rem,5.5vw,5rem)] italic">notas que</span>
                    <span class="block text-[clamp(3.5rem,9vw,8rem)] outline-text-thick text-bone uppercase tracking-[-0.01em]">cruzaron</span>
                    <span class="block text-[clamp(2.5rem,5.5vw,5rem)] italic text-bone/65">— el archivo.</span>
                </h2>
            </div>

            <div class="col-span-12 lg:col-span-3 lg:col-start-10 lg:self-end">
                <p class="font-mono text-[11px] uppercase leading-relaxed tracking-[0.22em] text-bone/65">
                    <span class="text-neon-magenta">▸</span> reportes del operador, protocolos del mercado, distritos en alerta.
                </p>
                <p class="hash-code mt-4 text-bone/45">{{ strtoupper(substr(md5('feed'), 0, 16)) }}</p>
            </div>

            @if ($featuredPosts->isNotEmpty())
                <div class="col-span-12 mt-8 grid grid-cols-12 gap-y-16 lg:gap-x-12">
                    @foreach ($featuredPosts as $idx => $post)
                        @php
                            $isFeatured = $idx === 0;
                            $colSpan = $isFeatured ? 'col-span-12 lg:col-span-7' : 'col-span-12 sm:col-span-6 lg:col-span-5';
                            $colStart = match ($idx) {
                                0 => '',
                                1 => 'lg:col-start-8',
                                2 => 'lg:col-span-4 lg:col-start-2',
                                default => '',
                            };
                            $tone = match ($post->cover_tone ?? 'neutral') {
                                'cyan', 'green' => 'text-neon-cyan',
                                'magenta', 'red' => 'text-vermillion',
                                'gold' => 'text-gold',
                                'violet' => 'text-neon-magenta',
                                default => 'text-vermillion',
                            };
                            $glow = match ($post->cover_tone ?? 'neutral') {
                                'cyan', 'green' => 'glow-cyan',
                                'magenta', 'red' => 'glow-vermillion',
                                'violet' => 'glow-magenta',
                                default => 'glow-vermillion',
                            };
                        @endphp
                        <article class="reveal {{ $colSpan }} {{ $colStart }}">
                            <a href="{{ route('posts.show', $post) }}" class="group block">
                                <div class="flex items-baseline gap-4 flex-wrap">
                                    <span class="font-jp text-2xl font-bold {{ $tone }} {{ $glow }}">{{ $japNumbers[$idx] ?? '○' }}</span>
                                    <span class="font-mono text-[10px] uppercase tracking-[0.3em] {{ $tone }}">{{ strtoupper($post->category) }}</span>
                                    <span class="hash-code text-bone/35 ml-auto">señal · {{ str_pad((string) $post->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </div>

                                <h3 class="glitch-hover mt-4 font-display font-medium leading-[0.95] tracking-[-0.02em] text-bone group-hover:text-vermillion transition-colors {{ $isFeatured ? 'text-[clamp(2.5rem,5vw,4.5rem)]' : 'text-[clamp(1.75rem,3vw,2.75rem)]' }}">
                                    {{ $post->title }}
                                </h3>

                                <p class="mt-5 max-w-prose font-display italic leading-relaxed text-bone/75 {{ $isFeatured ? 'text-xl' : 'text-base' }}">
                                    {{ $post->excerpt }}
                                </p>

                                <p class="mt-6 font-mono text-[10px] uppercase tracking-[0.24em] text-bone/55">
                                    @if ($post->published_at)
                                        <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('Y · m · d') }}</time>
                                        <span class="mx-2">·</span>
                                    @endif
                                    {{ $post->author }}
                                    <span class="mx-2">·</span>
                                    {{ $post->readingTimeLabel() }}
                                </p>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="col-span-12 mt-12 lg:col-span-4 lg:col-start-1">
                <x-ink-button :href="route('posts.index')" class="text-bone">
                    Archivo completo de transmisiones
                </x-ink-button>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         終 · CIERRE INTEGRADO + FOOTER · vermillion + minimal
    ════════════════════════════════════════════════════════════════════ --}}
    <section
        data-chapter="cierre"
        class="vignette scanlines paper-grain grain-strong relative w-screen overflow-hidden bg-vermillion text-bone"
        aria-labelledby="cierre-titulo"
    >
        {{-- Kanji 選 (elegir) gigantesco a la izquierda, ocupando casi todo --}}
        <span class="kanji-mark parallax-slow absolute -left-[5vw] top-1/2 -translate-y-1/2 font-jp font-extrabold leading-[0.85]" style="font-size: clamp(24rem, 70vw, 70rem); color: var(--color-ink-deep); opacity: 0.18;" aria-hidden="true">選</span>

        <div class="relative z-10 grid w-full grid-cols-12 gap-y-12 px-6 py-32 sm:px-16 sm:py-40 lg:px-24">
            <div class="col-span-12 lg:col-span-3">
                <p class="font-mono text-[10px] uppercase tracking-[0.4em] text-bone/85 flex items-center gap-3">
                    <span class="block h-1.5 w-1.5 rounded-full bg-bone"></span>
                    終 · cierre
                </p>
            </div>

            {{-- Cierre minimalista: el kanji 選 de fondo es el protagonista --}}
            <div class="col-span-12 lg:col-span-7 lg:col-start-6">
                <h2 id="cierre-titulo" class="font-display font-medium leading-[0.92] tracking-[-0.025em] text-bone">
                    <span class="block text-[clamp(3rem,7vw,7rem)]">elegí.</span>
                    <span class="block text-[clamp(2rem,4vw,3.5rem)] italic text-bone/85">— antes de que la señal cambie.</span>
                </h2>

                <div class="mt-12 flex flex-wrap items-center gap-x-10 gap-y-6">
                    <x-ink-button :href="route('products.index')" class="text-bone">
                        Abrir archivo de máscaras
                    </x-ink-button>
                    <x-ink-button :href="route('posts.index')" :arrow="false" class="text-bone/85 text-base">
                        Leer transmisiones
                    </x-ink-button>
                </div>
            </div>

            {{-- Footer integrado ABAJO, sin gap, mismo bg vermillion --}}
            <div class="col-span-12 mt-32 grid grid-cols-12 gap-y-8 lg:gap-x-12 lg:mt-40 border-t border-bone/20 pt-10">
                <div class="col-span-12 lg:col-span-4">
                    <p class="font-jp text-[10px] uppercase tracking-[0.4em] text-bone/65">archivo</p>
                    <ul class="mt-4 space-y-2 font-display italic">
                        <li><a href="{{ route('home') }}" class="text-bone hover:text-bone/70 transition-colors">↑ inicio</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-bone hover:text-bone/70 transition-colors">→ máscaras</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-bone hover:text-bone/70 transition-colors">→ transmisiones</a></li>
                    </ul>
                </div>

                <div class="col-span-12 lg:col-span-4 lg:col-start-5">
                    <p class="font-jp text-[10px] uppercase tracking-[0.4em] text-bone/65">coordenadas</p>
                    <ul class="mt-4 space-y-1 font-mono text-[11px] uppercase tracking-[0.18em] text-bone/85">
                        <li>35.6762°N · 139.6503°E</li>
                        <li>turno · noche</li>
                        <li>protocolo · público</li>
                    </ul>
                </div>

                <div class="col-span-12 lg:col-span-4 lg:col-start-9">
                    <p class="font-jp text-[10px] uppercase tracking-[0.4em] text-bone/65">aviso</p>
                    <p class="mt-4 max-w-[20rem] font-display italic text-bone/85">
                        El carrito de reservas se abre en la próxima fase del circuito.
                    </p>
                </div>

                <div class="col-span-12 mt-8 flex flex-wrap items-center justify-between gap-3 border-t border-bone/20 pt-6">
                    <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/65">
                        &copy; {{ date('Y') }} circuito kitsune · proyecto académico · portales y comercio electrónico
                    </p>
                    <p class="hash-code text-bone/65">{{ strtoupper(substr(md5(date('Y-m-d')), 0, 18)) }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- override · oculta el footer global del layout en home --}}
    <style>
        body > footer { display: none !important; }
    </style>
@endsection
