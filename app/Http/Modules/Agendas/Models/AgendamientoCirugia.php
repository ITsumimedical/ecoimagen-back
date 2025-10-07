<?php

namespace App\Http\Modules\Agendas\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Consultorios\Models\Consultorio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AgendamientoCirugia extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function afiliado(){
        return $this->belongsTo(Afiliado::class);
    }
    public function consultorio(){
        return $this->belongsTo(Consultorio::class);
    }
    public function cirujano(){
        return $this->belongsTo(User::class,'cirujano');
    }

    public function anestesiologo(){
        return $this->belongsTo(User::class,'anestesiologo');
    }
    public function sede(){
        return $this->belongsTo(Rep::class,'reps_id');
    }

    public function cup(){
        return $this->belongsTo(Cup::class);
    }

    public function cupsAgenda()
    {
        return $this->belongsToMany(Cup::class,'cups_agendas_cirugias','agenda_cirugia_id')->withPivot('agenda_cirugia_id','cup_id');
    }
}

