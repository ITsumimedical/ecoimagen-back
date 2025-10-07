<?php

namespace App\Http\Modules\CumTarifaContratos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class diagnostico_tarifa_contrato extends Model
{
    use HasFactory;
    protected $fillable = [
        'tarifa_id',
        'cie10_id',
        'user_id',
    ];
}
