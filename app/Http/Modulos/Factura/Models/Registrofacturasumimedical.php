<?php

namespace App\Http\Modulos\Factura\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrofacturasumimedical extends Model
{
    use HasFactory;

    protected $table = 'registrofacturasumimedicals';
    protected $fillable = [
        'sede_atencion_id',
        'afiliado_id',
        'consulta_id',
        'codigo_empresa',
        'codigo_clasificacion',
        'fecha_ingreso',
        'hora_ingreso',
        'medico_atiende_id',
        'contrato',
        'codigo_diagnostico',
        'codigo_cup',
        'descripcion_cup',
        'cantidad_cup',
        'valor_cup',
        'created_by',
        'fecha_facturacion',
        'numero_factura',
        'estado',
    ];
}
