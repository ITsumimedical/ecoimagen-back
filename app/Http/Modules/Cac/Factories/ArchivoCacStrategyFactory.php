<?php

namespace App\Http\Modules\Cac\Factories;

use App\Http\Modules\Cac\Contracts\ArchivoCacStrategyInterface;
use App\Http\Modules\Cac\Strategies\ArchivoCacErcStrategy;
use InvalidArgumentException;

class ArchivoCacStrategyFactory
{
    public static function make(int $patologiaId): ArchivoCacStrategyInterface
    {
        return match ($patologiaId) {
            1 => new ArchivoCacErcStrategy(), // Ej: 1 = ERC
            // 2 => new ArchivoCacVihStrategy(),
            // 3 => new ArchivoCacCancerStrategy(),
            default => throw new InvalidArgumentException('Patología no soportada')
        };
    }
}