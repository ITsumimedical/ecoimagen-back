<?php

namespace App\Http\Modules\GestionTurnos\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Taquillas\Models\Taquilla;
use App\Http\Modules\Triages\Models\Triage;
use App\Http\Modules\Turnos\Models\Turno;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestionTurno extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    /** Relaciones */
    public function taquillas()
    {
        return $this->belongsTo(Taquilla::class, 'taquilla_id');
    }

    public function turnos()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estados()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function triages()
    {
        return $this->belongsTo(Triage::class, 'triage_id');
    }

    /** Scopes */

    /** Sets y Gets */

}
