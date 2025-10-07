<?php

use App\Http\Controllers\Modules\Historia\Pdfs\Controllers\HistoricoPdfController as ControllersHistoricoPdfController;
use App\Http\Modules\Historia\Controllers\HistoriaController;
use App\Http\Modules\Historia\Odontograma\Controllers\OdontogramaController;
use App\Http\Modules\Historia\Pdfs\Controllers\HistoricoPdfController;
use Illuminate\Support\Facades\Route;

Route::prefix('historia', 'throttle:60,1')->group(function () {
    Route::controller(HistoriaController::class)->group(function () {
        Route::post('consultas', 'historicoConsultas');
        Route::get('consultas/historias-v1/{documento_afiliado}', 'historiasV1');
        Route::post('consultas/historias-v1/pdf', 'pdfHorusUno');
        Route::post('consultas/historias-v1/adjunto', 'adjuntoHorusUno');
        Route::get('historicoAtencionesOcupacionales/{cedula}', 'historicoAtencionesOcupacionales');
        Route::get('pdfs/{consulta}', 'impresion');
        Route::get('valoraciones/{afiliadoId}', 'valoraciones');
        Route::get('registro/{consultaId}/{afiliado}', 'registro');
        Route::post('guardar/{consultaId}', 'guardar');
        Route::post('plan-cuidado', 'historiaPlanCuidado');
        Route::post('guardar-plan-cuidado/{consultaId}', 'guardarPlanCuidado');
        Route::delete('eliminar-registro-plan-cuidado/{tipo}/{id}', 'eliminarRegistroPlanCuidado');

        Route::get('gestante-ginecologicos/{consultaId}', 'historiaGestanteGinecologicos');
        Route::post('guardar-gestante-ginecologicos/{consultaId}', 'guardarGestanteGinecologico');
        Route::delete('eliminar-gestante-ginecologicos/{id}', 'eliminarGestanteGinecologico');

        Route::get('redes-apoyos/{consultaId}', 'historiaRedesApoyos');
        Route::post('guardar-red-apoyo/{consultaId}', 'guardarRedApoyo');
        Route::delete('eliminar-red-apoyo/{id}', 'eliminarRedApoyo');

        Route::get('familiograma/{consultaId}', 'historiaFamiliograma');
        Route::post('guardar-familiograma/{consultaId}', 'guardarFamiliograma');
        Route::delete('eliminar-familiograma/{id}', 'eliminarFamiliograma');

        Route::post('finalizar-atencion/{consultaId}', 'finalizarHistoria');
        Route::post('concluir-no-finalizada/{consultaId}', 'concluirNoFinalizada');

        Route::post('examenFisico', 'examenFisico');
        Route::post('guardarCie10', 'guardarCie10');
        Route::post('listarCie10Historico', 'listarCie10Historico');

        Route::post('inasistir', 'inasistir');
        Route::post('enconsulta/{consultaId}', 'enconsulta');
        Route::post('actualizarTiempo', 'actualizarTiempo');

        Route::post('contadores', 'contadores');
        Route::post('repositorioHistorias', 'repositorioHistorias');

        Route::post('validacionHistoria', 'validacionHistoria');
        Route::get('datosParaclinicos/{afiliado_id}', 'datosParaclinicos');
        Route::post('saveAdherenciaFarmacologica', 'saveAdherenciaFarmacologica');
        Route::delete('eliminarCie10/{id}', 'eliminarCie10');

        Route::get('/repositorio/sumidental/{documento}', 'historiasSumidental');

        Route::post('/zip-historias', 'generarZipHistorias')->middleware('can:reportes.historico.consolidado');
        Route::get('obtenerDatosBarthel/{afiliado_id}', 'obtenerDatosBarthel');
        Route::get('obtenerDatosKarnofski/{afiliadoId}', 'obtenerDatosKarnosfki');
        Route::get('obtenerdatosEcog/{afiliadoId}', 'datosEcog');
        Route::get('obtenerDatosEdmon/{afiliadoId}', 'edmonEsas');
        Route::get('obtenerDatosEstiloVida/{afiliadoId}', 'estiloVida');
        Route::get('obtenerDatosGinecobstetricos/{afiliadoId}', 'obtenerDatosGinecobstetricos');
        Route::get('obtenerDatosValoracionPsicosocial/{afiliadoId}', 'obtenerDatosValoracionPsicosocial');

        Route::get('obtenerDatosFindric/{afiliadoId}', 'obtenerDatosFindric');

        Route::post('neuropsicologia/crear', 'crearNeuropsicologia');
        Route::get('neuropsicologia/obtenerDatos/{afiliadoId}', 'obtenerDatos');


        //Rutas para guardar los cups de Citologia y mamografia en ginecostetricos
        Route::post('cup-citologia/{consulta_id}', 'cupCitologia');
        Route::post('cup-mamografia/{consulta_id}', 'cupMamografia');
        Route::get('cup-citologia/{afiliado_id}', 'fetchcupCitologia');
        Route::get('cup-mamografia/{afiliado_id}', 'fetchcupMamografia');
        Route::delete('eliminarMamomgrafia/{id}', 'eliminarMamomgrafia');
        Route::delete('eliminarCitologia/{id}', 'eliminarCitologia');

        //Ruta actualizar impresion
        Route::put('actualizarImpresion/{id}', 'actualizarImpresion');

        //Escala abreviada
        Route::post('guardar-escala-abreviada/{id}', 'guardarEscalaAbreviada');
        Route::get('listar-escala-abreviada/{id}', 'listarEscalaAbreviada');


        Route::post('finalizar-atencion-urgencias/{consultaId}', 'finalizarHistoriaUrgencias');
        Route::get('consultar-signos-vitales-consulta/{consultaId}','consultarSignosVitalesConsulta');

        //Finaliar Historia Clinica
        Route::post('finalizar-historia-clinica/{consulta_id}', 'finalizarHistoriaClinica');
    });

    Route::prefix('odontograma', 'throttle:60,1')->group(function () {
        Route::controller(OdontogramaController::class)->group(function () {
            Route::get('listar-odontograma/{id}', 'listarOdontograma');
            Route::post('guardar/{id}', 'guardarOdontograma');
            Route::post('guardar-parametrizacion', 'guardarParametrizacion');
            Route::get('listar', 'listar');
        });
    });

    //ruta para listar Historico de PDFS por documento
    Route::controller(HistoricoPdfController::class)->group(function () {
        Route::get('/pdfs/{documento}',  'buscarPorDocumento');
        Route::post('/subir-pdf',  'subirPDF');
    });
});
