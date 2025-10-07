<?php

namespace App\Http\Modules\Rips\An\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class An extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'fecha_nacimiento',
    //     'edad_gestional',
    //     'Hora_nacimiento',
    //     'gestion_prenatal',
    //     'sexo',
    //     'peso',
    //     'causa_muerte',
    //     'fecha_muerte',
    //     'hora_muerte',
    //     'documento_an',
    //     'tipo_an',
    //     'numero_documento',
    //     'tipo_documento',
    //     'numero_factura',
    //     'codigo_prestador',
    //     'diagnostico_recien_nacido',
    //     'cie10_id',
    //     'paquete_rip_id',
    // ];
    protected $guarded = [];
}
