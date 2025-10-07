<?php

namespace App\Http\Modules\Historia\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GestanteGinecologico extends Model
{
    protected $guarded = [];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
