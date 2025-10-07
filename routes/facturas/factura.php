<?php


use App\Http\Modules\CuentasMedicas\Facturas\Controllers\FacturasController;
use Illuminate\Support\Facades\Route;

Route::prefix('factura','throttle:60,1v')->group(function(){
    Route::controller(FacturasController::class)->group(function(){
        Route::post('listarFacturaPrestador','listarFacturaPrestador');//->middleware(['permission:af.listarFacturaPrestador']);
        Route::post('asignarFactura','asignarFactura');//->middleware(['permission:af.asignarFactura']);
        Route::get('contadorFacturas','contadorFacturas');//->middleware(['permission:af.contadorFacturas']);
        Route::put('guardarServicio/{id_Af}','guardarServicio');//->middleware(['permission:af.guardarServicio']);
        Route::get('asignacionFactura/{idPrestador}','asignacionFactura');//->middleware('permission:cuentasMedicas.asignacionFactura');
        Route::put('guardarAuditoria/{id_af}','guardarAuditoria');//->middleware('permission:cuentasMedicas.guardarAuditoria');
        Route::get('facturas/{prestador_id}','facturas');//->middleware('permission:cuentasMedicas.facturas');
        Route::put('devolverAuditoria/{id_af}','devolverAuditoria');//->middleware('permission:cuentasMedicas.devolverAuditoria');
        Route::post('facturasPrestador','facturasPrestador');//->middleware('permission:cuentasMedicas.facturasPrestador');
        Route::post('guardarAuditoriaPrestador/{af_id}','guardarAuditoriaPrestador');//->middleware('permission:cuentasMedicas.guardarAuditoriaPrestador');
        Route::post('facturasConciliacion','facturasConciliacion');//->middleware('permission:cuentasMedicas.facturasConciliacion');
        Route::post('facturasCerradas','facturasCerradas');//->middleware('permission:cuentasMedicas.facturasCerradas');
        Route::post('facturaAuditoriaFinal','facturaAuditoriaFinal');//->middleware('permission:cuentasMedicas.facturaAuditoriaFinal');
        Route::post('guardarAuditoriaFinal','guardarAuditoriaFinal');//->middleware('permission:cuentasMedicas.guardarAuditoriaFinal');
        Route::post('facturaConciliadaAuditoriaFinal','facturaConciliadaAuditoriaFinal');//->middleware('permission:cuentasMedicas.facturaConciliadaAuditoriaFinal');
        Route::post('conciliar','conciliar');//->middleware('permission:cuentasMedicas.conciliar');
        Route::post('facturaConciliadaConsaldo','facturaConciliadaConsaldo');//->middleware('permission:cuentasMedicas.facturaConciliadaConsaldo');
        Route::post('conciliarConSaldo','conciliarConSaldo');//->middleware('permission:cuentasMedicas.conciliarConSaldo');
        Route::post('facturaCerradas','facturaCerradas');//->middleware('permission:cuentasMedicas.facturaCerradas');
    });
});
