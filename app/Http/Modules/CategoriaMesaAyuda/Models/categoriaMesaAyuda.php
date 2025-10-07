<?php

namespace App\Http\Modules\CategoriaMesaAyuda\Models;

use App\Http\Modules\AreasTalentoHumano\Models\AreaTh;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class categoriaMesaAyuda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'area_th_id',
        'estado_id'
    ];

    /** Relaciones */

    public function areaTh()
    {
        return $this->belongsTo(AreaTh::class);
    }

    /** Scopes */

    /** Sets y Gets */

}
