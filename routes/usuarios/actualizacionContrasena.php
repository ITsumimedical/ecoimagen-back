<?php

use App\Http\Modules\Usuarios\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::prefix('actualizacion', 'throttle:60,1')->group(function () {

    Route::post('actualizacion-contrasena', [UsuarioController::class, 'actualizacionContrasena']);
    Route::post('generar-recuperacion-funcionario', [UsuarioController::class, 'codigoRecuperacionFuncionario']);
    Route::post('actualizar-contrasena-usuario/{id}', [UsuarioController::class, 'actualizarContrasenaUsuario']);
});
