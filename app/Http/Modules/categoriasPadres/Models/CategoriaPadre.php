<?php

namespace App\Http\Modules\categoriasPadres\Models;

use App\Http\Modules\categorias\Models\categorias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaPadre extends Model
{
    use HasFactory;

    protected $table = 'categorias_padres';

    protected $guarded = [];

    public function categorias()
    {
        return $this->hasMany(categorias::class, 'categoria_padre_id');
    }
}
