@extends('layouts.app')

@section('title', 'Detalle de Usuario #' . $user->id . ' · Circuito Kitsune')
@section('section_label', 'PANEL ADMIN · DETALLE USUARIO')

@section('content')
    <section class="admin-card" style="max-width: 800px;">
        <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--br" aria-hidden="true"></span>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <x-system-tag label="EXPEDIENTE DE CORREDOR" pulse />
                <h1 class="t-display-sm" style="color: var(--color-bone);">{{ $user->name }}</h1>
                <div style="font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone-dim); margin-top: 0.75rem;">
                    [ID: #{{ $user->id }}] · [EMAIL: {{ $user->email }}] · [ROL: {{ strtoupper($user->role) }}]
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="bracket-cta bracket-cta--bone" style="text-decoration: none;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&lt;_ VOLVER AL REGISTRO</span>
                <span aria-hidden="true">]</span>
            </a>
        </div>

        <h2 class="t-title" style="color: var(--color-bone); margin-top: 3.5rem; margin-bottom: 2rem; font-family: var(--font-mono); font-size: var(--text-mono);">[ MÁSCARAS RESERVADAS / CONTRATADAS ]</h2>

        @if($user->products->isEmpty())
            <p style="font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone-dim); padding: 3rem 2rem; border: 1px dashed var(--color-ash); text-align: center;">
                Este corredor no posee reservas ni servicios contratados actualmente en el circuito.
            </p>
        @else
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($user->products as $product)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 2rem; background: var(--color-ink); border: 1px solid var(--color-ash); box-shadow: 0 0 15px rgba(0,0,0,0.3);">
                        <div>
                            <div style="font-family: var(--font-mono); font-size: var(--text-mono-xs); color: var(--color-cyan); margin-bottom: 0.5rem; font-weight: 600;">[CÓDIGO: {{ $product->code }}]</div>
                            <h3 style="font-size: 1.3rem; color: var(--color-bone); margin: 0; font-weight: 700;">{{ $product->name }}</h3>
                            <div style="font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone-dim); margin-top: 0.5rem;">
                                Distrito: {{ $product->district }} · Rareza: {{ $product->rarity }}
                            </div>
                        </div>
                        <div style="text-align: right; font-family: var(--font-mono);">
                            <div style="color: var(--color-gold); font-size: 1.25rem; font-weight: 700;">{{ $product->formattedPrice() }}</div>
                            <div style="font-size: var(--text-mono-xs); color: var(--color-bone-dim); margin-top: 0.5rem;">Fecha: {{ $product->pivot->created_at?->format('d/m/Y H:i') ?? 'N/A' }}</div>
                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" style="display: inline-block; margin-top: 0.75rem; font-size: var(--text-mono-xs); color: var(--color-cyan); text-decoration: none; font-weight: 600;">[VER FICHA →]</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
