<?php

namespace App\Http\Modules\HistoricoContratoEmpleado\Models;

use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\ProyectoEmpleado\Models\ProyectoEmpleado;
use App\Http\Modules\TiposContratosTH\Models\TipoContratoTh;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoContratoEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_empleado_id',
        'user_id',
        'cargo_id',
        'proyecto_id',
        'tipo_contrato_id',
        'salario',
        'horas',
        'accion',
        'observaciones',
        'fecha_ingreso',
        'fecha_vencimiento',
        'fecha_retiro',
        'fecha_fin_periodo_prueba',
        'jornada',
        'activo',
        'tipo_terminacion',
        'motivo_terminacion',
        'justa_causa',
        'numero_cuenta_bancaria',
        'municipio_trabaja_id',
        'tipo_cuenta_id',
        'banco_id',
        'fecha_aplicacion_novedad',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'contrato_empleado_id' => 'integer',
        'proyecto_id' => 'integer',
        'cargo_id' => 'integer',
        'tipo_contrato_id' => 'integer',
        'salario' => 'integer',
    ];

    public function contratoEmpleado()
    {
        return $this->belongsTo(ContratoEmpleado::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function proyecto()
    {
        return $this->belongsTo(ProyectoEmpleado::class);
    }

    public function tipoContrato()
    {
        return $this->belongsTo(TipoContratoTh::class);
    }
}
