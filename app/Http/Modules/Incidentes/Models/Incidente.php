<?php

namespace App\Http\Modules\Incidentes\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'fecha_incidente' => 'date'
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function cerrar(){
        return $this->update([
            'estado_id' => 17,
            'resultado' => 'resultado'
        ]);
    }
}
