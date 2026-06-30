<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

/**
 * Class AdminUserController
 *
 * Controlador para listar usuarios y ver el detalle de los servicios/máscaras contratadas.
 */
class AdminUserController extends Controller
{
    /**
     * Muestra el listado general de usuarios registrados.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::withCount('reservations')->latest()->get(),
        ]);
    }

    /**
     * Muestra el detalle individual de un usuario con sus reservas/compras.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        return view('admin.users.show', [
            'user' => User::with(['products'])->findOrFail($id),
        ]);
    }
}
