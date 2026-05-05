@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <p><a href="{{ route('posts.index') }}">← Volver a transmisiones</a></p>

    <h1>{{ $post->title }}</h1>

    <p>{{ $post->category }} · {{ $post->author }} · {{ $post->formattedDate() }} · {{ $post->readingTimeLabel() }}</p>

    <blockquote>{{ $post->excerpt }}</blockquote>

    @foreach($post->formattedBody() as $paragraph)
        <p>{{ $paragraph }}</p>
    @endforeach
@endsection
