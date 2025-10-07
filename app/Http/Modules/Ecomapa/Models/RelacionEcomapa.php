<?php

namespace App\Http\Modules\Ecomapa\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacionEcomapa extends Model
{
    use HasFactory;

    protected $fillable = ['figura_origen_id', 'figura_destino_id', 'tipo_relacion'];

    public function figuraOrigen()
    {
        return $this->belongsTo(FiguraEcomapa::class, 'figura_origen_id');
    }

    public function figuraDestino()
    {
        return $this->belongsTo(FiguraEcomapa::class, 'figura_destino_id');
    }
}
