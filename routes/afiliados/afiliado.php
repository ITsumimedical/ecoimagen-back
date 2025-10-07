<?php

use App\Http\Modules\Afiliados\Controllers\AfiliadoController;
use Illuminate\Support\Facades\Route;

Route::prefix('afiliados', 'throttle:60,1')->group(function () {
    Route::controller(AfiliadoController::class)->group(function () {
        Route::get('listar', 'listar'); //->middleware('permission:afiliado.listar');
        Route::post('crear', 'crear'); //->middleware('permission:afiliado.crear');
        Route::put('actualizar/{id}', 'actualizar'); //->middleware('permission:afiliado.actualizar');
        Route::put('actualizarAfiliado/{afiliado_id}', 'actualizarAfiliado'); //->middleware('permission:afiliado.actualizar');
        Route::put('actualizarHistoria/{id}', 'actualizarHistoria'); //->middleware('permission:afiliado.actualizar');
        Route::put('estado/{id}', 'cambiarEstado'); //->middleware('permission:afiliado.cambiarEstado');
        Route::get('/{cedula}/{tipoDocumento}', 'consultar'); //->middleware('permission:afilidado.consultar');
        Route::get('beneficiario/{cedula}', 'buscarBeneficiarios'); //->middleware('permission:afiliado.buscarBeneficiarios');
        Route::post('actualizacionMasiva', 'procedimientoActualizacion'); //->middleware('permission:afiliado.procedimientoActualizacion');
        Route::post('crearMarcacion/{id}', 'crearMarcacion'); //->middleware('permission:afiliado.crearMarcacion');
        Route::get('listarActivos/{cedula}/{tipo_documento}', 'listarActivos'); //->middleware('permission:afiliado.listar');
        Route::get('consultar-afiliado/{cedula}/{tipoDocumento}', 'consultarAfiliado'); //->middleware('permission:afiliado.listar');
        Route::post('grupoFamiliar', 'grupoFamiliar'); //->middleware('permission:afiliado.listar');
        Route::post('reporteRedAfiliados', 'reporteRedAfiliados'); //->middleware('permission:asegurador.verificacion.descargueReporteRed');
        //rutas red vital
        Route::post('validacionPacienteRedVital', 'validacionPacienteRedVital');
        Route::post('crearCaracterizacion', 'crearCaracterizacion');
        Route::get('buscarAfiliadoCaracterizacion/{cedula}/{tipoDocumento}', 'buscarAfiliadoCaracterizacion'); //->middleware('permission:afilidado.consultar');
        Route::post('registrarBeneficiario', 'registrarBeneficiario');
        Route::get('consultarDatosAfiliadoTodos/{cedula}/{tipoDocumento}', 'consultarDatosAfiliadoTodos');
        Route::post('actualizarDatosContacto/{afiliadoId}', 'actualizarDatosContacto');
        Route::get('verificarExistencia/{numero_documento}/{tipo_documento}', 'verificarExistencia');
        Route::post('crearAfiliadoAseguramiento', 'crearAfiliadoAseguramiento');
        Route::post('buscarAfiliados/{cedula}/{tipo_documento}', 'buscarAfiliados');
        Route::put('actualizarDireccion/{id}', 'actualizarDireccion');
        Route::put('actualizarAdmision/{id}', 'actualizarAdmision');
        Route::post('guardarAfiliadoAdmision', 'guardarAfiliadoAdmision');
        Route::post('consultar-afiliado-documento/{documento}', 'consultarAfiliadoDocumento');
        Route::post('listar-beneficiarios-por-doc/{documento_afiliado}', 'listarBeneficiariosPorDoc');
        Route::post('listar-afiliado-por-id/{afiliadoId}', 'listarAfiliadoPorId');
        Route::get('verificarEstado/{cedula}/{tipo_documento}', 'verificarEstado');
        Route::post('validar-parentesco', 'validarParentesco');
        Route::get('estructura-carga-excel', 'estructuraCargaExcel');
        Route::post('carga-masiva', 'cargueMasivoAfiliados');
        Route::post('subir-archivos-afiliados', 'cargarArchivo');
        Route::post('buscar-archivos/{id}', 'buscarArchivos');
        Route::get('verificar-existencia-nombre-fecha', 'verificarExistenciaPorNombreFecha');
        Route::post('generar-codigo-sms/{tipoDocumento}/{documento}', 'codigoAfiliadoHistorias');
    });
});
