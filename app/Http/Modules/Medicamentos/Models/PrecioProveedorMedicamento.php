<?php

namespace App\Http\Modules\Medicamentos\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioProveedorMedicamento extends Model
{
    use HasFactory;

    protected $fillable = ['precio_unidad','iva','iva_facturacion','precio_venta','rep_id','medicamento_id','total','precio_maximo'];

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }
}
