<?php

namespace App\Http\Modules\Caracterizacion\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\TipoAfiliaciones\Models\TipoAfiliacion;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegrantesFamiliaCaracterizacionEcis extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'afiliado_id',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'tipo_documento_id',
        'numero_documento',
        'fecha_nacimiento',
        'sexo',
        'rol_familia',
        'rol_familia_otro',
        'ocupacion',
        'nivel_educativo',
        'tipo_afiliacion_id',
        'entidad_id',
        'grupo_especial_proteccion',
        'pertenencia_etnica',
        'comunidad_pueblo_indigena',
        'discapacidad',
        'condiciones_salud_cronica',
    ];

    public function afiliados()
    {
        return $this->belongsToMany(
            Afiliado::class,
            'afiliado_integrante_familias',
            'integrante_id',
            'afiliado_id'
        )->withTimestamps();
    }

    public function tipo_documento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    public function entidad(): BelongsTo
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }

    public function tipo_afiliacion(): BelongsTo
    {
        return $this->belongsTo(TipoAfiliacion::class, 'tipo_afiliacion_id');
    }
}
