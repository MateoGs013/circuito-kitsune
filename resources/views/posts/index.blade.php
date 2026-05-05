@extends('layouts.app')

@section('title', 'Transmisiones · pendiente')

@section('content')
<section class="min-h-screen flex items-center justify-center px-6">
    <div class="text-center">
        <x-system-tag class="mb-4">▸ STUB</x-system-tag>
        <h1 class="font-display italic text-bone text-5xl">Transmisiones</h1>
        <p class="text-bone-dim mt-4 font-mono uppercase tracking-[0.22em] text-xs">{{ count($posts ?? []) }} señales</p>
    </div>
</section>
@endsection
