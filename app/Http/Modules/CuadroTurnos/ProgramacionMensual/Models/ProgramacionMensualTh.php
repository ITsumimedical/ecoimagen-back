<?php

namespace App\Http\Modules\CuadroTurnos\ProgramacionMensual\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramacionMensualTh extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

}
