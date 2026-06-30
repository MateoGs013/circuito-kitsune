@extends('layouts.app')

@section('title', 'Registrarse · Circuito Kitsune')
@section('section_label', 'PROTOCOLO · REGISTRO')
@section('meta_description', 'Registrá tu firma digital para reservar máscaras y acceder a los distritos del circuito nocturno.')

@section('content')
    <section class="admin-card" style="max-width: 500px;">
        <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--br" aria-hidden="true"></span>

        <x-system-tag label="CREACIÓN DE IDENTIDAD" pulse />
        <h1 class="t-display-sm" style="color: var(--color-bone); margin-bottom: 2.5rem;">REGISTRAR FIRMA.</h1>

        <form action="{{ route('auth.store') }}" method="POST" novalidate style="display: flex; flex-direction: column; gap: 2rem;">
            @csrf
            <div>
                <label for="name" class="admin-label">[ ALIAS / NOMBRE ]</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="admin-input @error('name') is-invalid @enderror" @error('name') aria-invalid="true" aria-errormessage="error-name" @enderror>
                @error('name')
                    <div id="error-name" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="email" class="admin-label">[ IDENTIFICADOR / EMAIL ]</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="admin-input @error('email') is-invalid @enderror" @error('email') aria-invalid="true" aria-errormessage="error-email" @enderror>
                @error('email')
                    <div id="error-email" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password" class="admin-label">[ CLAVE DE SEÑAL / PASSWORD ]</label>
                <input type="password" name="password" id="password" class="admin-input @error('password') is-invalid @enderror" @error('password') aria-invalid="true" aria-errormessage="error-password" @enderror>
                @error('password')
                    <div id="error-password" style="color: var(--color-ember); font-family: var(--font-mono); font-size: var(--text-mono-xs); margin-top: 0.5rem;">&gt;_ {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="bracket-cta bracket-cta--ember" style="background: none; border: none; cursor: pointer; width: 100%; justify-content: space-between; margin-top: 1rem;">
                <span aria-hidden="true">[</span>
                <span class="bracket-cta__text">&gt;_ ENCRIPTAR FIRMA</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </button>
        </form>

        <p style="margin-top: 2.5rem; font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone-dim); text-align: center;">
            ¿Ya tenés cuenta? <a href="{{ route('auth.login') }}" style="color: var(--color-cyan); text-decoration: none; font-weight: 600;">Iniciar sesión</a>
        </p>
    </section>
@endsection
