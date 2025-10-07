<?php

namespace App\Http\Modules\Pqrsf\Derechos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Derechos extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion'];
}
