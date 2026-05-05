@extends('layouts.app')

@section('title', '面 · Archivo de máscaras')
@section('description', 'Archivo completo de identidades del Circuito Kitsune. Filtrá por estado o rareza.')

@section('content')
    @php
        $defaultActive = $products->first()?->slug ?? '';
        $filters = [
            null => 'Todos',
            'disponibles' => 'Disponibles',
            'proximas' => 'Próximas',
            'agotadas' => 'Agotadas',
            'raras' => 'Raras',
            'legendarias' => 'Legendarias',
        ];
    @endphp

    {{-- ════════════════════════════════════════════════════════════════════
         HERO · número leading + outline · sin la fórmula plain+italic
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="vignette light-leak-double scanlines paper-grain grain-strong relative w-screen overflow-hidden bg-ink-deep pt-32 pb-20 sm:pt-40 sm:pb-28" aria-labelledby="archivo-titulo">
        {{-- Kanji 面 enorme con parallax --}}
        <span class="kanji-mark parallax-up absolute -right-[4vw] top-[8vh] font-jp leading-[0.8]" style="font-size: clamp(18rem, 50vw, 44rem); color: var(--color-vermillion); opacity: 0.13; text-shadow: 0 0 80px rgba(230,57,70,0.3);" aria-hidden="true">面</span>

        <div class="relative z-10 grid w-full grid-cols-12 gap-y-10 px-6 sm:px-16 lg:px-24">
            <div class="col-span-12 lg:col-span-2">
                <div class="flex items-center gap-3">
                    <span class="stamp text-vermillion">機密</span>
                    <span class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55">02</span>
                </div>
                <span class="float-num mt-8 block text-vermillion glow-vermillion leading-none">{{ str_pad((string) $totalCount, 2, '0', STR_PAD_LEFT) }}</span>
                <p class="mt-2 font-display italic text-bone/65">identidades.</p>
            </div>

            <div class="col-span-12 lg:col-span-9 lg:col-start-4 lg:self-end">
                <h1 id="archivo-titulo" class="font-display font-medium leading-[0.92] tracking-[-0.025em]">
                    <span class="block text-[clamp(2.5rem,5vw,4.5rem)] italic text-bone/65">archivo · 面</span>
                    <span class="block text-[clamp(3rem,7vw,6.5rem)] outline-text-thick text-bone uppercase">máscaras</span>
                    <span class="block text-[clamp(2.5rem,5vw,4.5rem)] italic text-bone">— del circuito.</span>
                </h1>
                <p class="mt-8 max-w-xl font-display text-lg italic leading-relaxed text-bone/85 sm:text-xl">
                    Cada entrada es una identidad activa del mercado nocturno.
                    Pasá el cursor por el roster para inspeccionar.
                </p>
                <p class="mt-6 font-mono text-[10px] uppercase tracking-[0.3em] text-bone/55 flex flex-wrap items-center gap-x-3 gap-y-1">
                    <span class="text-neon-cyan">▸</span>
                    catálogo · {{ str_pad((string) $products->count(), 2, '0', STR_PAD_LEFT) }} de {{ str_pad((string) $totalCount, 2, '0', STR_PAD_LEFT) }}
                    <span>·</span>
                    filtro · <span class="text-vermillion glow-vermillion">{{ $activeFilter ?? 'sin filtro' }}</span>
                    <span>·</span>
                    sha · {{ strtoupper(substr(md5($activeFilter ?? 'all'), 0, 12)) }}
                </p>
            </div>
        </div>

        {{-- Filtros --}}
        <nav aria-label="Filtros de catálogo" class="reveal relative z-10 mt-16 grid w-full grid-cols-12 px-6 sm:px-16 lg:px-24">
            <ul class="col-span-12 -mx-2 flex flex-wrap items-baseline gap-x-2 gap-y-3">
                @foreach ($filters as $key => $label)
                    @php $isActive = ($activeFilter ?? null) === ($key ?? null); @endphp
                    <li>
                        <a
                            href="{{ $key ? route('products.index', ['filter' => $key]) : route('products.index') }}"
                            @class([
                                'inline-flex items-baseline gap-2 px-3 py-1 font-display text-base italic transition-colors',
                                'text-vermillion glow-vermillion' => $isActive,
                                'text-bone/55 hover:text-bone' => ! $isActive,
                            ])
                            @if ($isActive) aria-current="true" @endif
                        >
                            @if ($isActive)
                                <span class="font-jp text-xs not-italic">▸</span>
                            @endif
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         ROSTER
    ════════════════════════════════════════════════════════════════════ --}}
    <section
        class="paper-grain grain-strong relative w-screen bg-sumi text-bone"
        aria-label="Roster de identidades"
        x-data="{ active: '{{ $defaultActive }}' }"
    >
        @if ($products->isEmpty())
            <div class="grid w-full grid-cols-12 px-6 py-24 sm:px-16 lg:px-24">
                <div class="col-span-12 lg:col-span-8">
                    <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-vermillion glow-vermillion">▸ resultado · vacío</p>
                    <p class="mt-4 font-display text-3xl italic text-bone/85">No hay máscaras que coincidan con este filtro.</p>
                    <div class="mt-10">
                        <x-ink-button :href="route('products.index')">Limpiar filtro</x-ink-button>
                    </div>
                </div>
            </div>
        @else
            <div class="grid w-full grid-cols-12 gap-x-6 gap-y-12 px-6 py-16 pb-32 sm:px-16 lg:gap-x-12 lg:px-24">
                <ol class="col-span-12 lg:col-span-7">
                    @foreach ($products as $idx => $product)
                        @php
                            $colorHex = str_replace(['background-color: ', ';'], '', $product->dominantColorStyle());
                            $statusClass = match ($product->status) {
                                \App\Models\Product::STATUS_AVAILABLE => 'text-neon-cyan',
                                \App\Models\Product::STATUS_UPCOMING => 'text-gold-soft',
                                \App\Models\Product::STATUS_SOLD_OUT => 'text-bone/40',
                                default => 'text-bone',
                            };
                        @endphp
                        <li>
                            <a
                                href="{{ route('products.show', $product) }}"
                                @mouseenter="active = '{{ $product->slug }}'"
                                @focus="active = '{{ $product->slug }}'"
                                :class="active === '{{ $product->slug }}' ? 'text-bone' : 'text-bone/85'"
                                class="masthead-line block transition-colors"
                                aria-label="Ver expediente de {{ $product->name }} · {{ $product->code }}"
                            >
                                <div class="flex items-baseline justify-between gap-4">
                                    <span class="masthead-line__index text-bone/45">
                                        no.{{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }}
                                        <span class="opacity-50">· {{ strtoupper(substr(md5($product->slug), 0, 6)) }}</span>
                                    </span>
                                    <span class="font-mono text-[9px] uppercase tracking-[0.28em] {{ $statusClass }} flex items-center gap-1.5">
                                        <span class="block h-1.5 w-1.5 rounded-full" style="background-color: {{ $colorHex }}; box-shadow: 0 0 6px {{ $colorHex }};"></span>
                                        {{ $product->statusLabel() }}
                                    </span>
                                </div>

                                <h2 class="masthead-line__title mt-3 glitch-hover">
                                    {{ $product->name }}
                                </h2>

                                <div class="mt-4 flex flex-wrap items-baseline gap-x-6 gap-y-1 font-mono text-[10px] uppercase tracking-[0.26em] text-bone/55">
                                    <span class="text-vermillion">▸</span>
                                    <span>{{ $product->code }}</span>
                                    <span>·</span>
                                    <span>{{ $product->district }}</span>
                                    <span>·</span>
                                    <span>{{ $product->rarityLabel() }}</span>
                                    <span class="ml-auto font-display text-base normal-case tracking-normal text-bone">{{ $product->formattedPrice() }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ol>

                <aside class="hidden lg:col-span-4 lg:col-start-9 lg:block" aria-label="Preview de la identidad">
                    <div class="sticky top-32">
                        @foreach ($products as $product)
                            <div x-show="active === '{{ $product->slug }}'" x-cloak x-transition.duration.220ms>
                                <div class="portrait-frame relative aspect-[3/4] w-full overflow-hidden">
                                    <x-mask-placeholder :product="$product" />
                                </div>
                                <div class="mt-6">
                                    <p class="font-mono text-[10px] uppercase tracking-[0.28em] text-vermillion glow-vermillion">{{ $product->code }}</p>
                                    <h3 class="mt-2 font-display text-2xl font-medium leading-tight text-bone">{{ $product->name }}</h3>
                                    <p class="mt-3 font-display italic text-bone/75">{{ $product->short_description }}</p>
                                    <div class="ink-divider mt-6 text-bone" aria-hidden="true"></div>
                                    <div class="mt-6 flex items-end justify-between gap-4">
                                        <span class="font-display text-2xl text-bone">{{ $product->formattedPrice() }}</span>
                                        <x-ink-button :href="route('products.show', $product)">
                                            Ver expediente
                                        </x-ink-button>
                                    </div>
                                    <p class="hash-code mt-6 text-bone/40">hash · {{ strtoupper(substr(md5($product->slug), 0, 16)) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </aside>
            </div>
        @endif
    </section>
@endsection
