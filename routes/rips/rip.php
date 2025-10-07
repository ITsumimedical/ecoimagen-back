<?php

use App\Http\Modules\Rips\Controllers\RipController;
use Illuminate\Support\Facades\Route;

Route::prefix('rips', 'throttle:60,1')->group(function () {
    Route::controller(RipController::class)->group(function (){
        Route::get('autorizacionPeriodoRips', 'autorizacionPeriodoRips');//->middleware('permission:rips.validar');
        Route::post('validar', 'validar');//->middleware('permission:rips.validar');
        Route::get('enProcesoValidacion', 'enProcesoValidacion');
        Route::get('eliminarProcesoValidacion/{paqRip}', 'eliminarProcesoValidacion');
        Route::get('descargarerrores/{id}',  'descargarErrores');
        Route::post('obtenerRadicados','getRadicados');
        Route::post('rechazarRips','rechazarRips');
        Route::post('aceptarRips','aceptarRips');
        Route::post('pendienteRips','pendienteRips');
        Route::post('generarRips','generarRips')->name('generarRips');
        Route::get('descargarArchivo/{nombre}','descargarArchivo')->name('descargarArchivo');
        //Rutas para guardar rips json
        Route::post('/guardar-archivos', 'guardarArchivosJson');
        Route::get('historico-rips-entidad/{historico}','historicoRipsEntidad');
        Route::post('consultar-nombre-soporte','consultarNombreSoporte');
        Route::post('descargar-soportes-json','descargarSoportesJson');
        ///// Conversor /////
        Route::post('conversor/{tipo}','conversor');
        Route::post('ripsJsonHorus1','ripsJsonHorus1');
        ///// RIPS JANIER /////
        Route::post('generarRIPSJanier','generarRIPSJanier');
    });
});
