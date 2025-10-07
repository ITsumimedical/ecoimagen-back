<?php

namespace App\Http\Modules\Empleados\Models;

use App\Http\Modules\AreasTalentoHumano\Models\AreaTh;
use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Models\CategoriaMesaAyuda;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\OrientacionesSexuales\Models\OrientacionSexual;
use App\Http\Modules\Sedes\Models\Sede;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'documento',
        'nombre_completo',
        'primer_apellido',
        'segundo_apellido',
        'primer_nombre',
        'segundo_nombre',
        'genero',
        'identidad_genero',
        'fecha_nacimiento',
        'fecha_expedicion_documento',
        'rh',
        'estado_civil',
        'grupo_etnico',
        'cabeza_hogar',
        'peso',
        'altura',
        'direccion_residencia',
        'barrio',
        'area_residencia',
        'telefono',
        'celular',
        'celular2',
        'email_personal',
        'email_corporativo',
        'descripcion',
        'nivel_estudio',
        'victima',
        'discapacidad',
        'descripcion_discapacidad',
        'ajuste_puesto',
        'edad',
        'indice_masa_corporal',
        'medico',
        'registro_medico',
        'tipo_documento_id',
        'orientacion_sexual_id',
        'municipio_expedicion_id',
        'municipio_nacimiento_id',
        'municipio_residencia_id',
        'areath_id',
        'sede_id',
        'jefe_inmediato_id',
        'th_tipo_plantilla_id',
        'estado_id',
    ];
    protected $appends = ['nombre_completo'];


    protected $casts = [
        'th_tipo_plantilla_id' => 'integer',
        'tipo_documento_id' => 'integer',
        'municipio_residencia_id' => 'integer',
        'municipio_expedicion_id' => 'integer',
        'municipio_nacimiento_id' => 'integer',
        'discapacidad' => 'boolean',
        'victima' => 'boolean',
        'cabeza_hogar' => 'boolean',
        'areath_id' => 'integer',
        'orientacion_sexual_id' => 'integer',
        'sede_id' => 'integer',
        'medico' => 'boolean',
        'edad' => 'integer',
        'altura' => 'integer',
        'peso' => 'integer',
        'indice_masa_corporal' => 'float',
        'tipo_contrato_id' => 'integer',
        'jefe_inmediato_id' => 'integer',
    ];

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function areaTh()
    {
        return $this->belongsTo(AreaTh::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function orientacionSexual()
    {
        return $this->belongsTo(OrientacionSexual::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function contratoEmpleado()
    {
        return $this->hasMany(ContratoEmpleado::class);
    }


    /**
     * getNombreCompletoAttribute
     * Concatena los campos de nombres y apellidos y asigna en nombre_completo
     *
     * @return void
     */
    public function getNombreCompletoAttribute(){
        return "{$this->primer_nombre} {$this->segundo_nombre} {$this->primer_apellido} {$this->segundo_apellido}";
    }

    public function categoriaMesaAyuda(){
        return $this->belongsToMany(CategoriaMesaAyuda::class, 'categoria_mesa_ayuda_empleados');
    }

}
