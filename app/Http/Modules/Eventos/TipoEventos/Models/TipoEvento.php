<?php

namespace App\Http\Modules\Eventos\TipoEventos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'clasificacion_area_id' => 'integer'
    ];
}
