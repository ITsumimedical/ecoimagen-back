<?php

namespace App\Http\Modules\MesaAyuda\CategoriaMesaAyuda\Models;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\MesaAyuda\AreasMesaAyuda\Models\AreasMesaAyuda;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaMesaAyuda extends Model
{
    use HasFactory;

    protected $table =  'categoria_mesa_ayudas';

    protected $fillable = [
        'nombre',
        'areas_mesa_ayuda_id',
        'estado_id'
    ];



    public function user()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function areasMesaAyuda()
    {
        return $this->belongsTo(AreasMesaAyuda::class);
    }
}
