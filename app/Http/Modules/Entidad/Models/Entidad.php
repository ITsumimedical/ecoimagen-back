<?php

namespace App\Http\Modules\Entidad\Models;

use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Imagenes\Models\Imagene;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Http\Modules\Solicitudes\TipoSolicitud\Models\TipoSolicitudRedVital;

class Entidad extends Model
{

    protected $guarded = [];
    protected $table = 'entidades';
    protected $hidden = array('pivot');
    protected $casts = [
        'generar_ordenes' => 'boolean',
        'consultar_historicos' => 'boolean',
        'autorizar_ordenes' => 'boolean',
        'atender_pacientes' => 'boolean',
        'entregar_medicamentos' => 'boolean',
        'agendar_pacientes' => 'boolean',
        'generar_ordenes' => 'boolean',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagene::class);
    }

    public function cups(): BelongsToMany
    {
        return $this->belongsToMany(Cup::class, 'cup_entidad', 'entidad_id', 'cup_id')->withPivot('diagnostico_requerido', 'nivel_ordenamiento', 'nivel_portabilidad', 'requiere_auditoria', 'periodicidad', 'cantidad_max_ordenamiento', 'copago', 'moderadora');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entidad_users', 'entidad_id', 'user_id');
    }

    public function tiposSolicitudes() {
        return $this->belongsToMany(TipoSolicitudRedVital::class, 'tipo_solicitud_entidads', 'entidad_id', 'tipo_solicitud_id');
    }

}
