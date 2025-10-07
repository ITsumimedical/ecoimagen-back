<?php

namespace App\Http\Modules\Ordenamiento\Models;

use App\Http\Modules\Codesumis\viasAdministracion\Model\viasAdministracion;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenArticuloIntrahospitalario extends Model
{
    use HasFactory;

    protected $fillable = [
            'orden_id',
            'codesumi_id',
            'estado_id',
            'via_administracion_id',
            'finalizacion',
            'dosis',
            'frecuencia',
            'unidad_tiempo',
            'horas_vigencia',
            'cantidad',
            'observacion',
            'user_crea_id',
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function codesumi(): BelongsTo
    {
        return $this->belongsTo(Codesumi::class, 'codesumi_id');
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function viaAdministracion(): BelongsTo
    {
        return $this->belongsTo(viasAdministracion::class, 'via_administracion_id');
    }

    public function userCrea(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_crea_id');
    }

    public function via(): BelongsTo
    {
        return $this->belongsTo(viasAdministracion::class,'via_administracion_id');
    }
}
