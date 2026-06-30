@extends('layouts.app')

@section('title', 'Nueva Transmisión · Circuito Kitsune')
@section('section_label', 'PANEL ADMIN · NUEVO BLOG')

@section('content')
    <section class="admin-card" style="max-width: 800px;">
        <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--br" aria-hidden="true"></span>

        <x-system-tag label="CENTRAL · PUBLICACIÓN" pulse />
        <h1 class="t-display-sm" style="color: var(--color-bone); margin-bottom: 2.5rem;">CREAR TRANSMISIÓN.</h1>

        <form action="{{ route('admin.posts.store') }}" method="POST" novalidate style="display: flex; flex-direction: column; gap: 2rem;">
            @csrf
            <div>
                <label for="title" class="admin-label">[ TÍTULO ]</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="admin-input @error('title') is-invalid @enderror" @error('title') aria-invalid="true" aria-errormessage="error-title" @enderror>
                @error('title')
                    <div id="error-title" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="excerpt" class="admin-label">[ RESUMEN / EXCERPT ]</label>
                <textarea name="excerpt" id="excerpt" rows="2" class="admin-input @error('excerpt') is-invalid @enderror" @error('excerpt') aria-invalid="true" aria-errormessage="error-excerpt" @enderror>{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <div id="error-excerpt" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="body" class="admin-label">[ CONTENIDO PRINCIPAL / BODY ]</label>
                <textarea name="body" id="body" rows="8" class="admin-input @error('body') is-invalid @enderror" @error('body') aria-invalid="true" aria-errormessage="error-body" @enderror>{{ old('body') }}</textarea>
                @error('body')
                    <div id="error-body" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <label for="category" class="admin-label">[ CATEGORÍA ]</label>
                    <input type="text" name="category" id="category" value="{{ old('category', 'PROYECTOS') }}" class="admin-input @error('category') is-invalid @enderror" @error('category') aria-invalid="true" aria-errormessage="error-category" @enderror>
                    @error('category')
                        <div id="error-category" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="author" class="admin-label">[ AUTOR ]</label>
                    <input type="text" name="author" id="author" value="{{ old('author', auth()->user()->name) }}" class="admin-input @error('author') is-invalid @enderror" @error('author') aria-invalid="true" aria-errormessage="error-author" @enderror>
                    @error('author')
                        <div id="error-author" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <label for="reading_time" class="admin-label">[ TIEMPO DE LECTURA (MIN) ]</label>
                    <input type="number" name="reading_time" id="reading_time" value="{{ old('reading_time', 3) }}" class="admin-input @error('reading_time') is-invalid @enderror" @error('reading_time') aria-invalid="true" aria-errormessage="error-reading-time" @enderror>
                    @error('reading_time')
                        <div id="error-reading-time" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="cover_tone" class="admin-label">[ TONO VISUAL ]</label>
                    <select name="cover_tone" id="cover_tone" class="admin-input @error('cover_tone') is-invalid @enderror" @error('cover_tone') aria-invalid="true" aria-errormessage="error-cover-tone" @enderror>
                        <option value="cyan" @if(old('cover_tone') === 'cyan') selected @endif>Cyan</option>
                        <option value="magenta" @if(old('cover_tone') === 'magenta') selected @endif>Magenta</option>
                        <option value="red" @if(old('cover_tone') === 'red') selected @endif>Red</option>
                        <option value="gold" @if(old('cover_tone') === 'gold') selected @endif>Gold</option>
                        <option value="neutral" @if(old('cover_tone') === 'neutral') selected @endif>Neutral</option>
                    </select>
                    @error('cover_tone')
                        <div id="error-cover-tone" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label style="display: flex; align-items: center; gap: 0.75rem; font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone); cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" @if(old('is_featured')) checked @endif style="accent-color: var(--color-cyan); width: 18px; height: 18px;">
                    [ MARCAR COMO DESTACADO EN INICIO ]
                </label>
            </div>

            <button type="submit" class="bracket-cta bracket-cta--cyan" style="background: none; border: none; cursor: pointer; width: 100%; justify-content: space-between; margin-top: 1rem;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ EMITIR SEÑAL (PUBLICAR)</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </button>
        </form>
    </section>
@endsection

