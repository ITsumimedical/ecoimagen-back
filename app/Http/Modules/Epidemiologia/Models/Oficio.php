<?php

namespace App\Http\Modules\Epidemiologia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_ciuo',
        'nombre_oficio',
        'estado'
    ];

    public function scopeWhereNombreOficio($query, $data)
    {
        return $query->where('nombre_oficio', 'ILIKE', '%' . $data . '%');
    }
}
