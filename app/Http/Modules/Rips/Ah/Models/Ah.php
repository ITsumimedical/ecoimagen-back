<?php

namespace App\Http\Modules\Rips\Ah\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ah extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'via_ingreso',
    //     'fecha_ingreso',
    //     'hora_ingreso',
    //     'numero_autorizacion',
    //     'causa_externa',
    //     'diagnostico_ingreso',
    //     'diagnostico_egreso',
    //     'diagnaostico_relacionado_1',
    //     'diagnaostico_relacionado_2',
    //     'diagnaostico_relacionado_3',
    //     'diagnostico_complicacion',
    //     'estado_Salida',
    //     'diagnostico_causa_muerte',
    //     'fecha_egreso',
    //     'hora_egreso',
    //     'numero_documento',
    //     'tipo_documento',
    //     'numero_factura',
    //     'codigo_prestador',
    //     'diagnostico_principal_ingreso',
    //     'diagnostico_principal_egreso',
    //     'paquete_rip_id'
    // ];
    protected $guarded = [];
}
