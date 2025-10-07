<?php

namespace App\Http\Modules\ProveedoresCompras\Models;

use App\Http\Modules\AreasProveedores\Models\AreasProveedores;
use App\Http\Modules\LineasCompras\Models\LineasCompras;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Paises\Models\Pais;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedoresCompras extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_proveedor',
        'nit',
        'nombre_representante',
        'telefono',
        'direccion',
        'municipio_id',
        'email',
        'actividad_economica',
        'modalidad_vinculacion',
        'forma_pago',
        'tiempo_entrega',
        'area_id',
        'tipo_proveedor',
        'estado',
        'fecha_ingreso',
        'observaciones',
        'tipo_documento_legal',
        'pais_id',
        'codigo_dian',
        'responsabilidad_fiscal'
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class ,'municipio_id');
    }

    public function pais(){
        return $this->belongsTo(Pais::class ,'pais_id');
    }

    public function area(){
        return $this->belongsTo(AreasProveedores::class ,'area_id');
    }

    public function lineasCompra(){
        return $this->belongsToMany(LineasCompras::class,'lineas_proveedores_compras' ,'proveedor_id','linea_id');
    }

    public function scopePorNIT($query, $nit)
    {
        return $query->where('nit', 'LIKE', "%$nit%");
    }

    public function scopePorContrato($query, $contrato)
    {
        return $query->where('modalidad_vinculacion', 'LIKE', "%$contrato%");
    }

}
