<?php

namespace App\Http\Modules\Solicitudes\RadicacionOnline\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Models\BeneficiarioRadicacion;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Solicitudes\AdjuntosRadicacionOnline\Models\AdjuntosRadicacionOnline;
use App\Http\Modules\Solicitudes\GestionRadicacionOnline\Models\GestionRadicacionOnline;
use App\Http\Modules\Solicitudes\TipoSolicitud\Models\TipoSolicitudRedVital;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadicacionOnline extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at'=> 'date:Y-m-d',
        'fecha_inicio'=> 'date:Y-m-d',
        'fecha_final'=> 'date:Y-m-d',
        ];

    protected $fillable =['ruta','descripcion','tipo_solicitud_red_vital_id','telefono','correo','afiliado_id','estado_id','fecha_inicio','fecha_final'];

    public function adjuntoRadicado()
    {
        return $this->hasMany(AdjuntosRadicacionOnline::class);
    }

    public function gestion()
    {
        return $this->hasMany(GestionRadicacionOnline::class);
    }

    public function tipo_solicitud_red_vital()
    {
        return $this->belongsTo(TipoSolicitudRedVital::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function beneficiarioRadicacion()
    {
        return $this->hasMany(BeneficiarioRadicacion::class,'solicitud_id');
    }
}
