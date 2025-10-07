<?php

use App\Http\Modules\Agendas\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;

Route::prefix('agenda')->group(function () {
    Route::controller(AgendaController::class)->group(function () {
        Route::post('','guardar');//->middleware('permission:agenda.guardar');
        Route::get('agendaDisponible','agendaDisponible');//->middleware('permission:agendaDisponible.listar');
        Route::post('reasignar','reasignarAgendas');//->middleware('permission:agendaDisponible.reasignar');
        Route::post('agendaDisponibleAutogestion','agendaDisponibleAutogestion');
        Route::post('generarPdf','generarPdf');
        Route::post('auditoria-agendas','auditoriaAgendas');
        Route::get('agendaSede/{consultorio_id}','agendaSede');
        Route::post('sede','sede');
        Route::post('medicos','medicos');
        Route::post('exportar','exportar');
        Route::post('exportarDemanda','exportarDemanda');
        Route::post('actualizarCita','actualizarCita');
        Route::get('consultar/{agenda_id}','getAgenda');
        // CIRUGIA //
        Route::post('agendas-activas-cirugia','agendasActivasCirugia');
        Route::post('guardar-agenda-cirugias','guardarAgendaCirugia');
        Route::post('consulta-agenda-cirugia','consultaAgendaCirugia');
        Route::post('reporte-cirugias-programadas',"reporteCirugiaProgramada");
        Route::post('listar-por-consultorio',"listarPorConsultorio");
        Route::post('trasladar-consultorio',"trasladarConsultorio");
    });
});
