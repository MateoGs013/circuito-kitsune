@extends('layouts.app')

@section('title', 'Circuito Kitsune · turno noche')

@section('content')
    <h1>Circuito Kitsune</h1>

    <section>
        <h2>Máscaras del archivo</h2>
        <ul>
            @foreach($circuitProducts as $product)
                <li>
                    <a href="{{ route('products.show', $product) }}">
                        {{ $product->name }}
                    </a>
                    — {{ $product->code }} · {{ $product->statusLabel() }} · {{ $product->formattedPrice() }}
                </li>
            @endforeach
        </ul>
    </section>

    <section>
        <h2>Transmisiones destacadas</h2>
        <ul>
            @foreach($featuredPosts as $post)
                <li>
                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    — {{ $post->category }} · {{ $post->formattedDate() }}
                </li>
            @endforeach
        </ul>
    </section>
@endsection
