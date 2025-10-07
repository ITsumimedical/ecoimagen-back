<?php

namespace App\Http\Modules\ActuacionTutelas\Models;

use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Tutelas\Models\Tutela;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Tutelas\Models\AdjuntoTutela;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\ProcesoTutela\Models\ProcesoTutela;
use App\Http\Modules\TipoActuaciones\Models\TipoActuacion;

class actuacionTutelas extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'direccion',
        'telefono',
        'observacion',
        'celular',
        'correo',
        'continuidad',
        'exclusion',
        'integralidad',
        'dias',
        'novedad_registro',
        'gestion_documental',
        'medicina_laboral',
        'reembolso',
        'transporte',
        'fecha_radica',
        'tipo_actuacion_id',
        'quien_creo_id',
        'tutela_id',
        'reintegro_laboral',
        'hospitalizacion',
        'estado_id',
    ];

    protected $table = 'actuacion_tutelas';

    protected $casts = [
        'tipo_actuacion_id' => 'integer',
    ];

    /** Relaciones */
    public function tipoActuacion(){
        return $this->belongsTo(TipoActuacion::class,'tipo_actuacion_id');
    }

    public function proceso()
    {
        return $this->belongsToMany(ProcesoTutela::class,'actuacion_tutelas_procesos')->withTimestamps();
    }

    public function tutela()
    {
        return $this->belongsTo(Tutela::class, 'tutela_id');
    }

    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class)->withTimestamps();
    }

    public function cup()
    {
        return $this->belongsToMany(Cup::class)->withTimestamps();
    }

    public function adjuntosTutelas()
    {
        return $this->hasMany(AdjuntoTutela::class, 'actuacion_tutela_id');
    }

    public function exlusionActuacion()
    {
        return $this->hasMany(ExclusionActuacionTutela ::class, 'actuacion_tutela_id');
    }
    /** Scopes */

    /** Sets y Gets */

}
