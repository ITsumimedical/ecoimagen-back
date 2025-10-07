<?php

namespace App\http\Modules\Referencia\AdjuntosReferencia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoReferencia extends Model
{
    use HasFactory;
    protected $fillable = ['ruta','referencia_id','nombre'];
}
