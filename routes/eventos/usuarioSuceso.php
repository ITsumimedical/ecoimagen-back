<?php

use App\Http\Modules\Eventos\UsuariosSuceso\Controllers\UsuariosSucesoController;
use Illuminate\Support\Facades\Route;


Route::prefix('usuario-suceso')->group( function () {
    Route::controller(UsuariosSucesoController::class)->group(function (){
        Route::get('listar','listarUsuarioSuceso');
        Route::post('asignar','asignarUsuarioSuceso');
        Route::post('eliminar-usuario-suceso/{id_suceso}/{id_usuario}','eliminarUsuariosuceso');
        Route::post('eliminar-suceso/{id_suceso}','eliminarSuceso');

        Route::get('listar-usuario-defecto','listarUsuarioDefecto');
        Route::post('asignar-usuario-defecto','asignarUsuarioDefecto');
        Route::post('eliminar-usuario-defecto/{id_usuario}','eliminarUsuarioDefecto');

    });
});