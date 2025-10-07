<?php

namespace App\Http\Modules\InduccionesEspecificas\DetalleInduccionesEspecificas\Models;

use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Models\InduccionEspecifica;
use App\Http\Modules\InduccionesEspecificas\TemasInduccionesEspecificas\Models\TemaInduccionEspecifica;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleInduccionEspecifica extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function induccion()
    {
        return $this->belongsTo(InduccionEspecifica::class);
    }

    public function tema()
    {
        return $this->belongsTo(TemaInduccionEspecifica::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
