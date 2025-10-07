<?php

namespace App\Http\Modules\Rips\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RipErrore extends Model
{
    use HasFactory;

    protected $fillable = [
        'archivo',
        'mensaje',
        'lineas',
        'paquete_rip_id',
    ];
}
