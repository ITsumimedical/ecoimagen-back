<?php

namespace App\Http\Modules\Urgencias\Oxigeno\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Oxigeno extends Model
{
    use HasFactory;

    protected $fillable = ['fecha','hora_inicio','hora_final','flujo','flo2','total_litros','total_horas','modo_administracion','created_by','admision_urgencia_id'];


    public function usuario()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
