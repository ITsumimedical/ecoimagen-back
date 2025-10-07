<?php

namespace App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Models;

use App\Http\Modules\Subcategorias\Models\Subcategorias;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategoriasPqrsf extends Model
{
    use HasFactory;

    protected $table = 'subcategorias_pqrsf';
    protected $guarded = [];

    public function subcategoria()
    {
        return $this->belongsTo(Subcategorias::class);
    }
}
