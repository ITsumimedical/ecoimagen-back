<?php

namespace App\Http\Modules\Medicamentos\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodegaMedicamento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

    public function bodega()
    {
        return $this->belongsTo(Bodega::class);
    }
}
