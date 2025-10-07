<?php

use App\Http\Modules\Auditorias\Controllers\AuditoriaController;
use Illuminate\Support\Facades\Route;

Route::prefix('auditoria', 'throttle:60,1')->group(function () {

    Route::controller(AuditoriaController::class)->group(function () {
        Route::post('ordenamiento', 'auditoria');//->middleware('permission:auditoria.ordenamiento');
        Route::get('detalle-auditoria/{consulta}', 'detalleAuditoria');//->middleware('permission:auditoria.detalleAuditori');
        Route::post('auditoria-estado', 'auditoriaEstado');//->middleware('permission:auditoria.cambiarEstado');
        Route::post('listarAuditoriaPrestador', 'listarAuditoriaPrestador');
        Route::post('visionTotal', 'visionTotal');
        Route::post('exportar', 'exportar');
        Route::post('oncologia', 'oncologia');
        Route::post('cambiar-auditoria-estado', 'cambiarAuditoriaEstado');
        Route::post('listar-ordenes-servicios-por-auditar', 'listarOrdenesServiciosPorAuditar');
        Route::post('gestionar-auditoria-servicios', 'gestionarAuditoriaServicios');
        Route::post('listar-ordenes-codigos-propios-por-auditar', 'listarOrdenesCodigosPropiosPorAuditar');
        Route::post('gestionar-auditoria-codigos-propios', 'gestionarAuditoriaCodigosPropios');
        Route::post('listar-ordenes-medicamentos-por-auditar', 'listarOrdenesMedicamentosPorAuditar');
        Route::post('gestionar-auditoria-medicamentos', 'gestionarAuditoriaMedicamentos');
    });
});
