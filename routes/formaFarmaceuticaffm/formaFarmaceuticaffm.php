<?php

use App\Http\Modules\FormaFarmaceuticaffm\Controller\FormaFarmaceuticaffmController;
use Illuminate\Support\Facades\Route;

Route::prefix('forma-farmaceutica-ffm')->group(function () {
    Route::controller(FormaFarmaceuticaffmController::class)->group(function (){
        Route::post('crear','crearFormaFarmaceutica');
        Route::get('listar','listarFormasFarmaceuticas');
        Route::put('actualizar/{id}','actualizarFormasFarmaceuticas');
        Route::put('cambiar-estado/{id}','cambiarEstado');
        Route::delete('eliminar/{id}','eliminar');
    });
});
