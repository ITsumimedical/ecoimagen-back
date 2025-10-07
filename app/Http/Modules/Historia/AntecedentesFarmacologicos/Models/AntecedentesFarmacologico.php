<?php

namespace App\Http\Modules\Historia\AntecedentesFarmacologicos\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\PrincipiosActivos\Model\principioActivo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AntecedentesFarmacologico extends Model
{
    use HasFactory;

    protected $fillable = ['alimento', 'ambiental', 'otras', 'observacion_ambiental', 'observacion_alimento', 'observacion_otro',
        'observacion_medicamento', 'estado_id', 'medicamento_id', 'medico_registra', 'consulta_id', 'no_tiene_antecedentes', 'principio_activo_id'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'medico_registra');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }

    public function principioActivo()
    {
        return $this->belongsTo(principioActivo::class, 'principio_activo_id');
    }
}
