<?php

namespace App\Http\Modules\CuentasMedicas\AdjuntoRelacionPago\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoRelacionPago extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','ruta','fecha','activo','prestador_id'];
}
