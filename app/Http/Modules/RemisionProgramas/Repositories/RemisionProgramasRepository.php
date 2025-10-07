<?php

namespace App\Http\Modules\RemisionProgramas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Cast\Array_;

class RemisionProgramasRepository extends RepositoryBase
{

    public function __construct(protected RemisionProgramas $remisionProgramas)
    {
        parent::__construct($this->remisionProgramas);
    }


    public function crearRemision(array $data)
    {
        return $this->remisionProgramas->updateOrCreate(
            ['consulta_id' => $data['consulta_id']],
            $data
        );
    }

    public function listarPorAfiliado($data)
    {
       return $this->remisionProgramas->select(
            'remision_programas.id',
            'remision_programas.consulta_id',
            'remision_programas.remision_programa',
            'remision_programas.observacion',
            'consultas.id as consulta',
            'consultas.afiliado_id',
            'consultas.medico_ordena_id as medico_registra',
            'operadores.nombre',
            'operadores.apellido'
        )
        ->join('consultas',  'remision_programas.consulta_id', 'consultas.id')
        ->join('users', 'consultas.medico_ordena_id', 'users.id')
        ->join('operadores', 'operadores.user_id', 'users.id')
        ->where('consultas.afiliado_id', $data)
        ->get();
    }

    public function eliminarRemision($id)
    {
        $remisionProgramas = $this->remisionProgramas->findOrFail($id);
        return $remisionProgramas->delete();
    }
}
