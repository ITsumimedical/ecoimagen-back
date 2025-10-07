<?php

namespace App\Http\Modules\Historia\AntecedentesHospitalarios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesHospitalarios\Models\AntecedentesHospitalario;

class AntecedentesHospitalariosRepository extends RepositoryBase {

    public function __construct(protected AntecedentesHospitalario $antecedenteModel) {
        parent::__construct($this->antecedenteModel);
    }

    // public function listarHospitalario($data) {
    //     return AntecedentesHospitalario::with('consulta','user')->where('consulta_id',$data['consulta'])->first();
    // }

    public function crearAntecedente($data){
       $this->antecedenteModel::updateOrCreate(['consulta_id' => $data['consulta_id']],$data);
    }

    public function listarAntecedentes($data) {
        return $this->antecedenteModel::select('cantidad_hospitalizaciones','fecha_ultimas_hospitalizaciones','descripcion_hospiurg','hospitalizacion_uci','fecha_hospitalizacion_uci_ultimo_ano','descripcion_hospi_uci','consulta_id','medico_registra')
        ->with('consulta:id,afiliado_id','user:id','user.operador:user_id,nombre,apellido')->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado)
            ->whereNotNull('hospitalizacion_uci');
        })->get();
    }

    public function eliminarAntecedente($id)
    {
        $resultado = $this->antecedenteModel->findOrFail($id);
        return $resultado->delete();
    }

}
