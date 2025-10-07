<?php

namespace App\Http\Modules\MesaAyuda\AreasMesaAyuda\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasMesaAyuda extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','activo','visible'];

    public function scopeWhereEstado($query, $estado){
        if($estado){
            return $query->where('activo', $estado);
        }
    }

}
