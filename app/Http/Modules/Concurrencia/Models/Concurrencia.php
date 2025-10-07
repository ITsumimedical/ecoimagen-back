<?php

namespace App\Http\Modules\Concurrencia\Models;

use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concurrencia extends Model
{
    use HasFactory;

    protected $fillable =[
        'costo_atencion',
        'fecha_egreso',
        'destino_egreso',
        'dias_estancia_observacion',
        'dias_estancia_intensivo',
        'dias_estancia_intermedio',
        'dias_estancia_basicos',
        'hospitalizacion_evitable',
        'reporte_patologia_diagnostica',
        'alto_costo',
        'costo_total_global',
        'numero_factura',
        'auditor_id',
        'dx_egreso',
        'dx_concurrencia',
        'estado_id',
        'ingreso_concurrencia_id',
    ];

    public function ingresoConcurrencia()
    {
        return $this->belongsTo(IngresoConcurrencia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function cie10()
    {
        return $this->belongsTo(Cie10::class, 'dx_concurrencia');
    }

    public function dxEgreso()
    {
        return $this->belongsTo(Cie10::class, 'dx_egreso');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoConcurrencia::class, 'concurrencia_id');
    }

    public function cambiosConcurrencias()
    {
        return $this->hasMany(CambiosConcurrencias::class, 'concurrencia_id');
    }


//    public function getDiasEstanciaAttribute(){
//        $hoy = Carbon::now();
//        return $hoy->diffInDays($this->fecha_ingreso);
//    }
}
