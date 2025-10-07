<?php

namespace App\Http\Modules\Cac\Contracts;

interface ArchivoCacStrategyInterface
{
    public function generar(array $historias): array;
}
