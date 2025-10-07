<?php

use App\Http\Modules\unidadesMedidasMedicamentos\Controllers\UnidadesMedidasMedicamentosController;
use Illuminate\Support\Facades\Route;
Route::prefix('unidades-medidas-medicamentos', 'throttle:60,1')->group(function () {
	Route::controller(UnidadesMedidasMedicamentosController::class)->group(function () {
		Route::post('crear', 'crear');
        Route::get('listar', 'listarUnidadesMedida');
        Route::put('actualizar/{id}', 'actualizar');
        Route::delete('eliminar/{id}', 'eliminar');
	});
});
