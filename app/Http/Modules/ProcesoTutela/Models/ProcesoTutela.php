<?php

namespace App\Http\Modules\ProcesoTutela\Models;

use App\Http\Modules\ActuacionTutelas\Models\actuacionTutelas;
use App\Http\Modules\ResponsableTutela\Models\ResponsableTutela;
use Illuminate\Database\Eloquent\Model;

class ProcesoTutela extends Model
{
    protected $guarded = [];
    protected $table = 'proceso_tutelas';

    /** Relaciones */
    public function actuacioTutela()
    {
        return $this->belongsToMany(actuacionTutelas::class)->withTimestamps();
    }

    public function responsableTutela()
    {
        return $this->hasOne(ResponsableTutela::class, 'proceso_id');
    }
    /** Scopes */

    /** Sets y Gets */

}
