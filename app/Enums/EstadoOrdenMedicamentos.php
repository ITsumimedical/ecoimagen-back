<?php

namespace App\Enums;

enum EstadoOrdenMedicamentos: int
{
    public static function valor(string $value): int
    {
        return match ($value) {
            'ACTIVO' => 1,
            'INACTIVO' => 2,
            'REQUIERE_AUTORIZACION' => 3,
            'REQUIERE_MIPRES' => 45,
            default => 0,
        };
    }

}