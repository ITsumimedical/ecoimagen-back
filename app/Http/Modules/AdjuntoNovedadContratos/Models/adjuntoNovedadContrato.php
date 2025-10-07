<?php

namespace App\Http\Modules\AdjuntoNovedadContratos\Models;

use App\Http\Modules\NovedadContratos\Models\novedadContrato;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adjuntoNovedadContrato extends Model
{
    use HasFactory;

    protected $fillable = ['ruta','nombre','contrato_novedad_id'];

}
