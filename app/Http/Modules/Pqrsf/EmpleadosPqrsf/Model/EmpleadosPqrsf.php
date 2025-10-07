<?php

namespace App\Http\Modules\Pqrsf\EmpleadosPqrsf\Model;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Operadores\Models\Operadore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadosPqrsf extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'empleados_pqrsf';

    public function empleado()
    {
        return $this->belongsTo(Operadore::class, 'operador_id');
    }
}
