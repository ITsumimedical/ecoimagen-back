<?php

namespace App\Http\Modules\DemandaInsatisfecha\Models;

use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Usuarios\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandaInsatisfecha extends Model
{
    use HasFactory;

    protected $fillable = ['observacion', 'consulta_id', 'especialidad_id', 'cita_id', 'afiliado_id', 'user_id', 'estado_id'];

    protected $appends = [
        'fecha_registro'
    ];

    public function especialidad()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeWhereAfiliadoId($query, $afiliado_id)
    {
        if ($afiliado_id) {
            return $query->where('afiliado_id', $afiliado_id);
        }
    }

    /**
     * Calcular edad cumplida con fecha nacimiento
     *@author Calvarez
     */
    public function getFechaRegistroAttribute() {
        return Carbon::parse($this->created_at)->Format('Y-m-d');
    }
}
