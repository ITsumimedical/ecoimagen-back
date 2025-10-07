<?php

namespace App\Http\Modules\Codesumis\codesumis\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CodesumiRepository extends RepositoryBase
{

    private $codesumiModel;

    public function __construct()
    {
        $this->codesumiModel = new Codesumi();
        parent::__construct($this->codesumiModel);
    }

    public function listarCodesumis(Request $request)
    {
        $consulta =  $this->codesumiModel
        ->with('estado', 'grupoTerapeutico', 'subgrupoTerapeutico',
        'formaFarmaceutica', 'lineaBase', 'grupo', 'viasAdministracion',
        'medicamentos.invima','programasFarmacia', 'viasAdministracion')
        ->whereCodigo($request->codigo)
        ->whereProducto($request->producto);

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();

        $resultados->makeHidden('principio_activo');

        return $resultados;
    }


    public function actualizar($id, $datosActualizados)
    {
        $codesumi = Codesumi::findOrFail($id);

        if ($codesumi) {
            // Actualizar los datos del codesumi
            $codesumi->fill($datosActualizados)->save();

            // Actualizar la relación muchos a muchos con programas de farmacia
            if (isset($datosActualizados['programa_farmacia_id'])) {
                $codesumi->programasFarmacia()->sync([]);
                foreach ($datosActualizados['programa_farmacia_id'] as $proceso) {
                    if (isset($proceso['id'])) {
                        $codesumi->programasFarmacia()->attach([$proceso['id']]);
                    } else {
                        $codesumi->programasFarmacia()->attach([$proceso]);
                    }
                }
            }

            // Verificar si se ha proporcionado un nuevo valor para 'principio_activo'
            if (isset($datosActualizados['principio_activo'])) {
                $principioActivo = $datosActualizados['principio_activo'];

                // Actualizar el campo 'principio_activo' en todos los medicamentos relacionados con el codesumi
                DB::table('medicamentos')
                    ->where('codesumi_id', $id) // Filtrar por el codesumi_id
                    ->update(['principio_activo' => $principioActivo]); // Actualizar el campo principio_activo
            }

            return $codesumi;
        } else {
            throw new \Exception('No se encontró el registro para actualizar');
        }
    }


    public function Buscarcodesumi($nombre) {
         return Codesumi::where('codigo', 'ILIKE', "%{$nombre}%")
                  ->orWhere('nombre', 'ILIKE', "%{$nombre}%")
                  ->where('estado_id', '!=', 2)
                  ->get();
    }

    public function codesumiEsquema($esquema){
        return $this->codesumiModel->select('codesumis.id','codesumis.codigo',
        'codesumis.nombre',
        'detalle_esquemas.dosis',
        'detalle_esquemas.unidad_medida',
        'detalle_esquemas.via',
        'detalle_esquemas.dosis_formulada',
        'detalle_esquemas.cantidad_aplicaciones',
        'detalle_esquemas.dias_aplicacion',
        'detalle_esquemas.frecuencia',
        'detalle_esquemas.frecuencia_duracion',
        'detalle_esquemas.indice_dosis',
        'detalle_esquemas.observaciones')->join('detalle_esquemas','detalle_esquemas.codesumi_id','codesumis.id')
        ->where('detalle_esquemas.esquema_id',$esquema)->get();
    }

    public function cambiarEstadoProducto($data){
       return $this->codesumiModel::find($data['codesumi'])->update(['estado_id'=>$data['estado']]);
    }

    public function sincronizarPrincipiosActivosCodesumis($request)
    {
        $codesumi = $this->codesumiModel::findOrFail($request['codesumi_id']);
        $codesumi->principioActivos()->sync($request['principio_activo_id']);
        return $codesumi->principioActivos;
    }

    public function obtenerPrincipiosActivosAsociados($codesumi_id)
    {
        $codesumis = $this->codesumiModel::findOrFail($codesumi_id);
        $principios = $codesumis->principioActivos;
        return $principios;
    }

    public function listarViasAdministracionPorCodesumi($codesumi_id)
    {
        $codesumis = $this->codesumiModel::where('id', $codesumi_id)->first();
        return $codesumis->viasAdministracion;
    }

    /**
     * Busca un codesumi por su codigo
     * @param string $codigo
     * @return Codesumi
     * @author Thomas
     */
    public function buscarCodesumiPorCodigo(string $codigo):?Codesumi
    {
        return $this->codesumiModel->where('codigo', $codigo)->first();
    }

}
