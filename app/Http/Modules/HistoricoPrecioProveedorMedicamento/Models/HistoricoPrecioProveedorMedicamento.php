<?php

namespace App\Http\Modules\HistoricoPrecioProveedorMedicamento\Models;

use App\Http\Modules\Medicamentos\Models\Medicamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPrecioProveedorMedicamento extends Model
{
    use HasFactory;

    protected $fillable = ['precio_unidad','rep_id','medicamento_id','solicitud_bodega_id'];

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class);
    }
}
