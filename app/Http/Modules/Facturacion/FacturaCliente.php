<?php

namespace App\Http\Modules\Facturacion;

use Illuminate\Database\Eloquent\Model;

class FacturaCliente extends Model
{
    protected $table = 'factura_clientes';
    protected $guarded = [];
}
