<?php

namespace App\Http\Modules\Direccionamientos\Models;

use App\Http\Modules\Georeferenciacion\Models\Georeferenciacion;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class direccionamiento extends Model
{
    use HasFactory;

    protected $fillable =[
        'georeferenciacion_id',
        'user_id',
        'rep_id',
        'activo'
    ];
    

    public function georeferenciacion()
    {
        return $this->belongsTo(Georeferenciacion::class, 'georeferenciacion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class, 'rep_id');
    }

    public function scopeWhereZona($query, $zona){
        if($zona){
            return $query->whereHas('georeferenciacion', function ($query) use ($zona) {
                $query->where('zona', $zona);
            });
        }
    }

    public function scopeWhereEntidad($query, $entidad_id){
        if($entidad_id){
            return $query->whereHas('georeferenciacion', function ($query) use ($entidad_id) {
                $query->where('entidad_id', $entidad_id);
            });
        }
    }

    public function scopeWhereMunicipio($query, $municipio_id){
        if($municipio_id){
            return $query->whereHas('georeferenciacion', function ($query) use ($municipio_id) {
                $query->where('municipio_id', $municipio_id);
            });
        }
    }
}
