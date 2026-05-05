@extends('layouts.app')

@section('title', 'Transmisiones · Circuito Kitsune')
@section('section_label', 'FEED · ' . str_pad($posts->count(), 2, '0', STR_PAD_LEFT))
@section('meta_description', 'Transmisiones interceptadas del circuito. Guías, sistemas y novedades del turno noche.')

@php
    $kanjiNumbers = ['壱', '弐', '参', '肆', '伍'];
@endphp

@section('content')
    <section class="posts-hero" aria-labelledby="posts-heading">
        <x-system-tag :label="'FEED · ' . str_pad($posts->count(), 2, '0', STR_PAD_LEFT) . ' SEÑALES · EN LÍNEA'" pulse />
        <h1 id="posts-heading" class="posts-hero__title" data-reveal><span class="title-line">TRANSMISIONES</span><span class="title-line">INTERCEPTADAS.</span></h1>
        <p class="posts-hero__lede t-body-lg">
            Guías, sistemas y novedades del turno noche. Cada señal es archivada con hash propio.
        </p>
    </section>

    <section class="posts-feed" aria-label="Lista de transmisiones">
        <div class="posts-feed__inner">
            <ul class="feed-tx__list">
                @foreach($posts as $i => $post)
                    <li>
                        <a href="{{ route('posts.show', $post) }}" class="feed-tx__item">
                            <span class="feed-tx__item-kanji" aria-hidden="true">{{ $kanjiNumbers[$i] ?? '伍' }}</span>
                            <div class="feed-tx__item-body">
                                <span class="feed-tx__item-tag">[{{ strtoupper($post->category) }} · {{ $post->reading_time }} MIN]</span>
                                <h2 class="feed-tx__item-title">{{ strtoupper($post->title) }}</h2>
                                <p class="feed-tx__item-excerpt">{{ \Illuminate\Support\Str::limit($post->excerpt, 160) }}</p>
                                <span class="feed-tx__item-meta">{{ strtoupper($post->author) }} · {{ $post->formattedDate() }} · 0x{{ strtoupper(substr(md5($post->slug), 0, 6)) }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
