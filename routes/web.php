<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;

Route::get('/', function () {
    return redirect()->route('clientes.index');
});

// Rutas para el sistema CRUD completo
Route::resource('clientes', ClienteController::class);
Route::resource('productos', ProductoController::class);
Route::resource('pedidos', PedidoController::class);
