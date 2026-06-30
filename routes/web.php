<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Rutas Públicas
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/transmisiones', [PostController::class, 'index'])->name('posts.index');
Route::get('/transmisiones/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Autenticación
Route::get('/iniciar-sesion', [AuthController::class, 'login'])->name('auth.login');
Route::post('/iniciar-sesion', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::get('/registrarse', [AuthController::class, 'register'])->name('auth.register');
Route::post('/registrarse', [AuthController::class, 'store'])->name('auth.store');
Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

// Reserva de Máscaras (Usuarios Autenticados)
Route::post('/productos/{id}/reservar', [ReservationController::class, 'store'])
    ->middleware('auth')
    ->name('products.reserve')
    ->whereNumber('id');
    
Route::delete('/productos/{id}/reservar', [ReservationController::class, 'destroy'])
    ->middleware('auth')
    ->name('products.reserve.cancel')
    ->whereNumber('id');

// Panel de Administración (Requiere middleware 'auth' y 'admin')
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // ABM de Transmisiones (Blog)
    Route::get('/transmisiones', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::get('/transmisiones/publicar', [AdminPostController::class, 'create'])->name('admin.posts.create');
    Route::post('/transmisiones/publicar', [AdminPostController::class, 'store'])->name('admin.posts.store');
    Route::get('/transmisiones/{post:slug}/editar', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/transmisiones/{id}/editar', [AdminPostController::class, 'update'])->name('admin.posts.update')->whereNumber('id');
    Route::get('/transmisiones/{id}/eliminar', [AdminPostController::class, 'delete'])->name('admin.posts.delete')->whereNumber('id');
    Route::delete('/transmisiones/{id}/eliminar', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy')->whereNumber('id');

    // ABM de Máscaras (Productos)
    Route::get('/productos', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/productos/crear', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/productos/crear', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/productos/{product:slug}/editar', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/productos/{id}/editar', [AdminProductController::class, 'update'])->name('admin.products.update')->whereNumber('id');
    Route::get('/productos/{id}/eliminar', [AdminProductController::class, 'delete'])->name('admin.products.delete')->whereNumber('id');
    Route::delete('/productos/{id}/eliminar', [AdminProductController::class, 'destroy'])->name('admin.products.destroy')->whereNumber('id');

    // Listado de Usuarios y Servicios Contratados
    Route::get('/usuarios', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/usuarios/{id}', [AdminUserController::class, 'show'])->name('admin.users.show')->whereNumber('id');
});

