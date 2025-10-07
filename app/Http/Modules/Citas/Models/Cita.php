<?php

namespace App\Http\Modules\Citas\Models;

use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\TipoCitas\Models\TipoCita;
use App\Http\Modules\TipoHistorias\Models\TipoHistoria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','especialidade_id','cantidad_paciente','tipo_cita_id','tiempo_consulta','sms','primera_vez_cup_id','control_cup_id','modalidad_id','requiere_orden','tipo_historia_id','tipo_consulta_id','estado_id','requiere_firma', 'entidad_id', 'whatsapp','exento','procedimiento_no_especifico','activo_autogestion'];

    protected $casts = [
        'procedimiento_no_especifico' => 'boolean'
    ];


    public function modalidad(){
        return $this->belongsTo(Modalidad::class,'modalidad_id');

    }
    public function especialidad(){
        return $this->belongsTo(Especialidade::class,'especialidade_id');
    }

    public function tipoCita(){
        return $this->belongsTo(TipoCita::class,'tipo_cita_id');
    }

    public function categoriasHistoria()
    {
        return $this->belongsToMany(CategoriaHistoria::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(CategoriaHistoria::class)->withPivot('orden','requerido');
    }

    public function cups()
    {
        return $this->belongsToMany(Cup::class);
    }

    public function tipoHistoria()
    {
        return $this->belongsTo(TipoHistoria::class, 'tipo_historia_id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function citasReps()
    {
        return $this->belongsToMany(Rep::class, 'cita_reps', 'cita_id', 'rep_id')->withTimestamps();
    }

}
