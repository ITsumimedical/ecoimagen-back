<?php

namespace App\Http\Modules\NotaAclaratoria\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NotaAclaratoria\Models\NotaAclaratoria;

class NotaAclaratoriaRepository extends RepositoryBase
{

    protected $notaAclaratoriaModel;

    public function __construct(NotaAclaratoria $notaAclaratoriaModel)
    {
        $this->$notaAclaratoriaModel = $notaAclaratoriaModel;
        parent::__construct($this->$notaAclaratoriaModel);
    }


    public function listarNota($data){
        return NotaAclaratoria::select('nota_aclaratorias.descripcion','nota_aclaratorias.id', 'nota_aclaratorias.created_at' , 'nota_aclaratorias.user_id', 'operador.nombre', 'operador.apellido', 'operador.documento')
        ->leftJoin('operadores as operador', 'operador.user_id', '=', 'nota_aclaratorias.user_id')
        ->join('historia_clinica_nota_aclaratoria','historia_clinica_nota_aclaratoria.nota_aclaratoria_id','nota_aclaratorias.id')
        ->where('historia_clinica_nota_aclaratoria.historia_clinica_id',$data['historia'])->get();
    }

}
