<?php

namespace App\Http\Modules\ContratosEmpleados\Models;

use App\Http\Modules\AdjuntosContratosEmpleados\Models\AdjuntoContratoEmpleado;
use App\Http\Modules\Bancos\Models\Banco;
use App\Http\Modules\Cargos\Models\Cargo;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Proyectos\Models\Proyecto;
use App\Http\Modules\TiposContratosTH\Models\TipoContratoTh;
use App\Http\Modules\TiposCuentasBancarias\Models\TipoCuentaBancaria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'tipo_contrato_id' => 'integer',
        'cargo_id' => 'integer',
        'municipio_trabaja_id' => 'integer',
        'prerrogativa' => 'boolean',
        'banco_id' => 'integer',
        'tipo_cuenta_id' => 'integer',
        'proyecto_id' => 'integer',
        'activo' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function tipoContrato()
    {
        return $this->belongsTo(TipoContratoTh::class);
    }

    public function adjunto()
    {
        return $this->belongsTo(AdjuntoContratoEmpleado::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function tipoCuentaBancaria()
    {
        return $this->belongsTo(TipoCuentaBancaria::class);
    }

}
