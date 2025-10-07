<?php

namespace App\Http\Modules\OrganosFonoarticulatorios\Services;

use App\Http\Modules\OrganosFonoarticulatorios\Models\OrganosFonoarticulatorios;
class OrganosFonoarticulatoriosService
{
    public function CrearOrganoFonoarticulatorio(array $data)
    {
        return OrganosFonoarticulatorios::updateOrCreate(
            ['consulta_id' => $data['consulta_id']],$data
        );
    }
}
