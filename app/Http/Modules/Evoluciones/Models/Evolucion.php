<?php

namespace App\Http\Modules\Evoluciones\Models;

use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evolucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'subjetivo',
        'descripcion_fisica',
        'paraclinicos',
        'procedimiento',
        'analisis',
        'tratamiento',
        'consulta_id',
        'admision_urgencia_id',
        'peso',
        'tension_arterial',
        'frecuencia_respiratoria',
        'frecuencia_cardiaca',
        'temperatura',
        'created_by',
        'updated_by',
        'presion_sistolica',
        'presion_diastolica',
    ];


    public function admisionUrgencia()
    {
        return $this->belongsTo(AdmisionesUrgencia::class);
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
