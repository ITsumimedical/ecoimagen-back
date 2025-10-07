<?php

namespace App\Http\Modules\ActividadInternacional\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadInternacional extends Model
{
    use HasFactory;

    protected $fillable = ['transa_monedaextr','cual_moneda','otra_moneda','produc_extranjeros','cual_prodc','pais_operaciones','estado_id','sarlaft_id'];
}
