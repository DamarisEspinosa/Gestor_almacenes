<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ArticulosController;
use App\Http\Controllers\ProveedorController;

use App\Models\Almacen;

// Ruta para guardar almacenes
Route::post('/api/almacenes', [WarehouseController::class, 'store']);

// Ruta para mostrar la vista del almacén
Route::get('/almacen-detalle/{name}', [WarehouseController::class, 'view'])->name('almacenView');


Route::get('/', [MenuController::class, 'welcome'])->name('welcome');
Route::get('/dashboard', [MenuController::class, 'index'])->name('dashboard');

// Ruta para actualizar un almacén
Route::put('/api/almacenes/{id}', [WarehouseController::class, 'update']);

// Ruta para eliminar un almacén
Route::delete('/api/almacenes/{id}', [WarehouseController::class, 'destroy']);

Route::middleware(['auth'])->group(function () {
    Route::resource('almacenes', WarehouseController::class);
});

// ARTICULOS 
Route::get('/almacenes/{almacen}/articulos/create', [ArticulosController::class, 'create'])->name('articulos.create');
Route::post('/almacenes/{almacen}/articulos', [ArticulosController::class, 'store'])->name('articulos.store');
Route::get('/almacenes/{almacen}/articulos/{articulo}/edit', [ArticulosController::class, 'edit'])->name('articulos.edit');
Route::put('/almacenes/{almacen}/articulos/{articulo}', [ArticulosController::class, 'update'])->name('articulos.update');
Route::delete('/almacenes/{almacen}/articulos/{articulo}', [ArticulosController::class, 'destroy'])->name('articulos.destroy');
//Enviar productos
Route::post('/almacenes/{almacen}/articulos/{articulo}/transferir', [ArticulosController::class, 'transferir'])
    ->middleware('auth')
    ->name('articulos.transferir');

// PROVEEDORES
Route::get('/proveedores/create', [ProveedorController::class, 'create'])->name('proveedores.create');
Route::post('/proveedores/store', [ProveedorController::class, 'store'])->name('proveedores.store');
Route::get('/proveedores/{proveedor}/edit', [ProveedorController::class, 'edit'])->name('proveedores.edit');
Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');

Route::get('/admin/register', [RegisteredUserController::class, 'create'])->name('admin.register');
Route::post('/admin/register', [RegisteredUserController::class, 'store'])->name('admin.register');
Route::get('/admin/administrar', [UsuarioController::class, 'index'])->name('admin.administrar');

Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.administrar');
Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


















use App\Http\Controllers\MenuController;

Route::get('/', [MenuController::class, 'welcome'])->middleware(['auth', 'verified'])->name('welcome');
Route::get('/dashboard', [MenuController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

