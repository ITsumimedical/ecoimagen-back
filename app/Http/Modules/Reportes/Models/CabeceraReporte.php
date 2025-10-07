<?php

namespace App\Http\Modules\Reportes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabeceraReporte extends Model
{
    use HasFactory;

    protected $table = 'cabecera_reportes';

    protected $fillable = [
        'nombre_reporte',
        'nombre_procedimiento',
        'estado',
        'created_by',
        'updated_by'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleReporte::class, 'cabecera_reporte_id');
    }
}
