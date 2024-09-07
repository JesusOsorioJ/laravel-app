<?php

use App\Http\Controllers\Api\CuentaController;
use App\Http\Controllers\Api\PedidoController;

Route::apiResource('/cuentas', CuentaController::class);
Route::apiResource('/pedidos', PedidoController::class);
