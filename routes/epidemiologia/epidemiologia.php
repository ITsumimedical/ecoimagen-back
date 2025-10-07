<?php

use App\Http\Modules\Epidemiologia\Controllers\EpidemiologiaController;
use Illuminate\Support\Facades\Route;

Route::prefix('epidemiologia', 'throttle:60,1')->group(function () {
    Route::controller(EpidemiologiaController::class)->group(function (){
        Route::get('listar-cabecera-campos/{id}', 'listarCabeceraCampos');
        Route::get('listar-consultas-diagnostico-epidemiologia', 'listarConsultasDiagnosticoEpidemiologia');
        Route::post('guardar-respuesta', 'guardarRespuestas');
        Route::post('descargar-pdf-epidemiologia-sivigila', 'descargarPdfEpidemiologiaSivigila');
        Route::post('cambiar-estado-activo-ficha/{id}', 'cambiarEstadoFormulario');
        // Route::get('listar-ips', 'listarIps');
        Route::post('actualizar-respuestas', 'actualizarRespuestas');
        Route::post('obtener-respuestas', 'obtenerRespuestas');
        Route::post('devolver-ficha-medico/{id}', 'devolverFichaMedico');
        Route::get('listar-observaciones-devolucion/{id}', 'listarObservacionesDevolucion');
        Route::get('listar-todas-consultas-diagnostico-epidemiologia', 'listarTodasConsultasDiagnosticoEpidemiologia');
    });
});
