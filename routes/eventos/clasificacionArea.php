<?php

use App\Http\Modules\Eventos\ClasificacionAreas\Controllers\ClasificacionAreaController;
use Illuminate\Support\Facades\Route;

Route::prefix('clasificaciones-areas')->group( function () {
    Route::controller(ClasificacionAreaController::class)->group(function (){
        Route::get('listar','listar');//->middleware('permission:clasificacionArea.listar');
        Route::get('{suceso_id}', 'listarConSuceso');//->middleware('permission:clasificacionArea.listar');
        Route::post('crear','crear');//->middleware('permission:clasificacionArea.crear');
        Route::put('/{id}','actualizar');//->middleware('permission:clasificacionArea.actualizar');
    });
});
