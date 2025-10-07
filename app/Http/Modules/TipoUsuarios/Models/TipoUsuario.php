<?php

namespace App\Http\Modules\TipoUsuarios\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Inicio\Models\Manuales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoUsuario extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function manuales()
    {
        return $this->belongsToMany(Manuales::class, 'manual_tipo_usuario', 'tipo_usuario_id', 'manual_id');
    }
}
