<?php

namespace App\Http\Modules\Whooley\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class whooley extends Model
{
    use HasFactory;

    protected $fillable = [
        'desanimado_deprimido',
        'poco_placer_interes',
        'interpretacion_resultado',
        'consulta_id'
    ];


    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
