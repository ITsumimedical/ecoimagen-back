<?php

namespace App\Http\Modules\Grupos\Models;

use App\Http\Modules\Subgrupos\Models\Subgrupo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','codigo','activo'];

    public function subgrupo()
    {
        return $this->hasMany(Subgrupo::class);
    }
}
