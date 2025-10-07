<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Repositories;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Models\RadicacionGlosaSumimedical;

class RadicacionGlosasSumimedicalRepository extends RepositoryBase {

    protected $radicacion;
    public function __construct() {
        $this->radicacion = new RadicacionGlosaSumimedical();
        parent::__construct($this->radicacion);
    }

    public function crearActualizar($data){
        $estado = $data['tipo'] == 'Conciliar' ? 1:2;
        $glosa = $this->radicacion::updateOrCreate(['glosa_id' =>  $data['id']],
        [
         'respuesta_sumimedical' => $data['respuesta_sumimedical'],
         'valor_no_aceptado' => $data['valorNoAceptadoSumi'],
         'valor_aceptado' => $data['valorAceptadoSumi'],
         'glosa_id' =>  $data['id'],
         'user_id'=> Auth::user()->id,
         'estado_id' => $estado
        ]);
    return $glosa;

    }

    public function actualizarGlosa($e){
         $this->radicacion::where('glosa_id',$e['glosa_id'])
        ->update([
            'acepta_ips' => $e['acepta_ips'],
            'levanta_sumi' => $e['levanta_sumi'],
            'no_acuerdo' => $e['no_acuerdo'],
            'estado_id' => 20
        ]);
    }

    public function actualizarEstado($e){
        $this->radicacion::where('glosa_id',$e['glosa_id'])
        ->where('estado_id',20)
        ->where('no_acuerdo','0')
       ->update([
           'estado_id' => 2
       ]);
   }

   public function actualizarGlosaAdministrativa($e){
    $this->radicacion::where('glosa_id',$e['glosa_id'])
   ->update([
       'valor_no_aceptado' => $e['glosa_inicial'],
       'acepta_ips' => $e['acepta_ips'],
       'levanta_sumi' => $e['levanta_sumi'],
       'no_acuerdo' => $e['no_acuerdo'],
       'estado_id' => 20
   ]);
}

public function actualizarGlosaConSaldo($e){
    $this->radicacion::where('glosa_id',$e['glosa_id'])
   ->update([
       'acepta_ips' => $e['acepta_ips'],
       'levanta_sumi' => $e['levanta_sumi'],
       'no_acuerdo' => $e['no_acuerdo'],
   ]);
}

public function informe($data){

    $appointments = Collect(DB::select("SET NOCOUNT ON exec dbo.SP_ReportesCuentasMedicas ?,?,?,?",
    [$data['fechaDesde'],$data['fechaHasta'],$data['tipo'],$data['prestador']]));
     $array = json_decode($appointments, true);
    return (new FastExcel($array))->download('CuentasMedicas.xls');
}




}
