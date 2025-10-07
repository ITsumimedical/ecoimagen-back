<?php

use App\Http\Modules\GestionPqrsf\Formulario\Controllers\FormulariopqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('formularios-pqrsf')->group(function () {
    Route::controller(FormulariopqrsfController::class)->group(function () {
        Route::post('listarPendientesInterna', 'listarPendientesInterna');
        Route::post('listarPendientesInternaDetalle', 'listarPendientesInternaDetalle');
        Route::post('listarAsignadosInternaDetalle', 'listarAsignadosInternaDetalle');
        Route::post('listarPendientesExternaDetalle', 'listarPendientesExternaDetalle');
        Route::post('crear', 'crear');
        Route::post('actualizar', 'actualizar');
        Route::post('consultar', 'consultar');
        Route::post('{id}/cambiar-estado', 'cambiarEstado');
        Route::get('historial/{numero_cedula}', 'historial');
        Route::get('contadoresPqrsf', 'contadoresPqrsfInterna');
        Route::post('anular', 'anular');
        Route::post('solucionar', 'solucionar');
        Route::post('asignar', 'asignar');
        Route::post('listarAsignados', 'listarAsignados');
        Route::post('respuesta', 'respuesta');
        Route::post('listarPresolucion', 'listarPresolucion');
        Route::post('reclasificar', 'reclasificar');
        Route::post('respuestaFinal', 'respuestaFinal');
        Route::post('reasignar', 'reasignar');
        Route::post('listarSolucionados', 'listarSolucionados');
        Route::post('listarPendientesExterna', 'listarPendientesExterna');
        Route::post('listarPendientesCentral', 'listarPendientesCentral');
        Route::post('listarAsignadosCentral', 'listarAsignadosCentral');
        Route::post('listarPresolucionCentral', 'listarPresolucionCentral');
        Route::post('listarAsignadosExterna', 'listarAsignadosExterna');
        Route::post('listarPresolucionExterna', 'listarPresolucionExterna');
        Route::post('listarSolucionadosExterna', 'listarSolucionadosExterna');
        Route::post('listarAsignadosTodos', 'listarAsignadosTodos');
        Route::post('listarSolucionadosTodos', 'listarSolucionadosTodos');
        Route::post('cargueMasivo', 'cargueMasivo');
        Route::post('reporte', 'reporte');
        Route::post('contadoresPqrsfExterna', 'contadoresPqrsfExterna');
        Route::post('contadoresPqrsfTodos', 'contadoresPqrsfTodos');
        Route::post('descargaFormato', 'descargaFormato');
        Route::post('crearPqrsfAutogestion', 'crearPqrsfAutogestion');
        Route::post('listarPqrsfAutogestion', 'listarPqrsfAutogestion');
        Route::post('actualizarDatosContactoPqrsf/{pqrsfId}', 'actualizarDatosContactoPqrsf');
        Route::get('contadoresPqrsfAdministracion', 'contadoresPqrsfAdministracion');
        Route::post('listarSolucionadosCentral', 'listarSolucionadosCentral');
        Route::post('listarPendientesGestionExterna', 'listarPendientesGestionExterna');
        Route::post('listarAsignadasGestionExterna', 'listarAsignadasGestionExterna');
        Route::post('listarPreSolucionadasGestionExterna', 'listarPreSolucionadasGestionExterna');
        Route::post('listarSolucionadasGestionExterna', 'listarSolucionadasGestionExterna');
        Route::post('listarPendientesGestionInterna', 'listarPendientesGestionInterna');
        Route::post('listarAsignadasGestionInterna', 'listarAsignadasGestionInterna');
        Route::post('listarPreSolucionadasGestionInterna', 'listarPreSolucionadasGestionInterna');
        Route::post('listarSolucionadasGestionInterna', 'listarSolucionadasGestionInterna');
        Route::post('listarAsignadasGestionArea', 'listarAsignadasGestionArea');
        Route::post('listarSolucionadasGestionArea', 'listarSolucionadasGestionArea');
        Route::post('cargueMasivoSupersalud', 'cargueMasivoSupersalud');
    });
});
