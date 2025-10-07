<?php

namespace App\Http\Modules\Historia\AntecedentesHospitalarios\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AntecedentesHospitalario extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalizacion_neonatal',
        'descripcion_neonatal',
        'consulta_urgencias',
        'descripcion_urgencias',
        'hospitalizacion_ultimo_anio',
        'descripcion_hospiurg',
        'mas_tres_hospitalizaciones_anio',
        'descripcion_urgencias_mas_tres',
        'hospitalizacion_mayor_dos_semanas_anio',
        'medico_registra',
        'descripcion_urgencias_mas_tres_semanas',
        'hospitalizacion_uci_anio',
        'descripcion_hospi_uci',
        'consulta_id',
        'fecha_ultimas_hospitalizaciones',
        'segunda_fecha_ultimas_hospitalizaciones',
        'tercera_fecha_ultimas_hospitalizaciones',
        'fecha_hospitalizacion_uci_ultimo_ano',
        'cantidad_hospitalizaciones',
        'hospitalizacion_uci'
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
        return $this->belongsTo(User::class, 'medico_registra');
    }
}
