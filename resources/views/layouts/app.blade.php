<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Circuito Kitsune') · 鬼 · Circuito Kitsune</title>
    <meta name="description" content="@yield('description', 'Circuito Kitsune. Identidades nocturnas. Máscaras del mercado nocturno japonés.')">
    <meta name="theme-color" content="#050608">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="paper-grain has-status-bar min-h-screen overflow-x-hidden bg-ink-deep text-bone">
    <a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:bg-bone focus:px-3 focus:py-1 focus:text-sm focus:text-ink-deep">
        Saltar al contenido
    </a>

    {{-- ════════════════════════════════════════════════════════════════
         BOOT VEIL · solo primera carga, fade-out automático
    ════════════════════════════════════════════════════════════════ --}}
    <div class="boot-veil" aria-hidden="true">
        <span class="boot-veil__text">アクセス</span>
        <div class="boot-veil__bar"></div>
        <span class="boot-veil__caption">verificando identidad · acceso autorizado</span>
    </div>

    {{-- Scroll progress vertical --}}
    <div class="scroll-progress" aria-hidden="true"></div>

    {{-- ════════════════════════════════════════════════════════════════
         HEADER · minimal con stamp clandestino
    ════════════════════════════════════════════════════════════════ --}}
    @php
        $nav = [
            ['label' => 'Inicio', 'route' => 'home', 'index' => '序'],
            ['label' => 'Máscaras', 'route' => 'products.index', 'index' => '面'],
            ['label' => 'Transmisiones', 'route' => 'posts.index', 'index' => '声'],
        ];
    @endphp

    <header class="absolute inset-x-0 top-0 z-30 mix-blend-difference">
        <div class="flex w-full items-center justify-between gap-4 px-6 py-6 sm:px-10 sm:py-8">
            <a href="{{ route('home') }}" class="flex items-baseline gap-3" aria-label="Inicio · Circuito Kitsune">
                <span class="font-jp text-2xl text-bone leading-none">鬼</span>
                <span class="hidden font-display text-sm uppercase tracking-[0.32em] text-bone sm:inline">circuito kitsune</span>
                <span class="hidden lg:inline-flex items-center gap-1.5 ml-2 font-mono text-[10px] uppercase tracking-[0.28em] text-bone/60">
                    <span class="block h-1.5 w-1.5 rounded-full bg-current"></span>
                    機密 · clasificado
                </span>
            </a>

            <nav aria-label="Principal" class="flex items-center gap-6 sm:gap-10">
                @foreach ($nav as $item)
                    @php
                        $active = request()->routeIs($item['route']) ||
                                  ($item['route'] === 'products.index' && request()->routeIs('products.*')) ||
                                  ($item['route'] === 'posts.index' && request()->routeIs('posts.*'));
                    @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'group inline-flex items-baseline gap-1.5 font-display text-sm uppercase tracking-[0.22em] transition-opacity',
                            'text-bone' => $active,
                            'text-bone/65 hover:text-bone' => ! $active,
                        ])
                        @if ($active) aria-current="page" @endif
                    >
                        <span class="font-jp text-xs opacity-60">{{ $item['index'] }}</span>
                        <span class="hidden sm:inline">{{ $item['label'] }}</span>
                    </a>
                @endforeach

                <button
                    type="button"
                    aria-label="Carrito · disponible en la próxima fase del circuito"
                    title="Carrito · próxima fase"
                    class="ml-2 hidden cursor-not-allowed font-mono text-[10px] uppercase tracking-[0.28em] text-bone/45 sm:inline"
                >
                    [ 籠 · 0 ]
                </button>
            </nav>
        </div>
    </header>

    {{-- ════════════════════════════════════════════════════════════════
         MAIN
    ════════════════════════════════════════════════════════════════ --}}
    <main id="contenido" class="relative">
        @yield('content')
    </main>

    {{-- ════════════════════════════════════════════════════════════════
         FOOTER ritual
    ════════════════════════════════════════════════════════════════ --}}
    <footer class="relative border-t border-bone/10 bg-sumi vignette">
        <div class="grid w-full gap-y-12 px-6 py-16 sm:px-10 lg:grid-cols-12 lg:gap-x-12 lg:py-24">
            <div class="lg:col-span-6">
                <p class="font-jp text-[10px] uppercase tracking-[0.4em] text-vermillion glow-vermillion">終 · cierre</p>
                <h2 class="headline mt-6 text-5xl text-bone sm:text-6xl lg:text-7xl">
                    <em>面</em><br>
                    Circuito Kitsune
                </h2>
                <p class="mt-6 max-w-md font-display italic text-bone/70">
                    Una tienda nocturna de identidades. Cada máscara abre una puerta
                    distinta del mercado. El circuito está abierto.
                </p>
                <p class="mt-8 hash-code text-bone/50">
                    sha · 9f3a · 1b6e · {{ strtoupper(substr(md5(date('Y-m-d')), 0, 12)) }}
                </p>
            </div>

            <div class="lg:col-span-3 lg:col-start-8">
                <p class="font-jp text-[10px] uppercase tracking-[0.4em] text-bone/50">archivo</p>
                <ul class="mt-6 space-y-3">
                    @foreach ($nav as $item)
                        <li>
                            <a href="{{ route($item['route']) }}" class="font-display text-base text-bone hover:text-vermillion transition-colors inline-flex items-baseline gap-2">
                                <span class="font-jp text-xs text-bone/50">{{ $item['index'] }}</span>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-3">
                <p class="font-jp text-[10px] uppercase tracking-[0.4em] text-bone/50">coordenadas</p>
                <ul class="mt-6 space-y-2 font-mono text-xs text-bone/60">
                    <li class="flex items-center gap-2"><span class="neon-dot"></span> 35.6762°N · 139.6503°E</li>
                    <li class="flex items-center gap-2"><span class="neon-dot neon-dot--vermillion"></span> turno · noche</li>
                    <li class="flex items-center gap-2"><span class="neon-dot neon-dot--gold"></span> protocolo · público</li>
                </ul>
                <p class="mt-6 max-w-[16rem] text-xs leading-relaxed text-bone/45">
                    El carrito de reservas se abre en la próxima fase del circuito.
                </p>
            </div>
        </div>

        <div class="ink-divider mx-6 sm:mx-10" aria-hidden="true"></div>

        <div class="flex w-full flex-wrap items-center justify-between gap-3 px-6 py-6 sm:px-10">
            <p class="font-mono text-[10px] uppercase tracking-[0.32em] text-bone/40">
                &copy; {{ date('Y') }} circuito kitsune · proyecto académico · portales y comercio electrónico
            </p>
            <p class="font-jp text-xs text-bone/40 flex items-center gap-2">
                <span class="neon-dot"></span> en línea · ahora
            </p>
        </div>
    </footer>

    {{-- ════════════════════════════════════════════════════════════════
         STATUS BAR · fija inferior, metadata viva
    ════════════════════════════════════════════════════════════════ --}}
    <div class="status-bar" role="status" aria-label="Estado del sistema">
        <span class="flex items-center gap-2">
            <span class="status-bar__dot" aria-hidden="true"></span>
            <span class="text-bone/85">señal · estable</span>
        </span>
        <span class="hidden sm:inline">35.6762°N · 139.6503°E</span>
        <span class="hidden md:inline">protocolo · público</span>
        <span class="hidden md:inline">turno · noche</span>
        <span class="ml-auto flex items-center gap-2 text-bone/85">
            <span class="hidden sm:inline">tokyo ·</span>
            <span data-status-clock class="font-medium text-bone">--:--:--</span>
        </span>
    </div>
</body>
</html>
