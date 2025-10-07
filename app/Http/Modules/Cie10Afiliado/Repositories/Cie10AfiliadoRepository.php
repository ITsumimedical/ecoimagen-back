<?php

namespace App\Http\Modules\Cie10Afiliado\Repositories;


use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Support\Carbon;

class Cie10AfiliadoRepository extends RepositoryBase
{


    public function __construct(protected Cie10Afiliado $cie10Model, protected Consulta $consultoModel)
    {
        parent::__construct($this->cie10Model);
    }

    public function crearCie10Paciente($cie10, $consulta)
    {
        $data = [];
        foreach ($cie10 as $index => $c10) {
            $data[] = [
                'cie10_id' => $c10,
                'consulta_id' => $consulta,
                'esprimario' => $index === 0 ? 1 : 0,
                'tipo_diagnostico' => null,
                'created_at' => now(),
            ];
        }

        $this->cie10Model->insert($data);

        $ciePrimario = $cie10[0];
        $this->consultoModel->where('id', $consulta)->update(['diagnostico_principal' => $ciePrimario]);
    }

    public function crearCie10PacienteTeleapoyo($cie10, $consulta)
    {
        $data = [];
        foreach ($cie10 as $index => $c10) {
            $data[] = [
                'cie10_id' => $c10,
                'consulta_id' => $consulta,
                'esprimario' => $index === 0 ? 1 : 0,
                'tipo_diagnostico' => null,
                'created_at' => now(),
            ];
        }

        $this->cie10Model->insert($data);

        $ciePrimario = $cie10[0];
        $this->consultoModel->where('id', $consulta)->update(['diagnostico_principal' => $ciePrimario]);
    }

    public function crearCie10Consulta($data)
    {
        $diagnostico =  $this->cie10Model::where('consulta_id', $data['consulta_id'])->where('esprimario', 1)->first();
        $this->cie10Model->create([
            'cie10_id' => $data['cie10_id'],
            'consulta_id' => $data['consulta_id'],
            'esprimario' => $diagnostico ? 0 : 1,
            'tipo_diagnostico' => $data['tipo']
        ]);
        $diagnosticoCreado = $this->cie10Model::where('consulta_id', $data['consulta_id'])->where('esprimario', 1)->first();
        $this->consultoModel->where('id', $data['consulta_id'])->update(['diagnostico_principal' => $diagnosticoCreado->cie10_id]);
    }

    public function listarCie10Historico($data)
    {
        return $this->cie10Model::where('consulta_id', $data['consulta'])
            ->with(['cie10.eventoSivigila'])->get();
    }

    public function eliminarCie10Afi($data)
    {
        $this->cie10Model::where('id', $data['id'])->delete();

        $registros = $this->cie10Model::where('consulta_id', $data['consulta_id'])->get();

        $esprimario = $registros->contains('esprimario', true);

        if (!$esprimario && $registros->isNotEmpty()) {
            $registros->first()->update(['esprimario' => true]);
        }
    }

    public function verificarDiagnosticosAsociados($consultaId)
    {
        return $this->cie10Model::where('consulta_id', $consultaId)->exists();
    }


    /**
     * Crea un nuevo diagnóstico para la consulta
     * @param int $cie10
     * @param int $consulta
     * @param int $key
     * @param string $tipo_diagnostico
     * @return void
     * @author Thomas
     */
    public function crearCie10AfiliadoTelesalud($cie10, $consulta, $key, $tipo_diagnostico)
    {
        $this->cie10Model->create([
            'cie10_id' => $cie10,
            'consulta_id' => $consulta,
            'esprimario' => $key === 0 ? 1 : 0,
            'tipo_diagnostico' => $tipo_diagnostico
        ]);
    }

    public function verificarDiagnosticoPrimario(int $consultaId)
    {
        return $this->cie10Model->where('consulta_id', $consultaId)->where('esprimario', true)->exists();
    }

    /**
     * verificarExisteDiagnostico - valida en el modelo cie10Afiliado si existe registro de diagnóstico relacionado a la consulta_id
     *
     * @param  mixed $consultaId
     * @return void
     */
    public function verificarExisteDiagnostico(int $consultaId)
    {
        return $this->cie10Model->where('consulta_id', $consultaId)->exists();
    }

    public function diagnosticoPrimario(int $consultaId){
        return $this->cie10Model::select('cie10s.codigo_cie10','cie10s.nombre')
        ->join('cie10s','cie10s.id','cie10_afiliados.cie10_id')
        ->where('consulta_id', $consultaId)->where('esprimario', true)->first();
    }
}
