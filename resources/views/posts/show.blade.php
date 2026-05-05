@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->excerpt)

@section('content')
    @php
        $tone = match ($post->cover_tone ?? 'neutral') {
            'cyan', 'green' => 'var(--color-neon-cyan)',
            'magenta', 'red' => 'var(--color-vermillion)',
            'gold' => 'var(--color-gold)',
            'violet' => 'var(--color-neon-magenta)',
            default => 'var(--color-vermillion)',
        };
        $signalId = str_pad((string) $post->id, 3, '0', STR_PAD_LEFT);
        $hashId = strtoupper(substr(md5($post->slug), 0, 16));
    @endphp

    {{-- ════════════════════════════════════════════════════════════════════
         HERO de la transmisión · noche
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="vignette light-leak-cyan scanlines paper-grain grain-strong relative w-screen overflow-hidden bg-ink-deep pt-32 pb-20 sm:pt-40 sm:pb-28">
        <span class="kanji-mark absolute -right-[6vw] top-[6vh] font-jp leading-[0.8]" style="font-size: clamp(18rem, 50vw, 44rem); color: {{ $tone }}; opacity: 0.12; text-shadow: 0 0 80px {{ $tone }}33;" aria-hidden="true">声</span>

        <nav aria-label="Migas" class="relative z-10 grid w-full grid-cols-12 px-6 sm:px-16 lg:px-20">
            <div class="col-span-12 lg:col-span-9">
                <a href="{{ route('posts.index') }}" class="font-display text-base italic text-bone/70 transition-colors hover:text-vermillion">
                    ← archivo de transmisiones
                </a>
            </div>
        </nav>

        <div class="relative z-10 grid w-full grid-cols-12 gap-y-10 px-6 pt-12 sm:px-16 sm:pt-16 lg:px-20">
            <div class="col-span-12 lg:col-span-9">
                <div class="flex items-baseline gap-4 flex-wrap">
                    <span class="stamp" style="color: {{ $tone }};">受信 · señal {{ $signalId }}</span>
                    <span class="font-mono text-[11px] uppercase tracking-[0.32em] text-bone/55">
                        {{ strtoupper($post->category) }}
                    </span>
                    @if ($post->is_featured)
                        <span class="font-mono text-[11px] uppercase tracking-[0.32em] text-vermillion glow-vermillion flicker">● prioridad alta</span>
                    @endif
                </div>

                <h1 class="headline mt-8 text-[clamp(2.75rem,8vw,8.5rem)] text-bone">
                    {{ $post->title }}
                </h1>

                <div class="mt-10 flex flex-wrap items-baseline gap-x-6 gap-y-2 font-mono text-[11px] uppercase tracking-[0.28em] text-bone/65">
                    <span>por</span>
                    <span class="text-bone">{{ $post->author }}</span>
                    @if ($post->published_at)
                        <span>·</span>
                        <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('Y · m · d · H:i') }}</time>
                    @endif
                    <span>·</span>
                    <span>{{ $post->readingTimeLabel() }}</span>
                </div>

                <p class="hash-code mt-8 text-bone/55">
                    sha · {{ $hashId }}
                </p>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         CUERPO editorial · noche
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="paper-grain grain-strong w-screen bg-sumi text-bone">
        <div class="grid w-full grid-cols-12 gap-y-12 px-6 py-24 sm:px-16 sm:py-32 lg:px-20">
            <aside class="col-span-12 lg:col-span-2" aria-label="Metadata vertical">
                <div class="hidden lg:block">
                    <p class="vertical-text font-mono text-[10px] uppercase tracking-[0.4em] text-bone/55">
                        señal {{ $signalId }} · {{ $post->author }} · {{ optional($post->published_at)->format('Y.m.d') ?? '' }}
                    </p>
                </div>
                <div class="lg:hidden">
                    <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/55">
                        <span class="text-vermillion">▸</span> señal {{ $signalId }} · {{ $post->author }}
                    </p>
                </div>
            </aside>

            <div class="col-span-12 lg:col-span-8 lg:col-start-3">
                {{-- Pull quote --}}
                <p class="border-l-2 pl-6 font-display text-2xl italic leading-relaxed text-bone sm:text-3xl" style="border-color: {{ $tone }};">
                    {{ $post->excerpt }}
                </p>

                {{-- Body con drop cap tonal --}}
                <div class="drop-cap mt-12 max-w-prose space-y-6 font-display text-lg leading-[1.85] text-bone/95 lg:text-xl" style="--drop-cap-color: {{ $tone }};">
                    @foreach ($post->formattedBody() as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <div class="ink-divider mt-16 text-bone" aria-hidden="true"></div>

                <p class="mt-6 font-jp text-[11px] uppercase tracking-[0.32em] flex items-center gap-3" style="color: {{ $tone }};">
                    <span class="block h-1.5 w-1.5 rounded-full" style="background-color: currentColor; box-shadow: 0 0 8px currentColor;"></span>
                    終 · fin de la transmisión · canal cerrado
                </p>

                <div class="mt-12 flex flex-wrap items-center gap-x-12 gap-y-6">
                    <x-ink-button :href="route('posts.index')" class="text-bone">
                        Volver al archivo
                    </x-ink-button>
                    <x-ink-button :href="route('home')" :arrow="false" class="text-bone/65 text-base">
                        Volver al circuito
                    </x-ink-button>
                </div>
            </div>
        </div>
    </section>
@endsection
