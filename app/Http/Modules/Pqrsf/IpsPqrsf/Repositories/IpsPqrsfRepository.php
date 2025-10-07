<?php

namespace App\Http\Modules\Pqrsf\IpsPqrsf\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\Pqrsf\IpsPqrsf\Model\ipsPqrsf;
use Illuminate\Http\JsonResponse;

class IpsPqrsfRepository extends RepositoryBase
{

    protected $ips;

    public function __construct()
    {
        $this->ips = new ipsPqrsf();
        parent::__construct($this->ips);
    }

    public function listarIps($data)
    {
        return   $this->ips::where('formulario_pqrsf_id', $data['pqr_id'])->with('rep')->get();
    }

    public function crearIps($ips, $pqr)
    {
        $this->ips::create(['rep_id' => $ips, 'formulario_pqrsf_id' => $pqr]);
    }

    public function eliminar($data)
    {
        return   $this->ips::find($data['rep'])->delete();
    }

    /**
     * Actualiza las ips de un PQRSF
     * @param int $pqrsfId
     * @param array<array<int>> $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarIps($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->ipsPqrsf()->syncWithoutDetaching($request['reps']);

        return response()->json(['message' => 'IPS actualizadas correctamente.']);
    }

    /**
     * Elimina una IPS de un PQRSF
     * @param int $pqrsfId
     * @param array<int> $request
     * @return JsonResponse
     * @author Thomas
     */
    public function removerIps($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        // Eliminar la relacion en la tabla intermedia
        $pqrsf->ipsPqrsf()->detach($request['rep']);

        return response()->json(['message' => 'IPS eliminada correctamente.']);
    }
}
