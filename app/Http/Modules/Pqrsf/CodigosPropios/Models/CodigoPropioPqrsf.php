<?php

namespace App\Http\Modules\Pqrsf\CodigosPropios\Models;

use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoPropioPqrsf extends Model
{
    use HasFactory;

    protected $fillable = ['codigo_propio_id', 'formulariopqrsf_id'];

    public function codigoPropio()
    {
        return $this->belongsTo(CodigoPropio::class);
    }
}
