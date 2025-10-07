<?php

namespace App\Http\Modules\Afiliados\Models;

use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Aseguradores\Models\Asegurador;
use App\Http\Modules\Caracterizacion\Models\CaracterizacionEcis;
use App\Http\Modules\Caracterizacion\Models\Encuesta;
use App\Http\Modules\Caracterizacion\Models\IntegrantesFamiliaCaracterizacionEcis;
use App\Http\Modules\Clasificaciones\Models\clasificacion;
use App\Http\Modules\Colegios\Models\Colegio;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Paises\Models\Pais;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Subregion\Models\Subregiones;
use App\Http\Modules\TipoAfiliaciones\Models\TipoAfiliacion;
use App\Http\Modules\TipoAfiliados\Models\TipoAfiliado;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use Carbon\Carbon;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class Afiliado extends Model
{

    protected $fillable = [
        'id_afiliado',
        'region',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'tipo_documento',
        'numero_documento',
        'sexo',
        'fecha_afiliacion',
        'fecha_nacimiento',
        'edad_cumplida',
        'telefono',
        'celular1',
        'celular2',
        'correo1',
        'correo2',
        'direccion_residencia_cargue',
        'direccion_residencia_numero_exterior',
        'direccion_residencia_via',
        'direccion_residencia_numero_interior',
        'direccion_residencia_interior',
        'direccion_residencia_barrio',
        'discapacidad',
        'grado_discapacidad',
        'parentesco',
        'tipo_documento_cotizante',
        'numero_documento_cotizante',
        'tipo_cotizante',
        'categorizacion',
        'nivel',
        'sede_odontologica',
        'subregion_id',
        'departamento_afiliacion_id',
        'municipio_afiliacion_id',
        'departamento_atencion_id',
        'municipio_atencion_id',
        'ips_id',
        'medico_familia1_id',
        'medico_familia2_id',
        'user_id',
        'estado_afiliacion_id',
        'tipo_afiliacion_id',
        'dpto_residencia_id',
        'mpio_residencia_id',
        'asegurador_id',
        'entidad_id',
        'tipo_afiliado_id',
        'tipo_categoria',
        'pais_id',
        'ciclo_vida_atencion',
        'grupo_sanguineo',
        'estrato',
        'tipo_vivienda',
        'zona_vivienda',
        'numero_habitaciones',
        'numero_miembros',
        'acceso_vivienda',
        'seguridad_vivienda',
        'vivienda',
        'agua_potable',
        'preparacion_alimentos',
        'energia_electrica',
        'nivel_educativo',
        'ocupacion',
        'donde_labora',
        'estado_civil',
        'etnia',
        'religion',
        'orientacion_sexual',
        'identidad_genero',
        'nombre_acompanante',
        'telefono_acompanante',
        'nombre_responsable',
        'telefono_responsable',
        'parentesco_responsable',
        'municipio_nacimiento_id',
        'colegio_id',
        'salario_minimo_afiliado',
        'plan',
        'categoria',
        'localidad',
        'ruta_adj_doc_cotizante',
        'ruta_adj_doc_beneficiario',
        'ruta_adj_solic_firmada',
        'ruta_adj_matrimonio',
        'ruta_adj_rc_nacimiento_beneficiario',
        'ruta_adj_rc_nacimiento_cotizante',
        'ruta_adj_cert_discapacidad_hijo',
        'numero_folio',
        'fecha_folio',
        'cuidad_orden_judicial',
        'created_at',
        'updated_at',
        'fecha_expedicion_documento',
        'fecha_vigencia_documento',
        'fecha_defuncion',
        'tipo_documento_padre_beneficiario',
        'fecha_posible_parto',
        'nivel_ensenanza',
        'area_ensenanza_nombrado',
        'escalafon',
        'cargo',
        'nombre_cargo',
        'tipo_vinculacion',
        'numero_documento_padre_beneficiario',
        'tipo_nombramiento',
        'gestante',
        'semanas_gestacion',
        'grupo_poblacional',
        'victima_conflicto_armado',
        'zona_residencia',
        'exento_pago',
        'notificacion_sms'
    ];

    protected $casts = [
        'departamento_afiliacion_id' => 'integer',
        'municipio_atencion_id' => 'integer',
        'tipo_afiliado_id' => 'integer',
        'tipo_afiliacion_id' => 'integer',
        'tipo_documento' => 'integer',
        'entidad_id' => 'integer',
        'asegurador_id' => 'integer',
        'subregion_id' => 'integer',
        'departamento_atencion_id' => 'integer',
        'dpto_residencia_id' => 'integer',
        'medico_familia1_id' => 'integer',
        'medico_familia2_id' => 'integer',
        'mpio_residencia_id' => 'integer',
        'municipio_afiliacion_id' => 'integer',
        'estado_afiliacion_id' => 'integer',
        'pais_id' => 'integer',
        'ips_id' => 'integer'
    ];
    protected $appends = ['nombre_completo', 'tipocon_documento', 'direccion'];
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function EstadoAfiliado()
    {
        return $this->belongsTo(Estado::class, 'estado_afiliacion_id');
    }

    public function TipoAfiliado()
    {
        return $this->belongsTo(TipoAfiliado::class, 'tipo_afiliado_id');
    }

    public function beneficiario()
    {
        return $this->hasMany(Afiliado::class, 'numero_documento_cotizante', 'numero_documento');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento');
    }

    public function asegurador()
    {
        return $this->belongsTo(Asegurador::class, 'asegurador_id');
    }

    public function subregion()
    {
        return $this->belongsTo(Subregiones::class, 'subregion_id');
    }

    public function ips()
    {
        return $this->belongsTo(Rep::class, 'ips_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_familia1_id');
    }

    public function medico2()
    {
        return $this->belongsTo(User::class, 'medico_familia2_id');
    }

    public function departamento_afiliacion()
    {
        return $this->belongsTo(Departamento::class, 'departamento_afiliacion_id');
    }

    public function colegios()
    {
        return $this->belongsTo(Colegio::class, 'colegio_id');
    }

    public function departamento_atencion()
    {
        return $this->belongsTo(Departamento::class, 'departamento_atencion_id');
    }

    public function municipio_afiliacion()
    {
        return $this->belongsTo(Municipio::class, 'municipio_afiliacion_id');
    }

    public function municipio_atencion()
    {
        return $this->belongsTo(Municipio::class, 'municipio_atencion_id');
    }

    public function pais_afiliado()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function tipo_afiliacion()
    {
        return $this->belongsTo(TipoAfiliacion::class, 'tipo_afiliacion_id');
    }

    public function tipo_afiliado()
    {
        return $this->belongsTo(TipoAfiliado::class, 'tipo_afiliado_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clasificacion()
    {
        return $this->belongsToMany(Clasificacion::class, 'afiliado_clasificacions')
            ->withPivot('estado');
    }

    public function caracterizacionAfiliado()
    {
        return $this->hasOne(CaracterizacionAfiliado::class, 'afiliado_id');
    }

    public function caracterizacionEcis()
    {
        return $this->hasOne(CaracterizacionEcis::class, 'afiliado_id');
    }

    public function integrantesFamilia(): BelongsToMany
    {
        return $this->belongsToMany(
            IntegrantesFamiliaCaracterizacionEcis::class,
            'afiliado_integrante_familias',
            'afiliado_id',
            'integrante_id'
        )->withTimestamps();
    }

    public function scopeWhereBeneficiarios($query, $cedula)
    {
        if ($cedula) {
            return $query->where('numero_documento', $cedula);
        }
    }

    public function scopeWhereDocumentos($query, $cedula)
    {
        if ($cedula) {
            return $query->where('numero_documento', $cedula);
        }
    }



    // /**
    //  * Concatena para crear el nombre completo
    //  * @return string
    //  */
    public function getNombreCompletoAttribute()
    {
        return "{$this->primer_nombre} {$this->segundo_nombre} {$this->primer_apellido} {$this->segundo_apellido}";
    }

    public function getTipoconDocumentoAttribute()
    {
        return "{$this->tipo_documento} - {$this->numero_documento}";
    }

    public function getDireccionAttribute()
    {
        return "{$this->direccion_residencia_cargue} {$this->direccion_residencia_via} {$this->direccion_residencia_numero_interior} {$this->direccion_residencia_interior} {$this->direccion_residencia_numero_exterior} {$this->direccion_residencia_barrio}";
    }

    /**
     * Calcular edad cumplida con fecha nacimiento
     *@author Calvarez
     */
    //    public function getEdadCumplidaAttribute() {
    //        return Carbon::parse($this->fecha_nacimiento)->age;
    //    }



    /**
     * The agendas that belong to the Afiliado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agendas()
    {
        return $this->belongsToMany(Agenda::class);
    }

    public function scopeWhereConsulta($query, $consulta)
    {
        if ($consulta) {
            return $query->join('consultas', 'consultas.afiliado_id', 'afiliados.id')->where('consultas.id', $consulta);
        }
    }

    public function departamento_residencia()
    {
        return $this->belongsTo(Departamento::class, 'dpto_residencia_id');
    }

    public function municipio_residencia()
    {
        return $this->belongsTo(Municipio::class, 'mpio_residencia_id');
    }

    public function encuesta()
    {
        return $this->hasOne(Encuesta::class);
    }

    public function scopeBuscarPorNombreYFecha($query, string $primer_nombre, ?string $segundo_nombre, string $primer_apellido, ?string $segundo_apellido, string $fecha_nacimiento)
    {
        $query->whereRaw("TRIM(UPPER(primer_nombre)) = ?", [trim(strtoupper($primer_nombre))])
            ->whereRaw("TRIM(UPPER(primer_apellido)) = ?", [trim(strtoupper($primer_apellido))])
            ->whereRaw("CONVERT(DATE, fecha_nacimiento, 23) = ?", [$fecha_nacimiento]);

        if (is_null($segundo_nombre) || trim($segundo_nombre) === '') {
            $query->where(function ($q) {
                $q->whereNull('segundo_nombre')
                    ->orWhereRaw("TRIM(UPPER(segundo_nombre)) = ''");
            });
        } else {
            $query->whereRaw("TRIM(UPPER(segundo_nombre)) = ?", [trim(strtoupper($segundo_nombre))]);
        }

        if (is_null($segundo_apellido) || trim($segundo_apellido) === '') {
            $query->where(function ($q) {
                $q->whereNull('segundo_apellido')
                    ->orWhereRaw("TRIM(UPPER(segundo_apellido)) = ''");
            });
        } else {
            $query->whereRaw("TRIM(UPPER(segundo_apellido)) = ?", [trim(strtoupper($segundo_apellido))]);
        }

        return $query;
    }
}
