<?php

namespace App\Http\Modules\ContactosEmpleados\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactoEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'municipio_id' => 'integer',
        'contacto_emergencia' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }
}
