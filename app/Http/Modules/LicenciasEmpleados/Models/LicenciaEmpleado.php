<?php

namespace App\Http\Modules\LicenciasEmpleados\Models;

use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\TipoLicenciasEmpleados\Models\TipoLicenciaEmpleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenciaEmpleado extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tipo_licencia_id' => 'integer'
    ];

    public function contrato()
    {
        return $this->belongsTo(ContratoEmpleado::class);
    }

    public function tipoLicencia()
    {
        return $this->belongsTo(TipoLicenciaEmpleado::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
