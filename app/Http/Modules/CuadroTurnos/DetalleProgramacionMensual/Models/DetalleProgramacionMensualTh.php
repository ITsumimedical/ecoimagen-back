<?php

namespace App\Http\Modules\CuadroTurnos\DetalleProgramacionMensual\Models;

use App\Http\Modules\EtiquetasTH\Models\EtiquetaTh;
use App\Http\Modules\ServiciosTH\Models\ServicioTh;
use App\Http\Modules\Turnos\Models\Turno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProgramacionMensualTh extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function etiqueta()
    {
        return $this->belongsTo(EtiquetaTh::class);
    }

    public function servicio()
    {
        return $this->belongsTo(ServicioTh::class);
    }
}
