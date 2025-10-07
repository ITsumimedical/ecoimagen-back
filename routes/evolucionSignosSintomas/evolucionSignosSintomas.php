<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\EvolucionSignosSintomas\Controllers\EvolucionSignosSintomasController;

Route::prefix('evolucion-signos-sintomas')->group(function () {
	Route::controller(EvolucionSignosSintomasController::class)->group(function () {
		Route::post('agregar-evolucion', 'agregarEvolucion');
		Route::get('listar-ultima-evolucion/{afiliadoId}', 'listarUltimaEvolucion');
	});
});
