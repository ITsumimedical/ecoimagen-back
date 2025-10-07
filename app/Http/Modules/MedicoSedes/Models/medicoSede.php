<?php

namespace App\Http\Modules\MedicoSedes\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Sedes\Models\Sede;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class medicoSede extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    /** Relaciones */

    public function reps(){
        return $this->belongsTo(Rep::class, 'rep_id');
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function sede(){
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    // Casts
    protected $casts = [
        'empleado_id' => 'integer',
        'rep_id' => 'integer',
    ];

    /** Scopes */
    public function scopeWhereReps($query, $rep_id){
        if($rep_id){
            return $query->where('rep_id', $rep_id);
        }
    }
    /** Sets y Gets */

}
