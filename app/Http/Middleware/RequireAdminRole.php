<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class RequireAdminRole
 * 
 * Middleware personalizado para verificar que el usuario autenticado tiene rol de administrador.
 */
class RequireAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')
                ->with('feedback.message', 'Debes iniciar sesión para acceder a este sector.')
                ->with('feedback.type', 'danger');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            return redirect()->route('home')
                ->with('feedback.message', 'Acceso denegado. Se requiere nivel de autorización de Administrador.')
                ->with('feedback.type', 'danger');
        }

        return $next($request);
    }
}
