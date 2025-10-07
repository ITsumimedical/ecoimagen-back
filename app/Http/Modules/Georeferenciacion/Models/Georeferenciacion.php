<?php

namespace App\Http\Modules\Georeferenciacion\Models;

use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Zonas\Models\Zonas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Georeferenciacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'zona_id',
        'entidad_id',
        'municipio_id',
        'user_id',
    ];

    public function zona()
    {
        return $this->belongsTo(Zonas::class, 'zona_id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

}
