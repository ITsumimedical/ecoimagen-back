<?php

namespace App\Http\Modules\Afiliados\Models;

use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Paises\Models\Pais;
use App\Http\Modules\TipoAfiliaciones\Models\TipoAfiliacion;
use App\Http\Modules\TipoAfiliados\Models\TipoAfiliado;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiarioRadicacion extends Model
{
    use HasFactory;

    protected $table = 'beneficiario_radicacions';

    protected $appends = ['direccion'];

    protected $fillable = [
        'tipo_documento_id',
        'numero_documento',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'sexo',
        'fecha_nacimiento',
        'edad_cumplida',
        'parentesco',
        'discapacidad',
        'grado_discapacidad',
        'pais_id',
        'departamento_afiliacion_id',
        'departamento_atencion_id',
        'municipio_afiliacion_id',
        'municipio_atencion_id',
        'direccion_residencia_cargue',
        'direccion_residencia_numero_exterior',
        'direccion_residencia_primer_interior',
        'direccion_residencia_segundo_interior',
        'direccion_residencia_interior',
        'direccion_residencia_barrio',
        'telefono',
        'celular1',
        'celular2',
        'correo1',
        'correo2',
        'tipo_afiliado_id',
        'tipo_afiliacion_id',
        'entidad_id',
        'numero_documento_cotizante',
        'solicitud_id',
        'tipo_beneficiario_id',
    ];

    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class,'tipo_documento_id');
    }

    public function nacionalidad(){
        return $this->belongsTo(Pais::class,'pais_id');
    }

    public function departamentoAfiliacion(){
        return $this->belongsTo(Departamento::class,'departamento_afiliacion_id');
    }

    public function municipioAfiliacion(){
        return $this->belongsTo(Municipio::class,'municipio_afiliacion_id');
    }

    public function tipoAfiliado(){
        return $this->belongsTo(TipoAfiliado::class,'tipo_afiliado_id');
    }

    public function tipoAfiliacion(){
        return $this->belongsTo(TipoAfiliacion::class,'tipo_afiliacion_id');
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class,'entidad_id');
    }

    public function tipoBeneficiario(){
        return $this->belongsTo(TipoBeneficiarioRadicacion::class,'tipo_beneficiario_id');
    }

    // public function getNombreCompletoAttribute(){
    //     return "{$this->primer_nombre} {$this->segundo_nombre} {$this->primer_apellido} {$this->segundo_apellido}";
    // }

    public function getDireccionAttribute(){
        return "{$this->direccion_residencia_cargue} {$this->direccion_residencia_numero_exterior} N° {$this->direccion_residencia_primer_interior} - {$this->direccion_residencia_segundo_interior}  {$this->direccion_residencia_interior}, {$this->direccion_residencia_barrio}";
    }
}
