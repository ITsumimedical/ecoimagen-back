<?php

namespace App\Http\Modules\Audit\Services;

use App\Http\Modules\Audit\Model\audit;

class AuditService
{

    public function __construct(
        protected audit $cuestionarioGad2model,
    ) {}

    public function updateOrCreate(array $conditions, array $data)
    {
        return Audit::updateOrCreate($conditions, $data);
    }
}
