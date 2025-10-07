<?php

namespace App\Http\Modules\EntidadesCodesumiParametrizacion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;

class CodesumiEntidadRepository extends RepositoryBase {

    public function __construct(protected CodesumiEntidad $codesumiEntidad)
    {
        parent::__construct($this->codesumiEntidad);
    }

    public function listarParametrizacionesCodesumi($codesumi_id){
        return $this->codesumiEntidad->where('codesumi_id', $codesumi_id)->with(['codesumi:id,codigo,nombre','codesumi.medicamentos', 'entidad:id,nombre', 'programaCodesumi'])->orderBy('id', 'desc')->get();
    }
}
