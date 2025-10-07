<?php

namespace App\Http\Modules\categorias\Models;

use App\Http\Modules\categoriasPadres\Models\CategoriaPadre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorias extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categoriaPadre()
    {
        return $this->belongsTo(CategoriaPadre::class, 'categoria_padre_id');
    }
}
