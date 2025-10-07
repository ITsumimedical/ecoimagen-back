<?php

namespace App\Http\Modules\Familiograma\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Figura extends Model
{
    use HasFactory;
    protected $table = 'figuras';

    protected $fillable = ['nombre', 'edad', 'pos_x', 'pos_y', 'afiliado_id', 'class', 'consulta_id', 'principal'];

    public function relacionesOrigen()
    {
        return $this->hasMany(Relacione::class, 'figura_origen_id');
    }

    public function relacionesDestino()
    {
        return $this->hasMany(Relacione::class, 'figura_destino_id');
    }
}
