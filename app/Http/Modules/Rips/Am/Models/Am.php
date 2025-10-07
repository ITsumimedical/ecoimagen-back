<?php

namespace App\Http\Modules\Rips\Am\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Am extends Model
{
    use HasFactory;

    // protected $fillable = ['numero_autorizacion','tipo_medicamento','numero_unidades','valor_unitario_medicamento',
    // 'valor_total_medicamento','numero_documento','tipo_documento','numero_factura','codigo_prestador','codigo_medicamento',
    // 'nombre_generico','forma_farmaceutica','concentracion_medicamento','unidad_medida', 'af_id','paquete_rip_id'];
    protected $guarded = [];
}
