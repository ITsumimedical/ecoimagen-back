<?php

namespace App\Http\Modules\DetalleEsquemas\Models;

use App\Http\Modules\Esquemas\Models\Esquema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEsquema extends Model
{
    use HasFactory;

    protected $fillable = ['dosis','unidad_medida','indice_dosis','nivel_ordenamiento','via','dosis_formulada','descripcion_dosis',
    'cantidad_aplicaciones','dias_aplicacion','frecuencia','frecuencia_duracion','observaciones','codesumi_id','esquema_id'];

    public function esquema()
    {
        return $this->belongsTo(Esquema::class);
    }
}
