<?php

namespace App\Http\Modules\GestionPqrsf\AdjuntosPqrsf\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoPqrsf extends Model
{
    use HasFactory;

    protected $fillable = ['gestion_pqrsf_id','nombre','ruta'];
}
