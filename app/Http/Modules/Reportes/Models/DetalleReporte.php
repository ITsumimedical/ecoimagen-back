<?php

namespace App\Http\Modules\Reportes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReporte extends Model
{
    use HasFactory;

    protected $table = 'detalle_reportes';

    protected $fillable = [
        'cabecera_reporte_id',
        'nombre_parametro',
        'orden_parametro',
        'tipo_dato',
        'origen',
        'nombre_columna_bd',
        'valor_columna_guardar',
        'created_by'
    ];

    public function cabecera()
    {
        return $this->belongsTo(CabeceraReporte::class, 'cabecera_reporte_id');
    }
}
