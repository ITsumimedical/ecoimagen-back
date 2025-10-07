<?php

use App\Http\Modules\Interoperabilidad\InteroperabilidadOrdenesController;
use App\Jobs\FormulaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\FastExcel\FastExcel;

/**
 * fomag
 */
Route::middleware('client')->group(function () {
    /** actualizar orden */
    Route::controller(InteroperabilidadOrdenesController::class)->group(function () {
        Route::post('/v1/ordenamiento/transcripcion/{orden}', 'respuestaTranscripcion');
        Route::put('/v1/ordenamiento/actualizar-detalle/rep/{detalle}', 'actualizarRep');
        Route::put('/v1/ordenamiento/actualizar-detalle/estado/{detalle}', 'actualizarEstado');
        Route::post('v1/ordenamiento/crear-orden-medicamento', 'crearOrdenMedicamento');
        Route::post('v1/ordenamiento/crear-orden-procedimiento', 'crearOrdenProcedimiento');
    });
});

// Route::post('yurany/consolidado', function (Request $request) {
//     set_time_limit(0);
//     $nombreCarpeta = 'tmp/glosa_2';
//     $rows = (new FastExcel())->import($request->file('file'), function ($row) use ($nombreCarpeta) {
//         $row['nombre'] = $nombreCarpeta . '/' . $row['DOCUMENTO'] . '-' . $row['NUMERO DE FORMULA'] . '.pdf';
//         $row['NUMERO DE FORMULA'] = intval($row['NUMERO DE FORMULA']);
//         return $row;
//     })->unique('NUMERO DE FORMULA')->toArray();
//     $errores = [];
//     foreach ($rows as $row) {
//         FormulaMedica::dispatch($row['NUMERO DE FORMULA'], $row['nombre'], $nombreCarpeta, $errores);
//     }
//     return response()->json(['message' => 'Proceso iniciado'], 200);
// });