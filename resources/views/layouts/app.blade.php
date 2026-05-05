@php
    $buildHash = '0x' . strtoupper(substr(md5(date('Ymd-Hi')), 0, 6));
    $version = 'V.' . date('y.m');
    $coords = '35.6762°N · 139.6503°E';
    $currentRoute = request()->route()?->getName();
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#14171F">
    <meta name="description" content="@yield('meta_description', 'Tienda clandestina de máscaras japonesas cyberpunk. Cada noche, una máscara, un distrito.')">

    <title>@yield('title', 'Circuito Kitsune') · turno noche</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=IBM+Plex+Mono:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Shippori+Mincho+B1:wght@400;500;700&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ cartOpen: false }">

<a href="#main" class="skip-link">Saltar al contenido</a>

<header role="banner" class="site-header">
    <div class="site-header__inner">
        <a href="{{ route('home') }}" class="site-header__brand" aria-label="Circuito Kitsune · inicio">
            <svg class="site-header__globe" viewBox="0 0 56 32" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true">
                <ellipse cx="28" cy="16" rx="26" ry="14"/>
                <line x1="2" y1="16" x2="54" y2="16"/>
                <line x1="28" y1="2" x2="28" y2="30"/>
                <ellipse cx="28" cy="16" rx="14" ry="14" stroke-width="0.6"/>
            </svg>
            <span class="site-header__brand-label">CIRCUITO KITSUNE</span>
        </a>

        <div class="site-header__center" aria-hidden="true">
            <span class="site-header__kanji">狐</span>
            <span>@yield('section_label', 'TURNO · NOCHE')</span>
            <span>· {{ $coords }}</span>
        </div>

        <nav class="site-header__nav" aria-label="Navegación principal">
            <a href="{{ route('products.index') }}"
               class="site-header__link"
               @if(in_array($currentRoute, ['products.index', 'products.show'])) aria-current="page" @endif>
                ARCHIVO
            </a>
            <a href="{{ route('posts.index') }}"
               class="site-header__link"
               @if(in_array($currentRoute, ['posts.index', 'posts.show'])) aria-current="page" @endif>
                TRANSMISIONES
            </a>
            <button type="button"
                    class="site-header__cart"
                    @click="cartOpen = true"
                    aria-label="Abrir carrito">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                    <rect x="2" y="4" width="10" height="9"/>
                    <path d="M5 4 V2.5 a2 2 0 0 1 4 0 V4"/>
                </svg>
                <span class="site-header__cart-label"><span class="site-header__cart-label-full">[ CARRITO 00 ]</span></span>
            </button>
        </nav>
    </div>
</header>

<main id="main">
    @yield('content')
</main>

<footer role="contentinfo" class="site-footer">
    <div class="site-footer__grid">
        <div class="site-footer__col">
            <h3>NAVEGACIÓN</h3>
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('products.index') }}">Archivo de máscaras</a></li>
                <li><a href="{{ route('posts.index') }}">Transmisiones</a></li>
            </ul>
        </div>
        <div class="site-footer__col">
            <h3>COORDENADAS</h3>
            <ul>
                <li>{{ $coords }}</li>
                <li>TURNO NOCHE · 02:45 JST</li>
                <li>SEÑAL ABIERTA</li>
            </ul>
        </div>
        <div class="site-footer__col">
            <h3>CARRITO</h3>
            <ul>
                <li>El carrito se abre en la próxima fase del circuito.</li>
                <li>Por ahora podés explorar el archivo y reservar tu señal.</li>
            </ul>
        </div>
    </div>
    <div class="site-footer__bottom">
        <span>© {{ date('Y') }} CIRCUITO KITSUNE · TP ACADÉMICO</span>
        <span>{{ $version }} · BUILD · <span class="hash">{{ $buildHash }}</span></span>
    </div>
</footer>

<div x-cloak
     x-show="cartOpen"
     x-transition.opacity
     class="cart-backdrop"
     @click="cartOpen = false"
     aria-hidden="true"></div>

<aside x-cloak
       x-show="cartOpen"
       x-transition:enter="transition ease-out duration-500"
       x-transition:enter-start="translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-300"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="translate-x-full"
       class="cart-drawer"
       role="dialog"
       aria-modal="true"
       aria-labelledby="cart-title"
       @keydown.escape.window="cartOpen = false">
    <button type="button"
            class="cart-drawer__close"
            @click="cartOpen = false"
            aria-label="Cerrar carrito">
        CERRAR ✕
    </button>
    <x-system-tag label="CARRITO · 00 EXPEDIENTES" pulse />
    <h2 id="cart-title" class="t-display-md" style="color: var(--color-bone);">
        <span class="title-line">Tu archivo</span><span class="title-line">está vacío.</span>
    </h2>
    <p class="t-body" style="color: var(--color-bone-dim);">
        El carrito se abre en la próxima fase del circuito. Por ahora podés explorar las máscaras del archivo y reservar señales.
    </p>
    <a href="{{ route('products.index') }}"
       class="bracket-cta bracket-cta--ember"
       @click="cartOpen = false">
        <span>[</span><span>VER EL ARCHIVO</span><span>]</span>
        <span class="bracket-cta__arrow">→</span>
    </a>
</aside>

@stack('scripts')
</body>
</html>
