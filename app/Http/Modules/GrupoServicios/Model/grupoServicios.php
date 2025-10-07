<?php

namespace App\Http\Modules\GrupoServicios\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grupoServicios extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'nomnbre'];
}
