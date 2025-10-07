<?php

namespace App\Http\Modules\Solicitudes\TipoSolicitud\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Solicitudes\TipoSolicitud\Models\TipoSolicitudRedVital;

class TipoSolicitudRedVitalRepository extends RepositoryBase
{

    public function __construct(protected TipoSolicitudRedVital $tipoSolicitudRedVitalModel)
    {
        parent::__construct($this->tipoSolicitudRedVitalModel);
    }

    public function listarTipo($request)
    {
        $tipo = $this->tipoSolicitudRedVitalModel
            ->select('nombre', 'descripcion', 'opcion1', 'opcion2', 'activo', 'id')
            ->orderBy('id', 'asc');

        return $request['page'] ? $tipo->paginate($request['cantidad']) : $tipo->get();
    }

    public function actualizarTipo($data)
    {

        return $this->tipoSolicitudRedVitalModel->where('id', $data['id'])
            ->update([
                'descripcion' => $data['descripcion'],
                'opcion1' => $data['opcion1'],
                'opcion2' => $data['opcion2']
            ]);
    }

    public function listarActivo()
    {
        $entidadId = Afiliado::where('user_id', Auth::id())->value('entidad_id');

        if (!$entidadId) {
            return response()->json(['message' => 'Entidad no encontrada para el usuario'], 404);
        }

        return $this->tipoSolicitudRedVitalModel->select('nombre', 'descripcion', 'id')
            ->where('activo', true)
            ->whereIn('id', function ($query) use ($entidadId) {
                $query->select('tipo_solicitud_id')
                    ->from('tipo_solicitud_entidads')
                    ->where('entidad_id', $entidadId);
            })
            ->get();
    }


    public function obtnerTipoPorId($id_tipo)
    {
        return $this->tipoSolicitudRedVitalModel->find($id_tipo);
    }

    public function cambiarEstado($data, int $id)
    {

        return  $this->tipoSolicitudRedVitalModel::find($id)->update([
            'activo' => $data['activo']
        ]);
    }
}
