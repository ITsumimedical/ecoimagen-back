<?php

namespace App\Http\Modules\Incapacidades\Models;

use App\Http\Modules\CambiosOrdenes\Models\CambiosOrdene;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Colegios\Models\Colegio;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Incapacidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_inicio',
        'dias',
        'fecha_final',
        'prorroga',
        'consulta_id',
        'descripcion_incapacidad',
        'usuario_realiza_id',
        'estado_id',
        'contingencia',
        'diagnostico_id',
        'colegio_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'usuario_realiza_id');
    }

    public function cie10()
    {
        return $this->belongsTo(Cie10::class, 'diagnostico_id');
    }

    public function colegio()
    {
        return $this->belongsTo(Colegio::class, 'colegio_id');
    }

    public function cambioOrden()
    {
        return $this->hasOne(CambiosOrdene::class, 'incapacidad_id', 'id');
    }
}
