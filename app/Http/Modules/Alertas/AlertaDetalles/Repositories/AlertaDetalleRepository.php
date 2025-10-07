<?php

namespace App\Http\Modules\Alertas\AlertaDetalles\Repositories;

use App\Http\Modules\Alertas\AlertaDetalles\Model\alertaDetalles;
use App\Http\Modules\Bases\RepositoryBase;

class AlertaDetalleRepository extends RepositoryBase
{
    protected $alertaDetalles;

    public function __construct()
    {
        $this->alertaDetalles = new alertaDetalles();
        parent::__construct($this->alertaDetalles);
    }

    public function historial($idAlerta)
    {
        try {
            $historial = alertaDetalles::where('alerta_id', $idAlerta)
                ->with(['alerta', 'tipoAlerta', 'mensajeAlerta', 'usuarioRegistra.operador', 'estado'])
                ->get();
            return $historial;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function cambiarEstado($id)
    {
        $alertaDetalles = alertaDetalles::find($id);
        if ($alertaDetalles) {
            if ($alertaDetalles->estado_id == 1) {
                $alertaDetalles->estado_id = 2;
            } elseif ($alertaDetalles->estado_id == 2) {
                $alertaDetalles->estado_id = 1;
            }
            $alertaDetalles->save();
            return $alertaDetalles;
        }
        throw new \Exception('Alerta no encontrada');
    }

    public function actualizar($data, $id)
    {
        $alertaDetalle = alertaDetalles::find($id);
        if ($alertaDetalle) {
            $alertaDetalle->update($data);
            return $alertaDetalle;
        } else {

            throw new \Exception('Alerta detalle no encontrado');
        }
    }
}
