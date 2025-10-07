<?php

namespace App\Http\Modules\GestionOrdenPrestador\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionOrdenPrestador extends Model
{
    use HasFactory;

    protected $table = 'gestion_orden_prestador';

    protected $fillable = [
        'orden_procedimiento_id',
        'orden_codigo_propio_id',
        'estado_gestion_id',
        'observacion',
        'funcionario_responsable',
        'funcionario_gestiona',
        'fecha_cancelacion',
        'motivo_cancelacion',
        'causa_cancelacion',
        'fecha_sugerida',
        'fecha_solicita_afiliado',
        'fecha_resultado',
        'cirujano',
        'especialidad',
        'fecha_preanestesia',
        'fecha_cirugia',
        'fecha_ejecucion',
        'fecha_ejecucion',
        'fecha_asistencia'
    ];

    public function ordenProcedimiento()
    {
        return $this->belongsTo(OrdenProcedimiento::class, 'orden_procedimiento_id');
    }

    public function ordenCodigoPropio()
    {
        return $this->belongsTo(OrdenCodigoPropio::class, 'orden_codigo_propio_id');
    }

    public function estadoGestion()
    {
        return $this->belongsTo(Estado::class, 'estado_gestion_id');
    }

    public function funcionarioGestiona()
    {
        return $this->belongsTo(User::class, 'funcionario_gestiona');
    }

    public function adjuntos()
    {
        return $this->hasMany(AdjuntosGestionOrden::class,'gestion_orden_id');
    }
}
