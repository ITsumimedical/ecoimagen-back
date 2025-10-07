<?php

namespace App\Http\Modules\Epidemiologia\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaSivigila extends Model
{
    use HasFactory;

    protected $fillable = [
        'respuesta_campo',
        'campo_id',
        'consulta_id',
        'pais_id',
        'departamento_id',
        'municipio_id',
        'registro_id'
    ];

    public function campoSivigila()
    {
        return $this->belongsTo(CampoSivigila::class, 'campo_id');
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    public function registroSivigila()
    {
        return $this->belongsTo(RegistroSivigila::class, 'registro_id');
    }
}
