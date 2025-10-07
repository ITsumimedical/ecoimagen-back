<?php

use App\Http\Modules\CuentasMedicas\Glosas\Controllers\GlosaController;
use Illuminate\Support\Facades\Route;

Route::prefix(('glosa'))->group(function(){
    Route::controller(GlosaController::class)->group(function (){
        Route::get('listaFacturaGlosa/{af_id}','listaFacturaGlosa');//->middleware('permission:cuentasMedicas.listaFacturaGlosa');
        Route::post('glosa','glosa');//->middleware('permission:cuentasMedicas.listaFacturaGlosa');
        Route::get('facturasGlosarPrestador/{af_id}','facturasGlosarPrestador');//->middleware('permission:cuentasMedicas.facturasGlosarPrestador');
        Route::get('glosasConciliacion/{id_af}','glosasConciliacion');//->middleware('permission:cuentasMedicas.glosasConciliacion');
        Route::get('glosasCerrada/{id_af}','glosasCerrada');//->middleware('permission:cuentasMedicas.glosasCerrada');
        Route::get('facturaGlosaAuditoriaFinal/{id_af}','facturaGlosaAuditoriaFinal');//->middleware('permission:cuentasMedicas.facturaGlosaAuditoriaFinal');
        Route::get('facturaConciliada/{id_af}','facturaConciliada');//->middleware('permission:cuentasMedicas.facturaConciliada');
        Route::get('facturaConciliadaConSaldo/{id_af}','facturaConciliadaConSaldo');//->middleware('permission:cuentasMedicas.facturaConciliadaConSaldo');


    });
});
