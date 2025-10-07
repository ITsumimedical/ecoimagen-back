<?php

namespace App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InduccionEspecifica extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'empleado_id' => 'integer'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function cerrar(){
        return $this->update([
            'activo' => 0
        ]);
    }
}
