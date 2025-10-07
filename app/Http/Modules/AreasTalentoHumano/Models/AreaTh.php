<?php

namespace App\Http\Modules\AreasTalentoHumano\Models;

use App\Http\Modules\CategoriaMesaAyuda\Models\categoriaMesaAyuda;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaTh extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function estados()
    {
        return $this->belongsTo(Estado::class);
    }

    public function categorias()
    {
        return $this->hasMany(categoriaMesaAyuda::class);
    }

}
