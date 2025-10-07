<?php

use App\Http\Modules\BarreraAccesos\Controllers\ResponsableController;
use Illuminate\Support\Facades\Route;

Route::prefix('responsable-barrera-acceso')->group( function () {
    Route::controller(ResponsableController::class)->group(function (){
        Route::post('listar-responsables-activos','listarResponsableActivos');
        Route::post('listar-responsables','listarResponsable');
        Route::post('crear-responsable', 'crearResponsable');
        Route::put('actualizar-responsable/{id}', 'actualizarResponsable');
        Route::put('cambiar_estado-responsable/{id}', 'cambiarEstadoResponsable');
        Route::post('responsable-por-area/{id}', 'responsablesPorArea');
    });
});
