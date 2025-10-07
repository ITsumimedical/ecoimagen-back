<?php

namespace App\Http\Modules\SalarioMinimo\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Homologo\Models\Homologo;
use App\Http\Modules\NovedadContratos\Models\novedadContrato;
use App\Http\Modules\ParametroSalarioMinimo\Model\parametros_salario_minimo;
use App\Http\Modules\SalarioMinimo\Models\SalarioMinimo;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpseclib3\Exception\FileNotFoundException;

class SalarioMinimoRepository extends RepositoryBase {

    protected $model;

    public function __construct(){
        $this->model = new SalarioMinimo();
        parent::__construct($this->model);
    }

    public function listarSalario($data)
    {
        $consulta = $this->model->orderBy('anio', 'desc');
        return $consulta->get();
    }

    public  function crearSalario($data)
    {
        $this->model->create([
            'anio' => $data['anio'],
            'valor' => $data['valor']
        ]);
        $appointments = Collect(DB::select("SET NOCOUNT ON exec dbo.SP_salarioMinimo ?,?",[$data['anio'],$data['valor']]));

        return true;
    }

    public function cambioValores($data, $request)
    {
        $salario = $this->model->where('id',$data->id)->first();

        $salario->update([
            'valor' => $request['valor'],
        ]);

    }

    public function listarParametros($data){
       $parametros = parametros_salario_minimo::where('salario_minimo_id',$data->id)->get();
       return $parametros;
    }

    public function parametros($data, $request)
    {

        parametros_salario_minimo::create([
            'salario_minimo_id' => $data->id,
            'rango' => $request['rango'],
            'valorCuota' => $request['valorCuota'],
            'valorCopagos' => $request['valorCopagos'],
            'valorEvento' => $request['valorEvento'],
            'valorCuotaAnual' => $request['valorCuotaAnual'],
            'valorCopagosAnual' => $request['valorCopagosAnual'],
            'valorEventoAnual' => $request['valorEventoAnual'],
        ]);

        return true;

    }
}
