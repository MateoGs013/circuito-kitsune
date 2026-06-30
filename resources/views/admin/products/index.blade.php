@extends('layouts.app')

@section('title', 'Admin Máscaras · Circuito Kitsune')
@section('section_label', 'PANEL ADMIN · MÁSCARAS')

@section('content')
    <section class="admin-section" style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <x-system-tag label="SISTEMA CENTRAL · MÁSCARAS" pulse />
                <h1 class="t-display-md" style="color: var(--color-bone);">GESTIÓN DE MÁSCARAS.</h1>
            </div>
            <a href="{{ route('admin.products.create') }}" class="bracket-cta bracket-cta--cyan" style="text-decoration: none;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ NUEVA MÁSCARA</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>[ID]</th>
                        <th>[IMAGEN]</th>
                        <th>[NOMBRE]</th>
                        <th>[CÓDIGO]</th>
                        <th>[ESTADO]</th>
                        <th>[PRECIO]</th>
                        <th>[ACCIONES]</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td style="color: var(--color-cyan); font-weight: 600;">#{{ $product->id }}</td>
                            <td>
                                @if($product->image_path)
                                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; object-fit: contain; background: var(--color-ink-deep); border: 1px solid var(--color-ash);">
                                @else
                                    <div style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; background: var(--color-ink-deep); border: 1px solid var(--color-ash); font-size: 0.7rem; color: var(--color-bone-dim);">SIN IMG</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->is_featured) <span class="admin-badge admin-badge--gold" style="margin-left: 0.5rem;">[DESTACADO]</span> @endif
                            </td>
                            <td style="color: var(--color-bone-dim);">{{ $product->code }}</td>
                            <td>
                                <span class="admin-badge @if($product->status === 'disponible') admin-badge--cyan @else admin-badge--ember @endif">{{ strtoupper($product->status) }}</span>
                            </td>
                            <td style="color: var(--color-bone-dim);">{{ $product->formattedPrice() }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="admin-action-link admin-action-link--view">[VER]</a>
                                    <a href="{{ route('admin.products.edit', $product->slug) }}" class="admin-action-link admin-action-link--edit">[EDITAR]</a>
                                    <a href="{{ route('admin.products.delete', $product->id) }}" class="admin-action-link admin-action-link--delete">[ELIMINAR]</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
