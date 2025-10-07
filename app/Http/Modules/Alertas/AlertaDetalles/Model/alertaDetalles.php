<?php

namespace App\Http\Modules\Alertas\AlertaDetalles\Model;

use App\Http\Modules\Alertas\Models\Alertas;
use App\Http\Modules\Cums\Models\Cum;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Farmacovigilancia\Models\MensajesAlerta;
use App\Http\Modules\TipoAlerta\Models\TipoAlerta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alertaDetalles extends Model
{
    use HasFactory;

    protected $fillable = ['interaccion_id', 'tipo_alerta_id', 'mensaje_alerta_id', 'usuario_registra_id', 'estado_id', 'alerta_id', 'interaccion'];

    public function interaccion()
    {
        return $this->belongsTo(Cum::class);
    }

    public function tipoAlerta()
    {
        return $this->belongsTo(TipoAlerta::class);
    }

    public function mensajeAlerta()
    {
        return $this->belongsTo(MensajesAlerta::class, 'mensaje_alerta_id');
    }

    public function usuarioRegistra()
    {
        return $this->belongsTo(User::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
    public function alerta()
    {
        return $this->belongsTo(Alertas::class);
    }
}
