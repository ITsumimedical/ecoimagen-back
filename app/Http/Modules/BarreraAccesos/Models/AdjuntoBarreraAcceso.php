<?php

namespace App\Http\Modules\BarreraAccesos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoBarreraAcceso extends Model
{
    use HasFactory;

    protected $fillable = ['barrera_id', 'nombre', 'ruta'];

    public function barreras()
    {
        return $this->belongsTo(BarreraAcceso::class, 'barrera_id');
    }
}
