<?php

namespace App\Http\Modules\Subcategorias\Models;

use App\Http\Modules\Pqrsf\Derechos\Models\Derechos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategorias extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function derechos()
    {
        return $this->belongsToMany(Derechos::class, "derechos_subcategoria", "subcategoria_id", "derecho_id");
    }
}
