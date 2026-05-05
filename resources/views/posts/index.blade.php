@extends('layouts.app')

@section('title', '声 · Transmisiones')
@section('description', 'Archivo de señales interceptadas. Notas, guías y reportes del Circuito Kitsune.')

@section('content')
    @php $japNumbers = ['壱', '弐', '参', '肆', '伍', '陸', '漆', '捌']; @endphp

    {{-- ════════════════════════════════════════════════════════════════════
         HERO transmisiones · noche
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="vignette light-leak-magenta scanlines paper-grain grain-strong relative w-screen overflow-hidden bg-ink-deep pt-32 pb-20 sm:pt-40 sm:pb-28" aria-labelledby="transmisiones-titulo">
        <span class="kanji-mark absolute -right-[6vw] top-[6vh] font-jp leading-[0.8]" style="font-size: clamp(18rem, 50vw, 44rem); color: var(--color-neon-magenta); opacity: 0.10; text-shadow: 0 0 80px rgba(255,74,140,0.30);" aria-hidden="true">声</span>

        <div class="relative z-10 grid w-full grid-cols-12 gap-y-12 px-6 sm:px-16 lg:px-24">
            <div class="col-span-12 lg:col-span-2">
                <div class="flex items-center gap-3">
                    <span class="stamp text-neon-magenta">受信中</span>
                </div>
                <span class="float-num mt-8 block text-neon-magenta glow-magenta leading-none">{{ str_pad((string) $posts->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <p class="mt-2 font-display italic text-bone/65">señales.</p>
            </div>

            <div class="col-span-12 lg:col-span-9 lg:col-start-4 lg:self-end">
                <h1 id="transmisiones-titulo" class="font-display font-medium leading-[0.92] tracking-[-0.025em]">
                    <span class="block text-[clamp(2.5rem,5vw,4.5rem)] italic text-bone/65">archivo · 声</span>
                    <span class="block text-[clamp(3rem,8vw,7.5rem)] outline-text-thick text-bone uppercase">transmisiones</span>
                    <span class="block text-[clamp(2.25rem,4.5vw,4rem)] italic text-bone">— interceptadas.</span>
                </h1>
                <p class="mt-8 max-w-xl font-display text-lg italic leading-relaxed text-bone/85 sm:text-xl">
                    Notas del operador, reportes de distrito, protocolos del circuito.
                    Cada transmisión es un mensaje del archivo nocturno.
                </p>
                <p class="mt-6 font-mono text-[10px] uppercase tracking-[0.3em] text-bone/55 flex flex-wrap items-center gap-x-3 gap-y-1">
                    <span class="text-neon-magenta">▸</span>
                    canal · {{ str_pad((string) $posts->count(), 2, '0', STR_PAD_LEFT) }} señales
                    <span>·</span>
                    <span class="text-neon-magenta glow-magenta flicker">en línea</span>
                    <span>·</span>
                    sha · {{ strtoupper(substr(md5('feed'), 0, 14)) }}
                </p>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════════
         ARCHIVO magazine asimétrico · noche
    ════════════════════════════════════════════════════════════════════ --}}
    <section class="paper-grain grain-strong w-screen bg-sumi text-bone" aria-label="Archivo de transmisiones">
        @if ($posts->isEmpty())
            <div class="grid w-full grid-cols-12 px-6 py-32 sm:px-16 lg:px-20">
                <div class="col-span-12 lg:col-span-8">
                    <p class="font-mono text-[11px] uppercase tracking-[0.3em] text-vermillion glow-vermillion">▸ canal · silencio</p>
                    <p class="mt-4 font-display text-3xl italic">No hay transmisiones publicadas todavía.</p>
                </div>
            </div>
        @else
            <div class="grid w-full grid-cols-12 gap-y-24 px-6 py-32 sm:px-16 lg:gap-x-12 lg:px-20">
                @foreach ($posts as $idx => $post)
                    @php
                        $patterns = [
                            ['span' => 'col-span-12 lg:col-span-9 lg:col-start-1', 'titleSize' => 'text-[clamp(2.5rem,6vw,5.5rem)]', 'big' => true],
                            ['span' => 'col-span-12 sm:col-span-7 lg:col-span-5 lg:col-start-7', 'titleSize' => 'text-[clamp(2rem,3.5vw,3.25rem)]', 'big' => false],
                            ['span' => 'col-span-12 sm:col-span-7 lg:col-span-6 lg:col-start-2', 'titleSize' => 'text-[clamp(2rem,3.5vw,3.25rem)]', 'big' => false],
                            ['span' => 'col-span-12 lg:col-span-7 lg:col-start-5', 'titleSize' => 'text-[clamp(2.25rem,4.5vw,4rem)]', 'big' => true],
                            ['span' => 'col-span-12 sm:col-span-7 lg:col-span-5 lg:col-start-1', 'titleSize' => 'text-[clamp(2rem,3.5vw,3.25rem)]', 'big' => false],
                        ];
                        $pattern = $patterns[$idx % count($patterns)];
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

                    <article class="reveal {{ $pattern['span'] }}">
                        <a href="{{ route('posts.show', $post) }}" class="group block" data-cursor="big">
                            <div class="flex items-baseline gap-4 flex-wrap">
                                <span class="font-jp text-3xl font-bold {{ $tone }} {{ $glow }} sm:text-4xl">{{ $japNumbers[$idx] ?? '○' }}</span>
                                <span class="font-mono text-[10px] uppercase tracking-[0.3em] {{ $tone }}">
                                    ▸ {{ strtoupper($post->category) }}
                                </span>
                                @if ($post->is_featured)
                                    <span class="font-mono text-[10px] uppercase tracking-[0.3em] text-vermillion glow-vermillion flicker">● destacada</span>
                                @endif
                                <span class="hash-code text-bone/45 ml-auto hidden sm:inline">señal · {{ str_pad((string) $post->id, 3, '0', STR_PAD_LEFT) }} · {{ strtoupper(substr(md5($post->slug), 0, 8)) }}</span>
                            </div>

                            <h2 class="glitch-hover headline mt-5 {{ $pattern['titleSize'] }} text-bone group-hover:text-vermillion transition-colors">
                                {{ $post->title }}
                            </h2>

                            <p class="mt-6 max-w-prose font-display italic leading-relaxed text-bone/80 {{ $pattern['big'] ? 'text-xl sm:text-2xl' : 'text-lg' }}">
                                {{ $post->excerpt }}
                            </p>

                            <div class="ink-divider mt-8 text-bone" aria-hidden="true"></div>

                            <p class="mt-5 font-mono text-[10px] uppercase tracking-[0.28em] text-bone/55 flex flex-wrap items-center gap-x-3 gap-y-1">
                                @if ($post->published_at)
                                    <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('Y · m · d') }}</time>
                                    <span class="text-bone/35">·</span>
                                @endif
                                <span>{{ $post->author }}</span>
                                <span class="text-bone/35">·</span>
                                <span>{{ $post->readingTimeLabel() }}</span>
                            </p>
                        </a>
                    </article>
                @endforeach
            </div>

            <div class="grid w-full grid-cols-12 px-6 pb-32 sm:px-16 lg:px-20">
                <div class="col-span-12 lg:col-span-6">
                    <p class="font-mono text-[10px] uppercase tracking-[0.28em] text-bone/55">
                        <span class="text-vermillion">▸</span> fin del archivo · próxima señal pendiente
                    </p>
                </div>
            </div>
        @endif
    </section>
@endsection
