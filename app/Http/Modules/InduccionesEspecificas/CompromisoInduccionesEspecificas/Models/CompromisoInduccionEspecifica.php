<?php

namespace App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Models;

use App\Http\Modules\InduccionesEspecificas\InduccionesEspecificas\Models\InduccionEspecifica;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompromisoInduccionEspecifica extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function induccion()
    {
        return $this->belongsTo(InduccionEspecifica::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
