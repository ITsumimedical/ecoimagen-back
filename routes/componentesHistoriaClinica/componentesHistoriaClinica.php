<?php

use App\Http\Modules\ComponentesHistoriaClinica\Controller\ComponenteHistoriaController;
use Illuminate\Support\Facades\Route;


Route::prefix('componentes-historia-clinica')->group(function (){
    Route::controller(ComponenteHistoriaController::class)->group(function (){
        Route::post('crear-componente-historia-clinica', 'crearComponente');
        Route::get('listar-componente-historia-clinica', 'listarComponentes');
        Route::put('actualizar-componente/{id}', 'actualizar');
        Route::get('listar-componentes-escalas','listarComponentesEscalas');
    });
});
