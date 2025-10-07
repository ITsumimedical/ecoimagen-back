<?php

use App\Http\Modules\UnidadesMedidasDispensacion\Controller\UnidadesMedidasDispensacionController;
use App\Http\Modules\unidadesMedidasMedicamentos\Controllers\UnidadesMedidasMedicamentosController;
use Illuminate\Support\Facades\Route;
Route::prefix('unidades-medidas-medicamentos-dispensacion', 'throttle:60,1')->group(function () {
	Route::controller(UnidadesMedidasDispensacionController::class)->group(function () {
		Route::post('crear', 'crear');
        Route::get('listar', 'listar');
        Route::put('actualizar/{id}', 'actualizar');
        Route::delete('eliminar/{id}', 'eliminar');
        Route::post('listarTodas', 'listarSinPaginar');

	});
});
