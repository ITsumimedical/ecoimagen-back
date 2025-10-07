<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Models;

use App\Http\Modules\AdjuntoMesaAyuda\Models\AdjuntosMesaAyuda;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\MesaAyuda\AsignadosMesaAyuda\Models\AsignadosMesaAyuda;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Models\CategoriaMesaAyuda;
use App\Http\Modules\MesaAyuda\SeguimientoActividades\Models\SeguimientoActividades;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesaAyuda extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacto',
        'asunto',
        'descripcion',
        'usuario_registra_id',
        'plataforma',
        'categoria_mesa_ayuda_id',
        'prioridad_id',
        'sede_id',
        'estado_id',
        'calficacion',
        'tiempo_respuesta',
        'fecha_meta_solucion',
        'clasificacion',
    ];

    public function AdjuntosMesaAyuda()
    {
        return $this->hasMany(AdjuntosMesaAyuda::class);
    }

    public function categoriaMesaAyuda()
    {
        return $this->belongsTo(CategoriaMesaAyuda::class, 'categoria_mesa_ayuda_id');
    }

    public function asignadosMesaAyuda()
    {
        return $this->hasMany(AsignadosMesaAyuda::class);
    }

    public function seguimientoActividades()
    {
        return $this->hasMany(SeguimientoActividades::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_registra_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
