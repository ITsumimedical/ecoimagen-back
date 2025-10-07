<?php

namespace App\Http\Modules\Rips\At\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class At extends Model
{
    use HasFactory;

    // protected $fillable = [ 'af_id','paquete_rip_id','numero_autorizacion','tipo_servicio','nombre_servicio','cantidad',
    // 'valor_unitario','valor_total','numero_documento','tipo_documento','numero_factura','codigo_prestador'];
    protected $guarded = [];
}
