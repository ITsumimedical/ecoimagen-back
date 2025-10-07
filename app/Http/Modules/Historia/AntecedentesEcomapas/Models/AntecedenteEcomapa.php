<?php

namespace App\Http\Modules\Historia\AntecedentesEcomapas\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AntecedenteEcomapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'asiste_colegio',
        'comparte_amigos',
        'comparte_vecinos',
        'pertenece_club_deportivo',
        'pertenece_club_social_cultural',
        'asiste_iglesia',
        'trabaja',
        'medico_registra',
        'consulta_id',
        'rendimiento',
        'aprendizaje',
        'actitud_aula',
        'relacionamiento',
        'orientacion_sex',
        'identidad_genero',
        'identidad_generotransgenero',
        'espermarquia',
        'edad_esperma',
        'menarquia',
        'edad_menarquia',
        'ciclos',
        'ciclosmnestruales',
        'inicio_sexual',
        'numero_relaciones',
        'activo_sexual',
        'dificultades_relaciones',
        'descripciondificultad',
        'uso_anticonceptivos',
        'tipo_anticonceptivos',
        'conocimiento_its',
        'sufrido_its',
        'cualits',
        'fecha_enfermedadits',
        'tratamientoits',
        'trasnmision_sexual',
        'derechos_sexuales',
        'decisionessexrep',
        'victima_identidadgenero',
        'tipo_victimagenero',
        'victima_genero',
        'tipo_victima_violencia_genero',
        'violencia',
        'presenciamutilacion',
        'matrimonioinfantil'

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
