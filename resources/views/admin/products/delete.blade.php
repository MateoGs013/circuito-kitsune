@extends('layouts.app')

@section('title', 'Eliminar Máscara · Circuito Kitsune')
@section('section_label', 'PANEL ADMIN · ELIMINAR MÁSCARA')

@section('content')
    <section class="admin-card" style="max-width: 600px; border-color: var(--color-ember);">
        <span class="frame-corner frame-corner--tl" aria-hidden="true" style="border-color: var(--color-ember);"></span>
        <span class="frame-corner frame-corner--tr" aria-hidden="true" style="border-color: var(--color-ember);"></span>
        <span class="frame-corner frame-corner--bl" aria-hidden="true" style="border-color: var(--color-ember);"></span>
        <span class="frame-corner frame-corner--br" aria-hidden="true" style="border-color: var(--color-ember);"></span>

        <x-system-tag label="ADVERTENCIA DE SISTEMA · PURGA" pulse />
        <h1 class="t-display-sm" style="color: var(--color-bone); margin-bottom: 1.5rem;">¿ELIMINAR MÁSCARA?</h1>
        <p style="font-family: var(--font-mono); color: var(--color-bone-dim); margin-bottom: 2.5rem; font-size: var(--text-mono-sm);">
            Estás por eliminar permanentemente la máscara <strong>"{{ $product->name }}"</strong> ({{ $product->code }}). Esta acción destruirá la entrada del archivo y purgará los registros y la imagen asociada en el circuito.
        </p>

        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
            @csrf
            @method('DELETE')
            <button type="submit" class="bracket-cta bracket-cta--ember" style="background: none; border: none; cursor: pointer; flex: 1; min-width: 200px; justify-content: space-between;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ CONFIRMAR PURGA</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </button>
            <a href="{{ route('admin.products.index') }}" class="bracket-cta bracket-cta--bone" style="flex: 1; min-width: 200px; text-decoration: none; justify-content: space-between; text-align: center;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">CANCELAR</span>
                <span aria-hidden="true">]</span>
            </a>
        </form>
    </section>
@endsection
