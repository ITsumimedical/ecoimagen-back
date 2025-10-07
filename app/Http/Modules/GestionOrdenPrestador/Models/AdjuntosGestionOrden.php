<?php

namespace App\Http\Modules\GestionOrdenPrestador\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntosGestionOrden extends Model
{
    use HasFactory;

    protected $fillable = ['gestion_orden_id', 'ruta', 'nombre'];
}
