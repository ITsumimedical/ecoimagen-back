<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\TratamientoFarmacologico\Controllers\TratamientoFarmacologicoController;


Route::prefix('tratamiento-farmacologico', 'throttle:60,1')->group(function () {
	Route::controller(TratamientoFarmacologicoController::class)->group(function () {
		Route::post('agregar-tratamiento', 'agregarTratamiento');
		Route::get('listar-tratamientos-afiliado/{afiliadoId}', 'listarTratamientosAfiliado');
		Route::delete('eliminar-tratamiento/{id}', 'eliminarTratamiento');
	});
});
