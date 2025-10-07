<?php

namespace App\Http\Modules\EvaluacionesPeriodosPruebas\EvaluacionesPeriodosPruebas\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionPeriodoPrueba extends Model
{
    protected $guarded = [];

    use HasFactory;

    protected $casts = [
        'empleado_evaluado_id' => 'integer',
        'usuario_registra_id' => 'integer',
        'aprueba_periodo_prueba' => 'boolean'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
