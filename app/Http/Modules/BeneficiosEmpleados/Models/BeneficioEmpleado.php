<?php

namespace App\Http\Modules\BeneficiosEmpleados\Models;

use App\Http\Modules\Beneficios\Models\Beneficio;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficioEmpleado extends Model
{
    use HasFactory;

    protected $casts = [
        'beneficio_id' => 'integer',
        'empleado_id' => 'integer'
    ];

    protected $guarded = [];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function beneficio()
    {
        return $this->belongsTo(Beneficio::class);
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
