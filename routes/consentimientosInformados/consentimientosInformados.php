<?php

use App\Http\Modules\ConsentimientosInformados\Controllers\ConsentimientosInformadosController;
use Illuminate\Support\Facades\Route;


Route::prefix('consentimientos-informados')->group(function (){
    Route::controller(ConsentimientosInformadosController::class)->group(function (){
        Route::post('listar','listar');
        Route::post('crear',action: 'crear');
        Route::put('actualizar', 'actualizar');
        Route::post('consultar','consultar');
        Route::post('consultar-grupo-procedimientos','consultarGrupo');
        Route::put('cambiar-estado/{codigo}', 'cambiarEstadoFormulario');
        Route::put('cambiar-laboratorio', 'cambiarEstadoLaboratorio');
        Route::get('listar-consentimientos', 'listarConsentimientos');
        Route::post('guardar-firma-discentimiento/{id}', 'guardarFirma');
        Route::post('consultar-cup-formato','consultarCupConsentimiento');
        Route::post('eliminar-cup/{id}','eliminarCup');
    });
});
