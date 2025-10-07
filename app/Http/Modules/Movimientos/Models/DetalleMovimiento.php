<?php

namespace App\Http\Modules\Movimientos\Models;

use App\Http\Modules\Medicamentos\Models\Lote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleMovimiento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}
