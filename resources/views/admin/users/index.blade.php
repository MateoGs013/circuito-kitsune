@extends('layouts.app')

@section('title', 'Admin Usuarios · Circuito Kitsune')
@section('section_label', 'PANEL ADMIN · USUARIOS')

@section('content')
    <section class="admin-section" style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem;">
        <div style="margin-bottom: 2rem;">
            <x-system-tag label="SISTEMA CENTRAL · CORREDORES" pulse />
            <h1 class="t-display-md" style="color: var(--color-bone);">REGISTRO DE USUARIOS.</h1>
        </div>

        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>[ID]</th>
                        <th>[NOMBRE]</th>
                        <th>[EMAIL]</th>
                        <th>[ROL]</th>
                        <th>[RESERVAS]</th>
                        <th>[ACCIONES]</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td style="color: var(--color-cyan); font-weight: 600;">#{{ $user->id }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td style="color: var(--color-bone-dim);">{{ $user->email }}</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="admin-badge admin-badge--ember">[ADMIN]</span>
                                @else
                                    <span class="admin-badge admin-badge--neutral">[USER]</span>
                                @endif
                            </td>
                            <td style="color: var(--color-gold); font-weight: 600;">{{ $user->reservations_count }} máscara(s)</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="admin-action-link admin-action-link--edit">[VER DETALLE]</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
