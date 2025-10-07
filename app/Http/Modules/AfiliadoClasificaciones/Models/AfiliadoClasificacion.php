<?php

namespace App\Http\Modules\AfiliadoClasificaciones\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Clasificaciones\Models\clasificacion;
use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\PrestadoresTH\Models\PrestadorTh;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AfiliadoClasificacion extends Model
{
    protected $casts = [
        'user_id' => 'integer',
        'afiliado_id' => 'integer',
        'clasificacion_id' => 'integer'
    ];

    protected $fillable = [
        'user_id',
        'afiliado_id',
        'clasificacion_id',
        'estado'
    ];

    protected $table = 'afiliado_clasificacions';


    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function clasificacion()
    {
        return $this->belongsTo(clasificacion::class, 'clasificacion_id');
    }
}
