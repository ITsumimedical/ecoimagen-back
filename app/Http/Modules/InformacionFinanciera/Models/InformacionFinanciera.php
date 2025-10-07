<?php

namespace App\Http\Modules\InformacionFinanciera\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionFinanciera extends Model
{
    use HasFactory;

    protected $fillable = ['total_activos','total_pasivos','ingreso_mensual','otros_ingresos','concepto_ingreso','egresos_mensuales',
    'otros_egresos','concepto_egreso','estado_id','sarlaft_id'];
}
