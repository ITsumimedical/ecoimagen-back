<?php

namespace App\Http\Modules\Esquemas\Models;

use App\Http\Modules\DetalleEsquemas\Models\DetalleEsquema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esquema extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_esquema','abreviatura_esquema','ciclos',
    'frecuencia_repeat','biografia','activo'];

    public function detalleEsquema()
    {
        return $this->hasMany(DetalleEsquema::class);
    }


}
