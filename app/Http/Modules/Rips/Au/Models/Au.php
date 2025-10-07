<?php

namespace App\Http\Modules\Rips\Au\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Au extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'diagnostico_salida',
    //     'fecha_ingreso',
    //     'hora_ingreso',
    //     'Numero_autorizacion',
    //     'causa_externa',
    //     'diagnostico_relacion_salida1',
    //     'diagnostico_relacion_salida2',
    //     'diagnostico_relacion_salida3',
    //     'destino_usuario_salida',
    //     'estado_salida',
    //     'causa_basica_muerte',
    //     'fecha_salida_usuario',
    //     'hora_salida_usuario',
    //     'numero_documento',
    //     'tipo_documento',
    //     'numero_factura',
    //     'codigo_prestado',
    //     'diagnostico_principal_salida',
    //     'paquete_rip_id'
    // ];
    protected $guarded = [];
}
