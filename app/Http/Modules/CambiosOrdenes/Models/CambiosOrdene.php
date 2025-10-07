<?php

namespace App\Http\Modules\CambiosOrdenes\Models;

use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambiosOrdene extends Model
{
    use HasFactory;

    protected $fillable = ['observacion','estado','orden_articulo_id','orden_procedimiento_id','orden_codigo_propio_id','user_id','cantidad_anteriorior', 'accion', 'incapacidad_id', 'rep_anterior_id', 'codigo_propio_anterior_id', 'cup_anterior','rep_nuevo_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class, 'cup_anterior');
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class, 'rep_anterior_id');
    }
}
