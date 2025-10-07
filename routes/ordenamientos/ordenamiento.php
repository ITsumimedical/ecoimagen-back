<?php

use App\Http\Modules\Medicamentos\Controllers\OrdenamientoController;
use Illuminate\Support\Facades\Route;

Route::prefix('ordenamiento', 'throttle:60,1')->group(function () {
    Route::controller(OrdenamientoController::class)->group(function () {
        Route::post('generarOrdenamiento/{idConsulta}/{tipo}', 'generarOrdenamiento');
        Route::get('ordenes-activas/{idConsulta}/{tipo}', 'ordenesActivas');
        Route::post('historico/', 'historico');
        Route::get('tipos', 'tipos');
        Route::get('detalleOrdenamientoPorConsulta/{consulta}', 'detalleOrdenamientoPorConsulta');
        Route::post('ordenMedicamnetosAutogestion', 'ordenMedicamnetosAutogestion');
        Route::post('ordenServiciosAutogestion', 'ordenServiciosAutogestion');
        Route::post('imprimirMedicamento', 'imprimirMedicamento');
        Route::post('generarPdf', 'generarPdf');
        Route::get('imprimirServicio/{orden_id}', 'imprimirServicio');
        Route::post('historicoMedicamentos6meses', 'historicoMedicamentos6meses');
        Route::post('HistoricoMedicamentosCronico', 'HistoricoMedicamentosCronicos');
        Route::post('historicoOrden6meses', 'historicoOrden6meses');
        Route::get('listaOrdenesDispensacion/{documento}', 'listaOrdenesDispensacion');
        Route::post('datosPrestador/{OrdenProcedimiento}', 'datosPrestador');
        Route::post('cancelarEsquema', 'cancelarEsquema');
        Route::post('actualizarOrden', 'actualizarOrden');
        Route::post('aplicacionesAgendadas', 'aplicacionesAgendadas');
        Route::post('finalizarAplicacion', 'finalizarAplicacion');
        Route::post('consultaEsquemaPaciente', 'consultaEsquemaPaciente');
        Route::post('suspenderEsquema', 'suspenderEsquema');
        Route::post('suspender', 'suspender');
        Route::post('asignarDireccionamiento', 'asignarDireccionamiento');
        Route::post('exportarServicios', 'exportarServicios');
        Route::post('exportarMedicamentos', 'exportarMedicamentos');
        Route::post('actualizarRep', 'actualizarRep');
        Route::post('actualizarCantidad', 'actualizarCantidad');
        Route::post('actualizarCup', 'actualizarCup');
        Route::post('actualizarCodigoPropio', 'actualizarCodigoPropio');
        Route::post('actualizarVigencia', 'actualizarVigencia');
        Route::post('notaAdicional', 'notaAdicional');
        Route::post('actualizarRepCodigoPropio', 'actualizarRepCodigoPropio');
        Route::post('actualizarRepMedicamento', 'actualizarRepMedicamento');
        Route::post('medicamentosDipensarPrestador', 'medicamentosDipensarPrestador');
        Route::get('detalleMedicamentosPrestador/{orden_id}', 'detalleMedicamentosPrestador');

        Route::get('/listar-por-afiliado/{afiliado_id}', 'listarOrdenesPorAfiliado');
        Route::get('/listar-articulo/{orden_id}/{estado?}', 'listarArticulosPorOrden');
        Route::get('/listar-articulo-pendientes/{orden_id}', 'listarArticulosPorOrdenPendiente');
        Route::get('/listar-articulo-por-afiliado/{afiliado_id}/{estados?}', 'listarArticulosPorAfiliado');
        Route::put('/set-pendiente/{orden_articulo_id}', 'setOrdenArticuloPendiente');
        Route::put('/set-autorizado/{orden_articulo_id}', 'setOrdenArticuloAutorizado');

        Route::post('dispensarProveedor', 'dispensarProveedor');
        Route::post('dispensar', 'dispensar');
        Route::post('cobroOrdenes', 'cobroOrdenes');
        Route::get('/listar-ordenes-activas/{afiliado_id}', 'listarOrdenesActivas');
        Route::get('/listar-ordenes-pendientes/{afiliado_id}', 'listarOrdenesPendientes');
        Route::get('/listar-ordenes-proximas/{afiliado_id}', 'listarOrdenesProximas');
        Route::post('/historialHorus1', 'listarHorus1Activas');
        Route::post('/transcribirFormulas', 'transcribirFormulas');
        Route::post('/ordenProcedimientoSede', 'ordenProcedimientoSede');
        Route::post('/ordenCodigoPropioSede', 'ordenCodigoPropioSede');
        Route::get('listarSuspension/{ordenArticuloId}', 'listarSuspension');
        Route::get('listarOrdenesAfiliado/{afiliado_id}', 'listarOrdenesAfiliado');
        Route::get('listar-articulos-activos/{orden_id}', 'listarArticulosActivosPorOrden');
        Route::post('dispensarPendiente', 'dispensarPendiente');
        Route::post('listarMovimientosDispensacion/{afiliadoId}', 'listarMovimientosDispensacion');
        Route::post('actualizarFechaVigencia/{ordenId}', 'actualizarFechaVigencia');
        Route::post('parametrizarDomicilio/{ordenArticuloId}', 'parametrizarDomicilio');
        Route::post('agregarNuevoCup/{id}', 'agregarNuevoCup');
        Route::post('agregarCodigoPropio/{id}', 'agregarCodigoPropio');
        Route::put('actualizarEstadoOrden', 'actualizarEstado');

        Route::put('cambioDireccionamiento/{rep_id}', 'cambioDireccionamientoMasivo');

        Route::post('buscarOrdenArticulo', 'buscarOrdenArticulo');
        Route::put('autorizarOrdenArticulo/{id}', 'autorizarOrdenArticulo');

        Route::post('validar-periodicidad/{idConsulta}', 'validarPeriodicidad');
        Route::post('enviar-a-fomag/{orden}', 'enviarFomag');

        Route::put('firmaAfiliadoOrdenNegada', 'firmaAfiliadoOrdenNegada');

        //Ruta para consultar los laboratorios por paciente
        Route::post('consultarLaboratorio', 'consultarLaboratorio');
        Route::post('firmar', 'firmar');
        Route::post('firmar-consentimientos-procedimientos', 'firmarConsentimientosProcedimientos');
        Route::post('firmar-consentimientos-orden', 'firmarConsentimientosOrden');
        Route::post('ordenesMedicamentosAfiliado', 'ordenesMedicamentosAfiliado');
        Route::post('ordenesProcedimientosAfiliado', 'ordenesProcedimientosAfiliado');
        Route::get('verificar-mipres', 'verificarMipresCodesumi');
        Route::post('orden-medicamentos-linea-base', 'ordenMedicamentosLineaBase');
        Route::get('listar-servicios-por-auditar/{afiliado_id}/{orden_id}', 'listarServiciosPorAuditar');
        Route::post('agregar-nota-adicional-orden-servicios', 'agregarNotaAdicionalOrdenServicios');
        Route::get('listar-notas-adicionales-orden-servicio/{orden_procedimiento_id}', 'listarNotasAdicionalesOrdenServicio');
        Route::post('cambiar-direccionamiento-servicios', 'cambiarDireccionamientoServicios');
        Route::post('agregar-nuevos-servicios', 'agregarNuevosServicios');
        Route::get('listar-codigos-propios-por-auditar/{afiliado_id}/{orden_id}', 'listarCodigosPropiosPorAuditar');
        Route::post('agregar-nuevos-codigos-propios', 'agregarNuevosCodigosPropios');
        Route::post('cambiar-direccionamiento-codigos-propios', 'cambiarDireccionamientoCodigosPropios');
        Route::post('agregar-nota-adicional-orden-codigos-propios', 'agregarNotaAdicionalOrdenCodigosPropios');
        Route::get('listar-notas-adicionales-orden-codigo-propio/{orden_codigo_propio_id}', 'listarNotasAdicionalesOrdenCodigoPropio');
        Route::get('listar-articulos-por-auditar/{orden_id}', 'listarArticulosPorAuditar');
        Route::post('cambiar-direccionamiento-medicamentos', 'cambiarDireccionamientoMedicamentos');

        Route::get('servicios-vigentes/{idAfiliado}', 'serviciosVigentes');
        Route::get('servicios-vigentes-admision/{idAfiliado}', 'serviciosVigentesAdmision');
        Route::get('ordenes-por-cobrar/{consulta_id}', 'ordenesPorCobrar');
        Route::post('cobro-servicio/{afiliado_id}', 'cobroServicio');
        Route::get('ordenes-a-cobrar/{consulta_id}', 'ordenesACobrar');
        Route::get('historico-recibos-caja/{tipoDocumento}/{numeroDocumento}', 'historicoRecibosCaja');
        Route::get('/listar-ordenes-cups/{afiliado_id}/{cup_id}', 'listarOrdenesCups');

        

        Route::patch('cambiar-servicio-orden/{ordenId}', 'cambiarServicioOrden');
        Route::patch('cambiar-codigo-propio-orden/{ordenId}', 'cambiarCodigoPropioOrden');

        Route::post('generar-ordenamiento-intrahospitalario', 'generarOrdenamientoIntrahospitalario');
        Route::get('listar-articulos-intrahospitalarios-ordenados-consulta/{consultaId}', 'listarArticulosIntrahospitalariosOrdenadosConsulta');

        Route::get('listar-historico-ordenes-intrahospitalarias-afiliado/{afiliadoId}', 'listarHistoricoOrdenesIntrahospitalariasAfiliado');
        Route::get('listar-historico-ordenes-intrahospitalarias/{tipoDocumento}/{numeroDocumento}', 'listarHistoricoOrdenesIntrahospitalarias');
        //RUTA PARA CONSULTAR LOS SERVICIOS QUE ESTAN PENDIENTES POR FACTURAR
        Route::post('listar-servicios-pendientes-facturar', 'listarServiciosPendientesFacturar');
        Route::get('listar-detalles-orden-usada/{orden_procedimiento_id}', 'listarDetallesOrdenUsada');

        //Listar ordenes de un afiliado para asignacion de citas
        Route::get('listar-ordenes-afiliado', 'listarOrdenesPorAfiliadoParaCitas');
        # realiza un consolidado de las formulas dispensadas
        Route::post('/generar/consolidado-formulas', 'generarConsolidado');
        Route::get('/listar/consolidado-formulas', 'listarConsolidado');
    });
});
