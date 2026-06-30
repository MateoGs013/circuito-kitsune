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
@php
    $cartItems = auth()->check() ? auth()->user()->products()->wherePivot('status', 'activa')->get() : collect();
    $cartItemsJson = $cartItems->map(function($item) {
        return [
            'id' => $item->id,
            'code' => $item->code,
            'name' => $item->name,
            'price' => $item->price,
    $cartTotal = $cartItems->sum('price');
@endphp
<body x-data="{ cartOpen: {{ session()->has('cartOpen') ? 'true' : 'false' }} }">

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
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.posts.index') }}" class="site-header__link" @if(str_starts_with($currentRoute ?? '', 'admin.posts')) aria-current="page" @endif>
                        [ADMIN: BLOG]
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="site-header__link" @if(str_starts_with($currentRoute ?? '', 'admin.products')) aria-current="page" @endif>
                        [ADMIN: MÁSCARAS]
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="site-header__link" @if(str_starts_with($currentRoute ?? '', 'admin.users')) aria-current="page" @endif>
                        [ADMIN: USUARIOS]
                    </a>
                @endif
                <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="site-header__link" style="background: none; border: none; cursor: pointer; font-family: inherit; font-size: inherit; color: var(--color-ember);">
                        [SALIR: {{ strtoupper(explode('@', auth()->user()->email)[0]) }}]
                    </button>
                </form>
            @else
                <a href="{{ route('auth.login') }}" class="site-header__link" @if($currentRoute === 'auth.login') aria-current="page" @endif>
                    [INGRESAR]
                </a>
                <a href="{{ route('auth.register') }}" class="site-header__link" @if($currentRoute === 'auth.register') aria-current="page" @endif>
                    [REGISTRARSE]
                </a>
            @endauth
            <button type="button"
                    class="site-header__cart"
                    @click="cartOpen = true"
                    aria-label="Abrir carrito">
                <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                    <rect x="2" y="4" width="10" height="9"/>
                    <path d="M5 4 V2.5 a2 2 0 0 1 4 0 V4"/>
                </svg>
                <span class="site-header__cart-label"><span class="site-header__cart-label-full">[ CARRITO {{ str_pad(isset($cartItems) ? $cartItems->count() : 0, 2, '0', STR_PAD_LEFT) }} ]</span></span>
            </button>
        </nav>
    </div>
</header>

<main id="main">
    @if (session()->has('feedback.message'))
        <div class="system-alert system-alert--{{ session()->get('feedback.type', 'success') }}" style="padding: 1rem 2rem; background-color: var(--color-ink); border-bottom: 1px solid var(--color-{{ session()->get('feedback.type', 'success') }}); color: var(--color-{{ session()->get('feedback.type', 'success') }}); font-family: 'IBM Plex Mono', monospace; text-align: center; letter-spacing: 1px;">
            <span aria-hidden="true">&gt;_</span> {!! session()->get('feedback.message') !!}
        </div>
    @endif
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
    <x-system-tag :label="'CARRITO · ' . str_pad(isset($cartItems) ? $cartItems->count() : 0, 2, '0', STR_PAD_LEFT) . ' EXPEDIENTES'" pulse />
    
    @if(!isset($cartItems) || $cartItems->isEmpty())
        <h2 id="cart-title" class="t-display-md" style="color: var(--color-bone); margin-top: 1.5rem;">
            <span class="title-line">Tu archivo</span><span class="title-line">está vacío.</span>
        </h2>
        <p class="t-body" style="color: var(--color-bone-dim); margin-bottom: 2rem;">
            No tenés señales reservadas en este turno. Explorá el archivo para asegurar tu máscara.
        </p>
        <a href="{{ route('products.index') }}"
           class="bracket-cta bracket-cta--ember"
           @click="cartOpen = false"
           style="text-decoration: none;">
            <span aria-hidden="true">[</span>
            <span class="bracket-cta__text">VER EL ARCHIVO</span>
            <span aria-hidden="true">]</span>
            <span class="bracket-cta__arrow">→</span>
        </a>
    @else
        <h2 id="cart-title" class="t-display-md" style="color: var(--color-bone); margin-top: 1.5rem; margin-bottom: 2rem;">
            SEÑALES RESERVADAS.
        </h2>
        
        <div style="display: flex; flex-direction: column; gap: 1rem; flex: 1; overflow-y: auto; padding-right: 0.5rem; margin-bottom: 1rem;">
            @foreach($cartItems as $item)
                <div style="display: flex; gap: 1rem; padding: 1rem; background: var(--color-ink-deep); border: 1px solid var(--color-ash);">
                    @if($item->hasImage())
                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" style="width: 60px; height: 60px; object-fit: contain; background: #000; border: 1px solid var(--color-ash);">
                    @else
                        <div style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; background: #000; border: 1px solid var(--color-ash); font-size: 0.6rem; color: var(--color-bone-dim);">SIN IMG</div>
                    @endif
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                        <span style="font-family: var(--font-mono); font-size: var(--text-mono-xs); color: var(--color-{{ $item->dominant_color ?? 'cyan' }});">[{{ $item->code }}]</span>
                        <strong style="color: var(--color-bone); font-size: 0.9rem; text-transform: uppercase; line-height: 1.2; margin: 0.2rem 0;">{{ $item->name }}</strong>
                        <span style="font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone-dim);">{{ $item->formattedPrice() }}</span>
                    </div>
                    <form action="{{ route('products.reserve.cancel', $item->id) }}" method="POST" style="display: flex; align-items: center;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" aria-label="Eliminar reserva" style="background: none; border: none; color: var(--color-ember); cursor: pointer; font-size: 1.2rem; padding: 0.5rem; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">✕</button>
                    </form>
                </div>
            @endforeach
        </div>
        
        <div style="margin-top: auto; border-top: 1px dashed var(--color-ash); padding-top: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-family: var(--font-mono); color: var(--color-bone);">
                <span style="font-size: var(--text-mono-sm); color: var(--color-bone-dim);">[ TOTAL ESTIMADO ]</span>
                <strong style="font-size: 1.2rem; color: var(--color-cyan);">${{ number_format($cartTotal, 0, ',', '.') }} CRD</strong>
            </div>
            <button class="bracket-cta bracket-cta--cyan" style="width: 100%; justify-content: space-between; background: none; border: none; cursor: pointer;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ PROCESAR PAGO</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </button>
        </div>
    @endif
</aside>

@stack('scripts')
</html>
