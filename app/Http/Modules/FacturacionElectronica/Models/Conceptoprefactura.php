<?php

namespace App\Http\Modules\FacturacionElectronica\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conceptoprefactura extends Model
{
    use HasFactory;

    protected $table = 'conceptoprefacturas';

    protected $fillable = [
        'nombre',
        'esta_activo',
        'create_by',
    ];
}
