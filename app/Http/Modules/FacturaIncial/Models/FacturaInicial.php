<?php

namespace App\Http\Modules\FacturaIncial\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaInicial extends Model
{
    use HasFactory;

    protected $fillable = ['tipo' ,'numero','fecha','cod_int','descripcion','presentacion',
    'nom_com','cum','lote','fecha_vence','laboratorio','embalaje','cajas','unidades','valor',
    'total','nit','pedido','user','estado_id'];
}
