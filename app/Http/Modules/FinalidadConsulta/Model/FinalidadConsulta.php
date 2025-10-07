<?php

namespace App\Http\Modules\FinalidadConsulta\Model;

use App\Http\Modules\Telesalud\Models\GestionesTelesalud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalidadConsulta extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'nombre', 'estado_id'];

    public function gestionTelesalud()
    {
        return $this->hasOne(GestionesTelesalud::class, 'finalidad_consulta_id');
    }
}
