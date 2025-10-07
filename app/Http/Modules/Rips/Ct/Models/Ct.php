<?php

namespace App\Http\Modules\Rips\Ct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ct extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_radicado',
        'nombre_archivo',
        'catidad_registros',
        'paquete_rip_id',
    ];
}
