<?php

namespace App\Http\Modules\RecomendacionesCups\Models;

use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecomendacionCup extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion','usuario_realiza_id','cup_id','estado'];

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }
}
