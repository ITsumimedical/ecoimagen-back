<?php

namespace App\Http\Modules\AdjuntosAyudasDiagnosticos\Models;

use App\Http\Modules\ResultadoAyudasDiagnosticos\Model\ResultadoAyudasDiagnosticas;
use App\Http\Modules\rqc\model\rqc;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntosAyudasDiagnosticos extends Model
{
    use HasFactory;

    protected $table = 'adjuntos_ayudas_diagnosticos';

    protected $fillable = [
        'nombre',
        'ruta',
        'resultado_ayudas_diagnosticas_id'
    ];


    public function resultado_ayudas_diagnosticas()
    {
        return $this->belongsTo(ResultadoAyudasDiagnosticas::class, 'resultado_ayudas_diagnosticas_id');
    }
}
