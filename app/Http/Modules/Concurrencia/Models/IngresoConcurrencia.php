<?php

namespace App\Http\Modules\Concurrencia\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngresoConcurrencia extends Model
{
    use HasFactory;

    protected $table = 'ingreso_concurrencias';

    protected $fillable = [
        'afiliado_id',
        'fecha_ingreso',
        'cie10_id',
        'tipo_hospitalizacion',
        'unidad_funcional',
        'via_ingreso',
        'reingreso_15_dias',
        'reingreso_30_dias',
        'rep_id',
        'cama_piso',
        'codigo_hospitalizacion',
        'estancia_total',
        'especialidad_id',
        'nota_seguimiento',
        'user_id'
    ];

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function cie10()
    {
        return $this->belongsTo(Cie10::class);
    }

    public function ordenConcurrencias() {
        return $this->hasMany(OrdenConcurrencia::class, 'ingreso_concurrencia_id');
    }

    public function evento() {
        return $this->hasMany(EventosIngresosConcurrencia::class, 'ingreso_concurrencia_id');
    }

    public function costoEvitado() {
        return $this->hasMany(CostoEvitado::class, 'ingreso_concurrencia_id');
    }

    public function costoEvitable() {
        return $this->hasMany(CostoEvitable::class, 'ingreso_concurrencia_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
