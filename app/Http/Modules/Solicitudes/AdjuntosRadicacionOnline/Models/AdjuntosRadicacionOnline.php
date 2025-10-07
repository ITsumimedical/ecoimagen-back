<?php

namespace App\Http\Modules\Solicitudes\AdjuntosRadicacionOnline\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntosRadicacionOnline extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','ruta','radicacion_online_id','gestion_radicacion_online_id'];
}
