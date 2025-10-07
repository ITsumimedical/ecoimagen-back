<?php

namespace App\Http\Modules\Zarit\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zarit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
