@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <p><a href="{{ route('products.index') }}">← Volver al archivo</a></p>

    <h1>{{ $product->name }}</h1>

    <p>{{ $product->code }} · {{ $product->district }} · {{ $product->rarityLabel() }} · {{ $product->statusLabel() }}</p>

    <p>{{ $product->short_description }}</p>

    <h2>Atributos</h2>
    <ul>
        <li>Señal: {{ $product->signal_level }}</li>
        <li>Agilidad: {{ $product->agility }}</li>
        <li>Espíritu: {{ $product->spirit }}</li>
        <li>Ferocidad: {{ $product->ferocity }}</li>
    </ul>

    <h2>Protocolo</h2>
    <p>{{ $product->long_description }}</p>

    <h2>Acción</h2>
    <p>Precio: {{ $product->formattedPrice() }}</p>
    @if($product->isAvailable())
        <button type="button">Reservar</button>
    @else
        <button type="button" disabled>{{ $product->statusLabel() }}</button>
    @endif
    <p><small>El carrito se abre en la próxima fase del circuito.</small></p>
@endsection
