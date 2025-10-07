<?php

namespace App\Http\Modules\Epicrisis\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Epicrisi extends Model
{
    use HasFactory;

    protected $fillable = ['motivo_salida','estado_salida','fecha_deceso','hora_deceso','certificado_defuncion','causa_muerte',
                        'fecha_egreso','hora_egreso','orden_alta','observacion','consulta_id','cie10_id','admision_urgencia_id',
                        'created_by','updated_by','entidad_id','servicio_remision','objeto_remision','fecha_referencia','otro_servicio',
                        'peso', 'talla','tension_arterial','frecuencia_respiratoria','frecuencia_cardiaca','temperatura',
                        'aspecto_general','cabeza','abdomen','cuello','torax','snp','ojos','respiratorio','extremidad_superior','oidos',
                        'gastrointestinal','extremidad_inferior','boca_garganta','linfatico','funcion_cerebral','piel_mucosa','psicomotor',
                        'reflejos','urogenital','snc','evolucion_anterior','impresion_diagnostica','plan'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
