<?php

namespace App\Http\Modules\VacacionesEmpleados\Models;

use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacacionEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts =[
        'requiere_reemplazo' => 'boolean'
    ];

    public function contrato()
    {
        return $this->belongsTo(ContratoEmpleado::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function autorizar(){
        return $this->update([
            'estado_id' => 4
        ]);
    }

    public function anular(){
        return $this->update([
            'estado_id' => 5
        ]);
    }
}
