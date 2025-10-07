<?php

use App\Http\Modules\Consultas\Controllers\ConsultaController;
use Illuminate\Support\Facades\Route;


Route::prefix('consultas')->group(function () {
    Route::controller(ConsultaController::class)->group(function () {
        Route::post('citasIndividales', 'citasIndividales'); //->middleware('permission:consulta.citasindividuales');
        Route::post('citasGrupales', 'citasGrupales'); //->middleware('permission:consulta.citasindividuales');
        Route::get('generarHistoria/{cita}', 'generarHistoria'); //->middleware('permission:consulta.generarhistoria');
        Route::post('crear', 'crear'); //->middleware('permission:consulta.crear');
        Route::put('/{id}', 'actualizar'); //->middleware('permission:consulta.actualizar');
        Route::post('guardarHistoria/{consulta}', 'guardarHistoria'); //->middleware('permission:consulta.guardarhistoria');
        Route::get('consultasPaciente/{afiliado}', 'consultasPaciente'); //->middleware('permission:consulta.consultapaciente');
        Route::get('contadorConsultaPendientes/{afiliado_id}', 'contadorConsultaPendientes'); //->middleware('permission:consulta.consultapaciente');
        Route::post('cancelar', 'cancelarConsulta'); //->middleware('permission:consulta.cancelarconsulta');
        Route::post('reasignar', 'reasignarConsulta'); //->middleware('permission:consulta.reasignarconsulta');
        Route::get('consulta/{consulta_id}', 'consulta'); //->middleware('permission:consulta.reasignarconsulta');
        Route::get('contadorConsultas', 'contadorConsultasIndividuales'); //->middleware('permission:consulta.reasignarconsulta');
        Route::get('contadorConsultaOcupaciona', 'contadorConsultaOcupaciona'); //->middleware('permission:consulta.reasignarconsulta');
        Route::get('contadorConsultaNoProgramada', 'contadorConsultaNoProgramada');
        Route::post('citasOcupacionales', 'citasOcupacionales'); //->middleware('permission:consulta.citasindividuales');
        Route::post('generar-noprogramada', 'generarNoProgramada'); //->middleware('permission:consulta.');
        Route::post('citasNoProgramadas', 'citasNoProgramadas');
        Route::post('foto', 'foto');
        Route::post('aplicacionesPendientes', 'aplicacionesPendientes');
        Route::post('confirmar', 'confirmar');
        Route::post('citasAgrupadas', 'citasAgrupadas'); //->middleware('permission:consulta.citasindividuales');
        Route::get('consultasPendientesPaciente/{afiliado_id}', 'consultasPendientesPaciente'); //->middleware('permission:consulta.citasindividuales');
        Route::get('consultasAtendidasPaciente/{afiliado_id}', 'consultasAtendidasPaciente'); //->middleware('permission:consulta.citasindividuales');
        Route::put('actualizarServicioSolicita/{consulta}', 'actualizarServicioSolicita');
        Route::get('verificarEstadoConsulta/{consultaId}', 'verificarEstadoConsulta');
        Route::post('asignarCitaAutogestion', 'asignarCitaAutogestion'); //->middleware('permission:consulta.crear');
        Route::get('historicoCitasAfiliado', 'historicoCitasAfiliado');
        Route::post('consultasSinFinalizar', 'consultasSinFinalizar');
        Route::get('detallesOrdenConsulta/{consultaId}', 'detallesOrdenConsulta');
        Route::post('noProgramadasSinFinalizar', 'noProgramadasSinFinalizar');
        Route::post('generarConsultaTriage', 'generarConsultaTriage');
        Route::post('obtenerConsultaTriage', 'obtenerConsultaTriage');
        Route::post('consultarCitas', 'consultarCitas');
        Route::post('confirmarAdmision', 'confirmarAdmision');
        Route::post('guardarFirma', 'guardarFirma');
        Route::post('crear-cita-demanda', 'crearCitaDemanda');
        Route::post('consultar-completo', 'consultarCompleto');
        Route::post('verificar-medico-atiende/{consultaId}', 'verificarMedicoAtiende');
        Route::post('ConsultasPorEspecialidad', 'ConsultasPorEspecialidad');
        Route::post('firmar-consentimiento-anestesia','firmarConsentimientoAnestesia');
    });
});
