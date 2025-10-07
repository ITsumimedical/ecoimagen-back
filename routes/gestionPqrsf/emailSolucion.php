<?php
use App\Http\Modules\GestionPqrsf\Formulario\Controllers\FormulariopqrsfController;
use Illuminate\Support\Facades\Route;

Route::prefix('notificacion')->group( function () {
    Route::controller(FormulariopqrsfController::class)->group(function (){
        Route::post('solucion-pqr','solucionPqr');
    });
});