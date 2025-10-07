<?php

use App\Http\Modules\Evoluciones\Controllers\EvolucionController;
use Illuminate\Support\Facades\Route;
use App\Http\Modules\EvolucionSignosSintomas\Controllers\EvolucionSignosSintomasController;

Route::prefix('evoluciones')->group(function () {
	Route::controller(EvolucionController::class)->group(function () {
		Route::post('crear', 'crear');
		Route::get('listar-evoluciones-admision/{admisionUrgenciasId}', 'listarEvolucionesAdmision');
		Route::patch('actualizar/{evolucionId}', 'actualizarEvolucion');
	});
});
