<?php

namespace App\Http\Modules\ModalidadGrupoTecSal\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modalidadGrupoTecSal extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'nombre'];
}
