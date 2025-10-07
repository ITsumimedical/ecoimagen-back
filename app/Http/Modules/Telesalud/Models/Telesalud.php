<?php

namespace App\Http\Modules\Telesalud\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\TipoSolicitud\Models\TipoSolicitude;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telesalud extends Model
{
    use HasFactory;

    protected $fillable = [
        "tipo_estrategia_id",
        "tipo_solicitud_id",
        "especialidad_id",
        "motivo",
        "resumen_hc",
        "cup_id",
        "afiliado_id",
        "funcionario_crea_id",
        "estado_id",
        "consulta_id",
    ];

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function tipoEstrategia()
    {
        return $this->belongsTo(TipoEstrategiaTelesalud::class, 'tipo_estrategia_id');
    }

    public function tipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitude::class, 'tipo_solicitud_id');
    }

    public function funcionarioCrea()
    {
        return $this->belongsTo(User::class, 'funcionario_crea_id');
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function gestiones()
    {
        return $this->hasMany(GestionesTelesalud::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Cup::class, 'cup_id');
    }

    public function integrantes()
    {
        return $this->belongsToMany(User::class, 'integrantes_telesaluds', 'telesalud_id', 'user_id');
    }

}
