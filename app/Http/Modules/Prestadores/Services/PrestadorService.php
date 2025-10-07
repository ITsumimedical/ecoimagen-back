<?php
namespace App\Http\Modules\Prestadores\Services;

use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Prestadores\Repositories\PrestadorRepository;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PrestadorService
{
    protected $repository;

    public function __construct(){
        $this->repository = new PrestadorRepository();
    }

    public function cambioEstado($prestador,$data){

        $prestador->update([
            'activo' => $data['activo']
        ]);

        $sedes = Rep::where('prestador_id', $data['id'])->get();

        if($sedes){
            foreach($sedes as $sede){
                $sede->update([
                    'activo' => $data['activo']
                ]);
            }
        }

        $contratos = Contrato::where('prestador_id',$data['id'])->get();

        foreach ($contratos as $contrato) {
            $contrato->update([
                'activo' => $data['activo']
            ]);

            $tarifas = Tarifa::where('contrato_id',$contrato->id)->get();
            if($tarifas){
                foreach($tarifas as $tarifa){
                    $tarifa->update([
                        'activo' => $data['activo']
                    ]);
                }
            }
        }

        return true;

    }

    public function tieneContrato($prestador_id) {
        return Contrato::select('id','entidad_id','activo','ambito_id')->with('entidad:id,nombre')->where('prestador_id',$prestador_id)->get();
    }

}
