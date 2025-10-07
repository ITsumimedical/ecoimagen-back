<?php


use App\Http\Modules\TipoRutas\Controllers\TipoRutaController;
use Illuminate\Support\Facades\Route;

Route::prefix('tipo-rutas', 'throttle:60.1')->group(function () {
    Route::controller(TipoRutaController::class)->group(
        function () {
            Route::post('crear-tipo-ruta', 'crearTipoRuta')->middleware('can:tipoRuta.crear');
            Route::post('listar-todas','listarTodas')->middleware('can:tipoRuta.listar');
            Route::get('listar-ruta-por-id/{ruta}', 'listarRutaPorId')->middleware('can:tipoRuta.listarDetalles');
            Route::post('actualizar-ruta/{ruta}','actualizarRuta')->middleware('can:tipoRuta.actualizar');
        }
    );
});
