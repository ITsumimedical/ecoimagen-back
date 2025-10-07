<?php

namespace App\Http\Modules\CapacitacionEmpleados\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapacitacionEmpleadoDetalle extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function capacitacion()
    {
        return $this->belongsTo(CapacitacionEmpleado::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

}
