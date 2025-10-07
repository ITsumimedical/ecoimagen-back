<?php

use App\Http\Modules\BarreraAccesos\Controllers\AreaResponsableController;
use Illuminate\Support\Facades\Route;

Route::prefix('area-responsable-barrera-acceso')->group( function () {
    Route::controller(AreaResponsableController::class)->group(function (){
        Route::post('listar-area-responsables-activas','listarAreaResponsableActivas');
        Route::post('listar-area-responsables','listarAreaResponsable');
        Route::post('crear-area-responsable', 'crearAreaResponsable');
        Route::put('actualizar-area-responsable/{id}', 'actualizarAreaResponsable');
        Route::put('cambiar_estado-area-responsable/{id}', 'cambiarEstadoAreaResponsable');
    });
});
