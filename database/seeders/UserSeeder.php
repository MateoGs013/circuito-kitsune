<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Administrador
        User::updateOrCreate(
            ['email' => 'admin@kitsune.com'],
            [
                'name' => 'Administrador Kitsune',
                'password' => Hash::make('asdasd'),
                'role' => 'admin',
            ]
        );

        // 2. Usuario Común
        $user = User::updateOrCreate(
            ['email' => 'user@kitsune.com'],
            [
                'name' => 'Usuario Corredor',
                'password' => Hash::make('asdasd'),
                'role' => 'user',
            ]
        );

        // 3. Cargar al menos un usuario con servicio contratado (Reserva de Máscara)
        $product = Product::first();
        if ($product) {
            Reservation::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ],
                [
                    'status' => 'activa',
                ]
            );
        }
    }
}
