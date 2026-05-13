<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('welcome');
});

// HU-1: Gestión de Pedidos
Route::resource('pedidos', PedidoController::class);
Route::patch('pedidos/{pedido}/estado', [PedidoController::class, 'updateEstado'])
    ->name('pedidos.updateEstado');

// HU-2: Gestión de Clientes
Route::resource('clientes', ClienteController::class);