<?php

namespace App\Enums;

enum TipoDocumentoEnum: int
{
    /**
     * obtiene un valor particular del enum
     */
    public static function valor(int $value): string
    {
        return match($value) {
            1 => 'CC',
            2 => 'TI',
            3 => 'RC',
            4 => 'TE',
            5 => 'CE',
            6 => 'NIT',
            7 => 'PA',
            8 => 'TE',
            9 => 'PPP',
            10 => 'PPT',
            11 => 'S',
            12 => 'CN',
            13 => 'AS',
            14 => 'MS',
            default => 'NA'
        };
    }
}
