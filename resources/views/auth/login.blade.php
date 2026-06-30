@extends('layouts.app')

@section('title', 'Iniciar Sesión · Circuito Kitsune')
@section('section_label', 'PROTOCOLO · ACCESO')
@section('meta_description', 'Iniciá sesión para acceder a tu archivo de máscaras y reservar señales en el circuito nocturno.')

@section('content')
    <section class="admin-card" style="max-width: 500px;">
        <span class="frame-corner frame-corner--tl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--tr" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--bl" aria-hidden="true"></span>
        <span class="frame-corner frame-corner--br" aria-hidden="true"></span>

        <x-system-tag label="SEÑAL DE ACCESO · TURNO NOCHE" pulse />
        <h1 class="t-display-sm" style="color: var(--color-bone); margin-bottom: 2.5rem;">INGRESAR AL CIRCUITO.</h1>

        <form action="{{ route('auth.authenticate') }}" method="POST" novalidate style="display: flex; flex-direction: column; gap: 2rem;">
            @csrf
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
                <span class="bracket-cta__text">&gt;_ INICIAR SEÑAL</span>
                <span aria-hidden="true">]</span>
                <span class="bracket-cta__arrow" aria-hidden="true">→</span>
            </button>
        </form>

        <p style="margin-top: 2.5rem; font-family: var(--font-mono); font-size: var(--text-mono-sm); color: var(--color-bone-dim); text-align: center;">
            ¿No tenés firma digital? <a href="{{ route('auth.register') }}" style="color: var(--color-cyan); text-decoration: none; font-weight: 600;">Registrarse en el circuito</a>
        </p>
    </section>
@endsection
