<?php

namespace App\Http\Modules\Empalme\Adjunto\Model;

use App\Http\Modules\Empalme\Models\Empalme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoEmpalme extends Model
{
    use HasFactory;

    protected $table = 'adjunto_empalme';

    protected $fillable = [
        'nombre',
        'ruta',
        'empalme_id'
    ];


}
