<?php

namespace App\Http\Modules\CuentasMedicas\ActasCuentasMedicas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActasCuentasMedica extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','ruta','prestador_id','user_id'];
}
