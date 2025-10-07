<?php

namespace App\Http\Modules\Contratos\Models;

use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\NovedadContratos\Models\novedadContrato;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Prestadores\Models\Prestador;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CobroServicio extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ordenProcedimiento()
    {
        return $this->belongsTo(OrdenProcedimiento::class);
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function ordenCodigoPropio()
    {
        return $this->belongsTo(OrdenCodigoPropio::class);
    }
}
