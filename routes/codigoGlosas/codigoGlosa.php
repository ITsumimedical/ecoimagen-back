<?php

use App\Http\Modules\CuentasMedicas\CodigoGlosas\Controllers\CodigoGlosaController;
use Illuminate\Support\Facades\Route;

Route::prefix('codigo-glosa','throttle:60,1v')->group(function(){
    Route::controller(CodigoGlosaController::class)->group(function(){
        Route::get('listarCodigoGlosas','listarCodigoGlosas');//->middleware('permission:cuentasMedicas.listarCodigoGlosas');
        Route::post('guardar','guardar');//->middleware('permission:cuentasMedicas.guardarCodigoGlosa');
        Route::put('cambiarEstado/{id_codigo_glosa}','cambiarEstado');//->middleware('permission:cuentasMedicas.cambiarEstadoCodigoGlosa');
    });
});
