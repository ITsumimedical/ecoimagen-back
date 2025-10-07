<?php

namespace App\Http\Modules\Caracterizacion\Services;

use App\Http\Modules\Afiliados\Models\CaracterizacionAfiliado;
use App\Http\Modules\Caracterizacion\Models\AuditoriaCaracterizacion;
use App\Http\Modules\Caracterizacion\Models\Caracterizacion;
use App\Http\Modules\Caracterizacion\Repositories\CaracterizacionRepository;
use Illuminate\Support\Facades\Auth;

class CaracterizacionService
{
    public function __construct(
        protected CaracterizacionRepository $caracterizacionRepository,
        protected Caracterizacion $caracterizacionModel,
        protected AuditoriaCaracterizacion $auditoriaCaracterizacion
    ) {}

    public function crearCaracterizacion($request)
    {
        $afiliadoId = $request['afiliado_id'];

        // Verificar si el afiliado ya tiene una caracterización
        if ($this->afiliadoTieneCaracterizacion($afiliadoId)) {
            throw new \Exception('El afiliado ya tiene una caracterización creada. Utilice la actualización.');
        }

        $request['usuario_registra_id'] = Auth()->id();
        $this->caracterizacionRepository->crear($request);
    }

    public function actualizarCaracterizacion($id, array $datos)
    {

        try {
            $caracterizacionModel = $this->caracterizacionModel->findOrFail($id);

            $caracterizacionModel->update($datos);

            return $caracterizacionModel;
        } catch (\Exception $th) {
            throw new \Exception("Error al actualizar la caracterización: " . $th->getMessage());
        }
    }

    public function afiliadoTieneCaracterizacion($afiliadoId)
    {
        return Caracterizacion::where('afiliado_id', $afiliadoId)->exists();
    }

    public function auditoriaCaracterizacion($id)
    {
        $caracterizacion = CaracterizacionAfiliado::with([
            'afiliado',
            'practica',
            'tipoCancerPropio',
            'tipoCancerFamilia',
            'tipoMetabolicaPropio',
            'tipoMetabolicaFamilia',
            'tipoRCV',
            'tipoRespiratoria',
            'tipoInmunodeficiencia',
            'condicionRiesgo',
            'rutaPromocion'
        ])->find($id);


        $datosAntiguos = $caracterizacion->toArray();

        if (is_array($datosAntiguos) || is_object($datosAntiguos)) {
            $jsonDatos = json_encode($datosAntiguos, JSON_UNESCAPED_UNICODE);
        }

        $auditoria = $this->auditoriaCaracterizacion->create([
            'caracterizacion_id' => $id,
            'cambios_anteriores' => $jsonDatos,
            'user_id' => Auth::id(),
        ]);
        return $auditoria;
    }
}
