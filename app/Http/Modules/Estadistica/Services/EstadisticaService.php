<?php

namespace App\Http\Modules\Estadistica\Services;

use App\Http\Modules\Estadistica\Models\Estadistica;
use App\Http\Modules\Estadistica\Repositories\EstadisticaRepository;
use Illuminate\Http\Request;

class EstadisticaService
{

    public function __construct(protected EstadisticaRepository $estadisticaRepository)
    {
    }

    public function crearEstadistica(Request $request)
    {
        $usuario_registra_id = auth()->id();
            Estadistica::create([
                'titulo' => $request->titulo,
                'inframe' => $request->inframe,
                'permission_id' => $request->permission_id,
                'estado_id' => 1,
                'usuario_registra_id' => $usuario_registra_id,
            ]);
            return response()->json([
                'message' => 'Estadística creada con éxito'
            ]);
        }
    }
