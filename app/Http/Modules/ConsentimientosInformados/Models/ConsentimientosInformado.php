<?php

namespace App\Http\Modules\ConsentimientosInformados\Models;

use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsentimientosInformado extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','beneficios','riesgos','alternativas',
                           'riesgo_no_aceptar','informacion','recomendaciones','cup_id','codigo','version','fecha_aprobacion', 'estado','laboratorio','odontologia'];

    public function cup()
    {
        return $this->belongsTo(Cup::class, 'cup_id');
    }
}
