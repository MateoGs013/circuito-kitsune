@extends('layouts.app')

@section('title', 'Admin Blog · Circuito Kitsune')
@section('section_label', 'PANEL ADMIN · BLOG')

@section('content')
    <section class="admin-section" style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <x-system-tag label="SISTEMA CENTRAL · TRANSMISIONES" pulse />
                <h1 class="t-display-md" style="color: var(--color-bone);">GESTIÓN DE BLOG.</h1>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="bracket-cta bracket-cta--cyan" style="text-decoration: none;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ NUEVA TRANSMISIÓN</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </a>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>[ID]</th>
                        <th>[TÍTULO]</th>
                        <th>[AUTOR]</th>
                        <th>[CATEGORÍA]</th>
                        <th>[FECHA]</th>
                        <th>[ACCIONES]</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td style="color: var(--color-cyan); font-weight: 600;">#{{ $post->id }}</td>
                            <td>
                                <strong>{{ $post->title }}</strong>
                                @if($post->is_featured) <span class="admin-badge admin-badge--gold" style="margin-left: 0.5rem;">[DESTACADO]</span> @endif
                            </td>
                            <td style="color: var(--color-bone-dim);">{{ $post->author }}</td>
                            <td><span class="admin-badge admin-badge--cyan">{{ $post->category }}</span></td>
                            <td style="color: var(--color-bone-dim);">{{ $post->formattedDate() }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="admin-action-link admin-action-link--view">[VER]</a>
                                    <a href="{{ route('admin.posts.edit', $post->slug) }}" class="admin-action-link admin-action-link--edit">[EDITAR]</a>
                                    <a href="{{ route('admin.posts.delete', $post->id) }}" class="admin-action-link admin-action-link--delete">[ELIMINAR]</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
