@extends('layouts.app')

@section('title', $product->name)
@section('description', $product->short_description)

@section('content')
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
        $sv = match ($product->status) {
            \App\Models\Product::STATUS_AVAILABLE => ['label' => 'Disponible', 'kanji' => '開', 'cls' => 'text-neon-cyan glow-cyan'],
            \App\Models\Product::STATUS_UPCOMING => ['label' => 'Próxima', 'kanji' => '待', 'cls' => 'text-gold'],
            \App\Models\Product::STATUS_SOLD_OUT => ['label' => 'Agotada', 'kanji' => '閉', 'cls' => 'text-bone/55'],
            default => ['label' => $product->statusLabel(), 'kanji' => '?', 'cls' => 'text-bone/55'],
        };
        $idDisplay = str_pad((string) $product->id, 4, '0', STR_PAD_LEFT);
        $hashId = strtoupper(substr(md5($product->slug), 0, 16));
    @endphp

    {{-- ════════════════════════════════════════════════════════════════════
         HERO color-driven · NOMBRE SUPERPUESTO al portrait (overlap)
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="relative min-h-screen w-screen overflow-hidden pt-32 pb-20 sm:pt-40" style="background-color: {{ $colorHex }};">
        <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(180deg, rgba(5,6,8,0.55) 0%, rgba(5,6,8,0.20) 35%, rgba(5,6,8,0.55) 100%);" aria-hidden="true"></div>
        <div class="absolute inset-0 pointer-events-none scanlines" aria-hidden="true"></div>
        <div class="absolute inset-0 pointer-events-none paper-grain grain-strong" aria-hidden="true"></div>

        {{-- Kanji familiar enorme con parallax --}}
        <span
            class="kanji-mark parallax-up absolute font-jp font-extrabold leading-[0.78] z-[2]"
            style="font-size: clamp(28rem, 80vw, 80rem); color: var(--color-ink-deep); opacity: 0.20; right: -12vw; top: -8vh;"
            aria-hidden="true"
        >{{ $familyKanji }}</span>

        {{-- Vertical metadata --}}
        <div class="absolute left-6 top-1/2 hidden -translate-y-1/2 sm:left-10 sm:block z-10">
            <p class="vertical-text font-mono text-[10px] uppercase tracking-[0.4em] text-bone/65">
                {{ $product->district }} · {{ $product->code }} · {{ $hashId }}
            </p>
        </div>

        {{-- Stamp arriba derecha --}}
        <div class="absolute right-6 top-28 hidden sm:right-16 sm:top-32 lg:right-24 z-10">
            <span class="stamp text-bone">機密 · expediente {{ $idDisplay }}</span>
        </div>

        {{-- breadcrumb --}}
        <nav aria-label="Migas" class="absolute left-6 top-28 sm:left-16 sm:top-32 lg:left-24 z-10">
            <a href="{{ route('products.index') }}" class="font-display text-base italic text-bone/85 transition-opacity hover:opacity-100 hover:text-bone">
                ← archivo
            </a>
        </nav>

        <div class="relative z-10 grid min-h-[calc(100vh-12rem)] w-full grid-cols-12 items-end px-6 pb-20 sm:px-16 lg:px-24 lg:pb-32">

            {{-- PORTRAIT absoluto a la derecha, sangrando, DETRÁS del título --}}
            <div class="absolute right-[-4vw] top-[14vh] z-[3] hidden lg:block" aria-hidden="false">
                <div class="portrait-frame relative aspect-[3/4] w-[44vw] max-w-[640px] overflow-hidden text-bone opacity-95">
                    <x-mask-placeholder :product="$product" mode="editorial" />
                </div>
            </div>
            {{-- Mobile portrait simple al costado --}}
            <div class="col-span-12 z-[3] mb-8 flex justify-end lg:hidden">
                <div class="portrait-frame relative aspect-[3/4] w-[55vw] max-w-[280px] overflow-hidden text-bone">
                    <x-mask-placeholder :product="$product" mode="editorial" />
                </div>
            </div>

            {{-- TÍTULO con z-[4], bleed-right para que pase POR ENCIMA del portrait --}}
            <div class="relative z-[4] col-span-12">
                <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/85 flex items-center gap-3">
                    <span class="block h-1 w-1 rounded-full bg-bone"></span>
                    no.{{ $idDisplay }} · {{ $product->category }}
                </p>

                <h1 class="mt-6 font-display font-medium leading-[0.88] tracking-[-0.03em] text-bone" style="text-shadow: 0 4px 30px rgba(5,6,8,0.65);">
                    <span class="block text-[clamp(3.5rem,15vw,18rem)] whitespace-nowrap">{{ explode(':', $product->name)[0] ?? $product->name }}</span>
                    @if (str_contains($product->name, ':'))
                        <span class="block text-[clamp(2rem,7vw,7rem)] italic mt-2 text-bone/90">
                            — {{ trim(explode(':', $product->name, 2)[1] ?? '') }}
                        </span>
                    @endif
                </h1>

                <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 font-mono text-[11px] uppercase tracking-[0.3em] text-bone/85">
                    <span class="inline-flex items-baseline gap-2">
                        <span class="font-jp text-base not-italic {{ $sv['cls'] }}">{{ $sv['kanji'] }}</span>
                        <span class="{{ $sv['cls'] }}">{{ $sv['label'] }}</span>
                    </span>
                    <span class="text-bone/55">·</span>
                    <span>{{ $product->rarityLabel() }}</span>
                    <span class="text-bone/55">·</span>
                    <span>{{ $product->district }}</span>
                </div>

                <p class="mt-10 max-w-xl font-display text-2xl italic leading-relaxed sm:text-3xl text-bone/95">
                    {{ $product->short_description }}
                </p>

                <p class="hash-code mt-10 text-bone/65">
                    sha · {{ $hashId }} · sync · {{ optional($product->updated_at)->format('Y.m.d-H:i') ?? '--' }}
                </p>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         01 · ATRIBUTOS · sin título grande, los stats hablan
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="paper-grain grain-strong vignette light-leak-cyan w-screen bg-sumi text-bone" aria-labelledby="ficha-titulo">
        <div class="grid w-full grid-cols-12 gap-y-12 px-6 py-32 sm:px-16 lg:px-24">
            <div class="col-span-12 lg:col-span-3">
                <p id="ficha-titulo" class="font-mono text-[11px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-3">
                    <span class="block h-1 w-6 bg-vermillion"></span>
                    01 · atributos
                </p>
                <p class="hash-code mt-6 text-bone/45">{{ strtoupper(substr(md5('stats'.$product->slug), 0, 24)) }}</p>
            </div>

            <div class="reveal col-span-12 lg:col-span-8 lg:col-start-5">
                <dl class="space-y-12">
                    @foreach ([
                        ['label' => 'señal',      'value' => $product->signal_level, 'kanji' => '信', 'desc' => 'capacidad de validar acceso en lectores saturados'],
                        ['label' => 'agilidad',   'value' => $product->agility,      'kanji' => '速', 'desc' => 'velocidad de tránsito entre distritos'],
                        ['label' => 'espíritu',   'value' => $product->spirit,       'kanji' => '魂', 'desc' => 'estabilidad de la identidad bajo presión'],
                        ['label' => 'ferocidad',  'value' => $product->ferocity,     'kanji' => '荒', 'desc' => 'fuerza para abrir corredores cerrados'],
                    ] as $i => $stat)
                        <div class="grid grid-cols-12 items-baseline gap-4 border-b border-bone/15 pb-12">
                            <span class="col-span-1 font-mono text-[10px] uppercase tracking-[0.2em] text-bone/45">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="col-span-2 font-jp text-3xl font-bold text-vermillion glow-vermillion sm:text-4xl">{{ $stat['kanji'] }}</span>
                            <div class="col-span-9 sm:col-span-5">
                                <p class="font-display text-xl italic text-bone">{{ $stat['label'] }}</p>
                                <p class="mt-1 max-w-md font-display text-sm text-bone/65">{{ $stat['desc'] }}</p>
                            </div>
                            <span class="col-span-12 sm:col-span-4 text-right font-display font-medium leading-[0.85] text-[clamp(4rem,9vw,8rem)] text-bone glow-cyan">{{ $stat['value'] }}</span>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         02 · PROTOCOLO · long_description editorial puro, sin título
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="paper-grain w-screen bg-ink-deep text-bone" aria-labelledby="protocolo-titulo">
        <div class="grid w-full grid-cols-12 gap-y-12 px-6 py-32 sm:px-16 lg:px-24">
            <div class="col-span-12 lg:col-span-3">
                <p id="protocolo-titulo" class="font-mono text-[11px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-3">
                    <span class="block h-1 w-6 bg-neon-cyan"></span>
                    02 · protocolo
                </p>

                <p class="parallax-down mt-12 hidden font-jp text-[clamp(8rem,18vw,14rem)] font-extrabold leading-[0.8] text-bone/12 lg:block flicker">
                    {{ $familyKanji }}
                </p>
            </div>

            <div class="col-span-12 lg:col-span-7 lg:col-start-5">
                <p class="reveal font-display text-2xl italic leading-relaxed text-bone/65 sm:text-3xl">
                    — {{ $product->category }}, distrito {{ $product->district }}.
                </p>

                <div class="reveal drop-cap mt-10 max-w-2xl space-y-6 font-display text-xl leading-[1.7] text-bone lg:text-2xl" style="--drop-cap-color: var(--color-vermillion);">
                    <p>{{ $product->long_description }}</p>
                </div>

                <div class="reveal ink-divider mt-12 text-bone" aria-hidden="true"></div>

                <p class="reveal mt-8 max-w-md font-mono text-[11px] uppercase leading-[1.7] tracking-[0.22em] text-bone/55">
                    <span class="text-vermillion">▸</span> identidad catalogada en {{ $product->district }}
                    bajo rareza <span class="text-bone/85">{{ $product->rarityLabel() }}</span>.<br>
                    última sincronización · {{ optional($product->updated_at)->format('d.m.Y · H:i') ?? '--' }}
                </p>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         03 · ACCIÓN · kanji 開 enorme + comando minimal
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="paper-grain grain-strong vignette light-leak-magenta relative w-screen overflow-hidden bg-sumi text-bone" aria-labelledby="accion-titulo">
        {{-- Kanji 開 (abrir) parallax, protagonista --}}
        <span
            class="kanji-mark parallax-slow absolute font-jp font-extrabold leading-[0.78]"
            style="font-size: clamp(20rem, 60vw, 60rem); opacity: 0.14; left: -8vw; bottom: -10vh; color: var(--color-vermillion); text-shadow: 0 0 80px rgba(230,57,70,0.4);"
            aria-hidden="true"
        >{{ $sv['kanji'] }}</span>

        <div class="relative z-10 grid w-full grid-cols-12 gap-y-12 px-6 py-32 sm:px-16 lg:px-24">
            <div class="col-span-12 lg:col-span-2">
                <p id="accion-titulo" class="font-mono text-[11px] uppercase tracking-[0.32em] text-bone/55 flex items-center gap-3">
                    <span class="block h-1 w-6 bg-vermillion"></span>
                    03 · acción
                </p>
            </div>

            <div class="col-span-12 lg:col-span-7 lg:col-start-4">
                <p class="font-display text-3xl italic leading-tight text-bone/65 sm:text-4xl">
                    @if ($product->isAvailable())
                        — disponible para reservar.
                    @elseif ($product->status === \App\Models\Product::STATUS_UPCOMING)
                        — fuera de rotación.
                    @else
                        — retirada del circuito.
                    @endif
                </p>

                <h2 class="mt-6 font-display font-medium leading-[0.88] tracking-[-0.025em] text-bone">
                    <span class="block text-[clamp(3rem,8vw,8rem)]">+ reserva</span>
                    @if (! $product->isAvailable())
                        <span class="block text-[clamp(2rem,5vw,4.5rem)] italic strike-through text-bone/45 mt-2">disponible</span>
                    @endif
                </h2>

                <p class="mt-8 max-w-xl font-display text-lg italic leading-relaxed text-bone/85">
                    @if ($product->isAvailable())
                        {{ $product->name }} está activa en el circuito. El carrito
                        de reservas se abre en la próxima fase del sistema.
                    @elseif ($product->status === \App\Models\Product::STATUS_UPCOMING)
                        Esta identidad todavía no entró en rotación. Próxima
                        sincronización pendiente.
                    @else
                        Esta identidad fue retirada del circuito. Solo se conserva
                        en archivo para consulta.
                    @endif
                </p>

                <div class="mt-12 flex flex-wrap items-center gap-x-12 gap-y-6">
                    <x-ink-button
                        as="button"
                        :disabled="! $product->isAvailable()"
                        class="text-[clamp(1.5rem,2.5vw,2rem)] {{ $product->isAvailable() ? 'text-vermillion glow-vermillion' : '' }}"
                    >
                        Reservar máscara
                    </x-ink-button>
                    <span class="font-display text-3xl font-medium text-bone">{{ $product->formattedPrice() }}</span>
                </div>

                <p class="mt-6 max-w-md font-mono text-[10px] uppercase leading-[1.7] tracking-[0.28em] text-bone/55">
                    <span class="text-vermillion">▸</span> el carrito estará disponible en la próxima fase del circuito.
                </p>
            </div>

            <div class="col-span-12 lg:col-span-2 lg:col-start-11 lg:self-end">
                <p class="font-jp text-[10px] uppercase tracking-[0.4em] text-bone/55">archivo</p>
                <ul class="mt-4 space-y-3 font-display text-base italic">
                    <li><a href="{{ route('products.index') }}" class="text-bone/85 hover:text-vermillion transition-colors">← máscaras</a></li>
                    <li><a href="{{ route('posts.index') }}" class="text-bone/85 hover:text-vermillion transition-colors">→ señales</a></li>
                    <li><a href="{{ route('home') }}" class="text-bone/85 hover:text-vermillion transition-colors">↑ inicio</a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection
