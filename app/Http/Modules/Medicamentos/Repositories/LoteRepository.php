<?php

namespace App\Http\Modules\Medicamentos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Medicamentos\Models\BodegaMedicamento;
use App\Http\Modules\Medicamentos\Models\Lote;

class LoteRepository extends RepositoryBase
{

    public function __construct(protected Lote $loteModel) {
        parent::__construct($this->loteModel);
    }

    public function actualizarCantidad($lote_id,$cantidadAprobada)
    {
       $lote =  $this->loteModel->find($lote_id);
       $cantidadLote = intval($lote->cantidad);
         $lote->update([
        'cantidad' => $cantidadLote - abs(intval($cantidadAprobada))
       ]);
       return $lote;
    }

    public function buscarLote($datos){

       // Verifica si se debe crear un nuevo lote
    if ($datos['nuevoLote']) {
        // Crea un nuevo registro en BodegaMedicamento
        $bodegaMedicamentos = BodegaMedicamento::create([
            'medicamento_id' => $datos["medicamento_id"],
            'bodega_id' => $datos['bodega'],
            'cantidad_total' => $datos["cantidad_inicial"],
        ]);

        // Crea un nuevo lote asociado al BodegaMedicamento creado
        Lote::create([
            'bodega_medicamento_id' => $bodegaMedicamentos->id,
            'codigo' => $datos["lote"],
            'fecha_vencimiento' => $datos["fecha_vencimiento"],
            'cantidad' => $datos["cantidad_inicial"],
        ]);
    }

    // Busca el lote con los criterios especificados
    $lote = $this->loteModel::select('lotes.cantidad', 'lotes.fecha_vencimiento', 'lotes.codigo', 'lotes.bodega_medicamento_id')
        ->with(['bodegaMedicamento', 'bodegaMedicamento.medicamento','bodegaMedicamento.medicamento.invima:id,cum_validacion,forma_farmaceutica','bodegaMedicamento.medicamento.codesumi:id,nombre'])
        ->where('lotes.codigo', $datos['lote']['codigo'])
        ->whereHas('bodegaMedicamento', function ($q) use ($datos) {
            $q->where('bodega_id', $datos['bodega']);
            $q->where('medicamento_id', $datos['medicamento_id']);
        })
        ->first();

    // Si se encuentra el lote, prepara los datos para retornar
    if ($lote) {
        // dd($lote);
        $data = $lote->toArray();
        $lotes = [
            'articulo' => $data["bodega_medicamento"]["medicamento"],
            'lote' => $data["codigo"],
            'fecha_vencimiento' => $data["fecha_vencimiento"],
            'cantidad_inicial' => $datos["cantidad_inicial"],
            'descripcion' => $datos["descripcion"],
            'observacion' => $datos["observacion"],
            'medicamento_id' => $data["bodega_medicamento"]["medicamento"]["id"],
            'bodega_medicamento_id' => $data["bodega_medicamento"]["id"],
        ];
        return $lotes;
    } else {
        // Si no se encuentra el lote, retorna los datos proporcionados
        $lotes = [
            'articulo' => $datos["articulo"],
            'lote' => $datos["lote"]["codigo"],
            'fecha_vencimiento' => $datos["fecha_vencimiento"],
            'cantidad_inicial' => $datos["cantidad_inicial"],
            'descripcion' => $datos["descripcion"],
            'observacion' => $datos["observacion"],
            'medicamento_id' => $datos["medicamento_id"],
        ];
        return $lotes;
    }

    }

    public function loteMedicamentoEntrada($datos) {
        $lote = $this->loteModel::select('lotes.cantidad','lotes.id','lotes.fecha_vencimiento','lotes.codigo')
        ->with(['bodegaMedicamento','bodegaMedicamento.medicamento'])
        ->whereHas('bodegaMedicamento', function ($q) use ($datos) {
            $q->where('bodega_id', $datos['bodega']);
            $q->where('medicamento_id', $datos['medicamento_id']);
        })
        ->get();

        return $lote;

    }

    public function loteMedicamentoSalida($datos) {
        $lote = $this->loteModel::select('lotes.cantidad','lotes.id','lotes.fecha_vencimiento','lotes.codigo')
        ->with(['bodegaMedicamento:id'])
        ->whereHas('bodegaMedicamento', function ($q) use ($datos) {
            $q->where('bodega_id', $datos['bodega']);
            $q->where('medicamento_id', $datos['medicamento_id']);
        })->where('cantidad', '>', 0)
        ->get();

        return $lote;

    }

     /**
	 * obtiene el lote
	 * @param int $bodegaMedicamento
	 * @return $lote
	 * @author Jdss
     */
    public function buscarLoteExacto($lote,int $bodegaMedicamento){
        return $this->loteModel::select('id','codigo','cantidad','fecha_vencimiento','bodega_medicamento_id','estado_id')
        ->where('lotes.codigo', $lote["lote"])
        ->where('lotes.fecha_vencimiento', $lote["fecha"])
        ->where('lotes.bodega_medicamento_id', $bodegaMedicamento)
         ->first();
    }

     /**
	 * actualiza el lote
	 * @param int $id
     * @param array $data
	 * @return $lote
	 * @author Jdss
     */

     public function actualizarLote(int $id, array $data){
        return $this->loteModel::where('id',$id)
        ->update($data);
    }





}
