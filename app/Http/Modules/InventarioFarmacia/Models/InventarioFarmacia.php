<?php

namespace App\Http\Modules\InventarioFarmacia\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioFarmacia extends Model
{
    use HasFactory;

    protected $fillable = [
        'bodega_id',
        'realizado_por',
        'estado_id'
    ];

    public function bodega()
    {
        return $this->belongsTo(Bodega::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
