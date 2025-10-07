<?php

use App\Http\Modules\TipoUsuarios\Controllers\TipoUsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-usuario', 'throttle:60,1')      ->group(function () {
    Route::controller(TipoUsuarioController::class) ->group(function() {
        Route::get('listar', 'listar');
        Route::get('todos', 'listarTodos');
    });
});
