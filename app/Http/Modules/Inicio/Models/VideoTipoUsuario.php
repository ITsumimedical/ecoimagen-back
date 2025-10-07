<?php

namespace App\Http\Modules\Inicio\Models;

use App\Http\Modules\TipoUsuarios\Models\TipoUsuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoTipoUsuario extends Model
{
    use HasFactory;

    protected $fillable = ['video_id', 'tipo_usuario_id'];

    public $timestamps = false;

    public function video(): BelongsTo
    {
        return $this->belongsTo(Videos::class, 'video_id');
    }

    public function tipoUsuario(): BelongsTo
    {
        return $this->belongsTo(TipoUsuario::class, 'tipo_usuario_id');
    }
}
