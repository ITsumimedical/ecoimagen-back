<?php

namespace App\Http\Modules\Historia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Consultas\Models\Consulta;

class PracticaCrianza extends Model
{

    protected $guarded = [];
    public function consulta()
    {
      return $this->belongsTo(Consulta::class);
      }
}
