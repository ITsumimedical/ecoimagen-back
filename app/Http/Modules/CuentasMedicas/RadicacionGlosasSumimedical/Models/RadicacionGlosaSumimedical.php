<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosasSumimedical\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadicacionGlosaSumimedical extends Model
{
    use HasFactory;

    protected $fillable = [ 'respuesta_sumimedical', 'valor_aceptado', 'valor_no_aceptado','acepta_ips',
    'levanta_sumi','no_acuerdo','glosa_id','user_id','estado_id'];
}
