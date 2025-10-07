<?php

namespace App\Http\Modules\Recomendaciones\Services;

use App\Http\Modules\Recomendaciones\Models\Recomendaciones;
use App\Http\Modules\Recomendaciones\Repositories\RecomendacionesRepository;

class RecomendacionesService
{

    public function __construct(
        private RecomendacionesRepository $recomendacionRepository,

    ) {}


    /**
     * crearRecomendacion - Crear un registro de recomendación por cada cie10_id
     *
     * @param  mixed $request
     * @return void
     */
    public function crearRecomendacion(array $data): array
    {
        $recomendaciones = [];

        foreach (['cie10_id', 'cup_id'] as $campo) {
            if (!isset($data[$campo]) || !is_array($data[$campo])) {
                continue;
            }

            foreach ($data[$campo] as $id) {
                $recomendaciones[] = [
                    'descripcion' => $data['descripcion'],
                    'user_id' => $data['user_id'],
                    $campo => $id,
                    'estado_id' => $data['estado_id'] ?? 1,
                    'edad_minima' => $data['edad_minima'] ?? null,
                    'edad_maxima' => $data['edad_maxima'] ?? null,
                    'sexo' => $data['sexo'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (empty($recomendaciones)) {
            throw new \Exception('No se proporcionaron CIE10 ni CUPS para crear recomendaciones.');
        }

        Recomendaciones::insert($recomendaciones);

        return $recomendaciones;
    }


    public function cambiarEstado($id)
    {
        $recomendacion = Recomendaciones::findOrFail($id);
        $recomendacion->estado_id = $recomendacion->estado_id == 1 ? 2 : 1;

        $recomendacion->save();
    }
}
