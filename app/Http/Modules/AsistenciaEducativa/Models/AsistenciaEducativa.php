<?php

namespace App\Http\Modules\AsistenciaEducativa\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaEducativa extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'ambito',
        'finalidad',
        'cup_id',
        'tema',
        'afiliado_id',
        'usuario_registra_id'

    ];

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }
}
