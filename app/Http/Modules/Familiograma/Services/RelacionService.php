<?php

namespace App\Http\Modules\Familiograma\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelacionService {

    public function crearRelacion(Request $request)
{
    $relaciones = $request->input('relaciones');

    try {
        foreach ($relaciones as $relacion) {
            DB::table('relaciones')->insert([
                'figura_origen_id' => $relacion['figura_origen_id'],
                'figura_destino_id' => $relacion['figura_destino_id'],
                'tipo_relacion' => $relacion['tipo_relacion'],
            ]);
        }
        return response()->json(['message' => 'Relaciones guardadas exitosamente'], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al guardar relaciones: ' . $e->getMessage()], 500);
    }
}

}
