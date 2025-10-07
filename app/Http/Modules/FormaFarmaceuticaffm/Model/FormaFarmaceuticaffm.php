<?php

namespace App\Http\Modules\FormaFarmaceuticaffm\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormaFarmaceuticaffm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forma_farmaceutica_ffm';

    protected $fillable = [
        'codigo',
        'nombre',
        'habilitado',
        'nombre_abreviado'
    ];
}
