<?php

namespace App\Http\Modules\Reps\Models;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Sedes\Models\Sede;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametrizacionCupPrestador extends Model
{
    use HasFactory;

    protected $table = 'parametrizacion_cup_prestadores';
    protected $guarded = [];


    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }

    public function sede(){
        return $this->belongsTo(Rep::class,'rep_id');
    }

    public function CodigoPropio()
    {
        return $this->belongsTo(CodigoPropio::class);
    }
}
