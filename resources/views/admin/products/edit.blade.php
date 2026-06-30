@extends('layouts.app')

@section('title', 'Editar Máscara · Circuito Kitsune')
@section('section_label', 'PANEL ADMIN · EDITAR MÁSCARA')

@section('content')
    <section class="admin-card" style="max-width: 800px;">
        <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--br" aria-hidden="true"></span>

        <x-system-tag label="CENTRAL · EDICIÓN DE MÁSCARA" pulse />
        <h1 class="t-display-sm" style="color: var(--color-bone); margin-bottom: 2.5rem;">EDITAR MÁSCARA #{{ $product->id }}.</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate style="display: flex; flex-direction: column; gap: 2rem;">
            @csrf
            @method('PUT')
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div>
                    <label for="name" class="admin-label">[ NOMBRE ]</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="admin-input @error('name') is-invalid @enderror" @error('name') aria-invalid="true" aria-errormessage="error-name" @enderror>
                    @error('name')
                        <div id="error-name" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="code" class="admin-label">[ CÓDIGO ]</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $product->code) }}" class="admin-input @error('code') is-invalid @enderror" @error('code') aria-invalid="true" aria-errormessage="error-code" @enderror>
                    @error('code')
                        <div id="error-code" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <label for="category" class="admin-label">[ CATEGORÍA ]</label>
                    <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" class="admin-input @error('category') is-invalid @enderror" @error('category') aria-invalid="true" aria-errormessage="error-category" @enderror>
                    @error('category')
                        <div id="error-category" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="rarity" class="admin-label">[ RAREZA ]</label>
                    <input type="text" name="rarity" id="rarity" value="{{ old('rarity', $product->rarity) }}" class="admin-input @error('rarity') is-invalid @enderror" @error('rarity') aria-invalid="true" aria-errormessage="error-rarity" @enderror>
                    @error('rarity')
                        <div id="error-rarity" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="district" class="admin-label">[ DISTRITO ]</label>
                    <input type="text" name="district" id="district" value="{{ old('district', $product->district) }}" class="admin-input @error('district') is-invalid @enderror" @error('district') aria-invalid="true" aria-errormessage="error-district" @enderror>
                    @error('district')
                        <div id="error-district" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <label for="price" class="admin-label">[ PRECIO (CRÉDITOS) ]</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="admin-input @error('price') is-invalid @enderror" @error('price') aria-invalid="true" aria-errormessage="error-price" @enderror>
                    @error('price')
                        <div id="error-price" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="status" class="admin-label">[ ESTADO ]</label>
                    <select name="status" id="status" class="admin-input @error('status') is-invalid @enderror" @error('status') aria-invalid="true" aria-errormessage="error-status" @enderror>
                        <option value="disponible" @if(old('status', $product->status) === 'disponible') selected @endif>Disponible</option>
                        <option value="próxima" @if(old('status', $product->status) === 'próxima') selected @endif>Próxima</option>
                        <option value="agotada" @if(old('status', $product->status) === 'agotada') selected @endif>Agotada</option>
                    </select>
                    @error('status')
                        <div id="error-status" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="dominant_color" class="admin-label">[ COLOR DOMINANTE ]</label>
                    <select name="dominant_color" id="dominant_color" class="admin-input @error('dominant_color') is-invalid @enderror" @error('dominant_color') aria-invalid="true" aria-errormessage="error-dominant-color" @enderror>
                        <option value="cyan" @if(old('dominant_color', $product->dominant_color) === 'cyan') selected @endif>Cyan</option>
                        <option value="red" @if(old('dominant_color', $product->dominant_color) === 'red') selected @endif>Red</option>
                        <option value="violet" @if(old('dominant_color', $product->dominant_color) === 'violet') selected @endif>Violet</option>
                        <option value="gold" @if(old('dominant_color', $product->dominant_color) === 'gold') selected @endif>Gold</option>
                        <option value="magenta" @if(old('dominant_color', $product->dominant_color) === 'magenta') selected @endif>Magenta</option>
                        <option value="blue" @if(old('dominant_color', $product->dominant_color) === 'blue') selected @endif>Blue</option>
                    </select>
                    @error('dominant_color')
                        <div id="error-dominant-color" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="short_description" class="admin-label">[ DESCRIPCIÓN CORTA ]</label>
                <textarea name="short_description" id="short_description" rows="2" class="admin-input @error('short_description') is-invalid @enderror" @error('short_description') aria-invalid="true" aria-errormessage="error-short-desc" @enderror>{{ old('short_description', $product->short_description) }}</textarea>
                @error('short_description')
                    <div id="error-short-desc" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="long_description" class="admin-label">[ DESCRIPCIÓN LARGA / PROTOCOLO ]</label>
                <textarea name="long_description" id="long_description" rows="6" class="admin-input @error('long_description') is-invalid @enderror" @error('long_description') aria-invalid="true" aria-errormessage="error-long-desc" @enderror>{{ old('long_description', $product->long_description) }}</textarea>
                @error('long_description')
                    <div id="error-long-desc" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                <div>
                    <label for="signal_level" class="admin-label">[ SEÑAL (0-99) ]</label>
                    <input type="number" name="signal_level" id="signal_level" value="{{ old('signal_level', $product->signal_level) }}" min="0" max="99" class="admin-input @error('signal_level') is-invalid @enderror" @error('signal_level') aria-invalid="true" aria-errormessage="error-signal" @enderror>
                    @error('signal_level')
                        <div id="error-signal" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="agility" class="admin-label">[ AGILIDAD (0-99) ]</label>
                    <input type="number" name="agility" id="agility" value="{{ old('agility', $product->agility) }}" min="0" max="99" class="admin-input @error('agility') is-invalid @enderror" @error('agility') aria-invalid="true" aria-errormessage="error-agility" @enderror>
                    @error('agility')
                        <div id="error-agility" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="spirit" class="admin-label">[ ESPÍRITU (0-99) ]</label>
                    <input type="number" name="spirit" id="spirit" value="{{ old('spirit', $product->spirit) }}" min="0" max="99" class="admin-input @error('spirit') is-invalid @enderror" @error('spirit') aria-invalid="true" aria-errormessage="error-spirit" @enderror>
                    @error('spirit')
                        <div id="error-spirit" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="ferocity" class="admin-label">[ FEROCIDAD (0-99) ]</label>
                    <input type="number" name="ferocity" id="ferocity" value="{{ old('ferocity', $product->ferocity) }}" min="0" max="99" class="admin-input @error('ferocity') is-invalid @enderror" @error('ferocity') aria-invalid="true" aria-errormessage="error-ferocity" @enderror>
                    @error('ferocity')
                        <div id="error-ferocity" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="image" class="admin-label">[ IMAGEN ADJUNTA (DEJAR VACÍO PARA MANTENER LA ACTUAL) ]</label>
                @if($product->image_path)
                    <div style="margin-bottom: 1.5rem;">
                        <img src="{{ asset($product->image_path) }}" alt="Imagen actual" style="max-width: 200px; border: 1px solid var(--color-ash); background: var(--color-ink-deep);">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="admin-input @error('image') is-invalid @enderror" @error('image') aria-invalid="true" aria-errormessage="error-image" @enderror>
                @error('image')
                    <div id="error-image" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label style="display: flex; align-items: center; gap: 0.75rem; font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone); cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1" @if(old('is_featured', $product->is_featured)) checked @endif style="accent-color: var(--color-cyan); width: 18px; height: 18px;">
                    [ MARCAR COMO DESTACADO EN INICIO ]
                </label>
            </div>

            <button type="submit" class="bracket-cta bracket-cta--cyan" style="background: none; border: none; cursor: pointer; width: 100%; justify-content: space-between; margin-top: 1rem;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ ACTUALIZAR MÁSCARA (GUARDAR)</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </button>
        </form>
    </section>
@endsection
