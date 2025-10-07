<?php

namespace App\Http\Modules\ContratosMedicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContratosMedicamentos\Models\ContratosMedicamentos;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class ContratosMedicamentosRepository extends RepositoryBase
{
    protected ContratosMedicamentos $contratosMedicamentosModel;

    public function __construct()
    {
        $this->contratosMedicamentosModel = new ContratosMedicamentos();
        parent::__construct($this->contratosMedicamentosModel);
    }


    /**
     * Lista los contratos de un prestador
     * @param array $request
     * @return LengthAwarePaginator
     * @author Thomas
     */
    public function listarContratosPrestador(array $request): LengthAwarePaginator
    {
        $prestadorId = $request['prestador'];

        return $this->contratosMedicamentosModel
            ->with([
                'prestador:id,nombre_prestador',
                'entidad:id,nombre',
                'ambito:id,nombre',
                'estado:id,nombre',
            ])
            ->where('prestador_id', $prestadorId)
            ->paginate($request['cantidadRegistros'], ['*'], 'page', $request['pagina']);
    }

    /**
     * Listar detalles de un contrato
     * @param int $contratoId
     * @return Model|null
     * @author Thomas
     */
    public function listarDetallesContrato(int $contratoId): ?Model
    {
        return $this->contratosMedicamentosModel
            ->with(['entidad:id,nombre',])
            ->where('id', $contratoId)
            ->first();
    }

    /**
     * Edita un contrato
     * @param mixed $contratoId
     * @param array $data
     * @return bool
     * @author Thomas
     */
    public function editarContrato($contratoId, array $data): bool
    {
        $contrato = $this->contratosMedicamentosModel->findOrFail($contratoId);
        return $contrato->update($data);
    }

    /**
     * Cambia el estado de un contrato, si no se propociona se cambia al estado activo o inactivo dependiendo del estado actual
     * @param int $contratoId
     * @param int|null $estadoId
     * @return bool
     * @author Thomas
     */
    public function cambiarEstadoContrato(int $contratoId, int|null $estadoId): bool
    {
        $contrato = $this->contratosMedicamentosModel->findOrFail($contratoId);

        $estadoActivo = 1;
        $estadoInactivo = 2;

        // Alternar estado si no se proporciona
        $estadoNuevo = $estadoId ?? ($contrato->estado_id == $estadoActivo ? $estadoInactivo : $estadoActivo);

        return $contrato->update(['estado_id' => $estadoNuevo]);
    }
}
