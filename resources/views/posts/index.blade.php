@extends('layouts.app')

@section('title', 'Transmisiones')

@section('content')
    <h1>Transmisiones</h1>

    <ul>
        @foreach($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                — {{ $post->category }} · {{ $post->author }} · {{ $post->formattedDate() }} · {{ $post->readingTimeLabel() }}
                <p>{{ $post->excerpt }}</p>
            </li>
        @endforeach
    </ul>
@endsection
