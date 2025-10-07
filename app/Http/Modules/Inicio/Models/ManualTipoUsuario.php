<?php

namespace App\Http\Modules\Inicio\Models;

use App\Http\Modules\TipoUsuarios\Models\TipoUsuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualTipoUsuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'manual_id',
        'tipo_usuario_id',
    ];

    public function manual()
    {
        return $this->belongsTo(Manuales::class);
    }

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class);
    }
}
