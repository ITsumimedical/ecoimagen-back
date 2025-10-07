<?php

namespace App\Http\Modules\Factura\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSisma extends Model
{
    use HasFactory;

    protected $table = 'log_sismas';

    protected $fillable = [
        'estudio',
        'idSede',
        'autoId',
        'codigoEmpresa',
        'codigoClasificacion',
        'fechaIngreso',
        'horaIngreso',
        'codigoMedico',
        'contrato',
        'idPuntoAtencion',
        'codigo',
        'descripcion',
        'cantidad',
        'valor',
        'created_by',
    ];
}
