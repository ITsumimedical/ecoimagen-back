<?php

use App\Http\Modules\FacturacionElectronica\Controllers\EstructuraFacturaElectronicaController;
use Illuminate\Support\Facades\Route;

Route::prefix('facturacion-electronica')->group(function(){
    Route::controller(EstructuraFacturaElectronicaController::class)->group(function(){
        Route::get('facturas-pendientes','facturasPendientesDeFacturacionElectronica');//->middleware(['permission:af.contadorFacturas']);
        Route::post('emitir-pre-factura','emitirPreFactura');//->middleware(['permission:af.listarFacturaPrestador']);
        Route::post('crear-concepto','crearConceptoPreFactura');//->middleware(['permission:af.listarFacturaPrestador']);
        Route::get('listar-concepto','listarConceptoPreFactura');//->middleware(['permission:af.listarFacturaPrestador']);
    });
});
