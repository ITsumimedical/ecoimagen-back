<?php

namespace App\Http\Modules\Urgencias\NotaEnfermeria\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasEnfermeriaUrgencia extends Model
{
    use HasFactory;

    protected $fillable = ['fecha', 'peso', 'tension_arterial', 'frecuencia_respiratoria', 'frecuencia_cardiaca', 'temperatura', 'saturacion_oxigeno', 'glucometria', 'tam', 'observacion', 'created_by', 'admision_urgencia_id', 'presion_diastolica','presion_sistolica'];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
