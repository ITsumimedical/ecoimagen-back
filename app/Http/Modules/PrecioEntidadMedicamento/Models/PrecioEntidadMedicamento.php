<?php

namespace App\Http\Modules\PrecioEntidadMedicamento\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioEntidadMedicamento extends Model
{
    use HasFactory;

    protected $fillable = ['subtotal','iva','total','precio_maximo','entidad_id','medicamento_id'];
}
