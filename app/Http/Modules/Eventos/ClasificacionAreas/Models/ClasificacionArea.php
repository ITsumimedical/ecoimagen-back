<?php

namespace App\Http\Modules\Eventos\ClasificacionAreas\Models;

use App\Http\Modules\Eventos\Sucesos\Models\Suceso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasificacionArea extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function suceso()
    {
        return $this->belongsTo(Suceso::class);
    }

    protected $casts = [
        'suceso_id' => 'integer'
    ];
}
