<?php

use App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Controllers\TiposCuentasMedicasController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-cuenta-medica','throttle:60,1')->group(function(){
    Route::controller(TiposCuentasMedicasController::class)->group(function(){
        Route::get('listar','listar')    ;//->middleware(['permission:tipoCuentaMedica.listar']);
        Route::post('guardar','guardar') ;//->middleware(['permission:tipoCuentaMedica.guardar']);
    });
});
