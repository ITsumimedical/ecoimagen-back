<?php

namespace App\Http\Modules\Medicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class BodegaMedicamentoRepository extends RepositoryBase
{

    public function __construct(protected BodegaMedicamento $medicamentoModel)
    {
        parent::__construct($this->medicamentoModel);
    }

    public function consultarBodega($data)
    {
        return $this->medicamentoModel->select(
            'bodega_medicamentos.cantidad_total as cantidadBodega',
            'lotes.codigo',
            'lotes.cantidad as cantidadLote',
            'lotes.fecha_vencimiento',
            'lotes.id',
            'bodega_medicamentos.id as bodegaMedicamento_id'
        )
            ->join('lotes', 'lotes.bodega_medicamento_id', 'bodega_medicamentos.id')
            ->where('bodega_medicamentos.medicamento_id', $data['medicamento_id'])
            ->where('bodega_medicamentos.bodega_id', $data['bodega_id'])
            ->where('lotes.cantidad', '>', '0')
            // ->where('bodega_medicamentos.estado',1)
            ->get();
    }

    public function actualizarCantidad($bodegaMedicamento_id, $cantidadAprobada)
    {
        $bodega = $this->medicamentoModel->find($bodegaMedicamento_id);
        $cantidad = intval($bodega->cantidad_total);
        $bodega->update([
            'cantidad_total' => $cantidad - abs(intval($cantidadAprobada))
        ]);

        return [
            'bodega' => $bodega,
            'cantidad' => $cantidad
        ];
    }

    public function inventario($id)
    {
        $bodega = $this->medicamentoModel::find($id);
        $stock = $this->medicamentoModel->select('bodegas.nombre', 'bodega_medicamentos.cantidad_total')
            ->join('bodegas', 'bodega_medicamentos.bodega_id', 'bodegas.id')
            ->where('bodega_medicamentos.medicamento_id', $bodega->medicamento_id)
            ->get();

        return $stock;
    }

    /**
     *
     */
    public function exportar(int $bodega_id = 0)
    {
        return DB::select("SELECT * FROM fn_medicamentos_existencias(" . strval($bodega_id) . ")");
    }

    public function listarBodega($data)
    {
        $bodegaMedicamento = $this->medicamentoModel->select('bodega_medicamentos.*')->with(['medicamento.codesumi', 'bodega']);
        if ($data->bodega) {
            // return 'fd';
            $bodegaMedicamento->where('bodega_medicamentos.bodega_id', $data->bodega);
        }

        if ($data->medicamento) {
            // return $data->medicamento;
            $bodegaMedicamento->where('bodega_medicamentos.medicamento_id', $data->medicamento);
        }

        return $data->page ? $bodegaMedicamento->paginate($data->cantidad) : $bodegaMedicamento->get();
    }

    public function guardarBodega($data)
    {

        $resultados = [];

        foreach ($data['bodegas'] as $bodega) {
            $existe = $this->medicamentoModel->where('bodega_id', $bodega['id'])->where('medicamento_id', $data['medicamento_id'])->first();

            if ($existe) {
                $resultados[] = (object)[
                    'mensaje' => 'Este medicamento ya fue asignado a esa bodega ' . $bodega['nombre']
                ];
            } else {
                $this->medicamentoModel::create([
                    'bodega_id' => $bodega['id'],
                    'medicamento_id' => $data['medicamento_id'],
                    'estado' => true
                ]);
                $resultados[] = (object)[
                    'mensaje' => 'Se asocio con éxito a la bodega ' . $bodega['nombre']
                ];
            }
        }

        return $resultados;
    }

    public function medicamentosEntrada($data)
    {
        $consulta = Medicamento::with('codesumi:id,codigo,nombre', 'invima:id,titular,cum_validacion')->select(
            'medicamentos.id as medicamento_id',
            'medicamentos.cum',
            'medicamentos.codesumi_id'
        )
            ->whereHas('codesumi', function ($query) {
                $query->where('estado_id', '!=', 2);
            })
            ->whereBodega($data);

        return $consulta->get();
    }

    public function medicamentosSalida($data)
    {
        $consulta = Medicamento::with('codesumi:id,codigo,nombre', 'invima:id,titular,cum_validacion')->select(
            'medicamentos.id as medicamento_id',
            'medicamentos.cum',
            'medicamentos.codesumi_id'
        )
            ->whereHas('codesumi', function ($query) {
                $query->where('estado_id', '!=', 2);
            })->whereBodega($data);

        return $consulta->get();
    }

    public function consultarBodegaTraslado($data)
    {
        return $this->medicamentoModel->select(
            'bodega_medicamentos.cantidad_total as cantidadBodega',
            'lotes.codigo',
            'lotes.cantidad as cantidadLote',
            'lotes.fecha_vencimiento',
            'lotes.id',
            'bodega_medicamentos.id as bodegaMedicamento_id'
        )
            ->join('lotes', 'lotes.bodega_medicamento_id', 'bodega_medicamentos.id')
            ->where('bodega_medicamentos.medicamento_id', $data['medicamento_id'])
            ->where('bodega_medicamentos.bodega_id', $data['bodega_id'])
            // ->where('bodega_medicamentos.estado',1)
            ->get();
    }

    public function inactivar($data)
    {
        $this->medicamentoModel::find($data['id'])->update(['estado' => $data['estado']]);
    }


    /**
	 * obtiene el detalle por solicitud
	 * @param int $bodega
     * @param int $medicamento
	 * @return $bodega
	 * @author Jdss
     */

    public function buscarBodega(int $bodega,int $medicamento){
     return  $this->medicamentoModel::where('bodega_id', $bodega)
        ->where('medicamento_id', $medicamento)->first();
    }

    /**
	 * actualiza el bodega medicamento
	 * @param int $id
     * @param array $data
	 * @return $bodega
	 * @author Jdss
     */
    public function actualizarBodegaMedicamento(int $id, array $data){
        return $this->medicamentoModel::where('id',$id)
        ->update($data);
    }

     /**
	 * obtiene el detalle por id
	 * @param int $id
	 * @return $bodega
	 * @author Jdss
     */

     public function buscarBodegaId(int $id){
        return  $this->medicamentoModel::where('id', $id)
           ->first();
       }
}
