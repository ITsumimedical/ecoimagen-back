<?php

use App\Http\Modules\Tarifas\Controllers\TarifaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tarifa', 'throttle:60,1')->group(function () {
    Route::controller(TarifaController::class)->group(function () {

        Route::post('/', 'crear');
        Route::get('/listar-por-contrato/{contrato_id}', 'listarPorContrato');
        Route::post('/agregar-cups/{tarifa_id}', 'agregarCups');
        Route::get('/cups/{tarifa_id}', 'listarCupsPorTarifa');
        Route::post('/carga-masiva/{tarifa_id}', 'cargaMasiva');
        Route::post('/carga-masiva-multiple', 'cargaMasivaMultiple');
        Route::post('listar', 'listar'); //->middleware('permission:tarifa.listar');
        Route::post('consultar-tarifa', 'consultarTarifa'); //->middleware('permission:tarifa.listar');
        Route::post('crear', 'crear'); //->middleware('permission:tarifa.crear');
        Route::post('actualizar', 'actualizarTarifas'); //->middleware('permission:tarifa.crear');
        Route::post('/tarifa-cups/{tarifa_id}', 'tarifaCups'); //->middleware('permission:tarifa.crear');
        Route::post('/listarCupsTarifas', 'listarCupTarifas'); //->middleware('permission:tarifa.listar');
        Route::post('/deleteCupsTarifas', 'deleteCupsTarifas'); //->middleware('permission:tarifa.listar');
        Route::post('/editarValor', 'editarValor'); //->middleware('permission:tarifa.listar');
        Route::post('tarifa-propia', 'tarifaPropia'); //->middleware('permission:tarifa.crear');
        Route::post('subirArchivo', 'subirArchivo'); //->middleware('permission:tarifa.crear');
        Route::post('tarifa-paquete/{tarifa_id}', 'tarifaPaquete'); //->middleware('permission:tarifa.crear');
        Route::post('listarPaquete', 'listarPaquete'); //->middleware('permission:tarifa.crear');
        Route::get('descargarPlantillaCups', 'descargarPlantillaCups'); //->middleware('permission:tarifa.listar');
        Route::get('descargarPlantillaTarifas', 'descargarPlantillaTarifas'); //->middleware('permission:tarifa.listar');
        Route::get('descargarPlantillaTarifaCup', 'descargarPlantillaTarifaCup'); //->middleware('permission:tarifa.listar');        
        Route::get('listarCodigosPropiosTarifas/{id}', 'listarCodigosPropiosTarifas'); //->middleware('permission:tarifa.crear');
        Route::delete('eliminarCodigoPropioTarifa/{tarifa_id}/{codigo_propio_id}', 'eliminarCodigoPropioTarifa'); //->middleware('permission:tarifa.crear');
        Route::get('listarPaqueteTarifa/{id}', 'listarPaqueteTarifa'); //->middleware('permission:tarifa.crear');
        Route::delete('eliminarPaqueteTarifa/{tarifa_id}/{paquete_id}', 'eliminarPaqueteTarifa'); //->middleware('permission:tarifa.crear');
        Route::put('actualizarPrecioPaquete', 'actualizarPrecioPaquete');
        Route::put('actualizarPrecioCodigoPropio', 'actualizarPrecioCodigoPropio');
        Route::put('actualizarPrecioCupsTarifa', 'actualizarPrecioCupsTarifa');
        Route::post('tarifa-diagnostico/{tarifa_id}', 'agregarTarifaDiagnostico');
        Route::delete('eliminarCupsTarifas', 'eliminarCupsTarifas');
        Route::post('eliminar/{tarifa_id}', 'eliminarTarifas');
        Route::post('tarifa-municipio/{tarifa_id}', 'tarifaMunicipio');
        Route::get('municipios-tarifa/{tarifa_id}', 'getMunicipiotarifa');
        Route::post('deleteMunicipioTarifas', 'deleteMunicipioTarifas');
        Route::post('tarifa-cums/{tarifa_id}', 'tarifaCums');
        Route::get('cum-tarifa/{tarifa_id}', 'getCumTarifas');
        Route::get('diagnostico-tarifa/{tarifa_id}', 'getDiagnosticoTarifa');
        Route::post('delete-diagnostico-tarifas', 'deleteDiagnosticoTarifas');
        Route::post('eliminar-cum-tarifa', 'eliminarCumTarifa');
    });
});
