<?php

namespace App\Http\Modules\RepresentanteLegal\Models;

use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentanteLegal extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','tipo_doc','num_doc','fecha_exp','fecha_nac','otra_nacionalidad','emali','direccion_reci','pais_reci',
                            'telefono','cargo_publico','poder_publico','reconocimento_publico','ocupacion','donde_trabaja','obli_tibutarias',
                        'descripcion_obliga','estado_id','sarlaft_id','ciudad_recidencia_id','deparamento_recidencia_id','lugar_nacimiento_id',
                        'lugar_expedicion_id'];


    public function lugarExpedicion()
    {
        return $this->belongsTo(Municipio::class,'lugar_expedicion_id');
    }

    public function lugarNacimiento()
    {
        return $this->belongsTo(Municipio::class,'lugar_nacimiento_id');
    }

    public function ciudadResidencia()
    {
        return $this->belongsTo(Municipio::class,'ciudad_recidencia_id');
    }

    public function departamentoResidencia()
    {
        return $this->belongsTo(Departamento::class,'deparamento_recidencia_id');
    }
}
