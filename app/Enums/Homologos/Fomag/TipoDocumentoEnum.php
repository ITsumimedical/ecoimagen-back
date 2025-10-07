<?php

namespace App\Enums\Homologos\Fomag;

enum TipoDocumentoEnum: int
{
    /**
     * obtiene un valor particular del enum
     */
    public static function homologo(string $value): int
    {
        return match ($value) {
            'CC' => 1,
            'TI' => 2,
            'RC' => 3,
            'TE' => 4,
            'CE' => 5,
            'NIT' => 6,
            'P' => 7,
            'TE' => 8,
            'PPP' => 9,
            'PPT' => 10,
            'S' => 11,
            'CN' => 12,
            'AS' => 13,
            'MS' => 14,
            default => 1
        };
    }
}
