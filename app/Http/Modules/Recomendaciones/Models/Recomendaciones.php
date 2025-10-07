<?php

namespace App\Http\Modules\Recomendaciones\Models;

use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recomendaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
        'cup_id',
        'cie10_id',
        'user_id',
        'estado_id',
        'edad_minima',
        'edad_maxima',
        'sexo'
    ];

    public function cie10()
    {
        return $this->belongsTo(Cie10::class, 'cie10_id');
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class, 'cup_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
