<?php

namespace App\Http\Modules\Urgencias\SignosVitales\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SignosVitales extends Model
{
    use HasFactory;

    protected $fillable = ['fecha','peso','tension_arterial','frecuencia_respiratoria','frecuencia_cardiaca','temperatura','saturacion_oxigeno','glucometria','tam','created_by','admision_urgencia_id'];


    public function usuario()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
