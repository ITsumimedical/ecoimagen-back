<?php

namespace App\Http\Modules\InduccionesEspecificas\SeguimientoCompromisoInduccionesEspecificas\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\InduccionesEspecificas\CompromisoInduccionesEspecificas\Models\CompromisoInduccionEspecifica;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoCompromisoInduccionEspecifica extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function compromiso()
    {
        return $this->belongsTo(CompromisoInduccionEspecifica::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
