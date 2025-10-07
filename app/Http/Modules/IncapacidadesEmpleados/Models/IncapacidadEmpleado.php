<?php

namespace App\Http\Modules\IncapacidadesEmpleados\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;

class IncapacidadEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = ['dias'];

    public function incapacidad()
    {
        return $this->belongsTo(IncapacidadEmpleado::class);
    }

    public function contratoEmpleado()
    {
        return $this->belongsTo(ContratoEmpleado::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function cie10()
    {
        return $this->belongsTo(Cie10::class);
    }

    /**
     * calcularDiasIncapacidad
     * Calcula los días entre las fechas desde y hasta de la incapacidad
     *
     * @return void
     */
    public function getDiasAttribute(){
        $fechaDesde = new Carbon($this->fecha_desde);
        $fechaHasta = new Carbon($this->fecha_hasta);
        return $fechaDesde->diffInDays($fechaHasta) + 1;
    }

}
