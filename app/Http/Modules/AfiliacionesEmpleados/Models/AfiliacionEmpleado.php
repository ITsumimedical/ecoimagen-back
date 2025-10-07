<?php

namespace App\Http\Modules\AfiliacionesEmpleados\Models;

use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\PrestadoresTH\Models\PrestadorTh;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AfiliacionEmpleado extends Model
{
    use SoftDeletes;

    protected $casts = [
        'prestador_id' => 'integer'
    ];

    protected $guarded = [];

    public function prestador()
    {
        return $this->belongsTo(PrestadorTh::class);
    }

    public function contrato()
    {
        return $this->belongsTo(ContratoEmpleado::class);
    }

    public function desafiliar(){
        return $this->update([
            'estado' => 0
        ]);
    }

}
