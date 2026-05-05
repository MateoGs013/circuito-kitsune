<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Circuito Kitsune')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <a href="{{ route('home') }}">Circuito Kitsune</a>
        <nav>
            <a href="{{ route('products.index') }}">Archivo</a>
            <a href="{{ route('posts.index') }}">Transmisiones</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <small>© {{ date('Y') }} Circuito Kitsune · proyecto académico</small>
    </footer>
</body>
</html>
