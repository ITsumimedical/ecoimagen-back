<?php

namespace App\Http\Modules\CuentasMedicas\CodigoGlosas\Models;

use App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Models\TiposCuentasMedica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoGlosa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tipoCuentaMedica()
    {
        return $this->belongsTo(TiposCuentasMedica::class);
    }

    public function scopeWhereListarCodigosGlosas($query){
        $query->select('codigo_glosas.codigo','codigo_glosas.descripcion','codigo_glosas.estado',
        'codigo_glosas.id','codigo_glosas.tipo_cuenta_medica_id')
       ->with('tipoCuentaMedica')
        ->where('codigo_glosas.estado',true);

        return $query;
    }
}
