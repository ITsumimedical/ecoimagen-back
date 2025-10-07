<?php

namespace App\Http\Modules\CumTarifaContratos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cum_tarifa_contrato extends Model
{
    use HasFactory;
    protected $fillable = [
        'tarifa_id',
        'cum_validacion',
        'valor',
        'user_id',
    ];
}
