<?php

namespace App\Http\Modules\Subgrupos\Models;

use App\Http\Modules\Grupos\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgrupo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','descripcion','grupo_id','activo'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
