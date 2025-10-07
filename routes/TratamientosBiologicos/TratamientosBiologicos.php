<?php

use App\Http\Modules\TratamientosBiologicos\Controller\TratamientosBiologicosController;
use Illuminate\Support\Facades\Route;

Route::prefix('tratamientos-biologicos', 'throttle:60,1')->group(function () {
    Route::controller(TratamientosBiologicosController::class)->group(function() {
        Route::post('crear-tratamiento-biologicos', 'crear');
        Route::get('listar-tratamiento-afiliado/{afiliado_id}', 'listarTratamientoPorAfiliado');
        Route::delete('eliminar-tratamiento-biologico/{id}', 'eliminarTratamiento');
    });
});
