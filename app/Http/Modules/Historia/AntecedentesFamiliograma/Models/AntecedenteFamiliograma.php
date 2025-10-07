<?php

namespace App\Http\Modules\Historia\AntecedentesFamiliograma\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AntecedenteFamiliograma extends Model
{
    use HasFactory;

    protected $fillable = [
        'vinculos',
        'relacion',
        'tipo_familia',
        'hijos_conforman',
        'responsable_ingreso',
        'problemas_de_salud',
        'cual_salud',
        'observacion_salud',
        'medico_registra',
        'consulta_id',
      'actividad_laboral',
      'alteraciones',
      'descripcion_actividad',
      'historia_repro',
      'paridad',
      'abortos_recurrentes',
      'hemorragia_pos',
      'peso_recien',
      'mortalidad_fetal',
      'trabajo_parto',
      'cirugia_gineco',
      'renal',
      'diabetes_gestacional',
      'diabetes_preconcepcion',
      'hemorragia',
      'semanas_hemorragia',
      'anemia',
      'valor_anemia',
      'embarazo_prolongado',
      'semanas_prolongado',
      'polihidramnios',
      'hiper_arterial',
      'embarazo_multiple',
      'presente_frente',
      'isoinmunizacion',
      'ansiedad_severa',
      'resultadopre'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    public function consulta()
        {
         return $this->belongsTo(Consulta::class);
        }

    public function user()
      {
          return $this->belongsTo(User::class,'medico_registra');
     }
}
