<?php

namespace App\Http\Modules\GrupoFamiliarEmpleados\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoFamiliarEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'municipio_id' => 'integer',
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

}
