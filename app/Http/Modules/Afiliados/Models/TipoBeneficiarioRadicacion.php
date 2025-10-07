<?php

namespace App\Http\Modules\Afiliados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBeneficiarioRadicacion extends Model
{
    use HasFactory;

    protected $table = 'tipo_beneficiario_radicacions';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
