<?php

namespace App\Http\Modules\Movimientos\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimiento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tipoMovimiento(){

        return $this->belongsTo(TipoMovimiento::class);
    }

    public function detalleMovimientos(){
        return $this->hasMany(DetalleMovimiento::class);
    }

    public function ordenArticulo()
    {
        return $this->belongsTo(OrdenArticulo::class, 'orden_articulo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bodegaOrigen()
    {
        return $this->belongsTo(Bodega::class, 'bodega_origen_id');
    }

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function solicitudBodega()
    {
        return $this->belongsTo(SolicitudBodega::class, 'solicitud_bodega_id');
    }
}
