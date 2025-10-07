<?php

namespace App\Http\Modules\TipoActuaciones\Models;

use App\Http\Modules\Tutelas\Models\Tutela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoActuacion extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =
    [
        'nombre'
    ];

    protected $guarded = [];
    protected $table = 'tipo_actuaciones';

    public function tutela(){
        return $this->hasMany(Tutela::class, 'tipo_actuacion_id');
    }
}
