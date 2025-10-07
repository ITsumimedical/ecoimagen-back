<?php

namespace App\Http\Modules\Colegios\Models;

use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colegio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo_dane_colegio',
        'municipio_id',
        'estado'
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class,'municipio_id');

    }
}