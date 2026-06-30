<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
         * Class ReservationController
         *
         * Controlador para gestionar la creación de reservas/compras de máscaras en el circuito.
         */
class ReservationController extends Controller
{
    public function store(Request $request, int $productId): RedirectResponse
    {
        $product = Product::findOrFail($productId);

        if (!$product->isAvailable()) {
            return redirect()->back()
                ->with('feedback.message', 'La máscara <b>' . e($product->name) . '</b> no se encuentra disponible en este turno.')
                ->with('feedback.type', 'danger');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verificar si ya la tiene reservada
        $exists = Reservation::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('status', 'activa')
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('cartOpen', true)
                ->with('feedback.message', 'Ya tienes una reserva activa para la máscara <b>' . e($product->name) . '</b>.')
                ->with('feedback.type', 'warning');
        }

        Reservation::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 'activa',
        ]);

        return redirect()->back()
            ->with('cartOpen', true)
            ->with('feedback.message', '¡Reserva confirmada! La señal de <b>' . e($product->name) . '</b> ha sido encriptada para tu usuario.')
            ->with('feedback.type', 'success');
    }

    /**
     * Cancela una reserva activa del usuario.
     *
     * @param Request $request
     * @param int $productId
     * @return RedirectResponse
     */
    public function destroy(Request $request, int $productId): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $reservation = Reservation::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->where('status', 'activa')
            ->first();

        if ($reservation) {
            $reservation->delete();
            return redirect()->back()
                ->with('cartOpen', true)
                ->with('feedback.message', 'Señal desencriptada. Reserva eliminada del archivo.')
                ->with('feedback.type', 'success');
        }

        return redirect()->back()->with('cartOpen', true);
    }
}
