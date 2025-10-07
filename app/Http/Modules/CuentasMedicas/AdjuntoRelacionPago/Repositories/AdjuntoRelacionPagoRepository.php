<?php

namespace App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Repositories;

use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Models\AdjuntoRelacionPago;
use App\Http\Modules\Prestadores\Models\Prestador;

class AdjuntoRelacionPagoRepository extends RepositoryBase {


    public function __construct(protected AdjuntoRelacionPago $adjuntoRelacionPagoModel) {
        parent::__construct($this->adjuntoRelacionPagoModel);
    }

    public function buscarCargaPagos($data){

         $pagos = $this->adjuntoRelacionPagoModel::where('prestador_id',$data['prestador_id'])
        ->where('fecha',$data['fecha'])
        ->where('activo',1);

        return $data['page'] ? $pagos->paginate($data['cantidad']) : $pagos->get();
    }

    public function crearAdjunto($data){
        $this->adjuntoRelacionPagoModel::create($data);
    }


    public function buscarPagosPrestador($data){

        $operador = Operadore::where('user_id',auth()->user()->id)->first();

        $pagos = $this->adjuntoRelacionPagoModel::where('prestador_id',$operador->prestador_id)
       ->where('fecha',$data['fecha'])
       ->where('activo',1);

       return $data['page'] ? $pagos->paginate($data['cantidad']) : $pagos->get();
   }


   public function eliminar($id){
    $teleapoyo = $this->model::find($id);
    return $teleapoyo->update([
      'activo' => false
    ]);
    }

    public function estadoCuenta($data){

        $operador = Operadore::where('user_id',auth()->user()->id)->first();
        $prestador = Prestador::find($operador->prestador_id);

        // $appointments = Collect(DB::select("SET NOCOUNT ON exec dbo.SP_ReportesCuentasMedicas ?,?",[$prestador->nit,$data['fecha']]));
        //  $array = json_decode($appointments, true);
        // return (new FastExcel($array))->download('CuentasMedicas.xls');
    }





}
