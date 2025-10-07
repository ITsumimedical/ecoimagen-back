<?php

use App\Http\Modules\ConfiguracionReportes\Controllers\ConfiguracionReporteController;
use Illuminate\Support\Facades\Route;

Route::prefix('reportes')->middleware('throttle:60,1')->group(function () {
    Route::controller(ConfiguracionReporteController::class)->group(function () {
        Route::post('configuracion-reportes', 'store');
        Route::get('configuracion-reportes/{id}/campos', 'listarCampos');
        Route::get('configuracion-reportes', 'index');

        // Ruta para listar reps quemadas
        Route::get('reps', 'listarReps');
        // Ruta para listar entidades quemadas
        Route::get('entidades', 'listarEntidades');

        //Parametrizacion de reportes para gestion de base de datos
        Route::post('crear-reporte', 'crearReporte')->middleware('permission:crear.reporte');
        Route::get('obtener-rutas', 'misRutas')->middleware('permission:crear.reporte');
        Route::post('registro-rutas', 'registroRutas')->middleware('permission:crear.reporte');
        Route::get('rutas', 'listarRutas')->middleware('permission:crear.reporte');
        Route::get('obtener-reportes', 'obtenerReportes')->middleware('permission:reportes.vista');

    });
});
