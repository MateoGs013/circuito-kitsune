@extends('layouts.app')

@section('title', 'Archivo de máscaras')

@section('content')
    <h1>Archivo de máscaras</h1>

    <p>{{ $totalCount }} expedientes en total. Filtro activo: {{ $activeFilter ?? 'ninguno' }}</p>

    <nav>
        <a href="{{ route('products.index') }}">Todos</a>
        <a href="{{ route('products.index', ['filter' => 'disponibles']) }}">Disponibles</a>
        <a href="{{ route('products.index', ['filter' => 'proximas']) }}">Próximas</a>
        <a href="{{ route('products.index', ['filter' => 'agotadas']) }}">Agotadas</a>
        <a href="{{ route('products.index', ['filter' => 'raras']) }}">Raras</a>
        <a href="{{ route('products.index', ['filter' => 'legendarias']) }}">Legendarias</a>
    </nav>

    <ul>
        @foreach($products as $product)
            <li>
                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                — {{ $product->code }} · {{ $product->district }} · {{ $product->rarityLabel() }} · {{ $product->statusLabel() }} · {{ $product->formattedPrice() }}
            </li>
        @endforeach
    </ul>
@endsection
