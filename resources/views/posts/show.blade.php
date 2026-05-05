@extends('layouts.app')

@section('title', $post->title . ' · Circuito Kitsune')
@section('section_label', 'SEÑAL · ' . str_pad($post->id, 3, '0', STR_PAD_LEFT))
@section('meta_description', $post->excerpt)

@php
    $hash = '0x' . strtoupper(substr(md5($post->slug), 0, 6));
    $finalHash = '0x' . strtoupper(substr(md5($post->slug . $post->id), 0, 8));
    $bodyParagraphs = $post->formattedBody();
@endphp

@section('content')
    <article class="post-article">
        <div class="post-article__inner">
            <x-system-tag :label="'SEÑAL ' . str_pad($post->id, 3, '0', STR_PAD_LEFT) . ' · ' . strtoupper($post->category) . ' · ' . $post->reading_time . ' MIN'" pulse />

            <h1 class="post-article__title" data-reveal>{{ strtoupper($post->title) }}.</h1>

            <div class="post-article__meta">
                <span>autor<strong style="margin-left: 0.3em;">{{ strtoupper($post->author) }}</strong></span>
                <span>fecha<strong style="margin-left: 0.3em;">{{ $post->formattedDate() }}</strong></span>
                <span>hash<strong style="margin-left: 0.3em;">{{ $hash }}</strong></span>
                <span>lectura<strong style="margin-left: 0.3em;">{{ $post->reading_time }} MIN</strong></span>
            </div>

            <blockquote class="post-article__pull">{{ $post->excerpt }}</blockquote>

            <div class="post-article__body">
                @forelse($bodyParagraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                @empty
                    <p>{{ $post->excerpt }}</p>
                @endforelse
            </div>

            <hr class="post-article__divider" aria-hidden="true">

            <p class="post-article__footer">fin de la transmisión · {{ $finalHash }}</p>

            <div class="post-article__back-row">
                <x-bracket-cta :href="route('posts.index')" variant="ember">← VOLVER A TRANSMISIONES</x-bracket-cta>
            </div>
        </div>
    </article>
@endsection
