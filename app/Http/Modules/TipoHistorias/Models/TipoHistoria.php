<?php

namespace App\Http\Modules\TipoHistorias\Models;

use App\Http\Modules\ComponentesHistoriaClinica\Model\ComponentesHistoriaClinica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoHistoria extends Model
{

    protected $guarded = [];
    protected $table = 'tipo_historias';

    /** Scopes */

    /** Sets y Gets */

    public function componentesHistoriaClinica()
    {
        return $this->belongsToMany(ComponentesHistoriaClinica::class, 'componentes_tipo_historia_clinicas', 'tipo_historia_id', 'componente_historia_id')
                    ->withPivot('orden_componente')
                    ->orderBy('orden_componente', 'asc');
    }

}
