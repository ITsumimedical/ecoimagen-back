<?php

namespace App\Http\Modules\Historia\Odontograma\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdontogramaImagen extends Model
{
    use HasFactory;

    protected $fillable = ['imagen', 'consulta_id', 'tipo'];
}
