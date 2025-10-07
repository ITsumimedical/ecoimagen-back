<?php

namespace App\Http\Modules\AdjuntosProveedoresCompras\Models;

use App\Http\Modules\ProveedoresCompras\Models\ProveedoresCompras;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AdjuntoProveedor extends Model
{
    use HasFactory;

    protected $table = 'adjuntos_proveedores_compras';

    protected $fillable = [
        "nombre",
        "ruta_adjunto",
        "tipo_adjunto",
        "proveedor_id",
    ];

    public function proveedor()
    {
        return $this->belongsTo(ProveedoresCompras::class);
    }
}
