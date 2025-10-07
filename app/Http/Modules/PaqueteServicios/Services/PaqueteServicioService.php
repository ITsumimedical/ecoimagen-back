<?php

namespace App\Http\Modules\PaqueteServicios\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;

class PaqueteServicioService
{

    protected $model;
    public function __construct()
    {
        $this->model = new PaqueteServicio;
    }

    public function agregarCup($request, $paquete_id)
    {
        $paquete = PaqueteServicio::where('id', $paquete_id)->first();
        foreach ($request as $cup) {
            $attach = $paquete->cup()->attach($cup['id']);
        }
        return $attach;
    }

    // public function agregarCodigosPropios($request, $paquete_id)
    // {
    //     $paquete = PaqueteServicio::where('id', $paquete_id)->first();
    //     foreach ($request as $codigoPropio) {
    //         $attach = $paquete->propios()->attach($codigoPropio['id']);
    //     }
    //     return $attach;
    // }

    public function agregarCodigoPropio($request, $paquete_id)
    {
        $paquete = PaqueteServicio::findOrFail($paquete_id);

        foreach ($request as $codigoPropio) {
            if (isset($codigoPropio['id'])) {
                $paquete->propios()->attach($codigoPropio['id']);
            } else {
                // Manejar el caso donde 'id' no está presente en $codigoPropio
                throw new \Exception("ID no presente en el código propio");
            }
        }

        return response()->json(['message' => 'Códigos propios agregados exitosamente'], 200);
    }


}