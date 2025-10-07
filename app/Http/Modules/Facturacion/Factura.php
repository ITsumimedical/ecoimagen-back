<?php

namespace App\Http\Modules\Facturacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->unique)) {
                $model->unique = (string) Str::uuid();
            }
        });

        static::updated(function($model){
            Cache::forget('facturas:' . $model->unique);
        });

    }

    public function detalles()
    {
        return $this->hasMany(FacturaDetalle::class, 'factura_id');
    }

    public function cliente()
    {
        return $this->belongsTo(FacturaCliente::class, 'cliente_id');
    }

    public function resolucion()
    {
        return $this->belongsTo(FacturaResolucion::class, 'resolucion_id');
    }
}
