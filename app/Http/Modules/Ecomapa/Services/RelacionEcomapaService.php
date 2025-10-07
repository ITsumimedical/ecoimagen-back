<?php

namespace App\Http\Modules\Ecomapa\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelacionEcomapaService
{

    public function crearRelacion($data)
    {
        foreach ($data['relaciones'] as $relacion) {
            DB::table('relacion_ecomapas')->insert([
                'figura_origen_id' => $relacion['figura_origen_id'],
                'figura_destino_id' => $relacion['figura_destino_id'],
                'tipo_relacion' => $relacion['tipo_relacion'],
            ]);
        }
    }
}
