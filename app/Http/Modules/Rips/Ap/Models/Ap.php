<?php

namespace App\Http\Modules\Rips\Ap\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ap extends Model
{
    use HasFactory;

    // protected $fillable = [ 'fecha_procedimiento', 'numero_autorizacion', 'ambito_procedimiento',
    // 'finalidad_procedimiento','personal_atiende','diagnostico_relacionado','complicacion','acto_quirurgico',
    // 'valor_procedimiento','numero_documento','tipo_documento','numero_factura','codigo_prestador','procedimiento',
    // 'diagnostico_primario','af_id','paquete_rip_id'];
    protected $guarded = [];
}
