<!DOCTYPE html>
<html lang="es" class="lenis">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#050608">
    <meta name="description" content="@yield('meta_description', 'Circuito Kitsune. Tienda clandestina de máscaras japonesas cyberpunk. Cada máscara abre un distrito de la ciudad nocturna.')">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'Circuito Kitsune · turno noche')">
    <meta property="og:description" content="@yield('og_description', 'Tienda clandestina de máscaras japonesas cyberpunk.')">

    <title>@yield('title', 'Circuito Kitsune') · turno noche</title>

    {{-- Google Fonts CDN: 3 familias cerradas (§2.2) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=JetBrains+Mono:wght@400;500&family=Shippori+Mincho+B1:wght@400;500;700&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-grain antialiased" x-data="{ cartOpen: false }">

    {{-- ───── BOOT LOADER · micro-overture <1s primera visita ────── --}}
    <div class="boot-loader" data-boot-loader aria-hidden="true">
        <div class="boot-loader__panel">
            <div class="boot-loader__head">▸ ingreso · kitsune node</div>
            <div class="boot-loader__line">vinculando coordenadas</div>
            <div class="boot-loader__progress">
                <span class="boot-loader__percent"><span data-boot-percent>00</span>%</span>
                <span class="boot-loader__bar"><span class="boot-loader__fill" data-boot-fill></span></span>
            </div>
            <div class="boot-loader__line boot-loader__line--small">35.6762°N · 139.6503°E · turno noche</div>
        </div>
    </div>

    <a href="#main" class="skip-link">Saltar al contenido</a>

    {{-- ───── HEADER ─────────────────────────────────────────────────── --}}
    <header class="fixed top-0 left-0 right-0 z-50 text-bone bg-ink border-b border-ash" role="banner">
        <div class="flex items-center justify-between px-6 sm:px-10 lg:px-16 py-5">

            {{-- brand mark izquierda · símbolo geométrico tipo globe utopia --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 sm:gap-4 group" aria-label="Circuito Kitsune · inicio">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 56 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="28" cy="16" rx="26" ry="14" stroke="currentColor" stroke-width="1"/>
                        <line x1="2" y1="16" x2="54" y2="16" stroke="currentColor" stroke-width="1"/>
                        <line x1="28" y1="2" x2="28" y2="30" stroke="currentColor" stroke-width="1"/>
                        <ellipse cx="28" cy="16" rx="14" ry="14" stroke="currentColor" stroke-width="0.6"/>
                    </svg>
                </span>
                <span class="font-display text-bone uppercase leading-none text-[1.05rem] sm:text-[1.15rem]" style="letter-spacing: 0.04em;">
                    circuito kitsune
                </span>
            </a>

            {{-- centro · título de sección actual + kanji sutil (solo desktop) --}}
            <div class="hidden lg:flex items-center gap-3 absolute left-1/2 -translate-x-1/2">
                <span class="font-cjk text-bone text-base leading-none" aria-hidden="true">狐</span>
                <span class="font-mono uppercase tracking-[0.32em] text-[0.7rem] text-bone-dim">
                    @if(request()->routeIs('home')) turno · noche
                    @elseif(request()->routeIs('products.*')) archivo · 06 identidades
                    @elseif(request()->routeIs('posts.*')) feed · transmisiones
                    @else circuito
                    @endif
                </span>
            </div>

            {{-- nav derecha --}}
            <nav aria-label="Navegación principal" class="flex items-center gap-5 sm:gap-8">
                <a href="{{ route('products.index') }}" class="font-mono uppercase tracking-[0.22em] text-[0.72rem] text-bone hover:text-ember transition-colors {{ request()->routeIs('products.*') ? 'text-ember' : '' }}">
                    archivo
                </a>
                <a href="{{ route('posts.index') }}" class="font-mono uppercase tracking-[0.22em] text-[0.72rem] text-bone hover:text-ember transition-colors hidden sm:inline {{ request()->routeIs('posts.*') ? 'text-ember' : '' }}">
                    transmisiones
                </a>
                <button @click="cartOpen = true" type="button" class="cart-button" aria-label="Abrir carrito">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                        <rect x="2" y="4" width="10" height="9" />
                        <path d="M5 4 V2.5 a2 2 0 0 1 4 0 V4" />
                    </svg>
                    <span class="hidden sm:inline">carrito</span>
                    <span class="cart-button__count">00</span>
                </button>
                <span class="brand-mark hidden lg:inline-block" aria-hidden="true">
                    <svg viewBox="0 0 56 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="28" cy="16" rx="26" ry="14" stroke="currentColor" stroke-width="1"/>
                        <line x1="2" y1="16" x2="54" y2="16" stroke="currentColor" stroke-width="1"/>
                        <line x1="28" y1="2" x2="28" y2="30" stroke="currentColor" stroke-width="1"/>
                        <ellipse cx="28" cy="16" rx="14" ry="14" stroke="currentColor" stroke-width="0.6"/>
                    </svg>
                </span>
            </nav>
        </div>
    </header>

    {{-- ───── MAIN ───────────────────────────────────────────────────── --}}
    <main id="main" class="relative">
        @yield('content')
    </main>

    {{-- ───── FOOTER compacto §3.1 ───────────────────────────────────── --}}
    <footer class="site-footer" role="contentinfo">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
            <div>
                <div class="text-bone-dim mb-3">▸ navegación</div>
                <ul class="space-y-1.5 normal-case tracking-normal">
                    <li><a href="{{ route('home') }}" class="text-bone hover:text-ember transition-colors">Turno noche</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-bone hover:text-ember transition-colors">Archivo de máscaras</a></li>
                    <li><a href="{{ route('posts.index') }}" class="text-bone hover:text-ember transition-colors">Transmisiones</a></li>
                </ul>
            </div>
            <div>
                <div class="text-bone-dim mb-3">▸ coordenadas</div>
                <div class="space-y-1.5">
                    <div>35.6762°N · 139.6503°E</div>
                    <div>turno · 22:00 → 05:00 jst</div>
                    <div>distritos · 06 activos</div>
                </div>
            </div>
            <div>
                <div class="text-bone-dim mb-3">▸ aviso</div>
                <p class="leading-relaxed normal-case tracking-normal">
                    El carrito está contemplado visualmente. La habilitación se abre en la próxima fase del circuito.
                </p>
            </div>
        </div>
        <div class="mt-10 pt-6 border-t border-ash flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <span>© {{ date('Y') }} circuito kitsune · proyecto académico</span>
            <span class="text-ember">{{ '#' . str_pad(dechex(crc32(date('Ymd'))), 6, '0', STR_PAD_LEFT) }}</span>
        </div>
    </footer>

    {{-- ───── CART DRAWER ────────────────────────────────────────────── --}}
    <x-cart-drawer />

    {{-- estilos críticos inline para fuentes (utility classes que Tailwind v4 sin config no detecta automáticamente) --}}
    <style>
        .font-display { font-family: var(--font-display); }
        .font-serif { font-family: var(--font-serif); }
        .font-cjk { font-family: var(--font-cjk); }
        .font-mono { font-family: var(--font-mono); }
        .text-bone { color: var(--color-bone); }
        .text-bone-dim { color: var(--color-bone-dim); }
        .text-ember { color: var(--color-ember); }
        .text-cyan { color: var(--color-cyan); }
        .text-ash { color: var(--color-ash); }
        .text-ink { color: var(--color-ink); }
        .text-ink-deep { color: var(--color-ink-deep); }
        .bg-bone { background-color: var(--color-bone); }
        .bg-ink { background-color: var(--color-ink); }
        .bg-ink-deep { background-color: var(--color-ink-deep); }
        .bg-ink-soft { background-color: var(--color-ink-soft); }
        .bg-ember { background-color: var(--color-ember); }
        .border-ash { border-color: var(--color-ash); }
        .border-ember { border-color: var(--color-ember); }
        .border-bone { border-color: var(--color-bone); }
        [x-cloak] { display: none !important; }
        .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
    </style>

    @stack('scripts')
</body>
</html>
